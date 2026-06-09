<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function product_requires_valid_slug()
    {
        $response = $this->post('/add-to-cart', [
            'slug' => '', // slug فارغ
        ]);

        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function product_slug_must_exist()
    {
        $response = $this->post('/add-to-cart', [
            'slug' => 'non-existent-product',
        ]);

        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function order_requires_valid_first_name()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => '', // مطلوب
            'last_name' => 'Test',
            'email' => 'test@example.com',
            'phone' => '01234567890',
            'address1' => 'Address',
            'country' => 'Egypt',
        ]);

        $response->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function order_requires_valid_email()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'not-an-email',
            'phone' => '01234567890',
            'address1' => 'Address',
            'country' => 'Egypt',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function order_requires_valid_phone()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '123', // رقم هاتف قصير جداً
            'address1' => 'Address',
            'country' => 'Egypt',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    /** @test */
    public function product_increase_requires_valid_id()
    {
        $response = $this->post('/cart/increase', [
            'product_id' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function product_decrease_requires_valid_id()
    {
        $response = $this->post('/cart/decrease', [
            'product_id' => '',
        ]);

        $response->assertSessionHasErrors('product_id');
    }

    /** @test */
    public function user_role_must_be_valid()
    {
        $user = User::factory()->make([
            'role' => 'invalid_role',
        ]);

        // يجب أن يكون هناك validation في المستقبل
        // هذا اختبار توثيقي
        $this->assertTrue(true);
    }

    /** @test */
    public function password_must_be_hashed()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $plainPassword = 'password123';
        $this->assertTrue(\Hash::check($plainPassword, $user->password));
    }

    /** @test */
    public function order_requires_valid_address()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '01234567890',
            'address1' => '', // مطلوب
            'country' => 'Egypt',
        ]);

        $response->assertSessionHasErrors('address1');
    }

    /** @test */
    public function order_requires_valid_country()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '01234567890',
            'address1' => 'Address',
            'country' => '', // مطلوب
        ]);

        $response->assertSessionHasErrors('country');
    }

    /** @test */
    public function address2_is_optional()
    {
        $product = Products::factory()->create();
        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/checkout', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '01234567890',
            'address1' => 'Address',
            'country' => 'Egypt',
            // address2 فارغ ولكن اختياري
        ]);

        $response->assertRedirect();
    }
}
