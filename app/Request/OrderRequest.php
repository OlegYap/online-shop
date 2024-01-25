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
            $errors['lastname'] = 'Введите фамилию';
        }
        if (empty($this->body['phonenumber'])) {
            $errors['phonenumber'] = 'Введите номер телефона';
        }
        if (empty($this->body['address'])) {
            $errors['address'] = 'Введите адрес проживания';
        }
        return $errors;
    }
}