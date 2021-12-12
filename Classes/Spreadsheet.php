<?php
class Spreadsheet {
    private $url;

    function __construct() {
       $this->url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSZ5JsMaq_kiclDlHTWf7h6x2hI5eZ6LQGPOJyNwyDCO_dKWFEg2dSUk7GF_fK9HP43k7XeK_zJqvl5/pub?gid=0&single=true&output=csv';
    }

    function getRows() {
        $response = new stdClass();

        if(!ini_set('default_socket_timeout', 15)){
            $response->error = 'unable to change socket timeout';
        }

        if (($handle = fopen($this->url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $spreadsheet_data[] = $data;
            }
            fclose($handle);
            $response->data = $spreadsheet_data;
        }else{
            $response->error = 'problem reading csv';
        }
        return $response;
    }
}

?>
