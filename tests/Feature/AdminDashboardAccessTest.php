<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminDashboardAccessTest extends TestCase
{
    public function test_guest_is_redirected_to_login_when_accessing_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_admin_dashboard_content(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $response->assertDontSee('Dashboard');
    }
}
