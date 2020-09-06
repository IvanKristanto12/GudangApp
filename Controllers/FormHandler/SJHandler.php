<?php
session_start();
if (isset($_GET["Cetak"])) {
    $result = self::$db->executeQuery("GetDetailPO", [$_GET["Cetak"]]);
    $_SESSION["POPDF"] = $result;
    $_SESSION["poDone"] = true;
} else if (isset($_GET["submitCreateSJ"])) {
    $inputTanggal = $_GET["inputTanggalSJ"];
    $inputNoPO = $_GET["inputNoPO"];
    $inputKeterangan = $_GET["inputKeterangan"];

    self::$db->executeNonQuery("CreateSJ", ["'".$inputTanggal."'", $inputNoPO, "'".$inputKeterangan."'"]);

    $result = self::$db->executeQuery("GetDetailPO", [$inputNoPO]);
    $_SESSION["SJPDF"] = $result;
    $_SESSION["SJKet"] = $inputKeterangan;
    $_SESSION["sjDone"] = true;
}
