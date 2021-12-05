
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
}