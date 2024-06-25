<?php

namespace App\Services\CrmOrderNipl;

use App\Models\CrmOrderNipl;
use App\Services\CommandService;

class CrmOrderNiplCommandService extends CommandService
{
    public function create($data)
    {
        return $this->createData(CrmOrderNipl::class, $data);
    }
}