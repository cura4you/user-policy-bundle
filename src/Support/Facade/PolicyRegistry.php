<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Support\Facade;

use GeekCell\Facade\Facade;
use Cura\UserPolicyBundle\Policy\PolicyRegistry as PolicyRegistryService;

class PolicyRegistry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PolicyRegistryService::class;
    }
}
