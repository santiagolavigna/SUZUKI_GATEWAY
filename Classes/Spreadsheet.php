<?php
class Spreadsheet {
    private $url;

    function __construct() {
       $this->url = GSHEET_URL_CSV;
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
