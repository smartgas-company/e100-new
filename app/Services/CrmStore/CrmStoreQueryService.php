<?php

namespace App\Services\CrmStore;

use App\Models\CrmStore;
use App\Services\QueryService;

class CrmStoreQueryService extends QueryService
{
    public function first($data)
    {
        return $this->firstData(CrmStore::class, $data);
    }
}