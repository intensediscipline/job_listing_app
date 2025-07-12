<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);
    }


    public function test_user_can_view_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_email_validation_is_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_validation_is_required()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => ''
        ]);

        $response->assertSessionHasErrors('password');
    }
    public function test_guest_cannot_see_the_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_user_can_login()
    {
        $this->assertDatabaseHas('users', [
            'email' => $this->user->email,
            'password' => $this->user->password
        ]);

        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($this->user);
    }
}
