<?php
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\RideController;
use App\Controllers\VehicleController;
use App\Controllers\TripController;
use App\Controllers\WalletController;
use App\Controllers\PaymentController;
use App\Controllers\ReportController;
use App\Controllers\AdminController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

$router = new Router();

// ── Auth Routes ──────────────────────────────────────────
$router->get('/login',       [AuthController::class, 'showLogin']);
$router->post('/login',      [AuthController::class, 'login']);
$router->get('/register',    [AuthController::class, 'showRegister']);
$router->post('/register',   [AuthController::class, 'register']);
$router->get('/logout',      [AuthController::class, 'logout']);
$router->get('/api/whoami',  [AuthController::class, 'whoami']);

// ── Dashboard Route ───────────────────────────────────────
$router->get('/',            [AuthController::class, 'showLogin']); // default redirect
$router->get('/dashboard',   [RideController::class, 'showFind'],    [AuthMiddleware::class]); // fallback view

// ── Ride Discovery / Publish ──────────────────────────────
$router->get('/find-ride',       [RideController::class, 'showFind'],       [AuthMiddleware::class]);
$router->post('/rides/search',   [RideController::class, 'search'],         [AuthMiddleware::class]);
$router->get('/rides/available', [RideController::class, 'available'],      [AuthMiddleware::class]);
$router->get('/offer-ride',      [RideController::class, 'showOffer'],      [AuthMiddleware::class]);
$router->post('/offerRide',      [RideController::class, 'offer'],          [AuthMiddleware::class]);
$router->post('/bookRide',       [RideController::class, 'book'],           [AuthMiddleware::class]);

// ── Vehicle Management ────────────────────────────────────
$router->get('/vehicles',             [VehicleController::class, 'index'],     [AuthMiddleware::class]);
$router->get('/vehicles/create',      [VehicleController::class, 'create'],    [AuthMiddleware::class]);
$router->post('/vehicles',            [VehicleController::class, 'store'],     [AuthMiddleware::class]);
$router->get('/vehicles/:id/edit',    [VehicleController::class, 'edit'],      [AuthMiddleware::class]);
$router->post('/vehicles/:id/update', [VehicleController::class, 'update'],    [AuthMiddleware::class]);
$router->post('/vehicles/:id/delete', [VehicleController::class, 'delete'],    [AuthMiddleware::class]);
$router->get('/api/vehicles',         [VehicleController::class, 'apiList'],   [AuthMiddleware::class]);

// ── Trip Tracking & Lifecycle ─────────────────────────────
$router->get('/my-trips',             [TripController::class, 'myTrips'],      [AuthMiddleware::class]);
$router->get('/trip/:id',             [TripController::class, 'details'],      [AuthMiddleware::class]);
$router->post('/trip/:id/start',      [TripController::class, 'start'],        [AuthMiddleware::class]);
$router->post('/trip/:id/end',        [TripController::class, 'end'],          [AuthMiddleware::class]);
$router->post('/trip/:id/location',   [TripController::class, 'updateLocation'],[AuthMiddleware::class]);
$router->get('/trip/:id/location',    [TripController::class, 'getLocation'],   [AuthMiddleware::class]);
$router->get('/api/myTrips',          [TripController::class, 'apiMyTrips'],   [AuthMiddleware::class]);

// ── Wallet & Payments ─────────────────────────────────────
$router->get('/wallet',               [WalletController::class, 'index'],      [AuthMiddleware::class]);
$router->post('/wallet/recharge',     [WalletController::class, 'recharge'],   [AuthMiddleware::class]);
$router->get('/api/wallet',           [WalletController::class, 'apiBalance'],  [AuthMiddleware::class]);

$router->post('/payments/initiate',    [PaymentController::class, 'initiate'],   [AuthMiddleware::class]);
$router->post('/payments/verify',      [PaymentController::class, 'verify'],     [AuthMiddleware::class]);
$router->post('/payments/cash-confirm',[PaymentController::class, 'cashConfirm'],[AuthMiddleware::class]);

// ── History & Reports ─────────────────────────────────────
$router->get('/reports',              [ReportController::class, 'index'],      [AuthMiddleware::class]);
$router->get('/reports/summary',      [ReportController::class, 'summary'],    [AuthMiddleware::class]);
$router->get('/ride-history',         [ReportController::class, 'history'],    [AuthMiddleware::class]);

// ── Admin Supervision ─────────────────────────────────────
$router->get('/admin/dashboard',        [AdminController::class, 'dashboard'],       [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/employees',        [AdminController::class, 'employees'],       [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/employees/:id',   [AdminController::class, 'updateEmployee'],  [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/vehicles',         [AdminController::class, 'vehicles'],        [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/admin/settings',         [AdminController::class, 'settings'],        [AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/admin/settings',        [AdminController::class, 'updateSettings'],  [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/reports/admin',          [ReportController::class, 'adminReport'],    [AuthMiddleware::class, AdminMiddleware::class]);

return $router;
