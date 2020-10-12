<?php
session_start();
if (isset($_GET["submitCreateRetur"])) {
    $inputTanggalRetur = $_GET["inputTanggalRetur"];
    $inputNoPO = $_GET["inputNoPO"];
    $inputKeterangan = $_GET["inputKeterangan"];
    $kain = $_GET["kain"];

    self::$db->executeNonQuery("createRetur", ["'" . $inputTanggalRetur . "'", $inputNoPO, "'" . $inputKeterangan . "'", "'" . $kain . "'"]);

    // $result = self::$db->executeQuery("GetDetailPO",["0"]);
    // $_SESSION["POPDF"] = $result;
    // $_SESSION["po"] = true;
}
