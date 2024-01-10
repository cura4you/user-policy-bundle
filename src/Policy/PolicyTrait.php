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

    /**
     * Takes in a list of either:
     * - Granted object
     * - Rejected object
     * - callable that returns Granted|Rejected object
     * Returns first rejected object or Granted if no Rejected objects were found
     *
     * @param Granted|Rejected|(callable(): (Granted|Rejected)) ...$grantsOrRejections
     */
    private function canAll(Granted|Rejected|callable ...$grantsOrRejections): Granted|Rejected
    {
        foreach ($grantsOrRejections as $grantedOrRejected) {
            $result = $grantedOrRejected;
            if (is_callable($grantedOrRejected)) {
                $result = $grantedOrRejected();
            }

            if ($result instanceof Rejected) {
                return $result;
            }
        }

        return new Granted();
    }
}
