<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Policy;

use Cura\UserPolicyBundle\Policy\Granted;
use Cura\UserPolicyBundle\Policy\Rejected;
use Cura\UserPolicyBundle\Policy\RejectionReason;

trait PolicyTrait
{
    private function reject(string|RejectionReason $rejectionReason): Rejected
    {
        if ($rejectionReason instanceof RejectionReason) {
            return new Rejected($rejectionReason);
        }

        return new Rejected(new RejectionReason($rejectionReason));
    }

    private function abilityNotSupported(string $ability): Rejected
    {
        return new Rejected(new AbilityNotSupportedRejection($ability));
    }

    private function grant(): Granted
    {
        return new Granted();
    }
}
