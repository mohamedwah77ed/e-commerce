<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\Order;
use App\Services\Cart\UserCartService;
use App\Services\Cart\GuestCartService;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    private function cartService()
    {
        return auth()->check()
            ? new UserCartService()
            : new GuestCartService();
    }

    public function create()
    {
        $cartItems = $this->cartService()->getItems();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'السلة فاضية');
            return redirect()->route('cart.index');
        }

        return view('frontend.checkout', compact('cartItems'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|numeric|digits_between:10,15',
            'address1'   => 'required|string|max:500',
            'address2'   => 'nullable|string|max:500',
            'country'    => 'required|string|max:100',
            'post_code'  => 'nullable|string|max:20',
        ]);

        $cartItems = $this->cartService()->getItems();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'السلة فاضية');
            return back();
        }

        try {
            $couponDiscount = session('coupon')
                ? (float) session('coupon')['value']
                : 0;

            $subTotal = $cartItems->sum('amount');

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'user_id'      => auth()->id() ?? null,
                'session_id'   => auth()->check() ? null : session()->getId(),
                'first_name'   => $validated['first_name'],
                'last_name'    => $validated['last_name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'country'      => $validated['country'],
                'address1'     => $validated['address1'],
                'address2'     => $validated['address2'] ?? null,
                'post_code'    => $validated['post_code'] ?? null,
                'sub_total'    => $subTotal,
                'quantity'     => $cartItems->sum('quantity'),
                'coupon'       => $couponDiscount,
                'total_amount' => $subTotal - $couponDiscount,
                'status'       => 'new',
            ]);

            $this->cartService()->clear($order->id);

            return redirect()->route('paymob.pay', $order->id);

        }  catch (\Exception $e) {
    dd($e->getMessage()); // ← بدل session()->flash
}
    }

    public function myOrders()
    {
        $orders = $this->getUserOrders();

        return view('frontend.orders_index', compact('orders'));
    }
    public function show($id)
    {
        $order = $this->getOrderById($id);

        if (!$order) {
            abort(404, 'الطلب غير موجود');
        }

        return view('frontend.orders_show', compact('order'));
    }

    public function success($id)
    {
        $order = $this->getOrderById($id);

        if (!$order) {
            abort(404, 'الطلب غير موجود');
        }

        return view('frontend.orders.success', compact('order'));
    }

    public function cancel(Request $request, $id)
    {
        $order = $this->getOrderById($id);

        if (!$order) {
            return back()->with('error', 'الطلب غير موجود');
        }

        if (!$this->isOrderOwner($order)) {
            abort(403, 'Unauthorized');
        }

        $cancellableStatuses = ['new', 'pending', 'processing'];

        if (!in_array($order->status, $cancellableStatuses)) {
            return back()->with('error', 'لا يمكن إلغاء هذا الطلب في حالته الحالية');
        }

        $order->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->input('reason'),
        ]);

        return back()->with('success', 'تم إلغاء الطلب بنجاح');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        // ✅ تصحيح اسم الـ route من orders.index إلى orders.my
        return redirect()->route('orders.my')->with('success', 'تم حذف الطلب');
    }

    // ─── Private Helpers ─────────────────────────────────────────

    private function getUserOrders()
    {
        if (auth()->check()) {
            return Order::where('user_id', auth()->id())
                ->with('cart_info.product')
                ->latest()
                ->paginate(10);
        }

        return Order::where('session_id', session()->getId())
            ->whereNull('user_id')
            ->with('cart_info.product')
            ->latest()
            ->paginate(10);
    }

    private function getOrderById($id)
    {
        if (auth()->check()) {
            return Order::where('id', $id)
                ->where('user_id', auth()->id())
                ->with('cart_info.product')
                ->first();
        }

        return Order::where('id', $id)
            ->where('session_id', session()->getId())
            ->whereNull('user_id')
            ->with('cart_info.product')
            ->first();
    }

    private function isOrderOwner($order)
    {
        if (auth()->check()) {
            return $order->user_id === auth()->id();
        }

        return $order->session_id === session()->getId() && is_null($order->user_id);
    }
}
