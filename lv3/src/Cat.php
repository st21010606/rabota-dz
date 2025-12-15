<?php
declare(strict_types=1);

namespace App;

class Cat extends Animal
{
    private string $color;

    public function __construct(string $name, int $age, string $color)
    {
        parent::__construct($name, $age, 'Кошка');
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function makeSound(): string
    {
        return "Мяу!";
    }

    public function getInfo(): string
    {
        return parent::getInfo() . ", цвет: " . $this->color;
    }

    public function purr(): string
    {
        return $this->name . " мурлычет...";
    }
}
?>