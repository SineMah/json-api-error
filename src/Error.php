<?php

namespace Sinema\JsonApi\Error;

class Error
{
    private function __construct(
        public readonly ?int $status,
        public readonly ?string $code,
        public readonly ?string $source,
        public readonly ?string $title,
        public readonly ?string $detail,
    ) {}

    const ERROR_FIELDS = ['status', 'code', 'source', 'title', 'detail'];
    public static function fromArray(array $array): self
    {
        $default = array_fill_keys(self::ERROR_FIELDS, null);
        $only = array_intersect_key($array, array_flip(self::ERROR_FIELDS));

        return call_user_func_array([Error::class, 'load'], array_merge($default, $only));
    }

    public static function load(int $status, ?string $code, ?string $source, string $title, ?string $detail): self
    {
        return new self($status, $code, $source, $title, $detail);
    }

    public function toArray(): array
    {
        return (array) $this;
    }

    public function __toArray(): array
    {
        $error = [];

        foreach (self::ERROR_FIELDS as $field) {
            if($this->{$field} !== null) {
                $error[$field] = $this->{$field};
            }
        }

        return $error;
    }
}
