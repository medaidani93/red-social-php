<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../helpers/FileHelper.php';
require_once __DIR__ . '/../models/PostRepository.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php?c=auth&action=login");
    exit();
}

$action = $_GET['action'] ?? 'feed';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $texto = trim($_POST['texto'] ?? '');

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $origin = $_FILES['image']['tmp_name'];
                $uniqueName = time() . "_" . basename($_FILES['image']['name']);

                if (FileHelper::uploadFile($origin, $uniqueName)) {
                    $fotoRuta = "public/uploads/" . $uniqueName;
                    PostRepository::create($texto, $fotoRuta, $_SESSION['user']['id']);
                }
            }
        }
        header("Location: index.php?c=post&action=feed");
        exit();

    case 'like':
        if (isset($_GET['post_id'])) {
            PostRepository::toggleLike($_SESSION['user']['id'], (int)$_GET['post_id']);
        }
        header("Location: index.php?c=post&action=feed");
        exit();

    case 'comment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = (int)($_POST['post_id'] ?? 0);
            $texto = trim($_POST['texto'] ?? '');
            if ($postId > 0 && !empty($texto)) {
                PostRepository::addComment($texto, $postId, $_SESSION['user']['id']);
            }
        }
        header("Location: index.php?c=post&action=feed");
        exit();

    case 'feed':
    default:
        $posts = PostRepository::getFeedPosts($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/feed.phtml';
        break;
}