<?php 
//PHP 7.4
//Enabled PDO_sqlite in php.ini file

require_once __DIR__ . '/Classes/Spreadsheet.php';
require_once __DIR__ . '/Classes/DbContext.php';
require_once __DIR__ . '/Classes/DbService.php';
require_once __DIR__ . '/Models/SpreadsheetModel.php';
require_once __DIR__ . '/Utils/Utils.php';

DbContext::initialize();
DbContext::generateSchema();

$spreadsheet = new Spreadsheet();

$data = $spreadsheet->getRows();

if(!isset($data->error)){
    foreach($data->data as $arr){
        if(!Utils::isHeader($arr)){
        $spm = new SpreadsheetModel($arr);
        DbService::insertRow($spm);
        //APLICAR LOGICA PARA ARRANCAR DESDE EL INDICE DE LA DB QUE CORRESPONDE CON LAS FILAS (EN CASO DE QUE NUNCA BORREN ALGUNA (????) )
        //REALIZAR LOGICA PARA ENVIAR A LA API (WHERE SENT = 0), ACTUALIZAR CAMPOS SENT Y SENTAT   LUEGO DE ENVIAR
        }
    }
}else{
    var_dump($data->error);
}

?>