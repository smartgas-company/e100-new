<?php

namespace App\Services\CrmPump;

use App\Models\CrmPump;
use App\Services\QueryService;

class CrmPumpQueryService extends QueryService
{
    public function first($data)
    {
        return $this->firstData(CrmPump::class, $data);
    }
}