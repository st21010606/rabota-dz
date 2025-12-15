<?php

declare(strict_types=1);

namespace PizzaApp;

use PizzaStore\PizzaStore;
use PizzaStore\Pizza;
use PizzaApp\Pizzas\CheesePizza;
use PizzaApp\Pizzas\PepperoniPizza;
use PizzaApp\Pizzas\VegetarianPizza;

/**
 * Моя пиццерия
 */
class MyPizzaStore extends PizzaStore
{
    /**
     * Создать пиццу
     * @param string $type Тип пиццы
     * @return Pizza
     */
    protected function createPizza(string $type): Pizza
    {
        return match ($type) {
            'cheese' => new CheesePizza(),
            'pepperoni' => new PepperoniPizza(),
            'vegetarian' => new VegetarianPizza(),
            default => throw new \InvalidArgumentException("Неизвестный тип пиццы: {$type}")
        };
    }
}