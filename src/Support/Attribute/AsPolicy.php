<?php

declare(strict_types=1);

namespace Cura\UserPolicyBundle\Support\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AsPolicy
{
    /**
     * @param class-string $subjectClass
     */
    public function __construct(
        public readonly string $subjectClass,
    ) {
    }
}
