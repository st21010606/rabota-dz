<?php

declare(strict_types=1);

namespace Pizza;

class Pizza
{
    protected string $name;
    protected string $sauce;
    protected array $toppings = [];

    public function prepare(): void
    {
        echo "Началась готовка пиццы {$this->name}";
        echo "Добавлен соус {$this->sauce}";
        echo "Добавлены топпинги: " . implode(', ', $this->toppings);
    }

    public function cut(): void
    {
        echo "Данную пиццу нарезают по диагонали";
    }

    public function getName(): string
    {
        return $this->name;
    }
}