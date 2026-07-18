<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Organization;
use App\Models\Ride;
use App\Models\Booking;
use App\Helpers\Validator;
use App\Services\NotificationService;

class AdminController extends Controller
{
    /**
     * Admin Dashboard.
     * GET /admin/dashboard
     */
    public function dashboard(): void
    {
        $orgId = $_SESSION['org_id'];

        $userModel    = new User();
        $rideModel    = new Ride();
        $bookingModel = new Booking();
        $orgModel     = new Organization();

        $org = $orgModel->findById($orgId);

        $stats = [
            'total_employees' => $userModel->countByOrg($orgId),
            'total_rides'     => $rideModel->countByOrg($orgId),
            'total_bookings'  => $bookingModel->countByOrg($orgId),
            'org'             => $org,
        ];

        $this->view('admin/dashboard', [
            'stats' => $stats,
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Employee Management page.
     * GET /admin/employees
     */
    public function employees(): void
    {
        $orgId     = $_SESSION['org_id'];
        $userModel = new User();
        $employees = $userModel->getByOrgId($orgId);

        $this->view('admin/employees', [
            'employees' => $employees,
            'flash'     => $this->getFlash(),
        ]);
    }

    /**
     * Update employee status (activate/deactivate).
     * POST /admin/employees/:id
     */
    public function updateEmployee(string $id): void
    {
        $data   = $this->jsonBody();
        $status = $data['status'] ?? 'active';

        $userModel = new User();
        $user      = $userModel->findById((int)$id);

        if (!$user || (int)$user['org_id'] !== (int)$_SESSION['org_id']) {
            $this->json(['success' => false, 'error' => 'Employee not found'], 404);
        }

        $userModel->updateStatus((int)$id, $status);
        $this->json(['success' => true, 'message' => "Employee {$status}d successfully"]);
    }

    /**
     * Vehicle moderation page.
     * GET /admin/vehicles
     */
    public function vehicles(): void
    {
        $orgId        = $_SESSION['org_id'];
        $vehicleModel = new Vehicle();
        $vehicles     = $vehicleModel->getByOrgId($orgId);

        $this->view('admin/vehicles', [
            'vehicles' => $vehicles,
            'flash'    => $this->getFlash(),
        ]);
    }

    /**
     * Organization Settings page.
     * GET /admin/settings
     */
    public function settings(): void
    {
        $orgModel = new Organization();
        $org      = $orgModel->findById($_SESSION['org_id']);

        $this->view('admin/settings', [
            'org'   => $org,
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Update organization settings.
     * POST /admin/settings
     */
    public function updateSettings(): void
    {
        $data = $_POST;

        $v = new Validator($data);
        $v->required('fuel_cost_per_km')->numeric('fuel_cost_per_km')
          ->required('default_fare_per_km')->numeric('default_fare_per_km');

        if ($v->fails()) {
            $this->flash('error', $v->firstError());
            $this->redirect('/admin/settings');
        }

        $orgModel = new Organization();
        $orgModel->updateSettings($_SESSION['org_id'], [
            'fuel_cost_per_km'    => (float)$data['fuel_cost_per_km'],
            'default_fare_per_km' => (float)$data['default_fare_per_km'],
        ]);

        NotificationService::push('success', 'Settings updated!');
        $this->redirect('/admin/settings');
    }
}
