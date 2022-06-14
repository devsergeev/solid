<?php

namespace solid\srp\problem;

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

interface Discount
{
    public function check(Product $product): bool;

    public function get(): int;
}

class DefaultDiscount implements Discount
{
    public function check(Product $product): bool
    {
        return true;
    }

    public function get(): int
    {
        return 5;
    }
}

class RulerDiscount implements Discount
{
    public function check(Product $product): bool
    {
        return $product->getGroup() === "Линейки";
    }

    public function get(): int
    {
        return 20;
    }
}

class SugarDiscount implements Discount
{
    public function check(Product $product): bool
    {
        return $product->getGroup() === "Сахар";
    }

    public function get(): int
    {
        return 10;
    }
}

class Order
{
    /**
     * @var Product[]
     */
    private array $products;

    /**
     * @var Discount[]
     */
    private array $discounts;

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function addDiscount(Discount $discount)
    {
        $this->discounts[] = $discount;
    }

    public function calculateTotalSum(): float
    {
        $totalSum = 0;
        foreach ($this->products as $product)
        {
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
        foreach ($this->discounts as $discount)
        {
            if ($discount->check($product))
            {
                return $discount->get();
            }
        }
        return 0;
    }
}

$product1 = new Product("Сахар тростниковый", 100, "Продукты");
$product2 = new Product("Линейка деревянная", 100, "Линейки");
$product3 = new Product("Тетрадь в клеточку 12 листов", 100, "Тетради");

$order = new Order();
$order->addProduct($product1);
$order->addProduct($product2);
$order->addProduct($product3);
$order->addDiscount(new SugarDiscount());
$order->addDiscount(new RulerDiscount());
$order->addDiscount(new DefaultDiscount());

echo $order->calculateTotalSum() . PHP_EOL;

/**
 * Order::getDiscountPercent() теперь не нарушает принцип:
 * этот код закрыт от изменений в связи с добавлением новых скидок
 */
