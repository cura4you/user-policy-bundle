<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Trait;

use Cura\UserPolicyBundle\Contracts\Policy;
use Cura\UserPolicyBundle\Policy\Rejected;
use Cura\UserPolicyBundle\Policy\Granted;
use Cura\UserPolicyBundle\Policy\PolicyRegistry;
use Cura\UserPolicyBundle\Support\Facade\PolicyRegistry as PolicyRegistryFacade;
use InvalidArgumentException;

trait PolicyResolverTrait
{
    /**
     * @param class-string|object $subject
     */
    public function can(string $ability, string|object $subject, mixed ...$extraArgs): Granted|Rejected
    {
        return $this
            ->resolvePolicy($subject)
            ->canDo($this, $ability, $subject, ...$extraArgs);
    }

    /**
     * @param class-string|object $subject
     */
    private function resolvePolicy(string|object $subject): Policy
    {
        if (is_object($subject)) {
            $subject = $subject::class;
        }

        if (!class_exists($subject)) {
            throw new InvalidArgumentException(
                sprintf('Class %s does not exist', $subject)
            );
        }

        /** @see PolicyRegistry::get() */
        $policy = PolicyRegistryFacade::get($subject);
        if (!$policy instanceof Policy) {
            throw new InvalidArgumentException(
                sprintf(
                    'Could not find policy for subject "%s". Try implementing %s (and configuring it in your services.yaml file) or manually registering the policy for the class by calling %s::register',
                    $subject,
                    PolicyRegistry::class,
                    Policy::class
                )
            );
        }

        return $policy;
    }
}
