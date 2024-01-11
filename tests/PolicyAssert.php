<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Test;

use Cura\UserPolicyBundle\Policy\Granted;
use Cura\UserPolicyBundle\Policy\Rejected;
use PHPUnit\Framework\Assert;

final class PolicyAssert
{
    final public static function assertIsGranted(mixed $actual, string $message = ''): void
    {
        Assert::assertInstanceOf(Granted::class, $actual, $message);
    }

    final public static function assertIsRejected(mixed $actual, string $message = ''): void
    {
        Assert::assertInstanceOf(Rejected::class, $actual, $message);
    }
}