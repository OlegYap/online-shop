<?php

namespace Request;

// http запрос состоит из чего? Из метода, headers, body . Из чего состоит http ответ? Из метода, URI, версию HTTP и адрес хоста. Строка статуса, headers, body. Рассказать про компоненты, из чего состоят компоненты
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
    public function setBody(array $body)
    {
         $this->body = $body;
    }
    public function getBody(): array
    {
        return $this->body;
    }

}
