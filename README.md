# Symfony Bundle for User Policies

This bundle is inspired by the [GeekCell User Policy bundle](https://github.com/geekcell/user-policy-bundle) and was adapted for the use cases Cura4You is facing.

## Example

Let's say you are working on a video platform where users are only allowed to upload if they either have a premium subscription or a remaining upload quota.

```php
use Cura\UserPolicyBundle\Policy\AbilityNotSupportedRejection;
use Cura\UserPolicyBundle\Policy\Rejected;
use Cura\UserPolicyBundle\Policy\Granted;
use Cura\UserPolicyBundle\Policy\RejectionReason;

#[AsPolicy(Video::class)]
/** @implements Policy<User, Video> */
class VideoPolicy implements Policy
{
    public function __construct(
        private readonly QuotaService $quotaService,
    ) {
    }

    public function canDo(
        $instance,
        string $ability,
        $subject,
        mixed ...$arguments
    ): Granted|Rejected {
        match ($ability) {
            'upload' => $this->upload($instance),
            default => new Rejected(new AbilityNotSupportedRejection())
        }
    }
    
    public function upload(User $user): Granted
    {
        if ($user->hasPremiumSubscription()) {
            return new Granted();
        }
        
        if ($this->quotaService->getRemainingUserUploads($user) > 0) {
            return new Granted();
        }
        
        return new Rejected(new RejectionReason('User has no premium subscription or remaining quote'));
    }
}
```

```php
use Cura\UserPolicyBundle\Policy\Granted;

class VideoController extends AbstractController
{
    #[Route('/videos/new_upload')]
    public function create(): Response
    {
        if ($this->getUser()->can('upload', Video::class) instanceof Granted) {
            // Proceed with upload ...
        }

        $this->createAccessDeniedException('Operation not allowed.');
    }
}
```

Pretty nice, isn't it? The business logic is encapsulated in policy classes and can be _magically queried_ directly from the user object.

## Installation

To use this bundle, require it in Composer

```bash
composer require cura/user-policy-bundle
```

When installed, add the following lines in your `config/services.yaml`

```yaml
services:

    # Add these lines below to your services.yaml

    _instanceof:
        Cura\UserPolicyBundle\Contracts\Policy:
            tags: ['cura.user_policy.policy']
```

These lines are crucial for Symfony to auto-discover the policies defined in your app. Alternatively, policies can be manually configured or even guessed by name, but these methods are not recommended.

Now add the `PolicyResolverTrait` trait to you user class.

```php
<?php

namespace App\Security;

use Cura\UserPolicyBundle\Trait\PolicyResolverTrait;
class User
{
    use PolicyResolverTrait;
}
```

You are now ready to go.

## Writing Policies

A basic policy looks like this:

```php
<?php

namespace App\Security\Policy;

use App\Entity\Book;
use App\Security\User;
use Cura\UserPolicyBundle\Policy\AbilityNotSupportedRejection;
use Cura\UserPolicyBundle\Policy\Granted;use Cura\UserPolicyBundle\Policy\Rejected;
use GeekCell\UserPolicyBundle\Contracts\Policy;
use GeekCell\UserPolicyBundle\Support\Attribute\AsPolicy;

#[AsPolicy(Book::class)]
/** @implements Policy<User, Book> */
class BookPolicy implements Policy
{
    public function canDo(
        $instance,
        string $ability,
        $subject,
        mixed ...$arguments
    ): Granted|Rejected {
      return match ($ability) {  
        'create' => $this->create($instance),
        'update' => $this->update($instance, $subject),
        'delete' => $this->delete($instance, $subject, $arguments),
        default => new Rejected(new AbilityNotSupportedRejection());
      }
    }
    
    public function create(User $user): Granted|Rejected
    {
        // ...
    }

    public function update(User $user, Book $book): Granted|Rejected
    {
        // ...
    }

    public function delete(User $user, Book $book, mixed $someArguments): Granted|Rejected
    {
        // ...
    }
}
```

Let's break it down:

- A policy must implement the `Cura\UserPolicyBundle\Contracts\Policy` interface.
- Use the `#[AsPolicy]` attribute to associate a policy to a subject.
- Annotate the polcy with `/** @implements Policy<InstanceClass, SubjectClass> */` to help with static analysis/auto completion
- The policy methods can have arbitrary names, i.e. they're not limited to CRUD operations.
    - The `canDo` function always received the object that "uses" the trait as first argument following by the ability like `create`, `update` etc., the subject (as class-string or object instance) and any other parameters passed into the `can` function

Since the `canDo` function must always return either an instance of `Granted` or `Rejected` the default match arms in the examples above always return a `AbilityNotSupported` "rejection". We recommend you to do the same.

## Inspiration(s)

- Laravel Authorization (https://laravel.com/docs/authorization)
- GeekCell user policy bundle (https://github.com/geekcell/user-policy-bundle)
