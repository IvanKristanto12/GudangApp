<?php

class PO extends Controller implements ViewInterface
{

    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="po" class="w3-bar-item w3-button w3-gray">PO</a>
            <a href="sj" class="w3-bar-item w3-button">SJ</a>
            <a href="alllist" class="w3-bar-item w3-button ">AllList</a>

            </div>';
    }

    public static function CreateHead()
    {
        $title = "Purchase Order";

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

        session_start();
        if (isset($_SESSION["po"])) {
            if ($_SESSION["po"] == true) {
                echo "<script>createPDF = true</script>";
            }
        }
        self::CreateHeader();
        self::CreateNavigationBar();
        self::FormPO();
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

    public static function FormPO()
    {
        if (isset($_SESSION["po"])) {
            if ($_SESSION["po"] == true) {
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> PO CREATED </b></div>';
            }
        }

        //kiri
        echo '
            <div class=" w3-half">
            <h4 class="w3-center w3-border-bottom w3-padding"><b>Form PO</u></b></h4>
            <form action="POHandler" method="GET" class="w3-container foS">
                <h4><b>Tanggal</b></h4>
                <input type="date" class="w3-select w3-border" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '" name="inputTanggalPO" required/> 
                <h4><b>Penjual</b></h4>
                <select class="w3-select w3-border w3-padding-small" name="inputPenjual" required>
                <option value="" disabled selected>Pilih Penjual</option>';
        $result = self::$db->executeQuery("GetListPenjual", [""]);
        for ($i = 0; $i < count($result); $i++) {
            echo '<option value="' . $result[$i]["Id_Penjual"] . '">' . $result[$i]["Nama"] . ' - ' . $result[$i]["Kode"] . '</option>';
        }
        echo '        
            </select> 
            <h4><b>Pembeli</b></h4>
            <select class="w3-select w3-border w3-padding-small" name="inputPembeli" required>
                <option value="" disabled selected>Pilih Pembeli</option>';
        $result = self::$db->executeQuery("GetListPembeli", [""]);
        for ($i = 0; $i < count($result); $i++) {
            echo '<option value="' . $result[$i]["Id_Pembeli"] . '">' . $result[$i]["Nama"] . ' - ' . $result[$i]["Alamat"] . '</option>';
        }
        echo '</select>
        <h4><b>Total Pcs</b></h4>
        <input id="totalPcs" class="total" type="number" value="0" disabled/>
        <h4><b>Total Meter</b></h4>
        <input id="totalMeter" class="total" type="number" value="0" disabled/>
        <input id="kain" type="hidden" name="kain"/>
        <input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitCreatePO" />
        </div>';

        //kanan
        echo '
            <div class="w3-half rightSide">
                <table class="w3-table-all">
                    <tr class="w3-yellow w3-border">
                        <th class="w3-center">Pilih</th>
                        <th class="w3-center">Sampel</th>
                        <th class="w3-center">Warna</th>
                        <th class="w3-center">Nomor Karung</th>
                        <th class="w3-center">Meter</th>
                        <th class="w3-center">Tanggal Masuk</th>
                    </tr>';

        $result = self::$db->executeQuery("GetListKain", ["1"]);
        for ($i = 0; $i < count($result); $i++) {
            echo '
            <tr>
                <th class="w3-center"><input class="checkSize" value="' . $result[$i]["Id_Kain"] . '" type="checkbox" onchange="setTotal()"/></th>
                <th class="w3-center">' . $result[$i]["Sampel"] . '</th>
                <th class="w3-center">' . $result[$i]["Warna"] . '</th>
                <th class="w3-center">' . $result[$i]["NomorKarung"] . '</th>
                <th id="meter" class="w3-center">' . $result[$i]["Meter"] . '</th>
                <th class="w3-center">' . $result[$i]["TanggalMasuk"] . '</th>
            </tr>';
        }
        echo '
            </div>
            </form>
        <script src="Assets/script/po.js"></script>';
    }
}
