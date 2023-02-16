<?php

namespace Sinema\JsonApi\Error;

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

    public function toArray(): array
    {
        $castedErrors = [];

        foreach ($this->errors as $error) {
            $castedErrors[] = (array) $error;
        }

        return ['errors' => $castedErrors];
    }

    protected function isAssoc(array $array): bool
    {
        $keys = array_keys($array);

        sort($keys);

        return array_keys($keys) !== $keys;
    }
}
