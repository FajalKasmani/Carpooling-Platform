<?php
namespace App\Services;

/**
 * NotificationService — in-app flash notification helpers.
 * For hackathon scope: session-based flash messages only.
 */
class NotificationService
{
    /**
     * Push a notification into session.
     */
    public static function push(string $type, string $message): void
    {
        if (!isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }
        $_SESSION['notifications'][] = [
            'type'    => $type, // success, error, info, warning
            'message' => $message,
            'time'    => date('H:i'),
        ];
    }

    /**
     * Get all pending notifications and clear them.
     */
    public static function pull(): array
    {
        $notifications = $_SESSION['notifications'] ?? [];
        unset($_SESSION['notifications']);
        return $notifications;
    }

    /**
     * Check if there are pending notifications.
     */
    public static function has(): bool
    {
        return !empty($_SESSION['notifications']);
    }
}
