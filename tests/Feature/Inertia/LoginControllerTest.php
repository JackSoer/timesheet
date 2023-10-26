<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userBcrypt;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = [
            'name' => 'asd',
            'password' => 'password',
        ];

        $this->userBcrypt = [
            'name' => 'asd',
            'password' => bcrypt('password'),
        ];
    }

    public function test_user_can_login()
    {
        User::factory()->create($this->userBcrypt);

        $response = $this->post('/login', $this->user);

        $response->assertRedirect('/');

        $this->assertTrue(Auth::check());
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');

        $this->assertFalse(Auth::check());
    }

    public function test_user_can_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldPassword'),
        ]);

        $this->actingAs($user);

        $newPassword = 'newPassword';

        $response = $this->post('/change-password', [
            'currentPassword' => 'oldPassword',
            'newPassword' => $newPassword,
        ]);

        $response->assertRedirect('/login');

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }
}
