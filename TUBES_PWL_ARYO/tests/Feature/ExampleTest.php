<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_directed_to_login_flow(): void
    {
        $this->get('/')->assertRedirect(route('dashboard'));
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/login')->assertOk();
    }

    public function test_mahasiswa_can_view_jadwal_but_cannot_manage_it(): void
    {
        $this->seed();

        $mahasiswa = User::where('role', 'mahasiswa')->firstOrFail();

        $this->actingAs($mahasiswa)->get('/jadwals')->assertOk();
        $this->actingAs($mahasiswa)->get('/jadwals/create')->assertForbidden();
    }

    public function test_admin_can_manage_jadwal(): void
    {
        $this->seed();

        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->get('/jadwals')->assertOk();
        $this->actingAs($admin)->get('/jadwals/create')->assertOk();
    }
}
