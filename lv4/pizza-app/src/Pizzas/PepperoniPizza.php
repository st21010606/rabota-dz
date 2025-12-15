<?php

declare(strict_types=1);

namespace PizzaApp\Pizzas;

use PizzaStore\Pizza;

/**
 * Пицца Пепперони
 */
class PepperoniPizza extends Pizza
{
    public function __construct()
    {
        $this->name = 'Пицца Пепперони';
        $this->sauce = 'Соус барбекю';
        $this->toppings = ['Пепперони', 'Сыр Моцарелла', 'Перец болгарский', 'Лук'];
    }
}