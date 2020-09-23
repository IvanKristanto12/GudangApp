<?php

class AllList extends Controller implements ViewInterface
{
    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="so" class="w3-bar-item w3-button">SO</a>
            <a href="po" class="w3-bar-item w3-button">PO</a>
            <a href="sj" class="w3-bar-item w3-button">SJ</a>
            <a href="alllist" class="w3-bar-item w3-button w3-gray">AllList</a>
            </div>';
    }

    public static function CreateHead()
    {
        $title = "All List";

        echo '<head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <!-- <meta http-equiv="refresh" content="1"> -->
            <link rel="stylesheet" type="text/css" href="assets/style/formPO.css">
            <link rel="stylesheet" href="Assets/style/w3.css">
            <link rel="stylesheet" href="Assets/style/w3-theme-blue-grey.css">
            <link rel="icon" href="Assets/image/title-icon.png">
            <title>' . $title . '</title>
            <script src="Assets/script/allListHead.js"></script>
            </head>';
    }

    public static function CreateBody()
    {
        echo '<body>';
        self::CreateHeader();
        self::CreateNavigationBar();
        self::listPOSJ();
        self::CreateFooter();
        echo '</body>';
    }

    public static function CreatePage()
    {
        if ($_COOKIE["userpermission"] == 0) {
            self::CreateHTML(self::CreateHead(), self::CreateBody());
        } else {
            header("Location: stock");
        }
    }

    private static function listPOSJ()
    {
        session_start();
        if (isset($_SESSION["sjDone"])) {
            if ($_SESSION["sjDone"] == true) {
                echo "<script>createSJPDF = true</script>";
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> BUAT SJ DONE </b></div>';
            }
            unset($_SESSION["sjDone"]);
        }

        if (isset($_SESSION["poDone"])) {
            if ($_SESSION["poDone"] == true) {
                echo "<script>createPOPDF = true</script>";
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> CETAK PO DONE </b></div>';
            }
            unset($_SESSION["poDone"]);
        }
        echo '
        <form action="AllListHandler" method="GET">
        <table class="w3-table-all">
            <tr class="w3-yellow">
                <th class="w3-center">No</th>
                <th class="w3-center">Kode PO</th>
                <th class="w3-center">Tanggal PO</th>
                <th class="w3-center">Kode SJ</th>
                <th class="w3-center">Tanggal SJ</th>
                <th class="w3-center">Cetak PO</th>
                <th class="w3-center">Cetak SJ</th>
            </tr>';

        $result = self::$db->executeQuery("GetListAll", [""]);

        for ($i = 0; $i < count($result); $i++) {
            $noPO = substr(($result[$i]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($result[$i]["Tanggal PO"] . '', 0, 4) * 1 - 2000) . "/" . substr($result[$i]["Tanggal PO"], 5, 2) . "/" . $result[$i]["Kode"];
            $noSJ = substr(($result[$i]["No_PO"] * 1 + 100000) . '', 1, 6) . '/SJ/' . (substr($result[$i]["Tanggal PO"] . '', 0, 4) * 1 - 2000) . "/" . substr($result[$i]["Tanggal PO"], 5, 2) . "/" . $result[$i]["Kode"];
            echo '
            <tr>
            <td class="w3-center">' . ($i + 1) . '</td>
            <td class="w3-center">' . $noPO . '</td>
            <td class="w3-center">' . $result[$i]["Tanggal PO"] . '</td>
            <td class="w3-center">' . $noSJ . '</td>
            <td class="w3-center">' . $result[$i]["Tanggal SJ"] . '</td>
            <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="CetakPO" value=' . $result[$i]["No_PO"] . '>Cetak PO</button></th>
            <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="CetakSJ" value=' . $result[$i]["No_SJ"] . '>Cetak SJ</button></th>
            </tr>';
        }
        echo '</form></table>
        <script src="Assets/script/allList.js"></script>
        ';
    }
}
