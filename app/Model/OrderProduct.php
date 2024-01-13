<?php

namespace Model;

class OrderProduct
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;
    private float $price;

    public function __construct(int $id, int $orderId, int $productId, int $quantity, float $price)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getId(): int
    {
        return $this->id;
    }


}