<?php
declare(strict_types=1);
namespace App;

class DB_Connect
{
    public static $conn;

    public static $user = "root";
    public static $password = "";
    public static $dsn = "mysql:host=localhost";
    const DB_NAME = "pizzeria";

    public function DB_Link(): \PDO
    {
        try {
            $conn = new \PDO(self::$dsn, self::$user, self::$password);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(\PDOException $e) {
            echo 'Connexion échouée : '.$e->getMessage();
        }
    }

    public function create_DB()
    {
        $sql_db = "CREATE DATABASE IF NOT EXISTS ".self::DB_NAME.
                    " CHARACTER SET utf8";
        
        try {
            $db_init = self::$conn->query($sql_db);
            echo "[V] Database ".self::DB_NAME." successfully initialized<br>";
            return $conn;
        } catch(\Exception $e) {
            echo "[X] Problème dans la création de la base ".self::DB_NAME." : $e->getMessage() <br>";
        }
    }
    
    public function exec_SQL_file(string $sql_filepath): void
    {
        try {
            $command = 'mysql'
            . ' --host=' . 'localhost'
            . ' --user=' . self::$user
            . ' --password=' . self::$password
            . ' --database=' . self::DB_NAME
            . ' --execute="SOURCE ' . $sql_filepath.'"';
    
            $output = shell_exec($command);
            echo gettype($output);
            echo "[V] Script '$sql_filepath' successfully executed<br>";
        } catch(\Exception $e) {
            echo "[X] Failed to execute the '$sql_filepath' script : ".$e->getMessage()." <br>";
        }
    }
}
