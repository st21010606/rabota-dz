<?php

// 1. Абстрактный базовый класс Animal
abstract class Animal {
    protected string $name;
    protected int $age;
    protected string $species;
    
    // Конструктор
    public function __construct(string $name, int $age, string $species) {
        $this->name = $name;
        $this->age = $age;
        $this->species = $species;
    }
    
    // Абстрактный метод - должен быть реализован в дочерних классах
    abstract public function makeSound(): string;
    
    // Геттеры для свойств
    public function getName(): string {
        return $this->name;
    }
    
    public function getAge(): int {
        return $this->age;
    }
    
    public function getSpecies(): string {
        return $this->species;
    }
    
    // Метод для получения информации о животном
    public function getInfo(): string {
        return "Имя: {$this->name}, Вид: {$this->species}, Возраст: {$this->age} лет";
    }
}

// 2. Класс Dog (наследуется от Animal)
class Dog extends Animal {
    private string $breed;
    
    public function __construct(string $name, int $age, string $breed) {
        parent::__construct($name, $age, 'Собака');
        $this->breed = $breed;
    }
    
    // Реализация абстрактного метода
    public function makeSound(): string {
        return "Гав-гав!";
    }
    
    public function getBreed(): string {
        return $this->breed;
    }
    
    // Переопределяем метод getInfo для добавления информации о породе
    public function getInfo(): string {
        return parent::getInfo() . ", Порода: {$this->breed}";
    }
}

// 3. Класс Cat (наследуется от Animal)
class Cat extends Animal {
    private string $color;
    
    public function __construct(string $name, int $age, string $color) {
        parent::__construct($name, $age, 'Кошка');
        $this->color = $color;
    }
    
    // Реализация абстрактного метода
    public function makeSound(): string {
        return "Мяу!";
    }
    
    public function getColor(): string {
        return $this->color;
    }
    
    // Переопределяем метод getInfo для добавления информации о цвете
    public function getInfo(): string {
        return parent::getInfo() . ", Цвет: {$this->color}";
    }
}

// 4. Класс Zoo
class Zoo {
    private array $animals = [];
    
    // Добавление животного в зоопарк
    public function addAnimal(Animal $animal): void {
        $this->animals[] = $animal;
        echo "Животное {$animal->getName()} добавлено в зоопарк!\n";
    }
    
    // Список всех животных в зоопарке
    public function listAnimals(): void {
        if (empty($this->animals)) {
            echo "В зоопарке пока нет животных.\n";
            return;
        }
        
        echo "=== СПИСОК ЖИВОТНЫХ В ЗООПАРКЕ ===\n";
        foreach ($this->animals as $index => $animal) {
            echo ($index + 1) . ". " . $animal->getInfo() . "\n";
        }
    }
    
    // Звуки всех животных
    public function animalSounds(): void {
        if (empty($this->animals)) {
            echo "В зоопарке тихо - нет животных.\n";
            return;
        }
        
        echo "=== ЗВУКИ ЖИВОТНЫХ ===\n";
        foreach ($this->animals as $animal) {
            echo $animal->getName() . " ({$animal->getSpecies()}): " . $animal->makeSound() . "\n";
        }
    }
    
    // Получить количество животных
    public function getAnimalCount(): int {
        return count($this->animals);
    }
    
    // Получить всех животных определенного вида
    public function getAnimalsBySpecies(string $species): array {
        return array_filter($this->animals, function($animal) use ($species) {
            return $animal->getSpecies() === $species;
        });
    }
}

// ===== ПРИМЕР ИСПОЛЬЗОВАНИЯ =====
echo "=== СОЗДАНИЕ ЗООПАРКА ===\n\n";

// Создаем зоопарк
$zoo = new Zoo();

// Создаем животных
echo "Создаем животных...\n";
$dog1 = new Dog("Бобик", 3, "Лабрадор");
$dog2 = new Dog("Рекс", 5, "Овчарка");
$cat1 = new Cat("Мурка", 2, "Рыжий");
$cat2 = new Cat("Васька", 4, "Черно-белый");
$cat3 = new Cat("Снежок", 1, "Белый");

echo "\n";

// Добавляем животных в зоопарк
echo "Добавляем животных в зоопарк:\n";
$zoo->addAnimal($dog1);
$zoo->addAnimal($dog2);
$zoo->addAnimal($cat1);
$zoo->addAnimal($cat2);
$zoo->addAnimal($cat3);

echo "\n";

// Выводим информацию о всех животных
$zoo->listAnimals();

echo "\n";

// Выводим звуки животных
$zoo->animalSounds();

echo "\n";

// Дополнительная информация
echo "=== ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ===\n";
echo "Всего животных в зоопарке: " . $zoo->getAnimalCount() . "\n";

// Показываем только собак
echo "\nСобаки в зоопарке:\n";
$dogs = $zoo->getAnimalsBySpecies('Собака');
foreach ($dogs as $dog) {
    echo "- " . $dog->getName() . " (" . $dog->getBreed() . ")\n";
}

// Показываем только кошек
echo "\nКошки в зоопарке:\n";
$cats = $zoo->getAnimalsBySpecies('Кошка');
foreach ($cats as $cat) {
    echo "- " . $cat->getName() . " (" . $cat->getColor() . ")\n";
}

echo "\n";

// Демонстрация полиморфизма
echo "=== ДЕМОНСТРАЦИЯ ПОЛИМОРФИЗМА ===\n";
$animals = [$dog1, $cat1, $dog2, $cat2];

foreach ($animals as $animal) {
    echo get_class($animal) . " {$animal->getName()} говорит: {$animal->makeSound()}\n";
}

echo "\n";

// Проверка работы методов с разными типами животных
echo "=== ИНФОРМАЦИЯ О КАЖДОМ ЖИВОТНОМ ===\n";
foreach ($zoo->getAnimalsBySpecies('Собака') as $dog) {
    if ($dog instanceof Dog) {
        echo "Собака: {$dog->getName()}, Порода: {$dog->getBreed()}\n";
    }
}

foreach ($zoo->getAnimalsBySpecies('Кошка') as $cat) {
    if ($cat instanceof Cat) {
        echo "Кошка: {$cat->getName()}, Цвет: {$cat->getColor()}\n";
    }
}