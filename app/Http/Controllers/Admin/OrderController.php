<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'cart_info']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('first_name',  'like', "%{$search}%")
                  ->orWhere('last_name',   'like', "%{$search}%")
                  ->orWhere('email',       'like', "%{$search}%")
                  ->orWhere('phone',       'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($payment = $request->input('payment_status')) {
            $query->where('payment_status', $payment);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('backend.orders.orders_index', compact('orders'));
    }

    /**
     */
    public function show($id)
    {
        $order = Order::with(['user', 'cart_info',])->findOrFail($id);
        return view('backend.orders.Order_show', compact('order'));
    }

    /**
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.orders.orders_edit', compact('order'));
    }

    /**
     */
   public function update(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $validated = $request->validate([
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'email'          => 'required|email|max:255',
        'phone'          => 'required|string|max:50',
        'address1'       => 'required|string|max:255',
        'address2'       => 'nullable|string|max:255',
        'country'        => 'required|string|max:100',
        'post_code'      => 'nullable|string|max:20',
        'sub_total'      => 'required|numeric|min:0',
        'total_amount'   => 'required|numeric|min:0',
        'quantity'       => 'nullable|integer|min:1',
        'status'         => 'required|in:new,pending,processing,shipped,delivered,cancelled,refunded',
        'payment_status' => 'required|in:unpaid,paid',
    ]);

    $order->update($validated);

    return redirect()->route('admin.orders.edit', $order->id)
                     ->with('success', 'Order updated successfully.');
}

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'تم حذف الأوردر');
    }
}
