<?php

declare(strict_types=1);

namespace PizzaApp\Pizzas;

use PizzaStore\Pizza;

/**
 * Сырная пицца
 */
class CheesePizza extends Pizza
{
    public function __construct()
    {
        $this->name = 'Сырная пицца';
        $this->sauce = 'Томатный соус';
        $this->toppings = ['Сыр Моцарелла', 'Сыр Пармезан', 'Сыр Чеддер'];
    }
}