<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymobController extends Controller
{
    // ─────────────────────────────────────────
    // 1. Entry Point
    // ─────────────────────────────────────────
    public function pay(Order $order)
    {
        try {
            $token         = $this->getAuthToken();
            $paymobOrderId = $this->registerOrder($token, $order->total_amount);

            $order->paymob_order_id = $paymobOrderId;
            $order->save();

            return $this->getPaymentKey($token, $paymobOrderId, $order->total_amount, $order);

        } catch (\Exception $e) {
            Log::error('Paymob pay() error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء الدفع، حاول تاني');
        }
    }

    // ─────────────────────────────────────────
    // 2. Auth Token
    // ─────────────────────────────────────────
    private function getAuthToken(): string
    {
        $response = Http::post(
            config('services.paymob.base_url') . '/api/auth/tokens',
            ['api_key' => config('services.paymob.api_key')]
        );

        throw_unless($response->successful(), \Exception::class, 'Auth token failed');

        return $response->json()['token'];
    }

    // ─────────────────────────────────────────
    // 3. Register Order
    // ─────────────────────────────────────────
    private function registerOrder(string $token, float $amount): int
    {
        $response = Http::post(
            config('services.paymob.base_url') . '/api/ecommerce/orders',
            [
                'auth_token'      => $token,
                'delivery_needed' => false,
                'amount_cents'    => (int) ($amount * 100),
                'currency'        => 'EGP',
                'items'           => [],
            ]
        );

        throw_unless($response->successful(), \Exception::class, 'Order registration failed');

        return $response->json()['id'];
    }

    // ─────────────────────────────────────────
    // 4. Payment Key + Redirect
    // ─────────────────────────────────────────
    private function getPaymentKey(string $token, int $orderId, float $amount, Order $order)
    {
        $response = Http::post(
            config('services.paymob.base_url') . '/api/acceptance/payment_keys',
            [
                'auth_token'     => $token,
                'amount_cents'   => (int) ($amount * 100),
                'expiration'     => 3600,
                'order_id'       => $orderId,
                'currency'       => 'EGP',
                'integration_id' => config('services.paymob.integration_id'),
                'redirect_url'   => route('paymob.callback'),
                'billing_data'   => [
                    'first_name'   => $order->first_name  ?? 'NA',
                    'last_name'    => $order->last_name   ?? 'NA',
                    'email'        => $order->email        ?? 'NA',
                    'phone_number' => $order->phone        ?? 'NA',
                    'country'      => $order->country      ?? 'EG',
                    'city'         => $order->city         ?? 'NA',
                    'street'       => $order->address1     ?? 'NA',
                    'building'     => 'NA',
                    'floor'        => 'NA',
                    'apartment'    => 'NA',
                ],
            ]
        );

        throw_unless($response->successful(), \Exception::class, 'Payment key request failed');

        $paymentToken = $response->json()['token'];
        $iframeId     = config('services.paymob.iframe_id');

        return redirect(
            'https://accept.paymob.com/api/acceptance/iframes/' . $iframeId
            . '?payment_token=' . $paymentToken
        );
    }

    // ─────────────────────────────────────────
    // 5. Callback (Transaction Response)
    // ─────────────────────────────────────────
    public function callback(Request $request)
    {
        if (! $this->verifyHmac($request)) {
            Log::warning('Paymob HMAC mismatch', $request->all());
            return redirect()->route('cart.index')->with('error', 'طلب غير موثوق');
        }

        $data = $request->all();

        if (($data['success'] ?? '') !== 'true') {
            return redirect()->route('cart.index')->with('error', 'فشل الدفع، حاول تاني');
        }

        $order = Order::where('paymob_order_id', $data['order'])->first();

        if (! $order) {
            Log::error('Paymob callback: order not found', ['paymob_order_id' => $data['order']]);
            return redirect()->route('cart.index')->with('error', 'الأوردر مش موجود');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.my', $order->id)->with('success', 'تم الدفع مسبقاً');
        }

        $order->update([
            'payment_status' => 'paid',
            'payment_method' => 'paymob',
            'status'         => 'processing',
            'transaction_id' => $data['id'] ?? null,
        ]);

        session()->forget(['cart', 'coupon']);

       return redirect()->route('order.success', $order->id)->with('success', 'تم الدفع بنجاح ');

    }

    // ─────────────────────────────────────────
    // 6. HMAC Verification
    // ─────────────────────────────────────────
    private function verifyHmac(Request $request): bool
    {
        $hmacSecret = config('services.paymob.hmac');

        if (empty($hmacSecret)) {
            Log::warning('Paymob HMAC secret not configured');
            return true;
        }

        $receivedHmac = $request->input('hmac');

        $fields = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];

        $concatenated = '';
        foreach ($fields as $field) {
            $concatenated .= $request->input($field, '');
        }

        $calculatedHmac = hash_hmac('sha512', $concatenated, $hmacSecret);

        return hash_equals($calculatedHmac, $receivedHmac ?? '');
    }
}
