<?php
class Database {
    private static $host = 'localhost';
    private static $dbName = 'dbprojetoEstancia';
    private static $username = 'root';
    private static $password = '';

    private static $conn;

    public static function conectar() {
        if (!isset(self::$conn)) {
            try {
                self::$conn = new PDO(
                    'mysql:host=' . self::$host . ';dbname=' . self::$dbName . ';charset=utf8',
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erro na conexão: ' . $e->getMessage());
            }
        }
        return self::$conn;
    }

    public static function desconectar() {
        self::$conn = null;
    }
}
?>