<?php

namespace PhalconRest\Transformers\Postman;

use PhalconRest\Export\Postman\ApiCollection as PostmanCollection;
use PhalconRest\Transformers\Transformer;

class ApiCollectionTransformer extends Transformer
{
    protected $defaultIncludes = [
        'item',
    ];

    public function transform(PostmanCollection $collection)
    {
        return [
            'info' => $collection->info,
            'auth' => $collection->auth,
            'event' => $collection->event,
            'variable' => $collection->variable
        ];
    }

    public function includeItem(PostmanCollection $collection)
    {
        return $this->collection($collection->getItems(), new RequestTransformer);
    }
}
