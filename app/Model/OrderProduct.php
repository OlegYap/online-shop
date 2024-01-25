<?php

namespace Model;

class OrderProduct extends Model
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

    public static function create(int $orderId, array $cartProducts, array $prices): void
    {
        foreach ($cartProducts as $cartProduct) {
            $stmt = self::getPDO()->prepare("INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
            $stmt->execute(['order_id' => $orderId, 'product_id' => $cartProduct->getProductId(), 'quantity' => $cartProduct->getQuantity(), 'price' => $prices[$cartProduct->getProductId()]]);
        }
    }

    public static function getAllByOrderId(int $orderId): array|null
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM order_products WHERE order_id = :order_id');
        $stmt->execute(['order_id' => $orderId]);

        $data = $stmt->fetchAll();

        if (empty($data)){
            return null;
        }
        $arr = [];
        foreach ($data as $obj)
        {
            $arr[] = new self($obj['id'], $obj['order_id'], $obj['product_id'],$obj['quantity'],$obj['price'],);
        }
        return $arr;
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