<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle;

use GeekCell\Facade\Facade;
use Cura\UserPolicyBundle\DependencyInjection\Compiler\UserPoliciesCompilerPass;
use Cura\UserPolicyBundle\DependencyInjection\CuraUserPolicyExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CuraUserPolicyBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new UserPoliciesCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CuraUserPolicyExtension();
    }

    public function boot(): void
    {
        parent::boot();

        if ($this->container instanceof \Psr\Container\ContainerInterface) {
            Facade::setContainer($this->container);
        }
    }
}
