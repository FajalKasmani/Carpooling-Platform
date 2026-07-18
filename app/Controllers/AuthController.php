<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Helpers\Validator;
use App\Services\NotificationService;

class AuthController extends Controller
{
    /**
     * Show welcome splash landing page.
     * GET /
     */
    public function showWelcome(): void
    {
        $this->view('auth/welcome');
    }

    /**
     * Show login page.
     * GET /login
     */
    public function showLogin(): void
    {
        // If already logged in, redirect to dashboard
        if ($this->userId()) {
            $this->redirect('/dashboard');
        }
        $flash = $this->getFlash();
        $this->view('auth/login', ['flash' => $flash]);
    }

    /**
     * Show registration page.
     * GET /register
     */
    public function showRegister(): void
    {
        if ($this->userId()) {
            $this->redirect('/dashboard');
        }
        $flash = $this->getFlash();
        $this->view('auth/register', ['flash' => $flash]);
    }

    /**
     * Process login.
     * POST /login
     */
    public function login(): void
    {
        $data = $_POST;

        $v = new Validator($data);
        $v->required('email')->email('email')->required('password');

        if ($v->fails()) {
            $this->flash('error', $v->firstError());
            $this->redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password_hash'])) {
            $this->flash('error', 'Invalid email or password');
            $this->redirect('/login');
        }

        if ($user['status'] !== 'active') {
            $this->flash('error', 'Your account has been deactivated. Contact admin.');
            $this->redirect('/login');
        }

        // Set session
        $_SESSION['user_id']  = (int)$user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['org_id']   = (int)$user['org_id'];

        NotificationService::push('success', "Welcome back, {$user['name']}!");

        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard');
        } else {
            $this->redirect('/dashboard');
        }
    }

    /**
     * Process registration.
     * POST /register
     */
    public function register(): void
    {
        $data = $_POST;

        $v = new Validator($data);
        $v->required('name')
          ->required('email')->email('email')
          ->required('phone')->phone('phone')
          ->required('password')->minLength('password', 8);

        if ($v->fails()) {
            $this->flash('error', $v->firstError());
            $this->redirect('/register');
        }

        // Extract domain from email
        $emailDomain = substr($data['email'], strpos($data['email'], '@') + 1);

        // Find matching organization
        $orgModel = new Organization();
        $org = $orgModel->findByDomain($emailDomain);

        if (!$org) {
            // Auto-create the organization for the domain so any user can test
            $orgId = $orgModel->create([
                'name' => ucfirst(explode('.', $emailDomain)[0]) . ' Organization',
                'domain' => $emailDomain
            ]);
            $org = $orgModel->findById($orgId);
        }

        $userModel = new User();

        if ($userModel->emailExists($data['email'])) {
            $this->flash('error', 'An account with this email already exists');
            $this->redirect('/register');
        }

        $userId = $userModel->create([
            'org_id'   => $org['id'],
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => $data['password'],
            'role'     => 'employee',
        ]);

        // Auto-login
        $_SESSION['user_id']   = $userId;
        $_SESSION['user_name'] = $data['name'];
        $_SESSION['role']      = 'employee';
        $_SESSION['org_id']    = (int)$org['id'];

        NotificationService::push('success', 'Account created successfully! Welcome to UDAAN.');
        $this->redirect('/dashboard');
    }

    /**
     * Logout.
     * GET /logout
     */
    public function logout(): void
    {
        session_destroy();
        // Start a new session for flash message
        session_start();
        $this->flash('success', 'You have been logged out');
        $this->redirect('/login');
    }

    /**
     * AJAX: Check current session.
     * GET /api/whoami
     */
    public function whoami(): void
    {
        if (!$this->userId()) {
            $this->json(['success' => false, 'error' => 'Not logged in'], 401);
        }

        $userModel = new User();
        $user = $userModel->findById($this->userId());

        if (!$user) {
            $this->json(['success' => false, 'error' => 'User not found'], 404);
        }

        unset($user['password_hash']);
        $this->json(['success' => true, 'user' => $user]);
    }

    /**
     * Show employee dashboard.
     * GET /dashboard
     */
    public function dashboard(): void
    {
        $this->view('dashboard');
    }

    /**
     * Show settings and saved places.
     * GET /settings
     */
    public function settings(): void
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM saved_places WHERE user_id = ? ORDER BY label");
        $stmt->execute([$this->userId()]);
        $places = $stmt->fetchAll();

        $this->view('user/settings', [
            'places' => $places,
            'flash'  => $this->getFlash()
        ]);
    }

    /**
     * Add a saved place.
     * POST /saved-places
     */
    public function addSavedPlace(): void
    {
        $data = $this->jsonBody();
        if (empty($data)) $data = $_POST;

        $v = new Validator($data);
        $v->required('label')
          ->required('address')
          ->required('lat')
          ->required('lng');

        if ($v->fails()) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'error' => $v->firstError()], 400);
            }
            $this->flash('error', $v->firstError());
            $this->redirect('/settings');
        }

        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("INSERT INTO saved_places (user_id, label, address, lat, lng) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $this->userId(),
            $data['label'],
            $data['address'],
            $data['lat'],
            $data['lng']
        ]);

        if ($this->isAjax()) {
            $this->json(['success' => true, 'message' => 'Place saved successfully!']);
        }

        NotificationService::push('success', 'Place saved successfully!');
        $this->redirect('/settings');
    }

    /**
     * Delete a saved place.
     * POST /saved-places/:id/delete
     */
    public function deleteSavedPlace(string $id): void
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("DELETE FROM saved_places WHERE id = ? AND user_id = ?");
        $stmt->execute([(int)$id, $this->userId()]);

        if ($this->isAjax()) {
            $this->json(['success' => true, 'message' => 'Saved place deleted!']);
        }

        NotificationService::push('success', 'Saved place deleted!');
        $this->redirect('/settings');
    }

    private function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
    }
}
