<?php
session_start();
if (isset($_GET["submitCreatePO"])) {
    $inputTanggalPO = $_GET["inputTanggalPO"];
    $inputPenjual = $_GET["inputPenjual"];
    $inputPembeli = $_GET["inputPembeli"];
    $kain = $_GET["kain"];

    self::$db->executeNonQuery("CreatePO", ["'".$inputTanggalPO."'", $inputPenjual,$inputPembeli, "'".$kain."'"]);

    $result = self::$db->executeQuery("GetDetailPO",["0"]);
    $_SESSION["POPDF"] = $result;
    $_SESSION["po"] = true;
}


