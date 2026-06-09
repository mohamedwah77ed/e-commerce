<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_can_display_cart_page()
    {
        $response = $this->get('/cart');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.cart');
    }

    /** @test */
    public function it_can_add_product_to_cart()
    {
        $product = Products::factory()->create([
            'status' => 'active',
            'stock' => 10,
        ]);

        $response = $this->post('/add-to-cart', [
            'slug' => $product->slug,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @test */
    public function it_fails_to_add_invalid_product()
    {
        $response = $this->post('/add-to-cart', [
            'slug' => 'invalid-product-slug',
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_validates_product_slug()
    {
        $response = $this->post('/add-to-cart', []);

        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function it_can_increase_cart_quantity()
    {
        $product = Products::factory()->create();

        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->post('/cart/increase', [
            'product_id' => $product->id,
        ]);

        $response->assertSessionHas('success');
    }

    /** @test */
    public function it_can_decrease_cart_quantity()
    {
        $product = Products::factory()->create();

        $this->post('/add-to-cart', ['slug' => $product->slug]);
        $this->post('/cart/increase', ['product_id' => $product->id]);

        $response = $this->post('/cart/decrease', [
            'product_id' => $product->id,
        ]);

        $response->assertSessionHas('success');
    }

    /** @test */
    public function it_can_delete_from_cart()
    {
        $product = Products::factory()->create();

        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->delete('/cart-delete', [
            'id' => $product->id,
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function it_returns_cart_count()
    {
        $product = Products::factory()->create();

        $this->post('/add-to-cart', ['slug' => $product->slug]);

        $response = $this->get('/cart/count');

        $response->assertStatus(200);
        $response->assertJsonStructure(['count']);
    }

    /** @test */
    public function it_prevents_invalid_product_quantity()
    {
        $response = $this->post('/cart/increase', [
            'product_id' => 'invalid',
        ]);

        $response->assertSessionHasErrors('product_id');
    }
}
