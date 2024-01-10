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