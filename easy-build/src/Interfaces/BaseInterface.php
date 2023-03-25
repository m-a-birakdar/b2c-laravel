<?php

namespace Birakdar\EasyBuild\Interfaces;

interface BaseInterface
{
    public function index($columns = ['*']);
    public function store(array $array);
    public function show($id, $with = null, $columns = ['*']);
    public function find($id, $with = null, $columns = ['*']);
    public function update(array $array, $id);
    public function destroy($id);
    public function findWhere(string $field, $value, $with = null, $columns = ['*']);
    public function findWhereIn(string $field, array $values, $with = null, $columns = ['*']);
    public function getWhere(string $field, $value, $with = null, $columns = ['*']);
    public function getWhereIn(string $field, array $values, $with = null, $columns = ['*']);
}
