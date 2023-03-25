<?php

namespace Birakdar\EasyBuild\Traits;

trait BaseRepositoryTrait
{
    public function find($id, $with = null, $columns = ['*']): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->model = $this->source($with)->findOrFail($id, $columns);
    }

    public function findWhere(string $field, $value, $with = null, $columns = ['*'])
    {
        return $this->source($with)->where($field, $value)->first($columns);
    }

    public function findWhereIn(string $field, array $values, $with = null, $columns = ['*'])
    {
        return $this->source($with)->whereIn($field, $values)->first($columns);
    }

    public function getWhere(string $field, $value, $with = null, $columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->source($with)->where($field, $value)->get($columns);
    }

    public function getWhereIn(string $field, array $values, $with = null, $columns = ['*']): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->source($with)->whereIn($field, $values)->get($columns);
    }

    public function source($with)
    {
        return $this->model->query()->when(! is_null($with), function ($q) use ($with){
            $q->with($with);
        });
    }
}
