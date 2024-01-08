<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Policy;

final readonly class Rejected
{
    public function __construct(public RejectionReason $reason)
    {
    }
}
