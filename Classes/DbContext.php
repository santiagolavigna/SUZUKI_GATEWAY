
<?php

use PDO as PDO;
use PDOException as PDOException;

class DbContext {
    private static $db = null;

    public static function initialize() {
        if(empty(self::$db)) {
            try {
                self::$db = new PDO('sqlite:DB/database.sqlite');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public static function getInstance() {
        return self::$db;
    }

    public static function generateSchema() {
        $command = '
        CREATE TABLE IF NOT EXISTS queue (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            timestamp VARCHAR(100) NOT NULL,
            user_name VARCHAR(100) NOT NULL,
            user_lastname VARCHAR(100) NOT NULL,
            email VARCHAR(25) NOT NULL,
            phone INTEGER(12) NOT NULL,
            card VARCHAR(100) NOT NULL,
            id_card INTEGER(12) NOT NULL,
            city VARCHAR(20) NOT NULL,
            concessionaire VARCHAR(100) NOT NULL,
            createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
            sent BOOLEAN DEFAULT 0,
            sentAt DATETIME DEFAULT NULL
            )';

        try {
            self::$db->exec($command);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}