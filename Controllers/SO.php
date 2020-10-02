<?php

class SO extends Controller implements ViewInterface
{

    public static function CreateNavigationBar()
    {
        echo '<div class="w3-bar w3-dark-gray">
            <a href="stock" class="w3-bar-item w3-button">Stock</a>
            <a href="so" class="w3-bar-item w3-button w3-gray">SO</a>
            <a href="po" class="w3-bar-item w3-button">PO</a>
            <a href="sj" class="w3-bar-item w3-button">SJ</a>
            <a href="alllist" class="w3-bar-item w3-button ">AllList</a>

            </div>';
    }

    public static function CreateHead()
    {
        $title = "Surat Order";

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
            <script src="Assets/script/soHead.js"></script>
            </head>';
    }

    public static function CreateBody()
    {
        echo '<body>';

        session_start();
        if (isset($_SESSION["SOPDF"])) {
            echo "<script>createSOPDF = true</script>";
        }
        self::CreateHeader();
        self::CreateNavigationBar();
        self::FormSO();
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

    public static function FormSO()
    {
        //kiri
        echo '<div class=" w3-half">';
        self::listSOmodal();
        echo '<h4 class="w3-center w3-border-bottom w3-padding"><b>Form SO</b></h4>
            <form action="SOHandler" method="POST" class="w3-container">
                <h4><b>Tanggal</b></h4>
                <input type="date" class="w3-select w3-border" min="' . date("Y-m-d") . '" value="' . date("Y-m-d") . '" name="inputTanggalSO" required/> 
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
        <h4><b>Keterangan</b></h4>
        <textarea class="w3-input w3-border" name="inputKeterangan"></textarea>
        <input class="w3-button w3-border w3-center w3-large w3-block w3-margin-top w3-green w3-text-black" value="submit" type="submit" name="submitCreateSO" />
 
        </div>';

        //kanan
        echo '
            <div class="w3-half rightSide">
                <table class="w3-table-all">
                    <tr class="w3-yellow w3-border">
                        <th class="w3-center">Pilih</th>
                        <th class="w3-center">Sampel</th>
                        <th class="w3-center">Warna - No Warna</th>
                        <th class="w3-center">Total Pcs Stock</th>
                    </tr>';

        $result = self::$db->executeQuery("GetStock", [""]);
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]["TotalPcs"] != null) {
                echo '
            <tr>
                <td class="w3-center"><input name="sampelchecked[]" class="checkSize" value="' . $result[$i]["Id_Sampel"] . '" type="checkbox" onclick="showFunction(' . "'D" . $i . "'" . ')"/></td>
                <input type="hidden" name="warna' . $result[$i]["Id_Sampel"] . '" value="' . $result[$i]["Id_Warna"] . '"/>
                <td class="w3-center">' . $result[$i]["Sampel"] . '</td>';
                if ($result[$i]["NomorWarna"] == null) {
                    echo '<td class="w3-center">' . $result[$i]["Warna"] . '</td>';
                } else {
                    echo '<td class="w3-center">' . $result[$i]["Warna"] . '-' . $result[$i]["NomorWarna"] . '</td>';
                }
                echo '<td class="w3-center">' . $result[$i]["TotalPcs"] . ' </td>
            </tr>
            <tr style="display:none"></tr>
            <tr>
                <td colspan="4" style="padding:0px">
                    <p id="D' . $i . '" style="display:none; text-align:center;">Input Pcs : <input style="display:inline; width:50%" class="w3-input w3-border" type="number" min="1" max=' . '"' . $result[$i]["TotalPcs"] . '"' . ' value="1" name="inputPcs' . $result[$i]["Id_Sampel"] . $result[$i]["Id_Warna"] . '"/></p>
                </td>
            </tr>';
            }
        }
        echo '
            </table>
            </div>
        </form>
        <script src="Assets/script/so.js"> </script>';
    }

    private static function listSOmodal()
    {
        echo '<button class="w3-button w3-blue w3-border w3-text-black w3-large" style="float:left" onclick="document.getElementById(' . "'id01'" . ').style.display=' . "'block'" . '" >List SO</button>';
        echo '<div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" >
         <header class="w3-container w3-blue w3-text-black"> 
          <span onclick="document.getElementById(' . "'id01'" . ').style.display=' . "'none'" . '" 
          class="w3-button w3-blue w3-xlarge w3-display-topright ">&times;</span>
          <h2>List SO</h2>
         </header>
       
         <div class="w3-bar w3-border-bottom">
          <button class="tablink w3-bar-item w3-button" onclick="openCity(event, ' . "'listSO'" . ')">ListSO</button>
        </div>';

        self::tabListSO();

        echo '<div class="w3-container w3-blue w3-padding" style="height:5%">
        </div>
        </div>
       </div>
       
       ';
        echo '<script src="Assets/script/listSOmodal.js"></script>';
    }
    private static function tabListSO()
    {
        echo '<div id="listSO" class="w3-container tab tabsize"  style="overflow-y:scroll">
        <br>
        <form action="SOHandler" method="GET">
        <table class="w3-table-all">
        <tr>
            <th class="w3-center">No SO</th>
            <th class="w3-center">Penjual</th>
            <th class="w3-center">Pembeli</th>
            <th class="w3-center">Cetak</th>
            <th class="w3-center">Hapus</th>
        </tr>';

        $result = self::$db->executeQuery("GetDetailSO",[0]);
        for($i = 0 ; $i < count($result) ; $i++){
            echo'<tr>
                <td class="w3-center">'.$result[$i]["No_SO"].'</td>
                <td class="w3-center">'.$result[$i]["Penjual"]."/".$result[$i]["KodePenjual"].'</td>
                <td class="w3-center">'.$result[$i]["Pembeli"]."/".$result[$i]["AlamatPembeli"].'</td>
                <th class="w3-center"><button class="w3-button w3-green w3-text-black" name="CetakSO" value=' . $result[$i]["No_SO"] . '>Cetak</button></th>
                <th class="w3-center"><button class="w3-button w3-red w3-text-black" name="HapusSO" value=' . $result[$i]["No_SO"] . '>Hapus</button></th>
            </tr>';
        }

        echo '
        </form>
        </table>
       </div>';
    }
}
