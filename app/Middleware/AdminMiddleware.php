<?php
namespace App\Middleware;

/**
 * AdminMiddleware — restricts access to admin-only routes.
 * Must be used AFTER AuthMiddleware in the middleware chain.
 */
class AdminMiddleware
{
    public function handle(): void
    {
        if (($_SESSION['role'] ?? '') !== 'admin') {
            if ($this->isAjax()) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Forbidden — admin access required']);
                exit;
            }

            $base = dirname($_SERVER['SCRIPT_NAME']);
            header('Location: ' . $base . '/dashboard');
            exit;
        }
    }

    private function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
    }
}
