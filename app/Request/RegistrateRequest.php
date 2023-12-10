<?php

namespace Request;

class RegistrateRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        //$data = $this->body;
        if (isset($this->body['name']))
        {
            $name = $this->body['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно содержать больше двух букв';
            }
        } else {
            $errors['name'] = 'Введите имя';
        }

        if (isset($this->body['email']))
        {
            $email = $this->body['email'];
            if (strlen($email) < 4) {
                $errors['email'] = 'Электронная почта должна содержать больше 4 символов';
            } elseif (!strpos($email,'@')) {
                $errors['email'] = 'Некорректный формат почты';
            }
        } else {
            $errors['email'] = 'Введите email';
        }

        if (isset($this->body['psw-repeat'])) {
            $password = $this->body['psw'];
            $passwordR = $this->body['psw-repeat'];
            if ($password !== $passwordR) {
                $errors['psw'] = 'Пароль должен содержать больше 6 символов';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }

        return $errors;
    }
}