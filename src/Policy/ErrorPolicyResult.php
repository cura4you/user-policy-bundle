<?php

namespace Cura\UserPolicyBundle\Policy;

use Throwable;

class ErrorPolicyResult implements PolicyResult, Throwable
{
    public function __construct(public readonly Throwable $error)
    {

    }

    public function getMessage(): string
    {
        return $this->error->getMessage();
    }

    public function getCode()
    {
        return $this->error->getCode();
    }

    public function getFile(): string
    {
        return $this->error->getFile();
    }

    public function getLine(): int
    {
        return $this->error->getLine();
    }

    public function getTrace(): array
    {
        return $this->error->getTrace();
    }

    public function getTraceAsString(): string
    {
        return $this->error->getTraceAsString();
    }

    public function getPrevious(): ?Throwable
    {
        return $this->error->getPrevious();
    }

    public function __toString()
    {
        return $this->error->__toString();
    }
}
