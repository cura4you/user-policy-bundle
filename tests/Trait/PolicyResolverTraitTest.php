<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Test\Trait;

use Cura\UserPolicyBundle\Policy\Rejected;
use Cura\UserPolicyBundle\Policy\Granted;
use Cura\UserPolicyBundle\Policy\RejectionReason;
use Cura\UserPolicyBundle\Trait\PolicyResolverTrait;
use GeekCell\Facade\Facade;
use Cura\UserPolicyBundle\Contracts\Policy;
use Cura\UserPolicyBundle\Policy\PolicyRegistry;
use Cura\UserPolicyBundle\Test\Fixture\Container;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class User
{
    use PolicyResolverTrait;
}

class Dummy
{
}

class DummyPolicy implements Policy
{
    public function __construct(private readonly Granted|Rejected $canDoResult)
    {
    }

    public function canDo(
        $instance,
        string $ability,
        $subject,
        mixed ...$arguments
    ): Granted|Rejected {
        return $this->canDoResult;
    }
}

final class PolicyResolverTraitTest extends TestCase
{
    private PolicyRegistry $policyRegistry;

    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
        $this->policyRegistry = new PolicyRegistry();
        $facadeContainer = new Container($this->policyRegistry);

        Facade::setContainer($facadeContainer);
    }

    protected function tearDown(): void
    {
        Facade::clear();
    }

    public function testCanThrowsExceptionIfGivenSubjectIsNotValidClass(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Class invalid-class does not exist');

        // @phpstan-ignore-next-line
        $this->user->can('doSomething', 'invalid-class');
    }

    public function testCanThrowsExceptionIfNoPolicyRegisteredForSubject(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Could not find policy');

        $this->user->can('doSomething', new Dummy());
    }

    public function testCanReturnsPolicyResult(): void
    {
        $result = new Rejected(new RejectionReason('Dummy'));
        $policy = new DummyPolicy($result);
        $subject = new Dummy();
        $ability = 'doSomething';

        $this->policyRegistry->register(Dummy::class, $policy);
        $this->assertSame($result, $this->user->can($ability, $subject));
    }
}
