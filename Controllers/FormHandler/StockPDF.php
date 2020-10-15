<?php
require('Assets/FPDF/fpdf.php');
session_start();

class StockPDF extends FPDF
{
    private $stockTotalPcs = 0;
    private $stockTotalMeter = 0;
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(54, 10, 'Stock', 0, 0, 'L');
        $this->Cell(91);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(55, 10, "Tanggal: " . date("d/m/Y"), 1, 1, 'C');
        $this->Ln(2);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function CreatePDF($result, $total)
    {
        $this->stockTotalPcs = $total[0]["TotalPcs"];
        $this->stockTotalMeter = $total[0]["TotalMeter"];
        $this->AliasNbPages();
        $this->AddPage();

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 5, "Total Pcs", 0, 0, 'L');
        $this->Cell(5, 5, " : ", 0, 0, 'L');
        $this->Cell(175, 5,  $this->stockTotalPcs, 0, 1, 'L');
        $this->Cell(20, 5, "Total Mtr", 0, 0, 'L');
        $this->Cell(5, 5, " : ", 0, 0, 'L');
        $this->Cell(175, 5,  $this->stockTotalMeter, 0, 1, 'L');
        $this->Cell(200, 0.1, "", 1, 0, 'C');
        // Line break
        $this->Ln(2);

        $nama = "";
        $sumPcs = 0;
        $sumMeter = 0;
        $jenisKain = "";
        for ($i = 0; $i < count($result); $i++) {
            $nomorWarna = $result[$i]["NomorWarna"];
            $warna = $result[$i]["Warna"];
            $totalPcs = $result[$i]["TotalPcs"];
            $totalMeter = $result[$i]["TotalMeter"];

            if ($totalPcs == null) {
                $totalPcs = 0;
                $totalMeter = 0;
            }
            if (strcmp($nama, $result[$i]["Sampel"]) != 0) {
                $nama = $result[$i]["Sampel"];
                if ($i != 0) {
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(130, 6, '', 1, 0, 'C');
                    $this->Cell(30, 6, $sumPcs, 1, 0, 'C');
                    $this->Cell(40, 6, $sumMeter, 1, 1, 'C');
                    $this->Cell(200, 3, '', 0, 1, 'C');
                    $sumPcs = 0;
                    $sumMeter = 0;
                }

                if (strcmp($jenisKain, $result[$i]["JenisKain"]) != 0) {
                    $jenisKain = $result[$i]["JenisKain"];
                    $this->SetFont('Arial', 'B', 12);
                    $this->Cell(200, 6, $jenisKain, 0, 1, 'C');
                }

                $this->SetFont('Arial', 'B', 12);
                $this->SetFillColor(139, 195, 74);
                $this->Cell(200, 6, $nama, 1, 1, '', true);

                $this->SetFont('Arial', '', 10);
                $this->Cell(20, 6, '', 1, 0, 'C');
                $this->Cell(15, 6, $nomorWarna, 1, 0, 'C');
                $this->Cell(45, 6, $warna, 1, 0, 'C');
                $this->Cell(20, 6, $totalPcs, 1, 0, 'C');
                $this->Cell(30, 6, $totalMeter, 1, 0, 'C');
                $this->Cell(30, 6, '', 1, 0, 'C');
                $this->Cell(40, 6, '', 1, 1, 'C');
            } else {

                $this->SetFont('Arial', '', 10);
                $this->Cell(20, 6, '', 1, 0, 'C');
                $this->Cell(15, 6, $nomorWarna, 1, 0, 'C');
                $this->Cell(45, 6, $warna, 1, 0, 'C');
                $this->Cell(20, 6, $totalPcs, 1, 0, 'C');
                $this->Cell(30, 6, $totalMeter, 1, 0, 'C');
                $this->Cell(30, 6, '', 1, 0, 'C');
                $this->Cell(40, 6, '', 1, 1, 'C');
            }
            $sumPcs += $totalPcs;
            $sumMeter += $totalMeter;
        }
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(130, 6, '', 1, 0, 'C');
        $this->Cell(30, 6, $sumPcs, 1, 0, 'C');
        $this->Cell(40, 6, $sumMeter, 1, 1, 'C');
        $this->Cell(200, 3, '', 0, 1, 'C');
        $sumPcs = 0;
        $sumMeter = 0;
        $this->Output();
    }
}

$pdf = new StockPDF();
if (isset($_SESSION["StockPDF"])) {
    $result = $_SESSION["StockPDF"];
    $total = $_SESSION["StockTotal"];
    $pdf = new StockPDF();
    $pdf->SetMargins(5, 5, 5, 5);
    $pdf->CreatePDF($result, $total);
}
session_unset();
session_destroy();
