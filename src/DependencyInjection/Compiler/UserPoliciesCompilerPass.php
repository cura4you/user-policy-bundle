<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\DependencyInjection\Compiler;

use Cura\UserPolicyBundle\Policy\PolicyRegistry;
use Cura\UserPolicyBundle\Support\Attribute\AsPolicy;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UserPoliciesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $policyRegistryService = $container->getDefinition(PolicyRegistry::class);

        $taggedServices = $container->findTaggedServiceIds('cura.user_policy.policy');
        foreach ($taggedServices as $id => $tags) {
            $reflClass = $container->getReflectionClass($id);
            if ($reflClass === null) {
                continue;
            }
            foreach ($reflClass->getAttributes() as $attribute) {
                if ($attribute->getName() === AsPolicy::class) {
                    /** @var AsPolicy $asPolicyAttribute */
                    $asPolicyAttribute = $attribute->newInstance();
                    $entityClass = $asPolicyAttribute->subjectClass;

                    $policyRegistryService->addMethodCall('register', [$entityClass, new Reference($id)]);
                    break;
                }
            }
        }
    }
}
