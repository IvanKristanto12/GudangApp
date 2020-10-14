<?php
session_start();
if (isset($_GET["CetakRetur"])) {
    $noRetur = $_GET["CetakRetur"];
    $result = self::$db->executeQuery("GetDetailRetur",[$noRetur]);
    $_SESSION["ReturPDF"] = $result;
    $_SESSION["retur"] = true;
} 
