<?php

namespace solid\srp\solution;

// делегирование + фасад, чтоб работать с объектом как раньше
class Emploee
{
    protected int $hours;

    private PayCalculator $payCalculator;
    private HourReporter $hourReporter;
    private EmployeeSaver $employeeSaver;

    public function __construct(int $hours)
    {
        $this->hours = $hours;
        $this->payCalculator = new PayCalculator();
        $this->hourReporter = new HourReporter();
        $this->employeeSaver = new EmployeeSaver();
    }

    public function calculatePay(): int
    {
        return $this->payCalculator->calculatePay($this->hours);
    }

    public function reportHours(): string
    {
        return $this->hourReporter->reportHours($this->hours);
    }

    public function save(): string
    {
        return $this->employeeSaver->save($this->hours);
    }

    protected function reqularHours(): int
    {
        return $this->hours;
    }
}

// определяется бухгалтерией
class PayCalculator
{
    public function calculatePay(int $hours): int
    {
        return $hours * 25;
    }
}

// определяется и используется отделом по работе с персоналом
class HourReporter
{
    public function reportHours(int $hours): string
    {
        $hours = $hours + 2;
        return "Отработано $hours часов";
    }
}

// определяется администраторами баз данных
class EmployeeSaver
{
    // определяется администраторами баз данных
    public function save(int $hours): string
    {
        return "Сохранено в архив {$hours} часов";
    }
}

// Непреднамеренное дублирование
$emploee = new EmploeeFacade(40);
echo "Зарплата сотрудника: \${$emploee->calculatePay()}" . PHP_EOL;
echo "Отчет об отработанных часах: {$emploee->reportHours()}" . PHP_EOL;
echo "Запись в хранилище: {$emploee->save()}" . PHP_EOL;

// изменение в Emploee::reqularHours для бухгалтерии вызывает нежелательные изменения в Emploee::reportHours
