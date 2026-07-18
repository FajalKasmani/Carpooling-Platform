<?php
namespace App\Middleware;

/**
 * AuthMiddleware — blocks unauthenticated access.
 */
class AuthMiddleware
{
    public function handle(): void
    {
        if (empty($_SESSION['user_id'])) {
            // AJAX requests get JSON 401
            if ($this->isAjax()) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized — please log in']);
                exit;
            }

            // HTML requests redirect to login
            $base = dirname($_SERVER['SCRIPT_NAME']);
            header('Location: ' . $base . '/login');
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
