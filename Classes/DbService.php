
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
    public static function getAllRows() {
        try {
            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'SELECT * FROM queue WHERE sent=0'
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

            DbContext::initialize();
            $qry = DbContext::getInstance()->prepare(
                'UPDATE queue SET sent=1,sentAt=? WHERE id=?'
            );

            $result = $qry->execute([$date,$id]);
        
            return $result;

        } catch (PDOException $e) {
            //TODO CREAR LOG CON EL ID DE REGISTRO PARA ACTUALIZARLO POR CRON
        
            //$logFile = fopen("log.txt", 'a') or die("Error creando archivo");
            //fwrite($logFile, "\n".date("d/m/Y H:i:s")." Mensaje que se quiera grabar") or die("Error escribiendo en el archivo");fclose($logFile);
    
            die("Error al actualizar el registro enviado a la API: " . $e->getMessage());
        }
    }
}