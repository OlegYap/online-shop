<?php

namespace Request;

class Request
{
    private string $method;
    private array $headers;
    private array $body;

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