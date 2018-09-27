<?php

namespace PhalconRest\Transformers\Documentation;

use PhalconRest\Export\Documentation\ApiEndpoint as DocumentationEndpoint;
use PhalconRest\Transformers\Transformer;

class ApiEndpointTransformer extends Transformer
{
    public function transform(DocumentationEndpoint $endpoint)
    {
        return [
            'name' => $endpoint->getName(),
            'description' => $endpoint->getDescription(),
            'explenation' => $endpoint->getExplenation(),
            'httpMethod' => $endpoint->getHttpMethod(),
            'path' => $endpoint->getPath(),
            'exampleRequest' => $endpoint->getExampleRequest(),
            'exampleResponse' => $endpoint->getExampleResponse(),
            'allowedRoles' => $endpoint->getAllowedRoles()
        ];
    }
}
