<?php

namespace App\Services\CrmVirtualCart;

use App\Models\CrmVirtualCart;
use App\Services\CommandService;

class CrmVirtualCartCommandService extends CommandService
{
    public function updateAll($data)
    {
        $this->updateAllData(CrmVirtualCart::class, $data);
    }
}