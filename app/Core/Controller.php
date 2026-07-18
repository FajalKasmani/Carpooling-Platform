<?php
namespace App\Core;

/**
 * BaseController — shared utilities for all controllers.
 */
class Controller
{
    /**
     * Render a view file with extracted data.
     *
     * @param string $path  Dot-separated view path, e.g. 'auth/login'
     * @param array  $data  Variables to extract into the view scope
     */
    protected function view(string $path, array $data = []): void
    {
        // Make data available as variables
        extract($data);

        // Also expose the base URL
        $baseUrl = $this->baseUrl();

        $viewFile = dirname(__DIR__) . "/Views/{$path}.php";

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View not found: {$path}";
            return;
        }

        require $viewFile;
    }

    /**
     * Return a JSON response and exit.
     */
    protected function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to another URL.
     */
    protected function redirect(string $path): void
    {
        header('Location: ' . $this->baseUrl() . $path);
        exit;
    }

    /**
     * Get the current authenticated user's ID from session.
     */
    protected function userId(): ?int
    {
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }

    /**
     * Get the current authenticated user's role from session.
     */
    protected function userRole(): ?string
    {
        return $_SESSION['role'] ?? null;
    }

    /**
     * Get JSON body from POST request.
     */
    protected function jsonBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    /**
     * Get the application base URL.
     */
    protected function baseUrl(): string
    {
        // For XAMPP: compute from SCRIPT_NAME
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        return dirname($scriptName);
    }

    /**
     * Set a flash message in session.
     */
    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Get and clear flash message.
     */
    protected function getFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
