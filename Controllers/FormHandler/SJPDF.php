<?php
require('Assets/FPDF/fpdf.php');
session_start();

class SJPDF extends FPDF
{
    private $noPO = '';
    private $noSJ = '';
    // Page header
    function Header()
    {
        if ($this->CurOrientation != 'L') {
            $this->SetFont('Arial', 'B', 20);
            $this->Cell(54, 10, 'Surat Jalan', 0, 0, 'C');
            $this->Cell(56);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(80, 10, $this->noSJ, 1, 0, 'C');
            // Line break
            $this->Ln(15);
        } else {
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(5, 0.6, 'Surat Jalan', 0, 0, 'L');
            $this->Cell(10);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(6, 0.6, $this->noSJ, 1, 0, 'C');
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
            $this->SetY(-2.5);
            $this->SetFont('Arial', '', 10);
            $this->Cell(7, 0.6, 'Pembuat', 0, 0, 'C');
            $this->Cell(7, 0.6, 'Disetujui', 0, 0, 'C');
            $this->Cell(7, 0.6, 'Pembeli', 0, 1, 'C');
            $this->Ln(1);
            $this->Cell(2);
            $this->Cell(3, 0.5, '(                              )', 0, 0, 'C');
            $this->Cell(4);
            $this->Cell(3, 0.5, '(                              )', 0, 0, 'C');
            $this->Cell(4);
            $this->Cell(3, 0.5, '(                              )', 0, 1, 'C');
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 0.3, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    public function CreatePDF($noPO, $noSJ, $tanggal, $namaPembeli, $alamatPembeli, $barang, $totalPcs, $totalMeter)
    {
        $this->noPO = $noPO;
        $this->noSJ = $noSJ;
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20, 6, 'Kode PO', 0, 0, '');
        $this->Cell(3, 6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(75, 6, $this->noPO, 0, 0);
        $this->Cell(50);
        $this->SetFont('Arial', 'B', 12);
        $tanggal = date_create($tanggal);
        $this->Cell(48, 6, 'Tanggal : ' . date_format($tanggal, "d/m/Y"), 0, 1);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20, 6, 'Nama', 0, 0, '');
        $this->Cell(3, 6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(77, 6, $namaPembeli, 0, 1);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20, 6, 'Alamat', 0, 0, '');
        $this->Cell(3, 6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(77, 6, $alamatPembeli, 0, 1);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 10, 'No.', 1, 0, 'C');
        $this->Cell(110, 10, 'Nama Barang', 1, 0, 'C');
        $this->Cell(20, 10, 'Pcs', 1, 0, 'C');
        $this->Cell(50, 10, 'Meter', 1, 1, 'C');
        $this->SetFont('Arial', '', 12);

        for ($i = 0; $i < count($barang); $i++) {
            $this->Cell(10, 10, $i + 1, 1, 0, 'C');
            $this->Cell(110, 10, $barang[$i][0], 1, 0, 'C');
            $this->Cell(20, 10, $barang[$i][1], 1, 0, 'C');
            $this->Cell(50, 10, $barang[$i][2], 1, 1, 'C');
        }
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(120, 10, 'Total     ', 1, 0, 'R');
        $this->Cell(20, 10, $totalPcs, 1, 0, 'C');
        $this->Cell(50, 10, $totalMeter, 1, 1, 'C');
        $this->ln(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 10, 'Pembuat', 0, 0, 'C');
        $this->Cell(25);
        $this->Cell(45, 10, 'Disetujui', 0, 0, 'C');
        $this->Cell(25);
        $this->Cell(50, 10, 'Pembeli', 0, 1, 'C');
        $this->ln(15);
        $this->Cell(45, 10, '(                                    )', 0, 0, 'C');
        $this->Cell(25);
        $this->Cell(45, 10, '(                                    )', 0, 0, 'C');
        $this->Cell(25);
        $this->Cell(50, 10, '(                                    )', 0, 0, 'C');
        $this->Output();
    }

    public function CreateCustomPDF($noPO, $noSJ, $tanggal, $namaPembeli, $alamatPembeli, $barang, $totalPcs, $totalMeter, $SJKet)
    {
        $this->noPO = $noPO;
        $this->noSJ = $noSJ;
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(2, 0.6, 'Kode PO', 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $this->noPO, 0, 0);
        $this->Cell(1.18);
        $this->SetFont('Arial', 'B', 12);
        $tanggal = date_create($tanggal);
        $this->Cell(1.5, 0.6, 'Tanggal : ' . date_format($tanggal, "d/m/Y"), 0, 1);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(2, 0.6, 'Nama', 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $namaPembeli, 0, 1);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(2, 0.6, 'Alamat', 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $alamatPembeli, 0, 1);
        $this->Ln(0.4);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(1, 0.6, 'No.', 1, 0, 'C');
        $this->Cell(12, 0.6, 'Nama Barang', 1, 0, 'C');
        $this->Cell(4, 0.6, 'Pcs', 1, 0, 'C');
        $this->Cell(4, 0.6, 'Meter', 1, 1, 'C');
        $this->SetFont('Arial', '', 10);

        for ($i = 0; $i < count($barang); $i++) {
            $this->Cell(1, 0.6, $i + 1, 1, 0, 'C');
            $this->Cell(12, 0.6, $barang[$i][0], 1, 0, 'C');
            $this->Cell(4, 0.6, $barang[$i][1], 1, 0, 'C');
            $this->Cell(4, 0.6, $barang[$i][2], 1, 1, 'C');
        }
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(13, 0.6, 'Total     ', 1, 0, 'R');
        $this->Cell(4, 0.6, $totalPcs, 1, 0, 'C');
        $this->Cell(4, 0.6, $totalMeter, 1, 1, 'C');
        $this->ln(0.3);
        $this->Cell(0,0.6,'Keterangan :',0,1);
        $this->SetFont('Arial', '', 10);
        $ket = [];
        $ket = explode("\n",$SJKet);
        for($i = 0 ; $i < count($ket) ; $i++){
            $this->Cell(0,0.6,$ket[$i],0,1,'L');
        }
        $this->Output();
    }
}

$pdf = new SJPDF();
if (isset($_SESSION["SJPDF"])) {
    $result = $_SESSION["SJPDF"];
    $keterangan = $_SESSION["SJKet"];
    $tanggal = $result[0]["Tanggal"];
    $noPO = substr(($result[0]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($tanggal . '', 0, 4) * 1 - 2000) . "/" . substr($tanggal, 5, 2) . "/" . $result[0]["KodePenjual"];
    $noSJ = substr(($result[0]["No_PO"] * 1 + 100000) . '', 1, 6) . '/SJ/' . (substr($tanggal . '', 0, 4) * 1 - 2000) . "/" . substr($tanggal, 5, 2) . "/" . $result[0]["KodePenjual"];

    $namaPembeli = $result[0]["Pembeli"];
    $alamatPembeli = $result[0]["Alamat"];
    $totalPcs = $result[0]["Total_Pcs"];
    $totalMeter = $result[0]["Total_Meter"];

    $idx = 0;
    $jenisKain = $result[0]["Jenis Kain"];
    $namaSampel = $result[0]["Sampel"];
    $warna = $result[0]["Warna"];
    $barang[$idx][0] = $jenisKain . ' ' . $namaSampel . ' ' . $warna;
    $pcs = 0;
    $meter = 0;
    for ($i = 0; $i < count($result); $i++) {
        if (strcmp($result[$i]["Sampel"], $namaSampel) != 0 || strcmp($result[$i]["Warna"], $warna) != 0) {
            $jenisKain = $result[$i]["Jenis Kain"];
            $namaSampel = $result[$i]["Sampel"];
            $warna = $result[$i]["Warna"];
            $barang[$idx][1] = $pcs;
            $barang[$idx][2] = $meter;
            $idx++;
            $barang[$idx][0] = $jenisKain . ' ' . $namaSampel . ' ' . $warna;
            $pcs = 0;
            $meter = 0;
        }
        $pcs++;
        $meter += $result[$i]["Meter"];
    }

    $barang[$idx][1] = $pcs;
    $barang[$idx][2] = $meter;

    $pdf = new SJPDF('L', 'cm', array(14, 21.6));
    $pdf->SetMargins(0.3, 0.3, 0.3);
    $pdf->CreateCustomPDF($noPO, $noSJ, $tanggal, $namaPembeli, $alamatPembeli, $barang, $totalPcs, $totalMeter,$keterangan);
}

session_unset();
session_destroy();
