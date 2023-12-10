<?php

namespace Request;

class Request
{
    protected string $method;
    protected array $headers;
    protected array $body;

    public function __construct(string $method, array $headers = [])
    {
        $this->method = $method;
        $this->headers = $headers;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
    public function setBody(array $body): array
    {
        return $this->body = $body;
    }
    public function getBody(): array
    {
        return $this->body;
    }

}