<?php
class SpreadsheetModel {
    public $id;
    public $timestamp;
    public $user_name;
    public $user_lastname;
    public $email;
    public $phone;
    public $card;
    public $id_card;
    public $city;
    public $concessionaire;

    function __construct($data,$isArray = false) { 
        if($isArray){ 
            $this->timestamp = $data[0];
            $this->user_name = $data[1];
            $this->user_lastname = $data[2];
            $this->email = $data[3];
            $this->phone = $data[4];
            $this->card = $data[5];
            $this->id_card = $data[6];
            $this->city = $data[7];
            $this->concessionaire = $data[8];
        }else{
            $this->id = $data->id;
            $this->timestamp = $data->timestamp;
            $this->user_name = $data->user_name;
            $this->user_lastname = $data->user_lastname;
            $this->email = $data->email;
            $this->phone = $data->phone;
            $this->card = $data->card;
            $this->id_card = $data->id_card;
            $this->city = $data->city;
            $this->concessionaire = $data->concessionaire;
        }
    }
}

?>