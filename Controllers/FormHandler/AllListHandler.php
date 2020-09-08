<?php
session_start();
if (isset($_GET["CetakPO"])) {
    $result = self::$db->executeQuery("GetDetailPO", [$_GET["CetakPO"]]);
    $_SESSION["POPDF"] = $result;
    $_SESSION["poDone"] = true;
} else if (isset($_GET["CetakSJ"])){
    $result = self::$db->executeQuery("GetDetailPO", [$_GET["CetakSJ"]]);
    $_SESSION["SJPDF"] = $result;
    $result = self::$db->executeQuery("GetSJKet", [$_GET["CetakSJ"]]);
    $_SESSION["SJKet"] = $result[0]["Keterangan"];
    $_SESSION["sjDone"] = true;
}
