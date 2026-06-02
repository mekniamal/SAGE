<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
    }

    public function test_user_has_default_role()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password')
        ]);

        $this->assertEquals('user', $user->role);
    }

    public function test_user_can_be_promoted_to_admin()
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $user->update(['role' => 'admin']);

        $this->assertEquals('admin', $user->refresh()->role);
    }

    public function test_password_is_hashed()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('mypassword'),
            'role' => 'user'
        ]);

        $this->assertNotEquals('mypassword', $user->password);
    }

    public function test_user_can_be_retrieved_by_email()
    {
        $user = User::create([
            'name' => 'Find Me',
            'email' => 'findme@example.com',
            'password' => bcrypt('password')
        ]);

        $found = User::where('email', 'findme@example.com')->first();

        $this->assertNotNull($found);
        $this->assertEquals('Find Me', $found->name);
    }
}
