<?php
declare(strict_types=1);

namespace App;

class Zoo
{
    private array $animals = [];

    public function addAnimal(Animal $animal): void
    {
        $this->animals[] = $animal;
        echo "Животное " . $animal->getName() . " добавлено в зоопарк!\n";
    }

    public function addAnimals(array $animals): void
    {
        foreach ($animals as $animal) {
            if ($animal instanceof Animal) {
                $this->addAnimal($animal);
            }
        }
    }

    public function listAnimals(): void
    {
        if (empty($this->animals)) {
            echo "В зоопарке пока нет животных.\n";
            return;
        }

        echo "\n=== СПИСОК ЖИВОТНЫХ В ЗООПАРКЕ ===\n";
        echo "Всего животных: " . count($this->animals) . "\n";
        echo str_repeat("-", 50) . "\n";

        foreach ($this->animals as $index => $animal) {
            echo ($index + 1) . ". " . $animal->getInfo() . "\n";
        }
    }

    public function animalSounds(): void
    {
        if (empty($this->animals)) {
            echo "В зоопарке пока нет животных.\n";
            return;
        }

        echo "\n=== ЗВУКИ ЖИВОТНЫХ ===\n";
        foreach ($this->animals as $animal) {
            echo $animal->getName() . " (" . $animal->getSpecies() . "): " . 
                 $animal->makeSound() . "\n";
        }
    }

    public function getTotalAnimals(): int
    {
        return count($this->animals);
    }

    public function getAnimalsBySpecies(string $species): array
    {
        return array_filter($this->animals, fn($animal) => 
            strtolower($animal->getSpecies()) === strtolower($species)
        );
    }

    public function getAnimalsByClass(string $className): array
    {
        return array_filter($this->animals, fn($animal) => 
            get_class($animal) === $className
        );
    }
}
?>
