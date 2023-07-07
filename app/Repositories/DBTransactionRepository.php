<?php

namespace App\Repositories;

use App\Exceptions\ApiErrorException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            Log::error($e->getMessage(), [$e]);
            throw new ApiErrorException($e);
        }
    }
}
