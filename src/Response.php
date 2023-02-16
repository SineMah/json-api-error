<?php

namespace Sinema\JsonApi\Error;

use Sinema\JsonApi\Traits\HasSingleton;

class Response
{
    use HasSingleton;

    protected ?ErrorBag $errors = null;

    public function __construct(null|array|Error $errors = null)
    {
        $this->errors = new ErrorBag();

        if($errors) {
            $this->errors->add($errors);
        }
    }

    public function errors(): ErrorBag
    {
        return $this->errors;
    }

    public function add(array|Error $errors): self
    {
        $this->errors->add($errors);

        return $this;
    }

    public function toArray(): array
    {
        return $this->errors->toArray();
    }
}
