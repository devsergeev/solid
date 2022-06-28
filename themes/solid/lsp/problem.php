<?php

namespace solid\lsp;

use JetBrains\PhpStorm\Pure;

class Rectangle
{
    protected int $heigth;
    protected int $width;

    public function setHeigth(int $heigth): void
    {
        $this->heigth = $heigth;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function area(): int
    {
        return $this->heigth * $this->width;
    }
}

class Square extends Rectangle
{
    public function setHeigth(int $heigth): void
    {
        $this->heigth = $heigth;
        $this->width = $heigth;
    }

    public function setWidth(int $width): void
    {
        $this->heigth = $width;
        $this->width = $width;
    }
}

$figures = [];
$figures[] = new Rectangle();
$figures[] = new Square();

foreach ($figures as $figure) {
    $figure->setHeigth(5);
    $figure->setWidth(2);
    echo ($figure->area() === 10 ? "ОК: равен 10" : "NOT OK: не равен 10") . PHP_EOL;
}
/**
 * Приведен пример нарушения LSP, код клиента должен различать квадрат и прямоугольник (if).
 */

//foreach ($figures as $figure) {
//    $figure->setHeigth(5);
//    $figure->setWidth(2);
//    if ($figure instanceof Square) {
//        echo ($figure->area() === 4 ? "ОК: равен 4" : "NOT OK: не равен 4") . PHP_EOL;
//    } else {
//        echo ($figure->area() === 10 ? "ОК: равен 10" : "NOT OK: не равен 10") . PHP_EOL;
//    }
//}
