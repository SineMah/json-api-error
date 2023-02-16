<?php

namespace Sinemah\JsonApi\Error\Responses;

use Illuminate\Http\JsonResponse;
use Sinemah\JsonApi\Error\Exceptions\StatusUnavailableException;
use Sinemah\JsonApi\Error\Response as JsonApiErrorResponse;
use Sinemah\JsonApi\Error\Error;
use Sinemah\JsonApi\Error\Traits\HasSingleton;

class Laravel extends JsonApiErrorResponse
{
    use HasSingleton;

    /**
     * @throws StatusUnavailableException
     */
    public function json(null|array|Error $errors = null, ?int $status = null, $headers = []): JsonResponse
    {
        if($errors) {
            $this->errors->add($errors);
        }

        return response()->json($this->toArray(), $this->getStatus($status), $headers);
    }

    /**
     * @throws StatusUnavailableException
     */
    protected function getStatus(?int $status): ?int
    {
        if($status === null) {
            $error = $this->errors->first();
            $status = $error->status ?? null;
        }

        $this->validateStatus($status);

        return $status;
    }

    protected function validateStatus(?int $status): void
    {
        if($status === null) {
            throw new StatusUnavailableException('Neither staus nor Errors delivered');
        }
    }
}
