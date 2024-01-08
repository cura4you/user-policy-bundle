<?php

declare(strict_types=1);

namespace GeekCell\UserPolicyBundle\Test\Fixture;

use GeekCell\UserPolicyBundle\Trait\CanTrait;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface {
    use CanTrait;

    /** @var string[] */
    private array $roles = [];

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function addRole(string $role): void
    {
        $this->roles[] = $role;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return '';
    }
}
