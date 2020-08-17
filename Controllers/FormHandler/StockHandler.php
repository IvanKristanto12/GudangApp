<?php
session_start();

if (isset($_GET['submitTambahStock'])) {
    $inputNomorKarung = $_GET['inputNomorKarung'];
    $inputMeter = $_GET['inputMeter'];
    $inputTanggalMasuk = $_GET['inputTanggalMasuk'];
    $inputSampel = $_GET['inputSampel'];
    $inputWarna = $_GET['inputWarna'];

    self::$db->executeNonQuery("InsertStock", [$inputNomorKarung, $inputMeter, "'" . $inputTanggalMasuk . "'", $inputSampel, $inputWarna]);
    $_SESSION["done"] = true;
} else if (isset($_GET['submitTambahSampel'])) {

    $inputSampelBaru = $_GET['inputSampelBaru'];
    $inputJenisKain = $_GET['inputJenisKain'];
    $inputWarna ="";

    $result = self::$db->executeQuery("GetListWarna", [""]);
    for($i = 0 ; $i < count($result) ; $i++){
        if(isset($_GET["warna"][$i])){
            $inputWarna .= $_GET["warna"][$i].', ';
        }
    }

    self::$db->executeNonQuery("InsertNewSampel", ["'".$inputSampelBaru."'", $inputJenisKain, "'".$inputWarna."'"]);
    $_SESSION["done"] = true;
}

