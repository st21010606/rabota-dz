<?php

declare(strict_types=1);

namespace PizzaApp\Pizzas;

use PizzaStore\Pizza;

/**
 * Вегетарианская пицца
 */
class VegetarianPizza extends Pizza
{
    public function __construct()
    {
        $this->name = 'Вегетарианская пицца';
        $this->sauce = 'Чесночный соус';
        $this->toppings = ['Грибы', 'Помидоры', 'Перец', 'Лук', 'Оливки', 'Кукуруза'];
    }
}