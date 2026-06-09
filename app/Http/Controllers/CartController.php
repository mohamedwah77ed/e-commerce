<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Services\Cart\UserCartService;
use App\Services\Cart\GuestCartService;

class CartController extends Controller
{
    private function service()
    {
        return auth()->check()
            ? new UserCartService()
            : new GuestCartService();
    }

    public function index()
    {
        $products  = $this->service()->getItems();
        $cartCount = $products->sum('quantity');
        $cartTotal = $products->sum('amount');

        return view('frontend.cart', compact('products', 'cartCount', 'cartTotal'));
    }

    public function addToCart(Request $request)
    {
        $product = Products::where('slug', $request->slug)->first();
        if (!$product) return back()->with('error', 'منتج غير موجود');

        $result = $this->service()->add($product);
        return back()->with($result['status'], $result['message']);
    }

    public function increaseCart(Request $request)
    {
        $result = $this->service()->increase($request->product_id);
        return back()->with($result['status'], $result['message']);
    }

    public function decreaseCart(Request $request)
    {
        $result = $this->service()->decrease($request->product_id);
        return back()->with($result['status'], $result['message']);
    }

    public function cartDelete(Request $request)
    {
        $result = $this->service()->delete($request->id);
        return back()->with($result['status'], $result['message']);
    }

    public function getCartCount()
    {
        $items = $this->service()->getItems();
        return response()->json([
            'count' => $items->sum('quantity'),
            'total' => $items->sum('amount'),
        ]);
    }

    public function buyNow(Request $request)
{
    $this->addToCart($request);

    return redirect()->route('checkout');
}
public function getCount()
{
    $items = $this->service()->getItems();
    return response()->json(['count' => $items->sum('quantity')]);
}

public function add(Request $request, $productId)
{
    $product = Products::findOrFail($productId);
    $qty = $request->input('qty', 1);

    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $qty;
    } else {
        $cart[$productId] = [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->final_price ?? $product->price,
            'image' => $product->images->first()?->image,
            'quantity' => $qty,
        ];
    }

    session()->put('cart', $cart);

    $count = array_sum(array_column($cart, 'quantity'));

    return response()->json([
        'success' => true,
        'count' => $count,
        'cart_count' => $count
    ]);
}
}
