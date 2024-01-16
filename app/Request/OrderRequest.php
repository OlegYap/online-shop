<?php

namespace Request;

class OrderRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (empty($this->body['name'])) {
            $errors['name'] = 'Введите имя';
        }
        if (empty($this->body['lastname'])) {
            $errors['quantity'] = 'Введите фамилию';
        }
        if (empty($this->body['phonenumber'])) {
            $errors['quantity'] = 'Введите номер телефона';
        }
        if (empty($this->body['address'])) {
            $errors['quantity'] = 'Введите адрес проживания';
        }
        return $errors;
    }
}