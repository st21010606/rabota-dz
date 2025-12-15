<?php

declare(strict_types=1);

namespace PizzaStore;

/**
 * Абстрактный класс пиццерии
 */
abstract class PizzaStore
{
    /**
     * Заказать пиццу
     * @param string $type Тип пиццы
     * @return Pizza
     */
    public function orderPizza(string $type): Pizza
    {
        $pizza = $this->createPizza($type);
        
        $pizza->prepare();
        $pizza->cut();
        
        return $pizza;
    }

    /**
     * Создать пиццу (фабричный метод)
     * @param string $type Тип пиццы
     * @return Pizza
     */
    abstract protected function createPizza(string $type): Pizza;
}