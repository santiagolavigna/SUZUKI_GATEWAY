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

    function __construct($array) {
        $this->timestamp = $array[0];
        $this->user_name = $array[1];
        $this->user_lastname = $array[2];
        $this->email = $array[3];
        $this->phone = $array[4];
        $this->card = $array[5];
        $this->id_card = $array[6];
        $this->city = $array[7];
        $this->concessionaire = $array[8];
    }
}

?>