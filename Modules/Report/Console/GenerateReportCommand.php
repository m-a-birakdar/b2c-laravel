<?php

namespace Modules\Report\Console;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Console\Command;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderReview;
use Modules\Report\Entities\CategoryReport;
use Modules\Report\Entities\ProductReport;
use Modules\Report\Entities\Report;
use Modules\Report\Enums\TypeEnum;
use Modules\User\Entities\User;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateReportCommand extends Command
{
    protected $name = 'report:save {type} {--sub}';

    protected $description = 'Generate report command.';

    private Carbon $startComparisonDate, $endComparisonDate;
    private int $average, $sub;
    private array $fields, $users, $orders, $categories, $allProducts = [], $allCategories = [], $create = [];

    public function handle(): int
    {
//        $tables = [
//            'notifications', 'favorites', 'reports', 'whatsapp', 'product_statistics', 'message_ack', 'product_reports', 'category_reports'
//        ];
//        foreach ($tables as $table)
//            DB::connection(tenant()->id . '-mongodb')->table($table)->truncate();
        if (! $this->validateType())
            return CommandAlias::FAILURE;
        $this->users();
        $this->orders();
        $this->categories();
        $this->save();
        return CommandAlias::SUCCESS;
    }

    private function where($q, $column = 'created_at'): void
    {
        $q->where($column, '>=', $this->startComparisonDate)->where($column, '<', $this->endComparisonDate);
    }

    private function sortBeforeCreate()
    {
        usort($this->allCategories, function ($a, $b) {
            return $b['orders_count'] <=> $a['orders_count'];
        });
        usort($this->allProducts, function ($a, $b) {
            return $b['orders_count'] <=> $a['orders_count'];
        });
    }

    private function subCategories($id): array
    {
        $parentCategories = SubCategory::with(['products' => function ($query) {
            $query->select('id', 'category_id')->whereHas('orders', function ($q){
                $this->where($q);
            })->withCount(['orders' => function ($q){
                $this->where($q);
            }]);
        }])->where('parent_id', $id)->get();
        $sub = [];
        foreach ($parentCategories as $parentCategory) {
            $inProducts = [];
            foreach ($parentCategory->products as $product){
                $data = [
                    'id' => $product->id,
                    'orders_count' => $product->orders_count,
                ];
                $this->allProducts[] = $data;
                $inProducts[] = $data;
            }
            $subCat = [
                'id' => $parentCategory->id,
                'products_count' => $parentCategory->products->count(),
                'orders_count' => $parentCategory->products->sum('orders_count'),
            ];
            usort($inProducts, function ($a, $b) {
                return $b['orders_count'] <=> $a['orders_count'];
            });
            $sub[] = array_merge($subCat, [
                'products' => $inProducts
            ]);
            $this->allCategories[] = $subCat;
        }
        usort($sub, function ($a, $b) {
            return $b['orders_count'] <=> $a['orders_count'];
        });
        return $sub;
    }

    private function categories()
    {
        foreach (Category::query()->whereNull('parent_id')->get() as $parentCategory) {
            $newSub = $this->subCategories($parentCategory->id);
            $subCat = [
                'id' => $parentCategory->id,
                'products_count' => array_sum(array_column($newSub,'products_count')),
                'orders_count' => array_sum(array_column($newSub,'orders_count')),
            ];
            $this->categories[] = array_merge($subCat, [
                'sub' => $newSub,
            ]);
            $this->allCategories[] = $subCat;
        }
        usort($this->categories, function ($a, $b) {
            return $b['orders_count'] <=> $a['orders_count'];
        });
    }

    private function create()
    {
        $this->create = array_merge([
            'type' => $this->argument('type'),
        ], $this->fields);
    }

    private function save()
    {
        $this->sortBeforeCreate();
        $this->create();
        Report::query()->create(array_merge($this->create , [
            'orders' => $this->orders, 'categories' => $this->categories, 'users' => $this->users,
        ]));
        ProductReport::query()->create(array_merge($this->create , [
            'products' => $this->allProducts
        ]));
        CategoryReport::query()->create(array_merge($this->create , [
            'categories' => $this->allCategories
        ]));
    }

    private function orders()
    {
        $sum = $this->orderModel()->sum('total_amount');
        $this->orders = [
            'count' => $this->orderModel()->count(),
            'total' => $this->doubleValue($sum),
            'average' => $this->doubleValue($sum / $this->average),
            'reviews' => $this->reviews(),
        ];
    }

    private function doubleValue($value, $decimals = 2): float
    {
        return (double) str_replace(',', '', number_format($value, $decimals));
    }

    private function reviews(): array
    {
        $data = [];
        $count = $this->reviewModel()->count();
        $data['count'] = $count;
        $data['average'] = $count > 0 ? ($this->doubleValue($this->reviewModel()->sum('rating') / $count, 1)) : 0;
        for($i = 1; $i <= 5; $i++)
            $data['r_' . $i] = $this->reviewModel()->where('rating', $i)->count();
        return $data;
    }

    private function orderModel(): \Illuminate\Database\Eloquent\Builder
    {
        return Order::query()->where(function ($q){
            $this->where($q);
        });
    }

    private function reviewModel(): \Illuminate\Database\Eloquent\Builder
    {
        return OrderReview::query()->where(function ($q){
            $this->where($q);
        });
    }

    private function users()
    {
        $this->users = [
            'new' => $this->userModel()->where(function ($q){
                            $this->where($q);
                        })->count(),
            'active' => $this->userModel()->whereHas('details', function ($query) {
                            $this->where($query, 'last_active_at');
                        })->count(),
            'first_order' => $this->firstOrder(),
        ];
    }

    private function userModel(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'customer')->select('id', 'name');
        });
    }

    private function firstOrder()
    {
        return User::whereHas('orders', function ($query){
            $this->where($query);
        })->doesntHave('orders', 'and', function ($query){
            $query->where('created_at', '<', $this->startComparisonDate);
        })->count();
    }

    protected function getOptions(): array
    {
        return [
            ['sub', 'sub', InputOption::VALUE_NONE, 'Carbon sub', null],
        ];
    }

    protected function getArguments(): array
    {
        return [
            ['type', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    private function validateType(): bool
    {
        $types = array_column(TypeEnum::cases(), 'value');
        if (! in_array($this->argument('type'), $types)){
            $this->error('Invalid type.');
            return false;
        }
        $this->sub = $this->option('sub') ? (int) $this->option('sub') : 1;
        $this->setDates();
        return true;
    }

    private function setDates()
    {
        match ($this->argument('type')){
            TypeEnum::DAILY->value => $this->dailyReport(),
            TypeEnum::WEEKLY->value => $this->weeklyReport(),
            TypeEnum::MONTHLY->value => $this->monthlyReport(),
            TypeEnum::YEARLY->value => $this->yearlyReport(),
        };
    }

    private function dailyReport()
    {
        $carbon = Carbon::now()->subDay();
        $this->startComparisonDate = Carbon::now()->subDay()->startOfDay();
        $this->endComparisonDate = Carbon::now()->subDay()->endOfDay();
        $this->fields = [
            'D' => $carbon->format('D'),
            'd' => $carbon->format('d'),
            'm' => $carbon->format('m'),
            'Y' => $carbon->format('Y'),
        ];
        $this->average = 12;
    }

    private function weeklyReport()
    {
        $this->startComparisonDate = Carbon::now()->subWeeks($this->sub)->startOfWeek(CarbonInterface::SATURDAY);
        $this->endComparisonDate = Carbon::now()->subWeeks($this->sub)->endOfWeek(CarbonInterface::FRIDAY);
        $this->average = 7;
        $this->fields = [
            'd' => $this->startComparisonDate->format('d'),
            'm' => $this->startComparisonDate->format('m'),
            'Y' => $this->startComparisonDate->format('Y'),
        ];
    }

    private function monthlyReport()
    {
        $this->startComparisonDate = Carbon::now()->subMonths($this->sub)->startOfMonth();
        $this->endComparisonDate = Carbon::now()->subMonths($this->sub)->endOfMonth();
        $date = Carbon::now()->subMonths($this->sub);
        $this->average = $date->daysInMonth;
        $this->fields = [
            'M' => $date->format('M'),
            'm' => $date->format('m'),
            'Y' => $date->format('Y'),
        ];
    }

    private function yearlyReport()
    {
        $this->startComparisonDate = Carbon::now()->subYears($this->sub)->startOfYear();
        $this->endComparisonDate = Carbon::now()->subYears($this->sub)->endOfYear();
        $this->average = 12;
        $this->fields = [
            'Y' => Carbon::now()->subYears($this->sub)->format('Y'),
        ];
//        dd($this->startComparisonDate->format('Y-m-d H:i:s'), $this->endComparisonDate->format('Y-m-d H:i:s'), $this->average);
    }
}
// pa tenants:run report:save --argument="type=daily"
