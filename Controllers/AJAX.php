<?php
class AJAX extends Controller
{

    public static function getListWarna()
    {
        self::initializeDB();
        $respondText = '<option value="0" disabled selected>Pilih Warna</option> ';
        $inputId = $_REQUEST["inputId"];
        $result = self::$db->executeQuery("GetIdSampelIdWarna", [$inputId]);
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]["NomorWarna"] != null) {
                $respondText .= '"<option value="' . $result[$i]["Id_Warna"] . '">' . $result[$i]["Warna"] . '-' . $result[$i]["NomorWarna"] . '</option> "';
            } else {
                $respondText .= '"<option value="' . $result[$i]["Id_Warna"] . '">' . $result[$i]["Warna"] . '</option> "';
            }
        }
        echo $respondText;
    }

    public static function getBySO()
    {
        self::initializeDB();
        $inputNoSO = $_REQUEST["inputNoSO"];
        $respondText = "~";
        $respondText .= self::getListKainBySO($inputNoSO) . "~";
        $respondText .= self::getDetailSO($inputNoSO) . "~";
        echo $respondText;
    }

    private static function getListKainBySO($NoSO)
    {
        $respondText = "";
        $respondText .= '
        <tr class="w3-yellow w3-border">
            <th class="w3-center">Pilih</th>
            <th class="w3-center">Sampel</th>
            <th class="w3-center">Warna</th>
            <th class="w3-center">Nomor Karung</th>
            <th class="w3-center">Meter</th>
            <th class="w3-center">Tanggal Masuk</th>
        </tr>';
        $result = self::$db->executeQuery("GetListKainBySO", [$NoSO]);
        for ($i = 0; $i < count($result); $i++) {
            $respondText .= '
            <tr>
                <td class="w3-center"><input class="checkSize" value="' . $result[$i]["Id_Kain"] . '" type="checkbox" onchange="setTotal()"/></td>
                <td class="w3-center">' . $result[$i]["Sampel"] . '</td>
                <td class="w3-center">' . $result[$i]["Warna"] . '</td>
                <td class="w3-center">' . $result[$i]["NomorKarung"] . '</td>
                <td id="meter" class="w3-center">' . $result[$i]["Meter"] . '</td>
                <td class="w3-center">' . $result[$i]["TanggalMasuk"] . '</td>
            </tr>
        ';
        }
        return $respondText;
    }

    private static function getDetailSO($NoSO)
    {
        $respondText = "";
        $respondText .= '
        <fieldset style="font-size:12px">
            <legend>Detail SO</legend>
            <table class="w3-table-all w3-medium">
                <tr>
                    <th class="w3-center w3-yellow">Barang</th>
                    <th class="w3-center w3-yellow">Total Pcs</th>
                </tr>';
        $result = self::$db->executeQuery("GetDetailSO", [$NoSO]);
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]["NomorWarna"] == null) {
                $respondText .=
                    '<tr>
                    <td class="w3-center w3-border">' . $result[$i]["Sampel"] . ' ' . $result[$i]["Warna"] . '</td>
                    <td class="w3-center w3-border">' . $result[$i]["Total_Pcs"] . '</td>
                </tr>';
            }
        }
        $respondText .= '</table>
        </fieldset>';
        $respondText .= "~";
        $respondText .= '<option value="' . $result[0]["Id_Penjual"] . '">' . $result[0]["Penjual"] . ' - ' . $result[0]["KodePenjual"] . '</option>';
        $respondText .= "~";
        $respondText .= '<option value="' . $result[0]["Id_Pembeli"] . '">' . $result[0]["Pembeli"] . ' - ' . $result[0]["AlamatPembeli"] . '</option>';
        return $respondText;
    }
}
