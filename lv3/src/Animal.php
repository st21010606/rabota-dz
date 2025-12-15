<?php
declare(strict_types=1);

namespace App;

abstract class Animal
{
    protected string $name;
    protected int $age;
    protected string $species;

    public function __construct(string $name, int $age, string $species)
    {
        $this->name = $name;
        $this->age = $age;
        $this->species = $species;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    abstract public function makeSound(): string;

    public function getInfo(): string
    {
        return sprintf(
            "%s: %s, возраст: %d лет, вид: %s",
            get_class($this),
            $this->name,
            $this->age,
            $this->species
        );
    }
}
?>