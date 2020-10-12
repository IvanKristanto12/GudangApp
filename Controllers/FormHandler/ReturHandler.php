<?php
session_start();
if (isset($_GET["submitCreateRetur"])) {
    $inputTanggalRetur = $_GET["inputTanggalRetur"];
    $inputNoPO = $_GET["inputNoPO"];
    $inputKeterangan = $_GET["inputKeterangan"];
    $kain = $_GET["kain"];

    $noRetur = self::$db->executeQuery("createRetur", ["'" . $inputTanggalRetur . "'", $inputNoPO, "'" . $inputKeterangan . "'", "'" . $kain . "'"]);

    $result = self::$db->executeQuery("GetDetailRetur",[$noRetur[0]["No_Retur"]]);
    $_SESSION["ReturPDF"] = $result;
    $_SESSION["retur"] = true;
}
