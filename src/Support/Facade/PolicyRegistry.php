<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Support\Facade;

use Cura\UserPolicyBundle\Contracts\Policy;
use GeekCell\Facade\Facade;
use Cura\UserPolicyBundle\Policy\PolicyRegistry as PolicyRegistryService;

/**
 * @method static Policy|null get(string $class)
 */
class PolicyRegistry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PolicyRegistryService::class;
    }
}
