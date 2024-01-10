<?php
namespace Model;

class CartProduct extends Model
{
    private int $id;
    private int $cardId;
    private int $productId;
    private int $quantity;

    public function __construct(int $id, int $cardId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->cardId = $cardId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function create(int $cartId, int $productId, int $quantity): bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt =self::getPDO()->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        return $stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getAllByCartId(int $cartId): array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
        $stmt->execute(['cart_id' => $cartId]);
        $data = $stmt->fetchAll();

        $arr = [];
        foreach ($data as $cartProduct)
        {
            $arr[$data['product-id']] = new self($cartProduct['id'], $cartProduct['cart_id'], $cartProduct['product_id'], $cartProduct['quantity']);
        }
        return $arr;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCardId(): int
    {
        return $this->cardId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}