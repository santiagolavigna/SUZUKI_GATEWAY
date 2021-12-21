
<?php

use PDO as PDO;
use DbContext as DbContext;

class DbService {

    public static function insertRow(SpreadsheetModel $spm) {
        try {
            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'INSERT INTO queue (timestamp, user_name, user_lastname, email, phone, card, id_card, city, concessionaire) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );

            $qry->execute([
                $spm->timestamp,
                $spm->user_name,
                $spm->user_lastname,
                $spm->email,
                $spm->phone,
                $spm->card,
                $spm->id_card,
                $spm->city,
                $spm->concessionaire
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getLastIndex() {
        try {
            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'SELECT id FROM queue order by id DESC limit 1'
            );

            $index = $qry->execute();
            $result = $qry->fetchAll(PDO::FETCH_OBJ);

            return isset($result[0]->id) ? $result[0]->id : 0;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //return all rows to send api
    public static function getAllRows($table,$where = '') {
        try {
            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'SELECT * FROM ' . $table . ' ' . $where
            );

            $index = $qry->execute();
            $result = $qry->fetchAll(PDO::FETCH_OBJ);

            return $result;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


      public static function updateRowByID($id) {
        try {
            $date = date('Y-m-d H:i:s');
            $errorMesage = "NULL";
            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'UPDATE queue SET sent=1,sentAt=?,errorMessage=? WHERE id=?'
            );

            $result = $qry->execute([$date,$errorMesage,$id]);
            return $result;

        } catch (Exception $e) {
            die("Error al actualizar el registro enviado a la API: " . $e->getMessage());
        }
    }

    public static function updateRowErrorByID($id,$message) {
        try {
            $date = date('Y-m-d H:i:s');
            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'UPDATE queue SET errorMessage=?,sentAt=? WHERE id=?'
            );
            $result = $qry->execute([$message,$date,$id]);

            return $result;
        } catch (PDOException $e) {
            die("Error al actualizar el campo errorMessage: " . $message . "ERROR= " . $e->getMessage());
        }
    }
}
