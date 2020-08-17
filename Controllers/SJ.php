<?php

class SJ extends Controller implements ViewInterface
{

    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="po" class="w3-bar-item w3-button">PO</a>
            <a href="sj" class="w3-bar-item w3-button w3-gray">SJ</a>
            </div>';
    }

    public static function CreateHead()
    {
        $title = "Surat Jalan";

        echo '<head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <!-- <meta http-equiv="refresh" content="1"> -->
            <link rel="stylesheet" type="text/css" href="assets/style/style.css">
            <link rel="stylesheet" href="Assets/style/w3.css">
            <link rel="stylesheet" href="Assets/style/w3-theme-blue-grey.css">
            <title>' . $title . '</title>
            <script src="Assets/script/sjHead.js"></script>
            </head>';
    }

    public static function CreateBody()
    {
        echo '<body>';

        session_start();
        if (isset($_SESSION["sjDone"])) {
            if ($_SESSION["sjDone"] == true) {
                echo "<script>createSJPDF = true</script>";
            }
        }


        if (isset($_SESSION["poDone"])) {
            if ($_SESSION["poDone"] == true) {
                echo "<script>createPOPDF = true</script>";;
            }
        }

        self::CreateHeader();
        self::CreateNavigationBar();
        self::FormSJ();
        self::CreateFooter();
        echo '</body>';
    }

    public static function CreatePage()
    {
        self::CreateHTML(self::CreateHead(), self::CreateBody());
    }

    public static function FormSJ()
    {
        if (isset($_SESSION["sjDone"])) {
            if ($_SESSION["sjDone"] == true) {
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> BUAT SJ DONE </b></div>';
            }
        }


        if (isset($_SESSION["poDone"])) {
            if ($_SESSION["poDone"] == true) {
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> CETAK PO DONE </b></div>';
            }
        }

        //kiri
        echo '
            <div class=" w3-half ">
            <h4 class="w3-center w3-border-bottom w3-padding"><b>Form SJ</u></b></h4>
            <form action="SJHandler" method="GET" class="w3-container">
                <h4><b>Tanggal</b></h4>
                <input type="date" class="w3-select w3-border" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '" name="inputTanggalSJ" required/> 
                <input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitCreateSJ" />
        </div>';

        //kanan
        echo '
            <div class="w3-half rightSide">
                <table class="w3-table-all">
                    <tr class="w3-yellow w3-border">
                        <th class="w3-center">Pilih</th>
                        <th class="w3-center">Tanggal PO</th>
                        <th class="w3-center">Kode PO</th>
                        <th class="w3-center">Cetak PO</th>
                    </tr>';

        $result = self::$db->executeQuery("GetListPO", [""]);
        for ($i = 0; $i < count($result); $i++) {
            echo '
            <tr>
                <th class="w3-center"><input class="w3-radio" value="' . $result[$i]["No_PO"] . '" type="radio" name="inputNoPO"/></th>
                <th class="w3-center formText">' . $result[$i]["Tanggal"] . '</th>';

            $result1 = self::$db->executeQuery("GetDetailPO", [$result[$i]["No_PO"]]);
            $noPO = substr(($result1[0]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($result1[0]["Tanggal"] . '', 0, 4) * 1 - 2000) . "/" . substr($result1[0]["Tanggal"], 5, 2) . "/" . $result1[0]["KodePenjual"];
            echo    '<th class="w3-center">' . $noPO . ' </th> 
                <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="Cetak" value=' . $result[$i]["No_PO"] . '>Cetak</button></th>
            </tr>';
        }
        echo '
            </div>
            </form>
        <script src="Assets/script/sj.js"></script>';
    }
}
