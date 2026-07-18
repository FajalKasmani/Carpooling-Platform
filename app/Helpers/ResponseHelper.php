<?php
namespace App\Helpers;

/**
 * ResponseHelper — uniform JSON response envelope.
 */
class ResponseHelper
{
    /**
     * Return a success JSON response.
     */
    public static function success(array $data = [], string $message = '', int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode(array_merge(['success' => true, 'message' => $message], $data));
        exit;
    }

    /**
     * Return an error JSON response.
     */
    public static function error(string $message, int $code = 400): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $message]);
        exit;
    }
}
