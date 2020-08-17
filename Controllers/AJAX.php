<?php
class AJAX extends Controller
{

    public static function getListWarna()
    {
        self::initializeDB();
        $respondText = '<option value="0" disabled selected>Pilih Warna</option> ';
        $inputId = $_REQUEST["inputId"];
        $result = self::$db->executeQuery("GetIdSampelIdWarna", [$inputId]);
        for ($i = 0; $i < count($result); $i++) {
            $respondText .= '"<option value="'.$result[$i]["Id_Warna"].'">'.$result[$i]["Warna"].'</option> "';
        }
        echo $respondText;
    }

}
