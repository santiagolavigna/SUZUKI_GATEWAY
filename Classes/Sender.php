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
            $concessionaire = explode('-',$spm->concessionaire);

            $where = "WHERE city='" . $spm->city . "' AND concessionaire LIKE '" . trim($concessionaire[0]) . ' ' . trim($concessionaire[1]) . "%' LIMIT 1";
            
            $result = DbService::getAllRows("showcase",$where);
          
            if(!empty($result)){     
                var_dump($spm);
                var_dump($result); 

            $data = array(
                    "name" => $spm->user_name . ' ' . $spm->user_lastname,
                    "cellphone" => $spm->phone,
                    "email" => $spm->email,
                    //TRAERLO DE LA BASE, WHERE CONCESSIONAIRE = $SPM->CONCESSIONAIRE
                    "car_brand" => $result[0]->brand,

                    "vehicle" => "swift",
                    "identification" => $spm->id_card,
                    "pieza" => "",
                    "buytime" => "",
                    "budget" => "",

                    //TRAERLO DE LA BASE, WHERE CONCESSIONAIRE = $SPM->CONCESSIONAIRE
                    "city" => $result[0]->city,
                    "store" => $result[0]->id,
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

            $curl_response = curl_exec($curl);

            curl_close($curl);

            die(var_dump($curl_response));

            $response->data = true;
        }else{
            $response->error = "No se encontro en la vitrina el concesionario: " . $spm->concessionaire ;
        }

            return $response;
        }catch(Exception $e){
            $response->error = "Error: " . $e->getMessage();
        }
        return $response;
    }
}

?>
