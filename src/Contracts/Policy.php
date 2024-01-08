<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Contracts;

use Cura\UserPolicyBundle\Policy\ErrorPolicyResult;
use Cura\UserPolicyBundle\Policy\OkPolicyResult;
use Stringable;

interface Policy
{
    /**
     * This function should be read as "can $instance do $ability"
     * @param class-string|object $subject
     */
    public function canDo(object $instance, Stringable $ability, string|object $subject, mixed ...$arguments): OkPolicyResult|ErrorPolicyResult;
}
