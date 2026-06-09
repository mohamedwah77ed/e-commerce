<?php

namespace App\Services\Cart;

use App\Models\Products;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class GuestCartService implements CartServiceInterface
{
    private function cartKey(): string
    {
        if (!Session::has('guest_cart_id'))
            Session::put('guest_cart_id', 'guest_' . uniqid());

        return Session::get('guest_cart_id');
    }

    private function getSession(): array
    {
        return Session::get('cart_' . $this->cartKey(), []);
    }

    private function saveSession(array $cart): void
    {
        Session::put('cart_' . $this->cartKey(), $cart);
    }

    public function getItems(): Collection
    {
        $items = collect();

        foreach ($this->getSession() as $productId => $item) {
            $product = Products::find($productId);
            if ($product) {
                $items->push((object)[
                    'id'         => $productId,
                    'product_id' => $productId,
                    'product'    => $product,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'amount'     => $item['price'] * $item['quantity'],
                ]);
            }
        }

        return $items;
    }

    public function add(Products $product): array
    {
        $cart = $this->getSession();

        if (isset($cart[$product->id])) {
            if ($product->stock <= $cart[$product->id]['quantity'])
                return ['status' => 'error', 'message' => 'الكمية غير كافية'];

            $cart[$product->id]['quantity'] += 1;
        } else {
            if ($product->stock <= 0)
                return ['status' => 'error', 'message' => 'الكمية غير كافية'];

            $cart[$product->id] = ['price' => $product->price, 'quantity' => 1];
        }

        $this->saveSession($cart);
        return ['status' => 'success', 'message' => 'تمت الإضافة للسلة'];
    }

    public function increase(int $productId): array
    {
        $cart = $this->getSession();

        if (!isset($cart[$productId]))
            return ['status' => 'error', 'message' => 'المنتج غير موجود'];

        $product = Products::find($productId);
        if ($product && $product->stock <= $cart[$productId]['quantity'])
            return ['status' => 'error', 'message' => 'الكمية غير كافية'];

        $cart[$productId]['quantity'] += 1;
        $this->saveSession($cart);

        return ['status' => 'success', 'message' => 'تم التحديث'];
    }

    public function decrease(int $productId): array
    {
        $cart = $this->getSession();

        if (!isset($cart[$productId]))
            return ['status' => 'error', 'message' => 'المنتج غير موجود'];

        if ($cart[$productId]['quantity'] <= 1) {
            unset($cart[$productId]);
            $this->saveSession($cart);
            return ['status' => 'success', 'message' => 'تم حذف المنتج'];
        }

        $cart[$productId]['quantity'] -= 1;
        $this->saveSession($cart);

        return ['status' => 'success', 'message' => 'تم التحديث'];
    }

    public function delete(int $id): array
    {
        $cart = $this->getSession();

        if (!isset($cart[$id]))
            return ['status' => 'error', 'message' => 'حدث خطأ'];

        unset($cart[$id]);
        $this->saveSession($cart);

        return ['status' => 'success', 'message' => 'تم الحذف'];
    }
    public function mergeInto(int $userId): void
{
    foreach ($this->getSession() as $productId => $item) {
        $existing = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $item['quantity']);
            $existing->update(['amount' => $existing->price * $existing->quantity]);
        } else {
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
                'amount'     => $item['price'] * $item['quantity'],
            ]);
        }
    }

    Session::forget('cart_' . $this->cartKey());
    Session::forget('guest_cart_id');
}
public function clear(int $orderId): void
{
    Session::forget('cart_' . $this->cartKey());
    Session::forget('guest_cart_id');
}
}