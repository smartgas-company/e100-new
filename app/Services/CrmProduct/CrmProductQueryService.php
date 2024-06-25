<?php

namespace App\Services\CrmProduct;

use App\Models\CrmProduct;
use App\Services\QueryService;

class CrmProductQueryService extends QueryService
{
    public function first($data)
    {
        return $this->firstData(CrmProduct::class, $data);
    }
}