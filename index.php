<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = $_GET['c'] ?? 'post';

switch ($controller) {
    case 'auth':
        require_once __DIR__ . '/controllers/authController.php';
        break;

    case 'user':
        require_once __DIR__ . '/controllers/userController.php';
        break;

    case 'post':
    default:
        require_once __DIR__ . '/controllers/postController.php';
        break;
}