<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Policy;

class RejectionReason
{
    public function __construct(public readonly string $reason)
    {
    }
}
