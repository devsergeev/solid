<?php

namespace solid\srp;

class Emploee
{
    private int $hours;

    public function __construct(int $hours)
    {
        $this->hours = $hours;
    }

    // определяется бухгалтерией
    public function calculatePay(): int
    {
        $hours = $this->reqularHours();
        return $hours * 25;
    }

    // определяется и используется отделом по работе с персоналом
    public function reportHours(): string
    {
        $hours = $this->reqularHours();
        return "Отработано $hours часов";
    }

    // определяется администраторами баз данных
    public function save(): string
    {
        return "Сохранено в архив {$this->reqularHours()} часов";
    }

    // Используеся в методах которые могут и будут менять разные акторы
    private function reqularHours(): int
    {
        return $this->hours/* + 2*/ ;
    }
}

// Непреднамеренное дублирование
$emploee = new Emploee(40);
echo "Зарплата сотрудника: \${$emploee->calculatePay()}" . PHP_EOL;
echo "Отчет об отработанных часах: {$emploee->reportHours()}" . PHP_EOL;
echo "Запись в хранилище: {$emploee->save()}" . PHP_EOL;

// изменение в Emploee::reqularHours для бухгалтерии вызывает нежелательные изменения в Emploee::reportHours
