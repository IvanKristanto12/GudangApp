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
        self::$db->executeNonQuery("InsertListSampelSO", [$noSO, $check, $_POST["warna" . $check], $_POST["inputPcs" . $check . $_POST["warna" . $check]]]);
    }
    $_SESSION["SOPDF"] = self::$db->executeQuery("GetDetailSO", [$noSO]);
}
