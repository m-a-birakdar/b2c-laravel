<?php

namespace Modules\Report\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderReview;
use Modules\Product\Entities\Product;
use Modules\Report\Entities\Report;
use Modules\User\Entities\User;
use MongoDB\BSON\UTCDateTime;
use Symfony\Component\Console\Input\InputArgument;

class MonthlyReportCommand extends Command
{
    protected $name = 'report:save {type}';

    protected $description = 'Monthly report command.';

    private Carbon $currentMonth;
    private int $daysInMonth, $rowsCount;
    private array $users, $orders, $products, $categories, $subCategories;

    public function __construct()
    {
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->daysInMonth = Carbon::now()->daysInMonth;
        $this->rowsCount = 5;
        parent::__construct();
    }

    public function handle()
    {
        $this->products();
//        $this->users();
//        $this->orders();
//        $this->products();
//        $this->save();
    }

    private function products()
    {
        $this->subCategories();
        $oldCategories = $this->categories;
        $this->categories = [];
        foreach ($oldCategories as $category) {
            foreach ($category['sub'] as $sub) {
                $products = Product::where('category_id', $sub['id'])
                    ->withCount(['orders' => function ($query) {
                        $query->where('created_at', '>=', $this->currentMonth);
                    }])
                    ->orderByDesc('orders_count')->limit($this->rowsCount)
                    ->get(['id', 'category_id']);
                foreach ($products as $product) {
                    dd($product);
                    $this->products[] = [
                        'id' => $product->id,
                        'orders_count' => $product->orders_count,
                    ];
                }
            }
        }
//        $this->subCategories();
//        $oldCategories = $this->categories;
//        $this->categories = [];
    }

    private function subCategories()
    {
        $this->categories();
        $oldCategories = $this->categories;
        $this->categories = [];
        foreach ($oldCategories as $oldCategory) {
            $parentCategories = SubCategory::withCount(['products' => function ($query) {
                $query->whereHas('orders', function ($q){
                    $q->where('created_at', '<=', $this->currentMonth);
                });
            }])->where('parent_id', $oldCategory['id'])->get();
            $sub = [];
            foreach ($parentCategories as $parentCategory) {
                $sub[] = [
                    'id' => $parentCategory->id,
                    'count' => $parentCategory->products_count
                ];
            }
            if (count($sub) > 0)
                $this->categories[] = [
                    'id' => $oldCategory['id'],
                    'count' => $oldCategory['count'],
                    'sub' => $sub
                ];
        }
        foreach ($this->categories as &$item) {
            usort($item['sub'], function ($a, $b) {
                return $b['count'] <=> $a['count'];
            });
        }
        $this->categories = array_slice($this->categories, 0, $this->rowsCount);
    }

    private function categories()
    {
        $parentCategories = Category::with(['subCategories' => function ($query) {
            $query->withCount(['products' => function ($query) {
                $query->whereHas('orders', function ($q){
                    $q->where('created_at', '<=', $this->currentMonth);
                });
            }]);
        }])->get(['id']);
        foreach ($parentCategories as $parentCategory) {
            $this->categories[] = [
                'id' => $parentCategory->id,
                'count' => $parentCategory->subCategories->sum('products_count')
            ];
        }
        usort($this->categories, function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });
        $this->categories = array_slice($this->categories, 0, $this->rowsCount);
    }

    private function save()
    {
        Report::query()->create([
            'type' => $this->argument('type'),
            'day' => date('d'), 'month'=> date('m'), 'year'=> date('Y'),
            'orders' => $this->orders, 'categories' => $this->categories, 'products' => $this->products, 'created_at' => new UTCDateTime(time() * 1000),
            'sub_categories' => $this->subCategories, 'users' => $this->users,
        ]);
    }

    private function oldProducts()
    {
        $parentCategories = Category::with(['subCategories' => function ($query) {
            $query->withCount(['products' => function ($query) {
                $query->whereHas('orders', function ($q){
                    $q->where('created_at', '<=', $this->currentMonth);
                });
            }]);
        }])->get(['id']);

        foreach ($parentCategories as $parentCategory) {
            $this->categories[] = [
                'id' => $parentCategory->id,
                'count' => $parentCategory->subCategories->sum('products_count')
            ];
            foreach ($parentCategory->subCategories as $category) {
                $dataProducts = [];
                $products = Product::where('category_id', $category->id)->withCount(['orders' => function ($query)  {
                    $query->where('created_at', '>=', $this->currentMonth);
                }])->get();
                foreach ($products as $product) {
                    $p = [
                        'id' => $product->id,
                        'count' => $product->orders_count,
                    ];
                    $this->products[] = $p;
                    $dataProducts[] = $p;
                }
                usort($dataProducts, function ($a, $b) {
                    return $b['count'] <=> $a['count'];
                });
                $this->subCategories[] = [
                    'id' => $category->id,
                    'count' => $parentCategory->products_count ?? 0,
                    'products' => $dataProducts
                ];
            }
        }
    }

    private function orders()
    {
        $this->orders['count'] = $this->orderModel()->count();
        $sum = $this->orderModel()->sum('total_amount');
        $this->orders['total'] = (int) $sum;
        $this->orders['average'] = (int) round($sum / $this->daysInMonth);
        $this->orders['reviews'] = $this->reviews();
    }

    private function reviews(): array
    {
        $data = [];
        $count = $this->reviewModel()->count();
        $data['count'] = $count;
        $data['average'] = $count > 0 ? ($this->reviewModel()->sum('rating') / $count) : 0;
        for($i = 1; $i <= 5; $i++)
            $data['r_' . $i] = $this->reviewModel()->where('rating', $i)->count();
        return $data;
    }

    private function orderModel(): \Illuminate\Database\Eloquent\Builder
    {
        return Order::query()->where('created_at', '>=', $this->currentMonth);
    }

    private function reviewModel(): \Illuminate\Database\Eloquent\Builder
    {
        return OrderReview::query()->where('created_at', '>=', $this->currentMonth);
    }

    private function users()
    {
        $this->users['all'] = $this->userModel()->count();
        $this->users['new'] = $this->userModel()->where('created_at', '>=', $this->currentMonth)->count();
        $this->users['active'] = $this->userModel()->whereHas('details', function ($query) {
            $query->where('last_active_at', '>=', $this->currentMonth);
        })->count();
        $this->users['first_order'] = $this->firstOrder();
    }

    private function userModel(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        });
    }

    private function firstOrder()
    {
        return User::whereHas('orders', function ($query){
            $query->where('created_at', '>=', $this->currentMonth);
        })->doesntHave('orders', 'and', function ($query){
            $query->where('created_at', '<', $this->currentMonth);
        })->count();
    }

    protected function getArguments(): array
    {
        $result = [
            ["id" => 1, "count" => 4, 'sub' => [
                'id' => 12 , 'count' => 8
            ]],
            ["id" => 2, "count" => 2, 'sub' => [
                'id' => 32 , 'count' => 5
            ]],
            ["id" => 2, "count" => 3, 'sub' => [
                'id' => 21 , 'count' => 9
            ]],
        ];
        return [
            ['type', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }
}
