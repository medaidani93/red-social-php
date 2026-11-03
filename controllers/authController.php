<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/UserRepository.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = "Todos los campos son obligatorios.";
                require_once __DIR__ . '/../views/register.php';
                break;
            }

            // Verificar si el usuario ya existe para evitar error fatal SQL
            $existingUser = UserRepository::findByUsername($username);
            if ($existingUser) {
                $error = "El usuario '$username' ya existe. Elige otro nombre.";
                require_once __DIR__ . '/../views/register.php';
                break;
            }

            // Encriptar contraseña y registrar
            $hash = password_hash($password, PASSWORD_BCRYPT);
            if (UserRepository::create($username, $hash)) {
                header("Location: index.php?c=auth&action=login&registered=1");
                exit();
            } else {
                $error = "Error al registrar el usuario.";
                require_once __DIR__ . '/../views/register.php';
            }
        } else {
            require_once __DIR__ . '/../views/register.php';
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = UserRepository::findByUsername($username);

            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username']
                ];
                header("Location: index.php?c=post&action=feed");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                require_once __DIR__ . '/../views/login.php';
            }
        } else {
            require_once __DIR__ . '/../views/login.php';
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?c=auth&action=login");
        exit();
        case 'profile':
        // Si viene un id por URL muestra ese perfil, si no, el del usuario conectado
        $profileUserId = isset($_GET['id']) ? (int)$_GET['id'] : $currentUserId;
        $profileUser = UserRepository::findByUsername(''); // Solo estructura base si hiciera falta
        
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, username FROM usuario WHERE id = :id");
        $stmt->execute([':id' => $profileUserId]);
        $targetUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$targetUser) {
            header("Location: index.php?c=post&action=feed");
            exit();
        }

        require_once __DIR__ . '/../models/PostRepository.php';
        $userPosts = PostRepository::getPostsByUserId($profileUserId);
        $userFriends = UserRepository::getFriends($profileUserId);

        require_once __DIR__ . '/../views/profile.php';
        break;
}