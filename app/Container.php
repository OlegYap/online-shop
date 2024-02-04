<?php

class Container
{
    private array $services;

    public function set(string $classname, callable $callback)
    {
        $this->services[$classname] = $callback;
    }

    public function get(string $classname): object
    {
        if (!isset($this->services[$classname])){
            return new $classname;
        }

        $callback = $this->services[$classname];
        return $callback($this);
    }

}