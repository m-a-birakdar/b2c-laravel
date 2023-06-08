<?php

namespace Modules\Report\Interfaces\DaApi;

interface MainReportRepositoryInterface
{
    public function show($type, $where);
    public function index($type, $sub);
}
