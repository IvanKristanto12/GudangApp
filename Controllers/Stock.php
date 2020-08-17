<?php

class Stock extends Controller implements ViewInterface
{
    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
        <a href="stock" class="w3-bar-item w3-button w3-gray">Stock</a>
        <a href="po" class="w3-bar-item w3-button">PO</a>
        <a href="sj" class="w3-bar-item w3-button">SJ</a>
        </div>';
    }

    public static function CreateHead()
    {
        $title = "Stock";

        echo '<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- <meta http-equiv="refresh" content="1"> -->
        <link rel="stylesheet" type="text/css" href="Assets/style/style.css">
        <link rel="stylesheet" type="text/css" href="Assets/style/tambahmodal.css">
        <link rel="stylesheet" href="Assets/style/w3.css">
        <link rel="stylesheet" href="Assets/style/w3-theme-blue-grey.css">
        <title>' . $title . '</title>
        <script src="Assets/script/tambahmodalHead.js"></script>
        </head>';
    }

    public static function CreateBody()
    {
        echo '<body class="w3-gray">';
        self::CreateHeader();
        self::CreateNavigationBar();
        self::doneText();
        self::modalTambah();
        self::listStock();
        self::CreateFooter();
        echo '</body>';
    }

    public static function CreatePage()
    {

        self::CreateHTML(self::CreateHead(), self::CreateBody());
    }

    private static function doneText()
    {
        session_start();
        if (isset($_SESSION["done"])) {
            if ($_SESSION["done"] == true) {
                echo '<div class="w3-text-black w3-green w3-center w3-border w3-large"><b> INSERT DONE </b></div>';
            }
        }
        session_unset();
        session_destroy();
    }

    private static function listStock()
    {
        $result = self::$db->executeQuery("GetAllPcsAllMeter", [""]);
        echo '
            <table class="w3-table-all ">
            <tr class="w3-yellow w3-border">
                <th colspan="3"class="w3-center">ALL</th>
                <th class="w3-center">' . $result[0]['All Pcs'] . '</th>
                <th class="w3-center">' . $result[0]['All Meter'] . '</th>
            </tr>
            <tr>
                <th>
                    No.
                </th>
                <th class="w3-center">
                    Sampel
                </th>
                <th class="w3-center">
                    Jenis Kain
                </th>
                <th class="w3-center">
                    Total Pcs
                </th>
                <th class="w3-center">
                    Total Meter
                </th>
            </tr>';

        $result = self::$db->executeQuery("GetListSampel", [""]);
        for ($i = 0; $i < count($result); $i++) {
            $color = 'w3-green';
            if ($result[$i]['Total_Pcs'] == 0) {
                $color = 'w3-red';
            }
            echo
                '<tr>
                    <th>
                        ' . ($i + 1) . '
                    </th>
                    <th >
                        <button onclick="showFunction(' . "'D" . ($i + 1) . "'" . ')" class="w3-button w3-block ' . $color . ' w3-left-align w3-center w3-text-black">' . $result[$i]['Sampel'] . '</button>
                    </th>
                    <th class="w3-center">'
                    . $result[$i]['Jenis Kain'] .
                    '</th>
                    <th class="w3-center">'
                    . $result[$i]['Total_Pcs'] .
                    '</th>
                    <th class="w3-center">'
                    . $result[$i]['Total_Meter'] .
                    '</th>
                </tr>
                <tr>
                <td colspan="5">
                    <div id="D' . ($i + 1) . '" class="w3-hide w3-container w3-blue-gray w3-padding-24 w3-margin">';

            $result2 = self::$db->executeQuery("GetListWarnaSampel", ["'" . $result[$i]['Sampel'] . "'"]);
            $temp = null;
            $isTable = false;
            for ($j = 0; $j < count($result2); $j++) {
                if ($temp !== $result2[$j]['Warna']) {
                    $temp = $result2[$j]['Warna'];

                    if ($isTable === true) {
                        echo '</table>';
                    }
                    $isTable = true;
                    echo '<h1>' . $temp . '</h1>';
                    if (!isset($result2[$j]['Total_Pcs'])) {
                        echo '<h4> Total Pcs : 0 </h4>
                                <h4> Total Meter : 0 </h4>
                                <table class="w3-table-all w3-centered">
                                <tr>
                                    <th class="w3-center">
                                        Tanggal Masuk
                                    </th>
                                    <th class="w3-center">
                                        Nomor Karung
                                    </th>
                                    <th class="w3-center">
                                        Meter
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="w3-center w3-red ">
                                        Stock Habis
                                    </th>
                                </tr>';
                    } else {
                        echo '<h4> Total Pcs : ' . $result2[$j]['Total_Pcs'] . '</h4>
                                <h4> Total Meter : ' . $result2[$j]['Total_Meter'] . '</h4>
                                <table class="w3-table-all w3-centered">
                                <tr>
                                    <th class="w3-center">
                                        Tanggal Masuk
                                    </th>
                                    <th class="w3-center">
                                        Nomor Karung
                                    </th>
                                    <th class="w3-center">
                                        Meter
                                    </th>
                                </tr>';
                    }
                }
                if ($result2[$j]['Total_Pcs'] !== null) {
                    echo '<tr class="w3-green w3-text-black">
                                    <th class="w3-center">' . $result2[$j]['TanggalMasuk'] . '</th>
                                    <th class="w3-center">' . $result2[$j]['NomorKarung'] . '</th>
                                    <th class="w3-center">' . $result2[$j]['Meter'] . '</th>
                                </tr>';
                }
            }
            if ($j <= 1 || !isset($result2[$j]['Total_Pcs'])) {
                echo '</table>';
            }

            echo '</div>
                </td>
                </tr>';
        }
        echo '<script src="Assets/script/accordion.js"></script>';
        echo '</table>';
    }

    private static function modalTambah()
    {
        echo '<button class="w3-button w3-blue w3-border w3-text-black w3-xlarge" onclick="document.getElementById(' . "'id01'" . ').style.display=' . "'block'" . '" >Tambah</button>';
        echo '<div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom">
         <header class="w3-container w3-blue w3-text-black"> 
          <span onclick="document.getElementById(' . "'id01'" . ').style.display=' . "'none'" . '" 
          class="w3-button w3-blue w3-xlarge w3-display-topright ">&times;</span>
          <h2>Tambah</h2>
         </header>
       
         <div class="w3-bar w3-border-bottom">
          <button class="tablink w3-bar-item w3-button" onclick="openCity(event, ' . "'Stock'" . ')">Stock</button>
          <button class="tablink w3-bar-item w3-button" onclick="openCity(event, ' . "'Sampel'" . ')">Sampel</button>
          <button class="tablink w3-bar-item w3-button" onclick="openCity(event, ' . "'Warna'" . ')">Warna</button>
         </div>';

        self::tabTambahStock();
        self::tabTambahSampel();
        self::tabTambahWarna();

        echo '<div class="w3-container w3-blue w3-padding" style="height:5%">
         
        </div>
        </div>
       </div>
       
       </div>';
        echo '<script src="Assets/script/tambahmodal.js"></script>';
    }

    private static function tabTambahStock()
    {
        $sampelOption = "";
        $result = self::$db->executeQuery("GetIdSampelIdWarna", ["0"]);

        for ($i = 0; $i < count($result); $i++) {
            $sampelOption .= '"<option value="' . $result[$i]["Id_Sampel"] . '">' . $result[$i]["Nama"] . '</option>"';
        }

        echo '<div id="Stock" class="w3-container tab tabsize " >
        <form action="StockFormHandler" method="GET">
            <h4><b>Nama Sampel</b></h4>
            <select id="selectSampel" class="w3-select w3-border w3-padding-small" name="inputSampel" required onchange="showWarna(this.value)">
                <option value="" disabled selected>Pilih Sampel</option>
                ' . $sampelOption . '
            </select>
            <h4><b>Warna</b></h4>
            <select id="selectWarna" class="w3-select w3-border w3-padding-small" name="inputWarna" required>
                <option value="0" disabled selected>Pilih Warna</option>
            </select>
            <h4><b>Nomor Karung</b></h4>
            <input type="number" class="w3-select w3-border w3-padding-small" min="0" value="0" name="inputNomorKarung"  required/>
            <h4><b>Meter</b></h4>
            <input type="number" class="w3-select w3-border w3-padding-small" min="0.00" value="0.00" step="0.01" name="inputMeter" required/> 
            <h4><b>Tanggal Masuk</b></h4>
            <input type="date" class="w3-select w3-border" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '" name="inputTanggalMasuk" required/> 
            <input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitTambahStock" />
        </form>
       </div>';
    }

    private static function tabTambahSampel()
    {
        echo '<div id="Sampel" class="w3-container tab tabsize">
        <form action="StockFormHandler" method="GET">
        <h4><b>Nama Sampel Baru</b></h4>
        <input class="w3-input w3-border" type="text" name="inputSampelBaru" required placeholder="input nama Sampel baru"/> 
        <h4><b>Jenis Kain</b></h4>
        <select class="w3-select w3-border w3-padding-small" name="inputJenisKain" required>
                <option value="" disabled selected>Pilih Jenis Kain</option>';

        $JenisKainOption = "";
        $result = self::$db->executeQuery("GetListJenisKain", [""]);

        for ($i = 0; $i < count($result); $i++) {
            $JenisKainOption .= '"<option value="' . $result[$i]["Id_JenisKain"] . '">' . $result[$i]["Nama"] . '</option>"';
        }
        echo $JenisKainOption . '</select>';

        echo '<h4><b>Warna</b></h4> ';
        $checkboxWarna = '';
        $result = self::$db->executeQuery("GetListWarna", [""]);

        for ($i = 0; $i < count($result); $i++) {
            $checkboxWarna .= '<input class="w3-check w3-border" type="checkbox" name="warna[' . $i . ']" value="' . $result[$i]["Id_Warna"] . '" /> <label>' . $result[$i]["Nama"] . '</label> <br>';
        }
        echo $checkboxWarna;
        echo '<input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitTambahSampel" />
        </form>
       </div>';
    }

    private static function tabTambahWarna()
    {
        echo '<div id="Warna" class="w3-container tab tabsize">
        <form action="StockFormHandler" method="GET">
        <h4><b>Nama Warna Baru</b></h4>
        <input class="w3-input w3-border" type="text" name="inputWarnaBaru" required placeholder="input nama warna baru" onchange="checkWarna()"/> ';
        echo '<input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitTambahWarna" />
        </form>
       </div>';
    }
}
