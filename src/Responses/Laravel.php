<?php

namespace Sinema\JsonApi\Error\Responses;

use Illuminate\Http\JsonResponse;
use Sinema\JsonApi\Error\Exceptions\StatusUnavailableException;
use Sinema\JsonApi\Error\Response as JsonApiErrorResponse;
use Sinema\JsonApi\Error\Error;
use Sinema\JsonApi\Error\Traits\HasSingleton;

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
