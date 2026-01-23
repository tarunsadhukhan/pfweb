<?php
require_once(APPPATH.'libraries/fpdf.php');

class InsuranceReportPDF extends FPDF {
    // Page header
    function Header() {
        // Company Name
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Your Company Name',0,1,'C');
        // Statement Title
        $this->SetFont('Arial','B',12);
        $this->Cell(0,8,'Insurance Statement Report',0,1,'C');
        // Line break
        $this->Ln(5);
    }

    // Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Usage example (in your controller):
// $pdf = new InsuranceReportPDF();
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->SetFont('Arial','',10);
// $pdf->Cell(0,10,'Report content here...',0,1);
// $pdf->Output('I', 'insurance_report.pdf');
