<?php
// ============================================================
// UDAAN Carpooling Platform — Single Entry Point
// Front controller pattern
// ============================================================

// Autoload composer dependencies and app classes
require_once __DIR__ . '/../vendor/autoload.php';

// Start server session
session_start();

// Boot application config
require_once __DIR__ . '/../app/Config/config.php';

// Load routes
$router = require_once __DIR__ . '/../routes/web.php';

// Dispatch routing matching
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
