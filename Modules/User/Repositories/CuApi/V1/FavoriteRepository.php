<?php

namespace Modules\User\Repositories\CuApi\V1;

use Birakdar\EasyBuild\Traits\BaseRepositoryTrait;
use Modules\Product\Enums\StatisticsEnum;
use Modules\Product\Jobs\ProductStatisticsJob;
use Modules\Product\Repositories\CuApi\V1\ProductRepository;
use Modules\User\Entities\Favorite;
use Modules\User\Interfaces\CuApi\V1\FavoriteRepositoryInterface;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    use BaseRepositoryTrait;

    public Favorite|null $model;

    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

    public function index(): \Illuminate\Contracts\Pagination\Paginator
    {
        $ids = $this->model->where('user_id', (int) sanctum()->id)->first();
        return ( new ProductRepository() )->getFavorites($ids ? $ids->product_ids : []);
    }

    public function toggle($status, $id)
    {
        return $this->{$status == 'add' ? 'add' : 'remove'}((int) $id);
    }

    private function add($id)
    {
        $favorite = $this->model->where('user_id', (int) sanctum()->id)->first();
        if ($favorite){
            if (in_array($id, $favorite->product_ids))
                return true;
            ProductStatisticsJob::dispatch($id, sanctum()->id, StatisticsEnum::AddToFavorite, time());
            $ids = array_merge($favorite->product_ids, (array) $id);
            return $favorite->update([
                'product_ids' => array_unique($ids),
            ]);
        }
        return $this->model->create([
            'product_ids' => (array) $id,
            'user_id' => (int) sanctum()->id,
        ]);
    }

    private function remove($id)
    {
        $favorite = $this->model->where('user_id', (int) sanctum()->id)->first();
        if ($favorite){
            $ids = $favorite->product_ids;
            if (! in_array($id, $favorite->product_ids))
                return true;
            $new = array_diff($ids, [$id]);
            ProductStatisticsJob::dispatch($id, sanctum()->id, StatisticsEnum::RemoveFromFavorite, time());
            return (count($new) > 0) ? $favorite->update([
                'product_ids' => array_unique($new),
            ]) : $this->model->where('user_id', (int) sanctum()->id)->delete();
        }
        return true;
    }
}
