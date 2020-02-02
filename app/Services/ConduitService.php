<?php

namespace App\Services;

class ConduitService{

    public function __construct() {
        $this->client = new \ConduitClient("https://p.mongla.net");
        $this->client->setConduitToken(env('CONDUIT_API_KEY', '')); //@TODO REMOVE [SECURITY]
    }

    public function __call($method, $args) {
        if(is_callable([$this->client,$method])) {
            return call_user_func_array([$this->client,$method],$args);
        } else {
            throw new BadMethodCallException("Method $method does not exist");
        }
    }

    /**
     * Pass any property calls onto $this->client
     *
     * @return mixed
     */
    public function __get($property) {
        if(property_exists($this->client,$property)) {
            return $this->client->{$property};
        } else {
            throw new BadMethodCallException("Property $property does not exist");
        }
    }
}