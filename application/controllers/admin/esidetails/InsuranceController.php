<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use Fpdf\Fpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once APPPATH . '../vendor/autoload.php';
	
require_once(APPPATH.'libraries/fpdf.php');  


class InsuranceController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('InsuranceModel');
    }
    public function index() {
        $this->load->view('admin/esidetails/insurance_entry');
    }
    public function fetchByInsuranceNo() {
        $insurance_no = $this->input->post('insurance_no');
        $data = $this->InsuranceModel->getMonthlyData($insurance_no);
        echo json_encode(['success' => true, 'data' => $data]);
    }


public function get_ipno_name_by_ebno() {
    $ebno = $this->input->post('ebno');
    $ipno = $this->input->post('ipno');
    $this->load->model('InsuranceModel');
    $result = $this->InsuranceModel->get_ipno_name_by_ebno($ipno, $ebno);
    if ($result) {
        echo json_encode([
            'success' => true,
            'ipno' => $result['ipno'],
            'name' => $result['name']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
    public function fetchRecord() {
        $recid = $this->input->post('recid');
        $data = $this->InsuranceModel->getRecord($recid);
        echo json_encode(['success' => true, 'data' => $data]);
    }

    public function saveRecord() {
        $data = $this->input->post();
        $result = $this->InsuranceModel->saveRecord($data);
        echo json_encode(['success' => $result]);
    }

    public function deleteRecord() {
        $recid = $this->input->post('recid');
        $result = $this->InsuranceModel->deleteRecord($recid);
        echo json_encode(['success' => $result]);
    }
 

public function exportpdfdata()
{
    $upfromdate = $this->input->get('upfromdate');
    $uptodate = $this->input->get('uptodate');
    $companyId = $this->input->get('companyId');
    $ebno = $this->input->get('ebno');
    $ipno = $this->input->get('ipno');
    $name = $this->input->get('name');
//    $rows = $this->WorkerGatePass_model->get_gate_pass_by_ids($upfromdate, $uptodate, $companyId, $ebno, $ipno, $name);
 
 
  
    $pdf = new FPDF('P','mm','A4');
    $pdf->SetAutoPageBreak(true, 12);

        $pdf->AddPage();
        $this->_print_joining_pass_letter($pdf, $upfromdate, $uptodate, $companyId, $ebno, $ipno, $name);
 
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="joining_pass.pdf"');
    $pdf->Output('D', 'joining_pass.pdf');
    exit;
}

private function _print_joining_pass_letter(FPDF $pdf, $upfromdate, $uptodate, $companyId, $ebno, $ipno,$name)
{
    // ----- DATA (safe defaults) -----
 
    // You can compute joining date = absent_to + 1 day if needed:
  
    // ----- HEADER (Company name + address + Date) -----
        $pdf->SetFont('Arial', '', 16);
         $currentDate = date('d-m-Y');
        $pdf->Cell(0, 8, 'WAGE VERIFICATION CERTIFICATE', 0, 1, 'C');
        $pdf->Ln(3);
        $lvperiod= $upfromdate.' to '.$uptodate;
        $contribution_period= '01.04.2025 To 30.09.2025';
        $benefit_period= '01.01.2026 To 30.06.2026';
        $employer_name= 'Nellimarla Jute Mills Co Ltd   ';
        $emp_code=' 70000422130000102';
        $auth= 'Authorized Signatory';
 
        $pdf->SetFont('Arial', '', 11);

        // Helper for label:value line (like your doc) :contentReference[oaicite:2]{index=2}
 
 /*        $this->_kv_line($pdf, '1. Date of wage verification', $currentDate, $leftW, $lineH);
        $this->_kv_line($pdf, '2. Whether daily/weekly/monthly rated', 'Monthly' ?? 'Monthly', $leftW, $lineH);
        $this->_kv_line($pdf, '3. Name of the employee', $name ?? '', $leftW, $lineH);
        $this->_kv_line($pdf, '4. Insurance No.', $ipno ?? '', $leftW, $lineH);
        $this->_kv_line($pdf, '5. Whether permanent/daily worker', 'Permanent' ?? '', $leftW, $lineH);
        $this->_kv_line($pdf, '6. Leave period', $lvperiod ?? '', $leftW, $lineH);
        $this->_kv_line($pdf, '7. Relevant contribution period', $contribution_period ?? '01.04.2025 – 30.09.2025', $leftW, $lineH);
        $this->_kv_line($pdf, '8. Relevant benefit period', $benefit_period ?? '01.01.2026 – 30.06.2026', $leftW, $lineH);
        $this->_kv_line($pdf, '9. Name & code No. of the employer', $employer_name_code ?? '', $leftW, $lineH);
  */
/*         $pdf->Ln(3);
        $pdf->Ln(16);
 */
    $y=15;    
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'1. Date of wage verification',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$currentDate,0,1,'L');
    $pdf->Ln(10);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'2. Whether daily/weekly/monthly rated',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,'Monthly',0,1,'L');

     $pdf->Ln(5);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'3. Name of the employee',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$name,0,1,'L');

    $pdf->Ln(5);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'4. Insurance No.',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$ipno,0,1,'L');
      $pdf->Ln(5);
    $x0 = 30; // left margin block  
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'5. Whether permanent/daily worker',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,'Permanent',0,1,'L');
    $pdf->Ln(5);    
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'6. Leave period',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$lvperiod,0,1,'L');
    $pdf->Ln(5);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'7. Relevant contribution period',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$contribution_period,0,1,'L');
    $pdf->Ln(5);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'8. Relevant benefit period',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$benefit_period,0,1,'L');
    $pdf->Ln(5);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'9. Name & code No. of the employer',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$employer_name,0,1,'L');
//    $pdf->Ln(10);
    $pdf->Ln(1);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Cell(60,6,$emp_code,0,1,'L');
    $pdf->Ln(10);
         

    $pdf->SetFont('Arial', 'B', 8);

        $wMonth = 35;
        $wDays1 = 18;
        $wWage1 = 35;
        $wDays2 = 18;
        $wWage2 = 35;
        $x0 = 20;
        $pdf->SetX($x0);

        // Top merged header row
        $pdf->Cell($wMonth, 8, 'Month / Year', 1, 0, 'C');
        $pdf->Cell($wDays1 + $wWage1, 8, 'Data taken from online', 1, 0, 'C');
        $pdf->Cell($wDays2 + $wWage2+20, 8, 'Data taken from wages given by the employer', 1, 1, 'C');
        $pdf->Ln(0);
        $x0 = 20;
        $pdf->SetX($x0);

        // Sub-header row
        $pdf->Cell($wMonth, 8, '', 1, 0, 'C');
        $pdf->Cell($wDays1, 8, 'Days', 1, 0, 'C');
        $pdf->Cell($wWage1, 8, 'Total wages paid', 1, 0, 'C');
        $pdf->Cell($wDays2, 8, 'Days', 1, 0, 'C');
        $pdf->Cell($wWage2+20, 8, 'Total Wages paid', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $x0 = 20;
        $pdf->SetX($x0);
        // Sample data rows (replace with actual data)

        $rows = $this->InsuranceModel->get_monthly_esi_data($upfromdate, $uptodate, $companyId, $ebno, $ipno, $name);
        $oda=$owgs=$nda=$nwgs=0;
        if (!empty($rows) && is_array($rows)) {
            foreach ($rows as $r) {
                $ipn  = isset($r['ipno']) ? $r['ipno'] : '';
                if (isset($r['month_end_date']) && $r['month_end_date']) {
                    $dt = DateTime::createFromFormat('Y-m-d', $r['month_end_date']);
                    $monthYear = $dt ? $dt->format("M'Y") : $r['month_end_date'];
                } else {
                    $monthYear = '';
                }
                $days_online = isset($r['online_days']) ? $r['online_days'] : '';
                $wages_online = isset($r['online_wages']) ? $r['online_wages'] : '';
                $days_employer = isset($r['njm_days']) ? $r['njm_days'] : '';
                $wages_employer = isset($r['njm_wages']) ? $r['njm_wages'] : '';

                $oda += (int)$days_online;
                $owgs += (int)$wages_online;    
                $nda += (int)$days_employer;
                $nwgs += (int)$wages_employer;

                $pdf->SetX($x0);

                $pdf->Cell($wMonth, 8, $monthYear, 1, 0, 'C');
                $pdf->Cell($wDays1, 8, $days_online, 1, 0, 'C');
                $pdf->Cell($wWage1, 8, number_format($wages_online), 1, 0, 'C');
                $pdf->Cell($wDays2, 8, $days_employer, 1, 0, 'C');
                $pdf->Cell($wWage2+20, 8, number_format($wages_employer), 1, 1, 'C');
                $pdf->Ln(0);
            }
                $pdf->SetX($x0);

                $pdf->Cell($wMonth, 8, 'Grand Total', 1, 0, 'C');
                $pdf->Cell($wDays1, 8, $oda, 1, 0, 'C');
                $pdf->Cell($wWage1, 8, number_format($owgs), 1, 0, 'C');
                $pdf->Cell($wDays2, 8, $nda, 1, 0, 'C');
                $pdf->Cell($wWage2+20, 8, number_format($nwgs), 1, 1, 'C');
                $pdf->Ln(0);

            }
 


 
        // ----- Authorized block (bottom left) -----
    $pdf->SetLeftMargin(15);
    $pdf->SetRightMargin(15);

    $pdf->SetFont('Arial','',10);
 //   $pdf->Cell(0,6,'Authorised by '.($auth ?: '_____________'),0,1,'L');
    $pdf->Ln(5);
    $pdf->Cell(150,6,'Yours Faithfully, ',0,1,'R');

	$pdf->SetLeftMargin(15);
    $pdf->SetRightMargin(15);
    $pdf->Ln(15);

    $pdf->SetFont('Arial','',10);
    $pdf->SetX(120);
    $pdf->Cell(50,0,'',1,1,'R'); // signature line
    $pdf->SetX(130);
    $pdf->Cell(40,6,'Signature of the employer',0,1,'R');
 
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'Average daily wages (Manual)',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Ln(8);
    
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'SB Rate calculated as per manual',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Ln(8);
    
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'Average daily wages (Online)	',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Ln(8);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'SB Rate Calculated as per Online',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Ln(8);
    $x0 = 30; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(40,6,'Rate Difference',0,0,'L');
    $x0 += 80; // left margin block
    $pdf->SetX($x0);
    $pdf->Cell(5,6,':',0,0,'L');
    $x0 += 10;
    $pdf->SetX($x0);
    $pdf->Ln(8);

}







    }
