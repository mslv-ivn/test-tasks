<?php
class Product {
    public string $name;
    private string $price;

    function createProduct($name, $price): void
    {
        $this->name = $name;
        $this->price = $price;
    }

    function showPrice(): string
    {
        return "Цена товара: ".$this->price;
    }
}