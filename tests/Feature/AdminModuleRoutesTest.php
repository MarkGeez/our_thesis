<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminModuleRoutesTest extends TestCase
{
    #[DataProvider('adminRouteDefinitions')]
    public function test_admin_route_is_registered(string $name, string $uri, string $method): void
    {
        $route = Route::getRoutes()->getByName($name);

        $this->assertNotNull($route, "Expected route [{$name}] to be registered.");
        $this->assertSame($uri, $route->uri(), "Unexpected URI for route [{$name}].");
        $this->assertContains($method, $route->methods(), "Unexpected HTTP method for route [{$name}].");
    }

    #[DataProvider('adminRouteDefinitions')]
    public function test_admin_route_has_required_admin_middleware(string $name, string $uri, string $method): void
    {
        $route = Route::getRoutes()->getByName($name);

        $this->assertNotNull($route, "Expected route [{$name}] to be registered.");

        $middleware = $route->gatherMiddleware();

        $this->assertContains('auth', $middleware, "Route [{$name}] should include auth middleware.");
        $this->assertContains('role:admin', $middleware, "Route [{$name}] should include role:admin middleware.");
        $this->assertContains('log.module.visit', $middleware, "Route [{$name}] should include log.module.visit middleware.");
    }

    public static function adminRouteDefinitions(): array
    {
        return [
            'admin dashboard' => ['admin.dashboard', 'admin/dashboard', 'GET'],
            'admin profile' => ['admin.profile', 'admin/profile', 'GET'],
            'admin household management' => ['admin.household', 'admin/household-management', 'GET'],
            'admin reports index' => ['admin.reports.index', 'admin/reports', 'GET'],
            'admin certificate request' => ['admin.certificateRequest', 'admin/certificateRequest', 'GET'],
            'admin clearance request' => ['admin.clearanceRequest', 'admin/clearanceRequest', 'GET'],
            'admin service request' => ['admin.serviceRequest', 'admin/serviceRequest', 'GET'],
            'admin complaint request' => ['admin.complaintRequest', 'admin/complaintRequest', 'GET'],
            'admin feedback request' => ['admin.feedbackRequest', 'admin/feedbackRequest', 'GET'],
            'admin settings' => ['admin.settings', 'admin/settings', 'GET'],
            'admin users' => ['admin.users', 'admin/users', 'GET'],
            'admin activity logs' => ['admin.activityLogs', 'admin/activityLogs', 'GET'],
            'admin services module' => ['admin.adminServices', 'admin/adminServices', 'GET'],
            'admin announcements' => ['admin.announcements', 'admin/announcements', 'GET'],
            'admin create announcement form' => ['admin.create-announcement', 'admin/create-announcement', 'GET'],
            'admin residents listing' => ['admin.residents', 'admin/residents', 'GET'],
            'admin blotter index' => ['admin.blotter.index', 'admin/blotter', 'GET'],
            'admin blotter create form' => ['admin.blotter.create', 'admin/blotter/create', 'GET'],
            'admin blotter store' => ['admin.blotter.store', 'admin/blotter', 'POST'],
            'admin blotter resident search' => ['admin.blotter.residents.search', 'admin/blotter/residents/search', 'GET'],
        ];
    }
}
