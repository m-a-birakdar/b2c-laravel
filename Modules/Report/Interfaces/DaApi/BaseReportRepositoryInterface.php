<?php

namespace Modules\Report\Interfaces\DaApi;

interface BaseReportRepositoryInterface
{
    public function show($id, $type, $where);
    public function index($ids, $type, $where);
    public function compare(array $ids, $type);
}
