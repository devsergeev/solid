<?php

class Customer
{
    public function order()
    {
        $order = new Order();
        $viewer = new OrderViewHtml();
        return $viewer->view($order);
    }
}

class Order
{
}

class OrderViewHtml
{
    public function view(Order $order): string
    {
        return "<html>Заказ</html>";
    }
}

$customer = new Customer();
echo $customer->order() . PHP_EOL;
