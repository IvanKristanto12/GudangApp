<?php
require('Assets/FPDF/fpdf.php');
session_start();

class POPDF extends FPDF
{
    private $noPO = '00001/PO/20/08/K';
    // Page header
    function Header()
    {
        if ($this->CurOrientation != 'L') {
            $this->SetFont('Arial', 'B', 20);
            $this->Cell(54, 10, 'Purchase Order', 0, 0, 'C');
            $this->Cell(56);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(80, 10, $this->noPO, 1, 0, 'C');
            // Line break
            $this->Ln(15);
        } else {
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(5, 0.6, 'Purchase Order', 0, 0, 'L');
            $this->Cell(10);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(6, 0.6, $this->noPO, 1, 0, 'C');
            $this->Ln(0.8);
        }
    }

    // Page footer
    function Footer()
    {
        if ($this->CurOrientation != 'L') {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        } else {
            $this->SetY(-0.5);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Page number
            $this->Cell(0, 0.5, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    public function CreatePDF($noPO, $namaPembeli, $tanggal, $Sampel, $allPcs, $allMeter)
    {
        $this->noPO = $noPO;
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20, 10, 'Nama', 0, 0, '');
        $this->Cell(3, 10, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(75, 10, $namaPembeli, 0, 0);
        $this->Cell(50);

        $tanggal = date_create($tanggal);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(48, 10, 'Tanggal : ' . date_format($tanggal, "d/m/Y"), 0, 1);
        $this->Ln(5);
        $this->SetFont('Arial', 'BU', 15);
        $this->Cell(0, 10, 'List Barang', 0, 1, 'C');

        for ($i = 0; $i < count($Sampel); $i++) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(20, 5, 'Sampel', 0, 0, '');
            $this->Cell(3, 5, ':', 0, 0);
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 5, $Sampel[$i][0], 0, 1);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(20, 6, 'Warna', 0, 0, '');
            $this->Cell(3, 6, ':', 0, 0);
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 6, $Sampel[$i][1], 0, 1);

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(100, 10, 'Nomor Karung', 1, 0, 'C');
            $this->Cell(0, 10, 'Meter', 1, 1, 'C');
            $this->SetFont('Arial', '', 12);

            $total = 0;
            $totalPcs = 0;
            for ($j = 0; $j < count($Sampel[$i][2]); $j += 2) {
                $this->Cell(100, 6, $Sampel[$i][2][$j], 1, 0, 'C');
                $this->Cell(0, 6, $Sampel[$i][2][$j + 1], 1, 1, 'C');
                $total += $Sampel[$i][2][$j + 1];
                $totalPcs++;
            }
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 6, '       Total', 1, 1, 'C');
            $this->SetFont('Arial', '', 12);
            $this->Cell(100, 6, $totalPcs, 1, 0, 'C');
            $this->Cell(0, 6, $total, 1, 1, 'C');
            $this->Ln(5);
        }

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(25, 8, 'All Pcs', 1, 0, '');
        $this->SetFont('Arial', '', 15);
        $this->Cell(0, 8, ' ' . $allPcs, 1, 1, '');

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(25, 8, 'All Meter', 1, 0, '');
        $this->SetFont('Arial', '', 15);
        $this->Cell(0, 8, ' ' . $allMeter, 1, 1, '');
        $this->Output();
    }

    public function CreateCustomPDF($noPO, $namaPembeli, $tanggal, $Sampel, $allPcs, $allMeter,$keterangan)
    {
        $this->noPO = $noPO;
        $this->AliasNbPages();
        $this->AddPage();

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(1.5, 0.6, 'Nama', 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $namaPembeli, 0, 0);
        $this->Cell(1.68);
        $tanggal = date_create($tanggal);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(1.5, 0.6, 'Tanggal : ' . date_format($tanggal, "d/m/Y"), 0, 1);
        $this->SetFont('Arial', 'BU', 13);
        $this->Cell(0, 0.6, 'List Barang', 0, 1, 'C');

        for ($i = 0; $i < count($Sampel); $i++) {
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(1.5, 0.5, 'Sampel', 0, 0, '');
            $this->Cell(0.5, 0.5, ':', 0, 0);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 0.5, $Sampel[$i][0], 0, 1);
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(1.5, 0.5, 'Warna', 0, 0, '');
            $this->Cell(0.5, 0.5, ':', 0, 0);
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 0.5, $Sampel[$i][1], 0, 1);

            $this->SetFont('Arial', 'B', 11);
            $this->Cell(10.5, 0.5, 'Nomor Karung', 1, 0, 'C');
            $this->Cell(0, 0.5, 'Meter', 1, 1, 'C');
            $this->SetFont('Arial', '', 10);

            $total = 0;
            $totalPcs = 0;
            for ($j = 0; $j < count($Sampel[$i][2]); $j += 2) {
                $this->Cell(10.5, 0.48, $Sampel[$i][2][$j], 1, 0, 'C');
                $this->Cell(0, 0.48, $Sampel[$i][2][$j + 1], 1, 1, 'C');
                $total += $Sampel[$i][2][$j + 1];
                $totalPcs++;
            }
            $this->SetFont('Arial', 'B', 11);
            $this->Cell(0, 0.5, 'Total', 1, 1, 'C');
            $this->SetFont('Arial', '', 10);
            $this->Cell(10.5, 0.48, $totalPcs, 1, 0, 'C');
            $this->Cell(0, 0.48, $total, 1, 1, 'C');
            $this->Ln(0.3);
        }

        $this->Ln(0.5);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(2.5, 0.5, 'All Pcs', 1, 0, '');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 0.5, ' ' . $allPcs, 1, 1, '');

        $this->SetFont('Arial', 'B', 11);
        $this->Cell(2.5, 0.5, 'All Meter', 1, 0, '');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 0.5, ' ' . $allMeter, 1, 1, '');

        $this->ln(0.3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0.6, 'Keterangan :', 0, 1);
        $this->SetFont('Arial', '', 10);
        $ket = [];
        $ket = explode("\n", $keterangan);
        for ($i = 0; $i < count($ket); $i++) {
            $this->Cell(0, 0.6, $ket[$i], 0, 1, 'L');
        }
        $this->Output();
    }
}



// Instanciation of inherited class
$pdf = new POPDF();
if (isset($_SESSION["POPDF"])) {
    $result = $_SESSION["POPDF"];
    $tanggal = $result[0]["Tanggal"];
    $noPO = substr(($result[0]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($tanggal . '', 0, 4) * 1 - 2000) . "/" . substr($tanggal, 5, 2) . "/" . $result[0]["KodePenjual"];
    $pembeli = $result[0]["Pembeli"] . ' - ' . $result[0]["Alamat"];
    $totalPcs = $result[0]["Total_Pcs"];
    $totalMeter = $result[0]["Total_Meter"];

    $idx = 0;
    $idxK = 0;
    $arrKain = [];
    $namaSampel = $result[0]["Sampel"];
    $warna = $result[0]["Warna"];
    $sampel[$idx][0] = $namaSampel;
    $sampel[$idx][1] = $warna;
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]["Sampel"], $namaSampel) != 0 || strcmp($result[$i]["Warna"], $warna) != 0) {
            $namaSampel = $result[$i]["Sampel"];
            $warna = $result[$i]["Warna"];
            $sampel[$idx][2] = $arrKain;
            $idx++;
            $sampel[$idx][0] = $namaSampel;
            $sampel[$idx][1] = $warna;
            $idxK = 0;
            $arrKain = [];
        }
        $arrKain[$idxK] = $result[$i]["NomorKarung"];
        $arrKain[$idxK + 1] = $result[$i]["Meter"];
        $idxK += 2;
    }

    $sampel[$idx][2] = $arrKain;

    $keterangan = $result[0]["KeteranganPO"];

    $pdf = new POPDF('L', 'cm', array(14, 21.6));
    $pdf->SetMargins(0.3,0.3,0.3);
    $pdf->CreateCustomPDF($noPO, $pembeli, $tanggal, $sampel, $totalPcs, $totalMeter, $keterangan);
}
session_unset();
session_destroy();
