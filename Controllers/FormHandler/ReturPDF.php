<?php
require('Assets/FPDF/fpdf.php');
session_start();

class ReturPDF extends FPDF
{
    private $noRetur = '';
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(5, 0.6, 'Retur', 0, 0, 'L');
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(6, 0.6, "R/" . $this->noRetur, 1, 0, 'C');
        $this->Ln(0.8);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-1);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 0.3, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function CreatePDF($noRetur, $tanggalRetur, $noPO, $namaPembeli, $alamatPembeli, $barang, $keterangan, $totalPcs, $totalMeter)
    {
        $this->noRetur = $noRetur;
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(1.8, 0.6, "No PO", 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $noPO, 0, 0);
        $this->Cell(1.18);
        $this->SetFont('Arial', 'B', 12);
        $tanggal = date_create($tanggalRetur);
        $this->Cell(1.5, 0.6, 'Tanggal : ' . date_format($tanggal, "d/m/Y"), 0, 1);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(1.8, 0.6, 'Pembeli', 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $namaPembeli, 0, 1);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(1.8, 0.6, 'Alamat', 0, 0, '');
        $this->Cell(0.5, 0.6, ':', 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(13, 0.6, $alamatPembeli, 0, 1);
        $this->Ln(0.4);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(1, 0.6, 'No.', 1, 0, 'C');
        $this->Cell(7, 0.6, 'Deskripsi', 1, 0, 'C');
        $this->Cell(3, 0.6, 'No.Karung', 1, 0, 'C');
        $this->Cell(5, 0.6, 'Warna', 1, 0, 'C');
        $this->Cell(5, 0.6, 'Meter', 1, 1, 'C');
        $this->SetFont('Arial', '', 10);

        for ($i = 0; $i < count($barang); $i++) {
            $this->Cell(1, 0.6, $i + 1, 1, 0, 'C');
            $this->Cell(7, 0.6, $barang[$i]["JenisKain"] . " " . $barang[$i]["Sampel"], 1, 0, 'C');
            $this->Cell(3, 0.6, $barang[$i]["NomorKarung"], 1, 0, 'C');
            $this->Cell(5, 0.6, $barang[$i]["Warna"], 1, 0, 'C');
            $this->Cell(5, 0.6, $barang[$i]["Meter"], 1, 1, 'C');
        }

        $this->SetFont('Arial', 'B', 11);
        $this->Cell(16, 0.6, 'Total  ', 1, 0, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(5, 0.6, $totalMeter, 1, 1, 'C');

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

$pdf = new ReturPDF();
// Controller::initializeDB();
// $_SESSION["ReturPDF"] = Controller::$db->executeQuery("GetDetailRetur", [1]);

if (isset($_SESSION["ReturPDF"])) {
    $result = $_SESSION["ReturPDF"];
    $keterangan = $result[0]["Keterangan"];
    $noRetur = $result[0]["No_Retur"];
    $tanggalRetur = $result[0]["TanggalRetur"];
    $noPO = substr(($result[0]["No_PO"] * 1 + 100000) . '', 1, 6) . '/PO/' . (substr($result[0]["TanggalPO"] . '', 0, 4) * 1 - 2000) . "/" . substr($result[0]["TanggalPO"], 5, 2) . "/" . $result[0]["KodePenjual"];
    $namaPembeli = $result[0]["Pembeli"];
    $alamatPembeli = $result[0]["Alamat"];
    for ($i = 0; $i < count($result); $i++) {
        $barang[$i]["Sampel"] = $result[$i]["Sampel"];
        if ($result[$i]["NomorWarna"] == null) {
            $barang[$i]["Warna"] = $result[$i]["Warna"];
        } else {
            $barang[$i]["Warna"] = $result[$i]["Warna"] . "-" . $result[$i]["NomorWarna"];
        }
        $barang[$i]["JenisKain"] = $result[$i]["Jenis Kain"];
        $barang[$i]["Sampel"] = $result[$i]["Sampel"];
        $barang[$i]["NomorKarung"] = $result[$i]["NomorKarung"];
        $barang[$i]["Meter"] = $result[$i]["Meter"];
    }
    $totalPcs = $result[0]["Total_Pcs"];
    $totalMeter = $result[0]["Total_Meter"];

    $pdf = new ReturPDF('L', 'cm', array(14, 21.6));
    $pdf->SetMargins(0.3, 0.3, 0.3);
    $pdf->CreatePDF($noRetur, $tanggalRetur, $noPO, $namaPembeli, $alamatPembeli, $barang, $keterangan, $totalPcs, $totalMeter);
}

session_unset();
session_destroy();
