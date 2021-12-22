<?php
//PHP 7.4
//Enabled 'pdo_sqlite' in php.ini file
//Enabled 'curl' in php.ini file

define('GSHEET_URL_CSV', 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSZ5JsMaq_kiclDlHTWf7h6x2hI5eZ6LQGPOJyNwyDCO_dKWFEg2dSUk7GF_fK9HP43k7XeK_zJqvl5/pub?gid=0&single=true&output=csv');
define('DERCO_URL_API', 'https://cariai.com/derco/sendhsmcity');

require_once __DIR__ . '/Classes/Spreadsheet.php';
require_once __DIR__ . '/Classes/DbContext.php';
require_once __DIR__ . '/Classes/DbService.php';
require_once __DIR__ . '/Classes/Sender.php';
require_once __DIR__ . '/Models/SpreadsheetModel.php';
require_once __DIR__ . '/Utils/Utils.php';

DbContext::initialize();

DbContext::generateSchema();

$spreadsheet = new Spreadsheet();

$data = $spreadsheet->getRows();

if(!isset($data->error)){

    $lastIndex = (int) DbService::getLastIndex();
    var_dump("index: " . $lastIndex);
    $count = 0;

    foreach($data->data as $arr){
        if(!Utils::isHeader($arr) && $count > $lastIndex){
        $spm = new SpreadsheetModel($arr,true);
        DbService::insertRow($spm);
        }
        $count++;
    }

    $result = DbService::getAllRows("queue","WHERE sent=0");

    if(!empty($result)){

        $sender = new Sender();

        foreach($result as $arr){

            $spm = new SpreadsheetModel($arr);

            $result = $sender->sendToAPI($spm);

            if(!isset($result->error) && $result->data){
                DbService::updateRowByID($spm->id);
            }else{
                DbService::updateRowErrorByID($spm->id,$result->error);
            }
        }
    }
}else{
    var_dump($data->error);
    die();
}


?>
