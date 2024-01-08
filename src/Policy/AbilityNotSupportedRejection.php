<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Policy;

class AbilityNotSupportedRejection extends RejectionReason
{
    public function __construct(string $ability)
    {
        parent::__construct(sprintf('Ability %s is not supported', $ability));
    }
}
