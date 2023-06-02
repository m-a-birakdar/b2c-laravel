<?php

namespace Modules\Report\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderReview;
use Modules\Product\Entities\Product;
use Modules\Report\Entities\CategoryReport;
use Modules\Report\Entities\ProductReport;
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
    private array $users, $orders, $categories, $allProducts = [], $allCategories = [], $create = [];

    public function __construct()
    {
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->daysInMonth = Carbon::now()->daysInMonth;
        $this->rowsCount = 5;
        parent::__construct();
    }

    public function handle()
    {
        $this->users();
        $this->orders();
        $this->products();
        $this->total();
        $this->create();
        $this->save();
    }

    private function total()
    {
        $parentCategories = Category::with(['subCategories' => function ($query) {
            $query->with(['products' => function ($d) {
                $d->with('orders', function ($q){
                    $q->where('created_at', '>=', $this->currentMonth)->select(['orders.id', 'orders.created_at']);
                })->select(['products.id', 'products.category_id']);
            }]);
        }])->get()->toArray();
        foreach ($parentCategories as $parentCategory) {
            $fC = [];
            foreach ($parentCategory['sub_categories'] as $sub) {
                $fP = [];
                foreach ($sub['products'] as $product) {
                    $fP[] = [
                        'id' => $product['id'],
                        'count' => count($product['orders']),
                    ];
                }
                $this->allProducts = array_merge($fP, $this->allProducts);
                $fC[] = [
                    'id' => $sub['id'],
                    'count' => array_sum(array_column($fP, 'count')),
                    'parent_id' => $sub['parent_id'],
                ];
            }
            $this->allCategories = array_merge($fC, $this->allCategories);
            $this->allCategories[] = [
                'id' => $parentCategory['id'],
                'count' => array_sum(array_column($fC, 'count')),
            ];
        }
    }

    private function products()
    {
        $this->subCategories();
        $oldCategories = $this->categories;
        $this->categories = [];
        foreach ($oldCategories as $category) {
            $newSub = [];
            foreach ($category['sub'] as $sub) {
                $newProducts = [];
                $products = Product::query()->where('category_id', $sub['id'])
                    ->withCount(['orders' => function ($query) {
                        $query->where('created_at', '>=', $this->currentMonth);
                    }])
                    ->orderByDesc('orders_count')->limit($this->rowsCount)
                    ->get();
                foreach ($products as $product) {
                    $newProducts[] = [
                        'id' => $product->id,
                        'count' => $product->orders_count,
                    ];
                }
                $newSub[] = [
                    'id' => $sub['id'],
                    'count' => $sub['count'],
                    'products' => $newProducts
                ];
            }
            $this->categories[] = [
                'id' => $category['id'],
                'count' => $category['count'],
                'sub' => $newSub
            ];
        }
    }

    private function subCategories()
    {
        $this->categories();
        $oldCategories = $this->categories;
        $this->categories = [];
        foreach ($oldCategories as $oldCategory) {
            $parentCategories = SubCategory::withCount(['products' => function ($query) {
                $query->whereHas('orders', function ($q){
                    $q->where('created_at', '>=', $this->currentMonth);
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
        foreach ($this->categories as $category) {
            $category['sub'] = array_slice($category['sub'], 0,1);
        }
    }

    private function categories()
    {
        $parentCategories = Category::with(['subCategories' => function ($query) {
            $query->withCount(['products' => function ($query) {
                $query->whereHas('orders', function ($q){
                    $q->where('created_at', '>=', $this->currentMonth);
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
        $this->allCategories = $this->categories;
        $this->categories = array_slice($this->categories, 0, $this->rowsCount);
    }

    private function create()
    {
        $this->create = [
            'type' => $this->argument('type'), 'day' => date('d'), 'month'=> date('m'), 'year'=> date('Y'),
            'created_at' => new UTCDateTime(time() * 1000),
        ];
    }

    private function save()
    {
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

    private function oldProducts()
    {
        $parentCategories = Category::with(['subCategories' => function ($query) {
            $query->withCount(['products' => function ($query) {
                $query->whereHas('orders', function ($q){
                    $q->where('created_at', '>=', $this->currentMonth);
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
