<?php

namespace App\Services\CrmStore;

use App\Services\CommandService;

class CrmStoreCommandService extends CommandService
{
    public function __construct(
        private readonly CrmStoreCommandService $crmStoreCommandService,
        private readonly CrmStoreQueryService $crmStoreQueryService,
    )
    {
    }
}