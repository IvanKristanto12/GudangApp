<?php

class Retur extends Controller implements ViewInterface
{

    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="so" class="w3-bar-item w3-button">SO</a>
            <a href="po" class="w3-bar-item w3-button">PO</a>
            <a href="sj" class="w3-bar-item w3-button">SJ</a>
            <a href="alllist" class="w3-bar-item w3-button ">AllList</a>
            <a href="retur" class="w3-bar-item w3-button w3-gray">Retur</a>
            </div>';
    }

    public static function CreateHead()
    {
        $title = "Retur";

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
            <script src="Assets/script/returHead.js"></script>
            </head>';
    }

    public static function CreateBody()
    {
        echo '<body>';
        session_start();
        if (isset($_SESSION["retur"])) {
            if ($_SESSION["retur"] == true) {
                echo "<script>createPDF = true</script>";
            }
        }
        self::CreateHeader();
        self::CreateNavigationBar();
        self::FormRetur();
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

    public static function FormRetur()
    {
        if (isset($_SESSION["retur"])) {
            if ($_SESSION["retur"] == true) {
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> Retur DONE </b></div>';
            }
        }

        //kiri
        echo '
            <div class=" w3-half" style="overflow-y:scroll; height:83%">
            <h4 class="w3-center w3-border-bottom w3-padding"><b>Form Retur</u></b></h4>
            <form action="ReturHandler" method="GET" class="w3-container foS">
                <h4><b>Tanggal</b></h4>
                <input type="date" class="w3-select w3-border" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '" name="inputTanggalRetur" required/> 
            ';
        echo '<h4><b>Kode PO</b></h4>
        <select class="w3-select w3-border w3-padding-small" name="inputNoPO" required onchange="showListKain(this.value)">
        <option value="" disabled selected>Pilih PO</option>';
        $result = self::$db->executeQuery("GetListPOForRetur", [""]);

        for ($i = 0; $i < count($result); $i++) {
            $noPO = substr(($result[$i]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($result[$i]["Tanggal"] . '', 0, 4) * 1 - 2000) . "/" . substr($result[$i]["Tanggal"], 5, 2) . "/" . $result[$i]["KodePenjual"];
            echo '<option value="' . $result[$i]["No_PO"] . '">' . $noPO . '</option>';
        }

        echo '
        </select>
        <br>
        <div id="fieldDetailPO">
        </div>
        <h4><b>Keterangan</b></h4>
        <textarea class="w3-input w3-border" name="inputKeterangan"></textarea> 
        <h4><b>Total Pcs</b></h4>
        <input id="totalPcs" class="total" type="number" value="0" disabled/>
        <h4><b>Total Meter</b></h4>
        <input id="totalMeter" class="total" type="number" value="0" disabled/>
        <input id="kain" type="hidden" name="kain"/>
        <input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitCreateRetur" />
        </div>';

        //kanan
        echo '
            <div class="w3-half rightSide">
                <table id="listKainTable" class="w3-table-all" style="overflow-x:scroll">
                    <tr class="w3-yellow w3-border">
                        <th class="w3-center">Pilih</th>
                        <th class="w3-center">Sampel</th>
                        <th class="w3-center">Warna</th>
                        <th class="w3-center">Nomor Karung</th>
                        <th class="w3-center">Meter</th>
                    </tr>
                </table>
            </div>
            </form>
        <script src="Assets/script/retur.js"></script>';
    }
}
