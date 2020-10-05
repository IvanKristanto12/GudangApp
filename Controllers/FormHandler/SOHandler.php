<?php
session_start();
if (isset($_POST["submitCreateSO"])) {
    $pembeli = $_POST["inputPembeli"];
    $penjual = $_POST["inputPenjual"];
    $tanggal = $_POST["inputTanggalSO"];
    $keterangan = $_POST["inputKeterangan"];

    $result = self::$db->executeQuery("CreateSO", ["'" . $tanggal . "'", $penjual, $pembeli, "'" . $keterangan . "'"]);

    $noSO = $result[0]["No_SO"];
    foreach ($_POST['sampelchecked'] as $check) {
        $temp = [];
        $temp = explode(",", $check);
        self::$db->executeNonQuery("InsertListSampelSO", [$noSO, $temp[0], $temp[1], $_POST["inputPcs" . $temp[0] . $temp[1]]]);
    }
    $_SESSION["SOPDF"] = self::$db->executeQuery("GetDetailSO", [$noSO]);
}
if (isset($_GET["CetakSO"])) {
    $noSO = $_GET["CetakSO"];
    $_SESSION["SOPDF"] = self::$db->executeQuery("GetDetailSO", [$noSO]);
}
if (isset($_GET["HapusSO"])) {
    $noSO = $_GET["HapusSO"];
    self::$db->executeNonQuery("HapusSO", [$noSO]);
    // $_SESSION["SOPDF"] = self::$db->executeQuery("GetDetailSO", [$noSO]);
}
