<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_display_checkout_page()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->get('/checkout');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.checkout');
    }

    /** @test */
    public function it_redirects_to_cart_if_empty()
    {
        $response = $this->get('/checkout');

        $response->assertRedirect('/cart');
    }

    /** @test */
    public function it_can_create_order_with_valid_data()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Ahmed',
            'last_name' => 'Mohamed',
            'email' => 'ahmed@example.com',
            'phone' => '01234567890',
            'address1' => '123 Main St',
            'country' => 'Egypt',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'email' => 'ahmed@example.com',
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', []);

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'email',
            'phone',
            'address1',
            'country',
        ]);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Ahmed',
            'last_name' => 'Mohamed',
            'email' => 'invalid-email',
            'phone' => '01234567890',
            'address1' => '123 Main St',
            'country' => 'Egypt',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_validates_phone_number()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Ahmed',
            'last_name' => 'Mohamed',
            'email' => 'ahmed@example.com',
            'phone' => 'invalid',
            'address1' => '123 Main St',
            'country' => 'Egypt',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    /** @test */
    public function authenticated_user_can_view_orders()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my-orders');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.orders_index');
    }

    /** @test */
    public function guest_can_view_orders_by_session()
    {
        $response = $this->get('/my-orders');

        // يجب أن يعرض الطلبيات للجلسة الحالية أو يعيد توجيه
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_order_details()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/my-orders/{$order->id}");

        $response->assertStatus(200);
    }

    /** @test */
    public function user_cannot_cancel_completed_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'completed'
        ]);

        $response = $this->actingAs($user)->post("/my-orders/{$order->id}/cancel");

        // إما redirect مع error أو 403
        $response->assertStatus(302);
    }

    /** @test */
    public function user_can_cancel_new_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'new'
        ]);

        $response = $this->actingAs($user)->post("/my-orders/{$order->id}/cancel");

        $response->assertRedirect();
    }
}
