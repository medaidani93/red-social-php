<?php
require_once __DIR__ . '/../bd.php';

class PostRepository {

    public static function create($texto, $foto, $userId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO publicacion (texto, foto, id_user) VALUES (:texto, :foto, :userId)");
        return $stmt->execute([
            ':texto' => $texto,
            ':foto' => $foto,
            ':userId' => $userId
        ]);
    }

    public static function getFeedPosts($currentUserId) {
        $db = Database::getConnection();
        $sql = "SELECT DISTINCT p.*, u.username,
                       (SELECT COUNT(*) FROM like_pub l WHERE l.id_publicacion = p.id) AS total_likes,
                       (SELECT COUNT(*) FROM like_pub l WHERE l.id_publicacion = p.id AND l.id_user = :userId) AS user_liked
                FROM publicacion p
                INNER JOIN usuario u ON p.id_user = u.id
                LEFT JOIN amigo a1 ON (a1.id_user = :userId AND a1.id_amigo = p.id_user)
                LEFT JOIN amigo a2 ON (a2.id_amigo = :userId AND a2.id_user = p.id_user)
                WHERE (p.id_user = :userId OR a1.id_amigo IS NOT NULL OR a2.id_user IS NOT NULL)
                  AND p.fecha >= DATE_SUB(NOW(), INTERVAL 15 DAY)
                ORDER BY p.fecha DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([':userId' => $currentUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function toggleLike($userId, $postId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT 1 FROM like_pub WHERE id_user = :userId AND id_publicacion = :postId");
        $stmt->execute([':userId' => $userId, ':postId' => $postId]);

        if ($stmt->fetch()) {
            $del = $db->prepare("DELETE FROM like_pub WHERE id_user = :userId AND id_publicacion = :postId");
            return $del->execute([':userId' => $userId, ':postId' => $postId]);
        } else {
            $ins = $db->prepare("INSERT INTO like_pub (id_user, id_publicacion) VALUES (:userId, :postId)");
            return $ins->execute([':userId' => $userId, ':postId' => $postId]);
        }
    }

    public static function addComment($texto, $postId, $userId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO comentario (texto, id_publicacion, id_user) VALUES (:texto, :postId, :userId)");
        return $stmt->execute([
            ':texto' => $texto,
            ':postId' => $postId,
            ':userId' => $userId
        ]);
    }

    public static function getCommentsByPost($postId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT c.*, u.username 
                              FROM comentario c 
                              INNER JOIN usuario u ON c.id_user = u.id 
                              WHERE c.id_publicacion = :postId 
                              ORDER BY c.fecha ASC");
        $stmt->execute([':postId' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getPostsByUserId($userId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM publicacion WHERE id_user = :userId ORDER BY fecha DESC");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}