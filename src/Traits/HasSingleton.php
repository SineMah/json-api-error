<?php

namespace Sinema\JsonApi\Traits;

trait HasSingleton
{
    protected static mixed $response = null;
    public static function get(): self
    {
        if(self::$response === null) {
            self::$response = new self();
        }

        return self::$response;
    }
}
