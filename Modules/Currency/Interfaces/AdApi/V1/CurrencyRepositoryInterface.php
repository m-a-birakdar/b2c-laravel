<?php

namespace Modules\Currency\Interfaces\AdApi\V1;

interface CurrencyRepositoryInterface
{
    public function show($id);
    public function update(array $array, $id);
}
