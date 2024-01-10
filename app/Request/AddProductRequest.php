<?php

namespace Request;

class AddProductRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (empty($this->body['product_id'])) {
            $errors['product_id'] = ' Введите id продукта';
        }

        if (empty($this->body['quantity'])) {
            $errors['quantity'] = ' Введите кол-во';
        }
        return $errors;
    }
}

/*    public function validate(): array
{
    $errors = [];
    if (isset($this->body['email'])) {
        $login = $this->body['email'];
        if (empty($login)) {
            $errors ['login'] = 'Заполните поле Login';
        } elseif (!strpos($login, '@')) {
            $errors['login'] = "Некорректный формат почты";
        }
    } else {
        $errors['login'] = 'Заполните поле Login';
    }
    if (isset($this->body['psw'])) {
        $password = $this->body['psw'];
        if (empty($password)) {
            $errors['psw'] = 'Введите пароль';
        }
    } else {
        $errors['psw'] = 'Введите пароль';
    }
    return $errors;
}*/