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
            $this->flash('old_email', $data['email'] ?? '');
            $this->redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($data['email']);

        if (!$user) {
            $this->flash('error', 'Account not found. Please check your email or register a new account.');
            $this->flash('old_email', $data['email'] ?? '');
            $this->redirect('/login');
        }

        if (!password_verify($data['password'], $user['password_hash'])) {
            $this->flash('error', 'Incorrect password. Please try again.');
            $this->flash('old_email', $data['email'] ?? '');
            $this->redirect('/login');
        }

        if ($user['status'] !== 'active') {
            $this->flash('error', 'Your account has been deactivated. Contact admin.');
            $this->flash('old_email', $data['email'] ?? '');
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
            $this->flash('old_name', $data['name'] ?? '');
            $this->flash('old_email', $data['email'] ?? '');
            $this->flash('old_phone', $data['phone'] ?? '');
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
            $this->flash('error', 'Company Email Address already exists');
            $this->flash('old_name', $data['name'] ?? '');
            $this->flash('old_email', $data['email'] ?? '');
            $this->flash('old_phone', $data['phone'] ?? '');
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

        NotificationService::push('success', 'Account created successfully! Welcome to Odoo.');
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

    /**
     * Show forgot password page.
     * GET /forgot-password
     */
    public function showForgotPassword(): void
    {
        $flash = $this->getFlash();
        $this->view('auth/forgot-password', ['flash' => $flash]);
    }

    /**
     * Process forgot password request.
     * POST /forgot-password
     */
    public function forgotPassword(): void
    {
        $data = $_POST;
        $email = $data['email'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->flash('error', 'No account found with that email address');
            $this->redirect('/forgot-password');
        }

        // Generate 4 digit code
        $code = sprintf("%04d", mt_rand(1000, 9999));

        // Insert into password_resets database
        $db = \App\Core\Database::getConnection();
        
        // Remove previous pending requests for this email to avoid duplicates
        $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ? AND status = 'pending'");
        $stmt->execute([$email]);
        
        $stmt = $db->prepare("INSERT INTO password_resets (email, code, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$email, $code]);

        $this->redirect('/forgot-password/verify?email=' . urlencode($email));
    }

    public function showVerifyCode(): void
    {
        $email = $_GET['email'] ?? '';
        if (empty($email)) {
            $this->redirect('/forgot-password');
        }
        $flash = $this->getFlash();
        $this->view('auth/verify-code', ['email' => $email, 'flash' => $flash]);
    }

    /**
     * Process 4-digit code verification.
     * POST /forgot-password/verify
     */
    public function verifyCode(): void
    {
        $data = $_POST;
        $email = $data['email'] ?? '';
        $code = $data['code'] ?? '';

        if (empty($email) || empty($code)) {
            $this->flash('error', 'Please enter the verification code');
            $this->redirect('/forgot-password/verify?email=' . urlencode($email));
        }

        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_resets WHERE email = ? AND code = ? AND status = 'pending' LIMIT 1");
        $stmt->execute([$email, $code]);
        $request = $stmt->fetch();

        if (!$request) {
            $this->flash('error', 'Incorrect or expired code. Please contact your administrator.');
            $this->redirect('/forgot-password/verify?email=' . urlencode($email));
        }

        // Update status to verified
        $stmt = $db->prepare("UPDATE password_resets SET status = 'verified' WHERE id = ?");
        $stmt->execute([$request['id']]);

        $this->redirect('/reset-password?email=' . urlencode($email) . '&code=' . urlencode($code));
    }

    public function showResetPassword(): void
    {
        $email = $_GET['email'] ?? '';
        $code = $_GET['code'] ?? '';

        if (empty($email) || empty($code)) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('/login');
        }

        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_resets WHERE email = ? AND code = ? AND status = 'verified' LIMIT 1");
        $stmt->execute([$email, $code]);
        $request = $stmt->fetch();

        if (!$request) {
            $this->flash('error', 'This reset link is invalid or has already been used.');
            $this->redirect('/login');
        }

        $flash = $this->getFlash();
        $this->view('auth/reset-password', [
            'flash' => $flash,
            'email' => $email,
            'code' => $code
        ]);
    }

    /**
     * Process reset password form.
     * POST /reset-password
     */
    public function resetPassword(): void
    {
        $data = $_POST;
        $email = $data['email'] ?? '';
        $code = $data['code'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($code) || empty($password)) {
            $this->flash('error', 'Invalid reset request.');
            $this->redirect('/login');
        }

        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM password_resets WHERE email = ? AND code = ? AND status = 'verified' LIMIT 1");
        $stmt->execute([$email, $code]);
        $request = $stmt->fetch();

        if (!$request) {
            $this->flash('error', 'Reset authorization expired.');
            $this->redirect('/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->flash('error', 'User not found.');
            $this->redirect('/login');
        }

        // Update password in DB
        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([
            password_hash($password, PASSWORD_DEFAULT),
            $user['id']
        ]);

        // Complete the request
        $stmt = $db->prepare("UPDATE password_resets SET status = 'completed' WHERE id = ?");
        $stmt->execute([$request['id']]);

        NotificationService::push('success', 'Password reset successfully! You can now log in.');
        $this->redirect('/login');
    }

    private function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
    }
}
