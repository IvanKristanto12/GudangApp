<?php

class AllList extends Controller implements ViewInterface
{
    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
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
            <script src="Assets/script/poHead.js"></script>
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
        self::CreateHTML(self::CreateHead(), self::CreateBody());
    }

    private static function listPOSJ()
    {
        echo '
        <table class w3-table-all>
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
            <td class="w3-center">'.($i+1).'</td>
            <td class="w3-center">'.$noPO.'</td>
            <td class="w3-center">'.$result[$i]["Tanggal PO"].'</td>
            <td class="w3-center">'.$noSJ.'</td>
            <td class="w3-center">'.$result[$i]["Tanggal SJ"].'</td>
            <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="Cetak" value=' . $result[$i]["No_PO"] . '>Cetak PO</button></th>
            <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="Cetak" value=' . $result[$i]["No_SJ"] . '>Cetak SJ</button></th>
            </tr>';
        }



        echo '</table>';

        // //kiri
        // echo '
        //     <div class=" w3-half">
        //     <h4 class="w3-center w3-border-bottom w3-padding"><b>Form PO</u></b></h4>
        // </div>';

        // //kanan
        // echo '
        //     <div class="w3-half rightSide">
        //         <table class="w3-table-all">
        //             <tr class="w3-yellow w3-border">
        //                 <th class="w3-center">Tanggal</th>
        //                 <th class="w3-center">Kode PO</th>
        //                 <th class="w3-center">Cetak PO</th>
        //             </tr>
        //         </table>
        //     </div>';
    }
}
