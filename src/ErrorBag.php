<?php

namespace Sinema\JsonApi\Error;

use Sinema\JsonApi\Error\Exceptions\EmptyErrorException;

class ErrorBag
{
    protected array $errors = [];

    public function add(array|Error $errors): self
    {
        if(!is_array($errors)) {
            $errors = [$errors];
        }

        if($this->isAssoc($errors)) {
            $errors = [Error::fromArray($errors)];
        }

        $this->errors = array_merge($this->errors, $errors);

        return $this;
    }

    public function all(): array
    {
        return $this->errors;
    }

    public function first(): ?Error
    {
        if($first = reset($this->errors)) {
            return $first;
        }

        return null;
    }

    public function next(): ?Error
    {
        if($next = next($this->errors)) {
            return $next;
        }

        return null;
    }

    public function current(): ?Error
    {
        if($current = current($this->errors)) {
            return $current;
        }

        return null;
    }

    public function merge(ErrorBag $errors): self
    {
        $this->errors = array_merge($this->errors, $errors->all());

        return $this;
    }

    /**
     * @throws EmptyErrorException
     */
    public function toArray(): array
    {
        $castedErrors = [];

        foreach ($this->errors as $error) {

            assert($error instanceof Error);

            $castedErrors[] = $error->toArray();
        }

        return $castedErrors;
    }

    protected function isAssoc(array $array): bool
    {
        $keys = array_keys($array);

        sort($keys);

        return array_keys($keys) !== $keys;
    }
}
