<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Vehicle;
use App\Helpers\Validator;
use App\Services\NotificationService;

class VehicleController extends Controller
{
    /**
     * List user's vehicles.
     * GET /vehicles
     */
    public function index(): void
    {
        $model = new Vehicle();
        $vehicles = $model->getByOwnerId($this->userId());

        $this->view('vehicles/list', [
            'vehicles' => $vehicles,
            'flash'    => $this->getFlash(),
        ]);
    }

    /**
     * Show add vehicle form.
     * GET /vehicles/create
     */
    public function create(): void
    {
        $this->view('vehicles/form', [
            'vehicle' => null,
            'flash'   => $this->getFlash(),
        ]);
    }

    /**
     * Store new vehicle.
     * POST /vehicles
     */
    public function store(): void
    {
        $data = $_POST;

        $v = new Validator($data);
        $v->required('model')
          ->required('registration_number')
          ->required('seating_capacity')->min('seating_capacity', 2);

        if ($v->fails()) {
            $this->flash('error', $v->firstError());
            $this->redirect('/vehicles/create');
        }

        $model = new Vehicle();

        if ($model->regNumberExists($data['registration_number'])) {
            $this->flash('error', 'This registration number is already registered');
            $this->redirect('/vehicles/create');
        }

        // Handle photo upload
        $photo = null;
        if (!empty($_FILES['photo']['name'])) {
            $photo = $this->handleUpload($_FILES['photo']);
        }

        $model->create([
            'owner_id'            => $this->userId(),
            'model'               => $data['model'],
            'registration_number' => strtoupper($data['registration_number']),
            'seating_capacity'    => (int)$data['seating_capacity'],
            'photo'               => $photo,
        ]);

        NotificationService::push('success', 'Vehicle added successfully!');
        $this->redirect('/vehicles');
    }

    /**
     * Show edit vehicle form.
     * GET /vehicles/:id/edit
     */
    public function edit(string $id): void
    {
        $model   = new Vehicle();
        $vehicle = $model->findById((int)$id);

        if (!$vehicle || (int)$vehicle['owner_id'] !== $this->userId()) {
            $this->flash('error', 'Vehicle not found');
            $this->redirect('/vehicles');
        }

        $this->view('vehicles/form', [
            'vehicle' => $vehicle,
            'flash'   => $this->getFlash(),
        ]);
    }

    /**
     * Update vehicle.
     * POST /vehicles/:id/update
     */
    public function update(string $id): void
    {
        $data  = $_POST;
        $model = new Vehicle();

        $vehicle = $model->findById((int)$id);
        if (!$vehicle || (int)$vehicle['owner_id'] !== $this->userId()) {
            $this->flash('error', 'Vehicle not found');
            $this->redirect('/vehicles');
        }

        $v = new Validator($data);
        $v->required('model')
          ->required('registration_number')
          ->required('seating_capacity')->min('seating_capacity', 2);

        if ($v->fails()) {
            $this->flash('error', $v->firstError());
            $this->redirect("/vehicles/{$id}/edit");
        }

        if ($model->regNumberExists($data['registration_number'], (int)$id)) {
            $this->flash('error', 'This registration number is already registered');
            $this->redirect("/vehicles/{$id}/edit");
        }

        $photo = $vehicle['photo'];
        if (!empty($_FILES['photo']['name'])) {
            $photo = $this->handleUpload($_FILES['photo']);
        }

        $model->update((int)$id, [
            'model'               => $data['model'],
            'registration_number' => strtoupper($data['registration_number']),
            'seating_capacity'    => (int)$data['seating_capacity'],
            'photo'               => $photo,
        ]);

        NotificationService::push('success', 'Vehicle updated!');
        $this->redirect('/vehicles');
    }

    /**
     * Delete (deactivate) vehicle.
     * POST /vehicles/:id/delete
     */
    public function delete(string $id): void
    {
        $model   = new Vehicle();
        $vehicle = $model->findById((int)$id);

        if (!$vehicle || (int)$vehicle['owner_id'] !== $this->userId()) {
            $this->flash('error', 'Vehicle not found');
            $this->redirect('/vehicles');
        }

        $model->delete((int)$id);
        NotificationService::push('success', 'Vehicle removed');
        $this->redirect('/vehicles');
    }

    /**
     * AJAX: Get vehicles for current user.
     * GET /api/vehicles
     */
    public function apiList(): void
    {
        $model    = new Vehicle();
        $vehicles = $model->getByOwnerId($this->userId());
        $this->json(['success' => true, 'vehicles' => $vehicles]);
    }

    /**
     * Handle file upload.
     */
    private function handleUpload(array $file): ?string
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) return null;

        $uploadDir = dirname(__DIR__, 2) . '/public/assets/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $filename = uniqid('vehicle_') . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

        return 'assets/uploads/' . $filename;
    }
}
