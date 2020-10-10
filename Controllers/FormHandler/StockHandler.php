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
    $inputWarna = "";

    $result = self::$db->executeQuery("GetListWarna", [""]);
    for ($i = 0; $i < count($result); $i++) {
        if (isset($_GET["warna"][$i])) {
            $inputWarna .= $_GET["warna"][$i] . ', ';
        }
    }

    self::$db->executeNonQuery("InsertNewSampel", ["'" . $inputSampelBaru . "'", $inputJenisKain, "'" . $inputWarna . "'"]);
    $_SESSION["done"] = true;
} else if (isset($_GET['submitTambahWarna'])) {
    $nomorBaru = $_GET['inputNomorBaru'];
    $result = self::$db->executeQuery("InsertWarnaBaru", ["'" . $_GET['inputWarnaBaru'] . "'", $nomorBaru]);
    if ($result[0][""] == 0) {
        $_SESSION["done"] = false;
    } else {
        $_SESSION["done"] = true;
    }
} else if (isset($_GET['submitTambahPenjual'])) {
    $result = self::$db->executeQuery("InsertPenjualBaru", ["'" . $_GET['inputPenjualBaru'] . "'", "'" . $_GET['inputKodeBaru'] . "'"]);
    if ($result[0][""] == 0) {
        $_SESSION["done"] = false;
    } else {
        $_SESSION["done"] = true;
    }
} else if (isset($_GET['submitTambahPembeli'])) {
    $result = self::$db->executeQuery("InsertPembeliBaru", ["'" . $_GET['inputPembeliBaru'] . "'", "'" . $_GET['inputAlamatBaru'] . "'"]);
    if ($result[0][""] == 0) {
        $_SESSION["done"] = false;
    } else {
        $_SESSION["done"] = true;
    }
} else if (isset($_GET['submitTambahJenisKain'])) {
    $jenisKain = $_GET['inputJenisKainBaru'];
    $result = self::$db->executeQuery("InsertJenisKainBaru", ["'" . $_GET['inputJenisKainBaru'] . "'"]);
    if ($result[0][""] == 0) {
        $_SESSION["done"] = false;
    } else {
        $_SESSION["done"] = true;
    }
} else if (isset($_GET["CetakStock"])) {
    $_SESSION["StockPDF"] = self::$db->executeQuery("GetStock", [""]);
}
