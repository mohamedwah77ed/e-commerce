<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Support\Collection;

class UserCartService implements CartServiceInterface
{
    public function getItems(): Collection
    {
        return Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
    }

    public function add(Products $product): array
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            if ($product->stock <= $cart->quantity)
                return ['status' => 'error', 'message' => 'الكمية غير كافية'];

            $cart->increment('quantity');
            $cart->update(['amount' => $cart->price * $cart->quantity]);
        } else {
            if ($product->stock <= 0)
                return ['status' => 'error', 'message' => 'الكمية غير كافية'];

            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'price'      => $product->price,
                'quantity'   => 1,
                'amount'     => $product->price,
            ]);
        }

        return ['status' => 'success', 'message' => 'تمت الإضافة للسلة'];
    }

    public function increase(int $productId): array
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if (!$cart)
            return ['status' => 'error', 'message' => 'المنتج غير موجود'];

        if ($cart->product->stock <= $cart->quantity)
            return ['status' => 'error', 'message' => 'الكمية غير كافية'];

        $cart->increment('quantity');
        $cart->update(['amount' => $cart->price * $cart->quantity]);

        return ['status' => 'success', 'message' => 'تم التحديث'];
    }

    public function decrease(int $productId): array
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if (!$cart)
            return ['status' => 'error', 'message' => 'المنتج غير موجود'];

        if ($cart->quantity <= 1) {
            $cart->delete();
            return ['status' => 'success', 'message' => 'تم حذف المنتج'];
        }

        $cart->decrement('quantity');
        $cart->update(['amount' => $cart->price * $cart->quantity]);

        return ['status' => 'success', 'message' => 'تم التحديث'];
    }

    public function delete(int $id): array
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if (!$cart)
            return ['status' => 'error', 'message' => 'حدث خطأ'];

        $cart->delete();
        return ['status' => 'success', 'message' => 'تم الحذف'];
    }
    public function clear(int $orderId): void
{
    Cart::where('user_id', auth()->id())
        ->update(['order_id' => $orderId]);
}

}