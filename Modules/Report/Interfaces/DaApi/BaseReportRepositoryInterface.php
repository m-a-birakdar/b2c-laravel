<?php

namespace Modules\Report\Interfaces\DaApi;

interface BaseReportRepositoryInterface
{
    public function show($id, $type, $where);
    public function index($id, $type, $sub);
    public function compareOne(array $ids, $type, $where);
    public function compareMany(array $ids, $type, $sub);
}
