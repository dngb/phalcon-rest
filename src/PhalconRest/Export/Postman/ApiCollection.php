<?php

namespace PhalconRest\Export\Postman;

class ApiCollection
{
    public $basePath;

    public $info = [];
    public $auth = [];
    public $event = [];
    public $variable = [];

    protected $items = [];

    public function addInfo(array $info)
    {
        $this->info = $info;
    }

    public function addAuth(array $auth)
    {
        $this->auth = $auth;
    }

    public function addEvent(array $event)
    {
        $this->event = $event;
    }

    public function addVariable(array $variable)
    {
        $this->variable = $variable;
    }

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function addManyRoutes(array $routes)
    {
        /** @var \Phalcon\Mvc\Router\Route $route */
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function addRoute(\Phalcon\Mvc\Router\Route $route)
    {
        if (@unserialize($route->getName())) {
            return;
        }

        $this->routes[] = $route;
    }

    public function addItem(Request $request)
    {
        $this->items[] = $request;
    }

    public function addManyCollections(array $collections)
    {
        /** @var \PhalconRest\Api\ApiCollection $collection */
        foreach ($collections as $collection) {
            $this->addCollection($collection);
        }
    }

    public function addCollection(\PhalconRest\Api\ApiCollection $apiCollection)
    {
        $item = array();

        foreach ($apiCollection->getEndpoints() as $apiEndpoint) {

            $link = $this->basePath.$apiCollection->getPrefix().preg_replace('/\{([a-z]+)\}/i', '{{$1}}', $apiEndpoint->getPath());

            $url = parse_url($link);

            $_item = array(
                'name' => $apiCollection->getPrefix().$apiEndpoint->getPath(),
                'request' => array(
                    'method' => $apiEndpoint->getHttpMethod(),
                    'header' => array(
                        array(
                            'key' => 'Content-Type',
                            'value' => 'application/json'
                        )
                    ),
                    'body' => array(
                        'mode' => 'raw',
                        'raw' => $apiEndpoint->getExampleRequest() ? json_encode($apiEndpoint->getExampleRequest(), JSON_PRETTY_PRINT) : ''
                    ),
                    'url' => array(
                        'raw' => $link,
                        'protocol' => $url['scheme'],
                        'host' => explode(".", $url['host']),
                        'path' => explode("/", substr($url['path'], 1))
                    ),
                    'description' => $apiEndpoint->getDescription()
                )
            );

            if($apiEndpoint->getExampleResponse()){
                $_item['response'] = array(
                    array(
                        'name' => 'Sample Response',
                        'body' => $apiEndpoint->getExampleResponse() ? json_encode($apiEndpoint->getExampleResponse(), JSON_PRETTY_PRINT) : ''
                    )
                );
            }
            array_push($item, $_item);
        }

        $this->addItem(new Request(
            $apiCollection->getName(),
            $item
        ));
    }

    public function getItems()
    {
        return $this->items;
    }
}
