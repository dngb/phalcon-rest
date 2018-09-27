<?php

namespace PhalconRest\Transformers\Postman;

use PhalconRest\Export\Postman\Request as PostmanRequest;
use PhalconRest\Transformers\Transformer;

class RequestTransformer extends Transformer
{
    public function transform(PostmanRequest $request)
    {
        return [
            'name' => $request->name,
            'item' => $request->item,
        ];
    }
}
