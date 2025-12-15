<?php

declare(strict_types=1);

namespace PizzaStore;

/**
 * Абстрактный класс пиццы
 */
abstract class Pizza
{
    /**
     * Название пиццы
     * @var string
     */
    protected string $name;

    /**
     * Соус пиццы
     * @var string
     */
    protected string $sauce;

    /**
     * Топпинги пиццы
     * @var array<string>
     */
    protected array $toppings = [];

    /**
     * Подготовка пиццы
     * @return void
     */
    public function prepare(): void
    {
        echo "Началась готовка пиццы {$this->name}" . PHP_EOL;
        echo "Добавлен соус {$this->sauce}" . PHP_EOL;
        
        $toppingsList = empty($this->toppings) 
            ? 'нет топпингов' 
            : implode(', ', $this->toppings);
        
        echo "Добавлены топики: {$toppingsList}" . PHP_EOL;
    }

    /**
     * Нарезка пиццы
     * @return void
     */
    public function cut(): void
    {
        echo "Данную пиццу нарезают по диагонали" . PHP_EOL;
    }

    /**
     * Получить название пиццы
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить соус пиццы
     * @return string
     */
    public function getSauce(): string
    {
        return $this->sauce;
    }

    /**
     * Получить топпинги пиццы
     * @return array<string>
     */
    public function getToppings(): array
    {
        return $this->toppings;
    }

    /**
     * Установить название пиццы
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Установить соус пиццы
     * @param string $sauce
     * @return void
     */
    public function setSauce(string $sauce): void
    {
        $this->sauce = $sauce;
    }

    /**
     * Добавить топпинг
     * @param string $topping
     * @return void
     */
    public function addTopping(string $topping): void
    {
        $this->toppings[] = $topping;
    }

    /**
     * Установить список топпингов
     * @param array<string> $toppings
     * @return void
     */
    public function setToppings(array $toppings): void
    {
        $this->toppings = $toppings;
    }
}