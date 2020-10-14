<?php

class ListRetur extends Controller implements ViewInterface
{
    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="so" class="w3-bar-item w3-button">SO</a>
            <a href="po" class="w3-bar-item w3-button">PO</a>
            <a href="sj" class="w3-bar-item w3-button">SJ</a>
            <a href="alllist" class="w3-bar-item w3-button">AllList</a>
            <a href="retur" class="w3-bar-item w3-button">Retur</a>
            <a href="listretur" class="w3-bar-item w3-button w3-gray">ListRetur</a>
            </div>';
    }

    public static function CreateHead()
    {
        $title = "List Retur";
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
            <script src="Assets/script/listReturHead.js"></script>
            </head>';
    }

    public static function CreateBody()
    {
        echo '<body>';
        self::CreateHeader();
        self::CreateNavigationBar();
        self::listAllRetur();
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

    private static function listAllRetur()
    {
        session_start();
        if (isset($_SESSION["retur"])) {
            if ($_SESSION["retur"] == true) {
                echo "<script>createReturPDF = true</script>";
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> CETAK Retur DONE </b></div>';
            }
            unset($_SESSION["retur"]);
        }
        echo '
        <form action="ListReturHandler" method="GET" style="overflow-x:scroll">
        <table class="w3-table-all">
            <tr class="w3-yellow">
                <th class="w3-center">No</th>
                <th class="w3-center">Kode Retur</th>
                <th class="w3-center">Tanggal</th>
                <th class="w3-center">Kode PO</th>
                <th class="w3-center">Pembeli</th>
                <th class="w3-center">Cetak Retur</th>
            </tr>';

        $result = self::$db->executeQuery("GetListRetur", [""]);

        for ($i = 0; $i < count($result); $i++) {
            $noRetur = "R/".$result[$i]["No_Retur"];
            $kodePO = substr(($result[$i]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($result[$i]["TanggalPO"] . '', 0, 4) * 1 - 2000) . "/" . substr($result[$i]["TanggalPO"], 5, 2) . "/" . $result[$i]["KodePenjual"];
            $tanggal = $result[$i]["TanggalRetur"];
            $pembeli = $result[$i]["Pembeli"] ." - ". $result[$i]["Alamat"];
            echo '
            <tr>
            <td class="w3-center">' . ($i + 1) . '</td>
            <td class="w3-center">' . $noRetur. '</td>
            <td class="w3-center">' . $tanggal. '</td>
            <td class="w3-center">' . $kodePO. '</td>
            <td class="w3-center">' . $pembeli. '</td>
            <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="CetakRetur" value=' . $result[$i]["No_Retur"] . '>Cetak Retur</button></th>
            </tr>';
        }
        echo '</form></table>
        <script src="Assets/script/listRetur.js"></script>
        ';
    }
}
