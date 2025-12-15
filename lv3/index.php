<?php
// Подключаем автозагрузчик Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Dog;
use App\Cat;
use App\Zoo;

// Выводим информацию о проекте
echo "=== СИСТЕМА УПРАВЛЕНИЯ ЗООПАРКОМ ===\n\n";

// Создаем зоопарк
$zoo = new Zoo();

// Создаем животных
echo "Создаем животных...\n";
$dog1 = new Dog("Бобик", 3, "Овчарка");
$dog2 = new Dog("Шарик", 5, "Лабрадор");
$dog3 = new Dog("Рекс", 2, "Доберман");

$cat1 = new Cat("Мурка", 4, "Рыжий");
$cat2 = new Cat("Васька", 6, "Черный");
$cat3 = new Cat("Барсик", 2, "Серый");

// Добавляем животных в зоопарк
echo "\nДобавляем животных в зоопарк...\n";
$zoo->addAnimals([$dog1, $dog2, $dog3, $cat1, $cat2, $cat3]);

// Выводим список животных
$zoo->listAnimals();

// Выводим звуки животных
$zoo->animalSounds();

// Дополнительная информация
echo "\n=== ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ===\n";

// Проверяем количество животных
echo "Всего животных в зоопарке: " . $zoo->getTotalAnimals() . "\n";

// Получаем только собак
$dogs = $zoo->getAnimalsBySpecies("Собака");
echo "Собак в зоопарке: " . count($dogs) . "\n";

// Получаем только кошек
$cats = $zoo->getAnimalsBySpecies("Кошка");
echo "Кошек в зоопарке: " . count($cats) . "\n";

// Специальные методы животных
echo "\n=== СПЕЦИАЛЬНЫЕ МЕТОДЫ ===\n";
foreach ($zoo->getAnimalsByClass('App\Dog') as $dog) {
    if ($dog instanceof Dog) {
        echo $dog->fetch() . "\n";
    }
}

foreach ($zoo->getAnimalsByClass('App\Cat') as $cat) {
    if ($cat instanceof Cat) {
        echo $cat->purr() . "\n";
    }
}

// Динамическое создание животных
echo "\n=== ДИНАМИЧЕСКОЕ СОЗДАНИЕ ЖИВОТНЫХ ===\n";

// Массив для создания случайных животных
$dogBreeds = ["Такса", "Пудель", "Хаски", "Бульдог", "Чихуахуа"];
$catColors = ["Белый", "Трехцветный", "Полосатый", "Черно-белый", "Рыже-белый"];
$names = ["Арчи", "Белла", "Чарли", "Дейзи", "Элвис", "Фокси", "Гарри", "Ирис"];

// Создаем несколько случайных животных
$randomAnimals = [];
for ($i = 0; $i < 3; $i++) {
    if (rand(0, 1) === 0) {
        // Создаем собаку
        $randomAnimals[] = new Dog(
            $names[array_rand($names)],
            rand(1, 10),
            $dogBreeds[array_rand($dogBreeds)]
        );
    } else {
        // Создаем кошку
        $randomAnimals[] = new Cat(
            $names[array_rand($names)],
            rand(1, 15),
            $catColors[array_rand($catColors)]
        );
    }
}

// Добавляем случайных животных
echo "Добавляем случайных животных...\n";
$zoo->addAnimals($randomAnimals);

// Выводим обновленный список
$zoo->listAnimals();

// Тестирование полиморфизма
echo "\n=== ТЕСТИРОВАНИЕ ПОЛИМОРФИЗМА ===\n";

// Используем анонимную функцию вместо обычной
$interactWithAnimal = function (\App\Animal $animal): void {
    echo $animal->getName() . " говорит: " . $animal->makeSound() . "\n";
};

// Массив разных животных
$animalsForPolymorphism = [
    new Dog("Полли", 3, "Колли"),
    new Cat("Симба", 2, "Золотистый"),
    new Dog("Макс", 4, "Бигль"),
    new Cat("Луна", 1, "Серебристый")
];

echo "\nВзаимодействие с разными животными:\n";
foreach ($animalsForPolymorphism as $animal) {
    $interactWithAnimal($animal);
}

echo "\n=== ЗАВЕРШЕНО ===\n";
?>