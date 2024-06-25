<?php

namespace App\Services\CrmStoreProduct;

use App\Models\CrmStoreProduct;
use App\Services\QueryService;

class CrmStoreProductQueryService extends QueryService
{
    public function first($data)
    {
        return $this->firstData(CrmStoreProduct::class, $data);
    }
}