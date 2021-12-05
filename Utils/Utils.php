<?php
class Utils
{

    public static function isHeader($arr)
    {
        $response = false;
        if ($arr[0] == 'Marca temporal' || $arr[1] == 'Nombre_del_usuario' || $arr[2] == 'Apellido' || $arr[3] == 'Email' || $arr[4] == 'Teléfono' || $arr[5] == 'Cédula' || $arr[6] == 'Número de la cédula' || $arr[7] == 'Ciudad' || $arr[8] == 'Concesionario') {
            $response = true;
        }
        return $response;
    }

}