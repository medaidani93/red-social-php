<?php
require_once __DIR__ . '/../bd.php';

class UserRepository {

    public static function findByUsername($username) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM usuario WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($username, $passwordHash) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO usuario (username, password) VALUES (:username, :password)");
        return $stmt->execute([
            ':username' => $username,
            ':password' => $passwordHash
        ]);
    }

    // Alias para evitar el error si authController llama a register()
    public static function register($username, $passwordHash) {
        return self::create($username, $passwordHash);
    }

    public static function searchUsers($search, $currentUserId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, username FROM usuario WHERE username LIKE :search AND id != :currentId");
        $stmt->execute([
            ':search' => "%$search%",
            ':currentId' => $currentUserId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function isFriend($userId, $friendId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT 1 FROM amigo WHERE (id_user = :userId AND id_amigo = :friendId) OR (id_user = :friendId AND id_amigo = :userId)");
        $stmt->execute([
            ':userId' => $userId,
            ':friendId' => $friendId
        ]);
        return (bool)$stmt->fetch();
    }

    public static function addFriend($userId, $friendId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT IGNORE INTO amigo (id_user, id_amigo) VALUES (:userId, :friendId)");
        return $stmt->execute([
            ':userId' => $userId,
            ':friendId' => $friendId
        ]);
    }

    public static function getFriends($userId) {
        $db = Database::getConnection();
        $sql = "SELECT id, username FROM usuario WHERE id IN (
                    SELECT id_amigo FROM amigo WHERE id_user = :userId
                    UNION
                    SELECT id_user FROM amigo WHERE id_amigo = :userId
                ) AND id != :userId
                ORDER BY username ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function removeFriend($userId, $friendId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM amigo 
                              WHERE (id_user = :userId AND id_amigo = :friendId) 
                                 OR (id_user = :friendId AND id_amigo = :userId)");
        return $stmt->execute([
            ':userId' => $userId,
            ':friendId' => $friendId
        ]);
    }
}