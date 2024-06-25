<?php

namespace App\Services\CrmOrderItemDetail;

use App\Models\CrmOrderItemDetail;
use App\Services\CommandService;

class CrmOrderItemDetailCommandService extends CommandService
{
    public function create($data)
    {
        return $this->createData(CrmOrderItemDetail::class, $data);
    }
}