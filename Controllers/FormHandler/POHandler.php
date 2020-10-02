<?php
session_start();
if (isset($_GET["submitCreatePO"])) {
    $inputTanggalPO = $_GET["inputTanggalPO"];
    $inputPenjual = $_GET["inputPenjual"];
    $inputPembeli = $_GET["inputPembeli"];
    $inputNoSO = $_GET["inputNoSO"];
    $inputKeterangan = $_GET["inputKeterangan"];
    $kain = $_GET["kain"];

    self::$db->executeNonQuery("CreatePO", ["'".$inputTanggalPO."'", $inputPenjual,$inputPembeli, "'".$kain."'",$inputNoSO,"'".$inputKeterangan."'"]);

    $result = self::$db->executeQuery("GetDetailPO",["0"]);
    $_SESSION["POPDF"] = $result;
    $_SESSION["po"] = true;
}


