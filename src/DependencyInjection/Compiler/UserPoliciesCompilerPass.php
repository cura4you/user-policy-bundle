<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\DependencyInjection\Compiler;

use Cura\UserPolicyBundle\Support\Attribute\AsPolicy;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UserPoliciesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $policyRegistryService = $container->getDefinition('cura.user_policy.policy_registry');

        $taggedServices = $container->findTaggedServiceIds('cura.user_policy.policy');
        foreach ($taggedServices as $id => $tags) {
            $reflClass = $container->getReflectionClass($id);
            foreach ($reflClass->getAttributes() as $attribute) {
                if ($attribute->getName() === AsPolicy::class) {
                    $entityClass = $attribute->newInstance()->getSubjectClass();

                    $policyRegistryService->addMethodCall('register', [$entityClass, new Reference($id)]);
                    break;
                }
            }
        }
    }
}
