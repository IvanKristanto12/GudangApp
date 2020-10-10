<?php
require('Assets/FPDF/fpdf.php');
session_start();

class StockPDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(54, 10, 'Stock', 0, 0, 'L');
        $this->Cell(91);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(55, 10, "Tanggal: " . date("d/m/Y"), 1, 0, 'C');
        // Line break
        $this->Ln(13);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function CreatePDF($result)
    {
        $this->AliasNbPages();
        $this->AddPage();

        $nama = "";
        $sumPcs = 0;
        $sumMeter = 0;
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
                    $this->Cell(120, 6, '', 1, 0, 'C');
                    $this->Cell(40, 6, $sumPcs, 1, 0, 'C');
                    $this->Cell(40, 6, $sumMeter, 1, 1, 'C');
                    $this->Cell(200, 3, '', 0, 1, 'C');
                    $sumPcs = 0;
                    $sumMeter = 0;
                }

                $this->SetFont('Arial', 'B', 12);
                $this->SetFillColor(139, 195, 74);
                $this->Cell(200, 6, $nama, 1, 1, '', true);

                $this->SetFont('Arial', '', 10);
                $this->Cell(25, 6, '', 1, 0, 'C');
                $this->Cell(15, 6, $nomorWarna, 1, 0, 'C');
                $this->Cell(30, 6, $warna, 1, 0, 'C');
                $this->Cell(20, 6, $totalPcs, 1, 0, 'C');
                $this->Cell(30, 6, $totalMeter, 1, 0, 'C');
                $this->Cell(40, 6, '', 1, 0, 'C');
                $this->Cell(40, 6, '', 1, 1, 'C');
            } else {

                $this->SetFont('Arial', '', 10);
                $this->Cell(25, 6, '', 1, 0, 'C');
                $this->Cell(15, 6, $nomorWarna, 1, 0, 'C');
                $this->Cell(30, 6, $warna, 1, 0, 'C');
                $this->Cell(20, 6, $totalPcs, 1, 0, 'C');
                $this->Cell(30, 6, $totalMeter, 1, 0, 'C');
                $this->Cell(40, 6, '', 1, 0, 'C');
                $this->Cell(40, 6, '', 1, 1, 'C');
            }
            $sumPcs += $totalPcs;
            $sumMeter += $totalMeter;
        }
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(120, 6, '', 1, 0, 'C');
        $this->Cell(40, 6, $sumPcs, 1, 0, 'C');
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
    $pdf = new StockPDF();
    $pdf->SetMargins(5, 5, 5, 5);
    $pdf->CreatePDF($result);
}
session_unset();
session_destroy();
