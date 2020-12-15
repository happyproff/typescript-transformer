<?php

namespace Spatie\TypeScriptTransformer\TypeReflectors;

use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionType;

class MethodParameterTypeReflector extends TypeReflector
{
    private ReflectionParameter $reflection;

    public static function create(ReflectionParameter $reflection): self
    {
        return new self($reflection);
    }

    public function __construct(ReflectionParameter $reflection)
    {
        $this->reflection = $reflection;
    }

    protected function getDocblock(): string
    {
        return $this->reflection->getDeclaringFunction()->getDocComment();
    }

    protected function docblockRegex(): string
    {
        return "/@param ((?:(?:[\\w?|\\\\<>,])+(?:\\[])?)+) \\\${$this->reflection->getName()}/";
    }

    protected function getReflectionType(): ?ReflectionType
    {
        return $this->reflection->getType();
    }
}