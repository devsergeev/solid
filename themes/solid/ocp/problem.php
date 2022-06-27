<?php

namespace solid\ocp;

use JetBrains\PhpStorm\Pure;

class Product
{
    private string $name;
    private int $price;
    private string $group;

    public function __construct(string $name, int $price, string $group)
    {
        $this->name = $name;
        $this->price = $price;
        $this->group = $group;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getGroup(): string
    {
        return $this->group;
    }
}

class Order
{
    /**
     * @var Product[]
     */
    private array $products;

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function calculateTotalSum(): float
    {
        $totalSum = 0;
        foreach ($this->products as $product) {
            $totalSum += $this->getPriceWithDiscount($product);
        }
        return $totalSum;
    }

    private function getPriceWithDiscount(Product $product): float
    {
        $price = $product->getPrice();
        $discountPercent = $this->getDiscountPercent($product);
        return $price - ($price * ($discountPercent / 100));
    }

    #[Pure]
    private function getDiscountPercent(Product $product): float
    {
        if ($product->getGroup() === "Линейки") {
            return 20;
        }

        if ($product->getName() === "Сахар") {
            return 10;
        }

        return 5;
    }
}

$product1 = new Product("Сахар тростниковый", 100, "Продукты");
$product2 = new Product("Линейка деревянная", 100, "Линейки");
$product3 = new Product("Тетрадь в клеточку 12 листов", 100, "Тетради");

$order = new Order();
$order->addProduct($product1);
$order->addProduct($product2);
$order->addProduct($product3);

echo $order->calculateTotalSum() . PHP_EOL;

/**
 * Order::getDiscountPercent() нарушает принцип:
 * этот код подвержен изменениям в связи с добавлением новых скидок
 */
