<?php

namespace Modules\Chat\Interfaces\Ajax;

interface ChatRepositoryInterface
{
    public function messages($firstId, $secondId);
}
