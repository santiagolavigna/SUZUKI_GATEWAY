<?php
class Sender {
    private $url;

    function __construct() {
        //TODO levantar de archivo de configuracion
       $this->url = '';
    }
   
   
    function sendToAPI($spm) {
        $response = new stdClass();
        try{
            //enviar a la api 
            //setear url api
            $response->data = true;
        }catch(Exception $e){
            $response->error = "Error: " . $e->getMessage();
        }
        return $response;
    }
}

?>