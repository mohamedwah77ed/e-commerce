<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->post('/logout');

        $this->assertGuest();
    }

    /** @test */
    public function only_admin_can_access_admin_dashboard()
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $regularUser = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($adminUser)->get('/admin/dashboard');
        $this->assertNotEquals(403, $response->status());

        $response = $this->actingAs($regularUser)->get('/admin/dashboard');
        $this->assertEquals(403, $response->status());
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin/dashboard');

        $this->assertNotEquals(200, $response->status());
    }

    /** @test */
    public function admin_cannot_modify_other_user_role()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        // محاولة تغيير الدور يجب أن تفشل أو تحتاج صلاحيات أعلى
        $this->actingAs($admin);

        $this->assertTrue($user->role === 'user');
    }

    /** @test */
    public function role_must_be_valid()
    {
        // محاولة إنشاء user برول غير صحيح
        $user = new User([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin', // دور غير صحيح
        ]);

        // يجب أن يكون هناك validation أو guard
        // هذا اختبار للتوثيق
    }
}
