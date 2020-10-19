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
            <th class="w3-center">Ubah Meter</th>
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
                <th class="w3-center">
                    <form method="GET" action="POHandler">
                    <input type="hidden" name="idUbah"value="' . $result[$i]["Id_Kain"] . '"/>
                    <input class="w3-input w3-border" name="inputMeter" type="number" min="0" value="' . $result[$i]["Meter"] . '"/>
                    <input class="w3-input w3-red w3-center w3-text-black" name="submitUbahMeter" value="Ubah" type="submit">
                    </form>
                </th>
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
        $result = self::$db->executeQuery("GetDetailSO", [$NoSO, 0]);
        for ($i = 0; $i < count($result); $i++) {
            if ($result[$i]["NomorWarna"] == null) {
                $respondText .=
                    '<tr>
                    <td class="w3-center w3-border">' . $result[$i]["Sampel"] . ' ' . $result[$i]["Warna"] . '</td>
                    <td class="w3-center w3-border">' . $result[$i]["Total_Pcs"] . '</td>
                </tr>';
            } else {
                $respondText .=
                    '<tr>
                    <td class="w3-center w3-border">' . $result[$i]["Sampel"] . ' ' . $result[$i]["Warna"] . '-' . $result[$i]["NomorWarna"] . '</td>
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

    public static function getByPO()
    {
        self::initializeDB();
        $inputNoPO = $_REQUEST["inputNoPO"];
        $respondText = "~";
        $respondText .= self::getListKainByPO($inputNoPO) . "~";
        $respondText .= self::getDetailPO($inputNoPO) . "~";
        echo $respondText;
    }

    private static function getDetailPO($NoPO)
    {
        $respondText = "";
        $respondText .= '
        <fieldset style="font-size:12px">
            <legend>Detail PO</legend>
            <table class="w3-table-all w3-medium">
                <tr>
                    <th class="w3-center w3-yellow">Tanggal</th>
                    <th class="w3-center w3-yellow">Penjual</th>
                    <th class="w3-center w3-yellow">Pembeli</th>
                </tr>';
        $result = self::$db->executeQuery("GetDetailPO", [$NoPO]);
        $respondText .= '
            <tr>
                <td>' . $result[0]["Tanggal"] . '</td>
                <td>' . $result[0]["KodePenjual"] . "-" . $result[0]["Penjual"] . '</td>
                <td>' . $result[0]["Pembeli"] . "-" . $result[0]["Alamat"] . '</td>
            </tr>';
        $respondText .= '</table>
        </fieldset>';
        return $respondText;
    }

    private static function getListKainByPO($NoPO)
    {
        $respondText = "";
        $respondText .= '
        <tr class="w3-yellow w3-border">
            <th class="w3-center">Pilih</th>
            <th class="w3-center">Sampel</th>
            <th class="w3-center">Warna</th>
            <th class="w3-center">Nomor Karung</th>
            <th class="w3-center">Meter</th>
        </tr>';
        $result = self::$db->executeQuery("GetDetailPOForRetur", [$NoPO]);
        for ($i = 0; $i < count($result); $i++) {
            $respondText .= '
            <tr>
                <td class="w3-center"><input class="checkSize" value="' . $result[$i]["Id_Kain"] . '" type="checkbox" onchange="setTotal()"/></td>
                <td class="w3-center">' . $result[$i]["Sampel"] . '</td>
                <td class="w3-center">' . $result[$i]["Warna"] . '</td>
                <td class="w3-center">' . $result[$i]["NomorKarung"] . '</td>
                <td id="meter" class="w3-center">' . $result[$i]["Meter"] . '</td>
            </tr>
        ';
        }
        return $respondText;
    }
}
