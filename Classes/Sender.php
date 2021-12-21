<?php
class Sender {
    private $url;

    function __construct() {
        //TODO levantar de archivo de configuracion
       $this->url = 'https://cariai.com/derco/sendhsmcity';
    }


    function sendToAPI($spm) {
        $response = new stdClass();
        $response->data = false;

        try{
            //enviar a la api
            //setear url api

            $data = array(
                    "name" => $spm->user_name . ' ' . $spm->user_lastname,
                    "cellphone" => $spm->phone,
                    "email" => $spm->email,
                    //TRAERLO DE LA BASE, WHERE CONCESSIONAIRE = $SPM->CONCESSIONAIRE
                    "car_brand" => $client_device,

                //???"vehicle" => $client_device,
                    "identification" => $spm->identification,
                //???"pieza" => $client_device,
                //???"buytime" => $client_device,
                //???"budget" => $client_device,

                    //TRAERLO DE LA BASE, WHERE CONCESSIONAIRE = $SPM->CONCESSIONAIRE
                    "city" => $client_device,
                    "store" => $client_device,
            );
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ZGVyY29Ic21MZWFkczpSaXNYMkZnd2Rk',
                    'Content-Type: text/plain',
                    'Cookie: AWSALB=Ozk9IXa+Rlxl42f8Jop73jMva0vyBSG3DtmkWcG7b5uZKXAb4fRKrA3SEg+WHLrSGxu242iSXsX7z4L+U8aIT4B7AQee9NnBkttFLdOayRtIsQ90oMhcW2yYWUXk; AWSALBCORS=Ozk9IXa+Rlxl42f8Jop73jMva0vyBSG3DtmkWcG7b5uZKXAb4fRKrA3SEg+WHLrSGxu242iSXsX7z4L+U8aIT4B7AQee9NnBkttFLdOayRtIsQ90oMhcW2yYWUXk; PHPSESSID=b6hdnr6gglb63532eo1ksa3h85'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            die($response);
            echo $response;
            $response->data = true;

        }catch(Exception $e){
            $response->error = "Error: " . $e->getMessage();
        }
        return $response;
    }
}

?>
