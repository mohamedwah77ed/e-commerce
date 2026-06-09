<?php

namespace App\Services\Cart;

use App\Models\Products;
use Illuminate\Support\Collection;

interface CartServiceInterface
{
    public function getItems(): Collection;
    public function add(Products $product): array;
    public function increase(int $productId): array;
    public function decrease(int $productId): array;
    public function delete(int $id): array;
    public function clear(int $orderId): void;
}