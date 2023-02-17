# JSON:API error response

## Spec
https://jsonapi.org/examples/#error-objects-basics

## Installation
`composer require sinema/json-api-error`

## Usage

### Basic Usage
```php
<?php

use Sinemah\JsonApi\Error\Error;
use Sinemah\JsonApi\Error\ErrorBag;

$errors = new ErrorBag();

$errors->add(
    Error::fromArray(
        [
            'status' => 404,
            'source' => null,
            'title' => 'Item not found',
            'detail' => sprintf('Item %s not found', 'some-id'),
        ]
    )
);

$errors->toArray()
```

Result as JSON representation
```json
[
  {
    "status": 404,
    "title": "Item not found",
    "detail": "Item some-id not found"
  }
]
```

### Response Usage

```php
<?php

use Sinemah\JsonApi\Error\Error;
use Sinemah\JsonApi\Error\Response;

$response = Response::get();

$response->add(
    Error::fromArray(
        [
            'status' => 404,
            'source' => null,
            'title' => 'Item not found',
            'detail' => sprintf('Item %s not found', 'some-id'),
        ]
    )
);

$response->toArray()
```

Result as JSON representation
```json
{
    "errors": [
        {
            "status": 404,
            "title": "Item not found",
            "detail": "Item some-id not found"
        }
    ]
}
```