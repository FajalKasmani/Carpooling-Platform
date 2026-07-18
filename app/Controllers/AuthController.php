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
            $this->flash('error', "No organization found for domain '{$emailDomain}'. Please use your company email.");
            $this->redirect('/register');
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
}
