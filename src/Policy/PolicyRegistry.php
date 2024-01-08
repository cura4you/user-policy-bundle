<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Policy;

use Cura\UserPolicyBundle\Contracts\Policy;

class PolicyRegistry
{
    /**
     * @var array<class-string, Policy>
     */
    private array $registry = [];

    /**
     * @param class-string $class
     */
    public function register(string $class, Policy $policy): void
    {
        $this->registry[$class] = $policy;
    }

    /**
     * @param class-string $class
     */
    public function get(string $class): ?Policy
    {
        return $this->registry[$class] ?? null;
    }
}
