<?php

namespace App\Repositories;

use App\Exceptions\ApiErrorException;
use Illuminate\Support\Facades\DB;

class DBTransactionRepository
{
    public function executeInTransaction(\Closure $closure)
    {
        DB::beginTransaction();
        try {
            $result = $closure();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiErrorException($e);
        }
    }
}
