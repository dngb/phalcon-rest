<?php

namespace PhalconRest\Export\Postman;

class Request
{
    public $name;
    public $item;

    public function __construct(
        $name,
        $item
    ) {
        $this->name = $name;
        $this->item = $item;
    }
}
