<?php

namespace App\Services\CrmVirtualCart;

use App\Models\CrmVirtualCart;
use App\Services\QueryService;

class CrmVirtualCartQueryService extends QueryService
{
    public function first($data)
    {
        return $this->firstData(CrmVirtualCart::class, $data);
    }
}