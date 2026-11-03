<?php
class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            $host = 'localhost';
            $dbName = 'red_social';
            $user = 'root';
            $password = ''; // Si tienes contraseña en MySQL, ponla aquí

            try {
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$dbName;charset=utf8mb4",
                    $user,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("❌ Error en la conexión: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
