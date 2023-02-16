# JSON:API error response

## Installation
`composer require sinema/json-api-error`

## Usage

In your Laravel controller:
```php
<?php

namespace App\Http\Controllers;

use Sinema\JsonApi\Error\Error;
use Sinema\JsonApi\Error\Responses\Laravel;
use Illuminate\Http\JsonResponse;

class AnyController extends Controller
{
    public function show(): JsonResponse
    {

        return Laravel::get()->json(
            404,
            Error::fromArray(
                [
                    'status' => 404,
                    'source' => null,
                    'title' => 'Item not found',
                    'detail' => sprintf('Item %s not found', request('item_uuid')),
                ]
            )
        );
//        https://jsonapi.org/examples/#error-objects-basics
    }
}
```

Response
```json
{
    "errors": [
        {
            "status": 404,
            "title": "Bike not found",
            "detail": "Bike bd11f048-8663-4d95-8c7a-02a5579b0682 not found in customer data"
        }
    ]
}
```

Build an error stack
```php
<?php

namespace App\Http\Controllers;

use Sinema\JsonApi\Error\Error;
use Sinema\JsonApi\Error\Responses\Laravel;
use Illuminate\Http\JsonResponse;

class AnyController extends Controller
{
    public function show(): JsonResponse
    {
        return Laravel::get()
            ->add(Error::fromArray(['status' => 500, 'code' => 'first_error']))
            ->add(Error::fromArray(['status' => 500, 'code' => 'second_error']))
            ->add(Error::fromArray(['status' => 500, 'code' => 'third_error']))
            ->json(500);
    }
}
```
Response
```json
{
    "errors": [
        {
            "status": 500,
            "code": "first_error"
        },
        {
            "status": 500,
            "code": "second_error"
        },
        {
            "status": 500,
            "code": "third_error"
        }
    ]
}
```