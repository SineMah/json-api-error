<?php

namespace Sinema\JsonApi\Error;

use Sinema\JsonApi\Error\Exceptions\EmptyErrorException;

class Error
{
    private function __construct(
        public readonly ?int $status,
        public readonly ?string $id,
        public readonly ?array $links,
        public readonly ?string $code,
        public readonly ?array $source,
        public readonly ?string $title,
        public readonly ?string $detail,
        public readonly ?array $meta,
    ) {}

    const ERROR_FIELDS = ['id', 'links', 'status', 'code', 'source', 'title', 'detail', 'meta'];
    public static function fromArray(array $array): self
    {
        $default = array_fill_keys(self::ERROR_FIELDS, null);
        $only = array_intersect_key($array, array_flip(self::ERROR_FIELDS));

        return call_user_func_array([Error::class, 'load'], array_merge($default, $only));
    }

    public static function load(
        int $status,
        ?string $id,
        ?array $links,
        ?string $code,
        ?string $source,
        ?string $title,
        ?string $detail,
        ?array $meta
    ): self
    {
        return new self($status, $id, $links, $code, $source, $title, $detail, $meta);
    }

    /**
     * @throws EmptyErrorException
     */
    public function toArray(): array
    {
        $error = [];

        foreach (self::ERROR_FIELDS as $field) {
            if($this->{$field} !== null) {
                $error[$field] = $this->{$field};
            }
        }

        if(count(array_diff(['code', 'title'], array_keys($error))) === 2) {
            throw new EmptyErrorException(sprintf('Atleast set title and/or code in %s', Error::class));
        }

        return $error;
    }
}
