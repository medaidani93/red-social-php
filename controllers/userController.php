<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/UserRepository.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php?c=auth&action=login");
    exit();
}

$action = $_GET['action'] ?? 'friends';
$currentUserId = $_SESSION['user']['id'];

switch ($action) {
    case 'addFriend':
        $friendId = (int)($_GET['id'] ?? 0);
        if ($friendId > 0 && $friendId !== $currentUserId) {
            UserRepository::addFriend($currentUserId, $friendId);
        }
        $searchParam = urlencode($_GET['q'] ?? '');
        header("Location: index.php?c=user&action=search&q=" . $searchParam);
        exit();

    case 'removeFriend':
        $friendId = (int)($_GET['id'] ?? 0);
        if ($friendId > 0) {
            UserRepository::removeFriend($currentUserId, $friendId);
        }
        header("Location: index.php?c=user&action=friends");
        exit();

    case 'friends':
        $friends = UserRepository::getFriends($currentUserId);
        require_once __DIR__ . '/../views/friends.phtml';
        break;

    case 'search':
    default:
        $query = trim($_GET['q'] ?? '');
        $results = [];

        if (!empty($query)) {
            $results = UserRepository::searchUsers($query, $currentUserId);
        }

        require_once __DIR__ . '/../views/search.phtml';
        break;
}