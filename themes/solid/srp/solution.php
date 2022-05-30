<?php

namespace solid\srp\solution;

class Emploee
{
    protected int $hours;

    public function __construct(int $hours)
    {
        $this->hours = $hours;
    }

    protected function reqularHours(): int
    {
        return $this->hours;
    }
}

// определяется бухгалтерией
class PayCalculator extends Emploee
{
    public function calculatePay(): int
    {
        $hours = $this->reqularHours();
        return $hours * 25;
    }
}

// определяется и используется отделом по работе с персоналом
class HourReporter extends Emploee
{
    public function reportHours(): string
    {
        $hours = $this->reqularHours();
        return "Отработано $hours часов";
    }

    // Используеся в методах которые могут и будут менять разные акторы
    protected function reqularHours(): int
    {
        return $this->hours + 2;
    }
}

// определяется администраторами баз данных
class EmployeeSaver extends Emploee
{
    // определяется администраторами баз данных
    public function save(): string
    {
        return "Сохранено в архив {$this->reqularHours()} часов";
    }
}

class EmploeeFacade
{
    private PayCalculator $payCalculator;
    private HourReporter $hourReporter;
    private EmployeeSaver $employeeSaver;

    public function __construct(int $hours)
    {
        $this->payCalculator = new PayCalculator($hours);
        $this->hourReporter = new HourReporter($hours);
        $this->employeeSaver = new EmployeeSaver($hours);
    }

    public function calculatePay(): int
    {
        return $this->payCalculator->calculatePay();
    }

    public function reportHours(): string
    {
        return $this->hourReporter->reportHours();
    }

    public function save(): string
    {
        return $this->employeeSaver->save();
    }
}

// Непреднамеренное дублирование
$emploee = new EmploeeFacade(40);
echo "Зарплата сотрудника: \${$emploee->calculatePay()}" . PHP_EOL;
echo "Отчет об отработанных часах: {$emploee->reportHours()}" . PHP_EOL;
echo "Запись в хранилище: {$emploee->save()}" . PHP_EOL;

// изменение в Emploee::reqularHours для бухгалтерии вызывает нежелательные изменения в Emploee::reportHours
