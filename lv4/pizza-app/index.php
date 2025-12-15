<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use PizzaApp\MyPizzaStore;

echo "=== ДЕМОНСТРАЦИЯ РАБОТЫ ПИЦЦЕРИИ ===\n\n";

// Создаем пиццерию
$pizzaStore = new MyPizzaStore();

// Заказываем разные пиццы
try {
    echo "1. Заказ сырной пиццы:\n";
    echo str_repeat("-", 40) . "\n";
    $cheesePizza = $pizzaStore->orderPizza('cheese');
    echo "Заказана пицца: " . $cheesePizza->getName() . "\n\n";

    echo "2. Заказ пиццы Пепперони:\n";
    echo str_repeat("-", 40) . "\n";
    $pepperoniPizza = $pizzaStore->orderPizza('pepperoni');
    echo "Заказана пицца: " . $pepperoniPizza->getName() . "\n\n";

    echo "3. Заказ вегетарианской пиццы:\n";
    echo str_repeat("-", 40) . "\n";
    $vegetarianPizza = $pizzaStore->orderPizza('vegetarian');
    echo "Заказана пицца: " . $vegetarianPizza->getName() . "\n\n";

    // Попытка заказа неизвестной пиццы
    echo "4. Попытка заказа неизвестной пиццы:\n";
    echo str_repeat("-", 40) . "\n";
    $unknownPizza = $pizzaStore->orderPizza('unknown');
    
} catch (\InvalidArgumentException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}

// Дополнительная информация
echo "\n=== ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ===\n";

// Создаем пиццы напрямую для демонстрации
$pizzas = [
    new \PizzaApp\Pizzas\CheesePizza(),
    new \PizzaApp\Pizzas\PepperoniPizza(),
    new \PizzaApp\Pizzas\VegetarianPizza()
];

foreach ($pizzas as $index => $pizza) {
    echo "\n" . ($index + 1) . ". " . $pizza->getName() . ":\n";
    echo "   Соус: " . $pizza->getSauce() . "\n";
    echo "   Топпинги: " . implode(', ', $pizza->getToppings()) . "\n";
}

echo "\n=== ЗАВЕРШЕНО ===\n";