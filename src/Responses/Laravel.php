<?php

namespace Sinema\JsonApi\Error\Responses;

use Illuminate\Http\JsonResponse;
use Sinema\JsonApi\Error\Response as JsonApiErrorResponse;
use Sinema\JsonApi\Error\Error;
use Sinema\JsonApi\Traits\HasSingleton;

class Laravel extends JsonApiErrorResponse
{
    use HasSingleton;
    public function json(int $status, null|array|Error $errors, $headers = []): JsonResponse
    {
        $this->errors->add($errors);

        return response()->json($this->errors->toArray(), $status, $headers);
    }
}
