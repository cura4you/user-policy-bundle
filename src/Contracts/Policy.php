<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Contracts;

use Cura\UserPolicyBundle\Policy\Rejected;
use Cura\UserPolicyBundle\Policy\Granted;

/**
 * @template Instance of object
 * @template Subject of object
 */
interface Policy
{
    /**
     * This function should be read as "can $instance do $ability"
     *
     * @param Instance $instance
     * @param class-string<Subject>|Subject $subject
     */
    public function canDo($instance, string $ability, $subject, mixed ...$arguments): Granted|Rejected;
}
