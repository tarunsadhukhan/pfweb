<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Pfoutstandingdata extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	 public function __construct() {
        parent::__construct();
		$this->load->database('db2');
		$this->load->model('Winding_doff_Model');
        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
	} 

	  public function index()
	{

		$company_id = $this->session->userdata('company_id');

			if (strlen($company_id)==0) { 
				redirect('admin/login/logout');
			}


		//$this->load->view('welcome_message');
	//	$data['records'] = $this->Doffdata_Model->get_all_records();
     //   $this->load->view('record_form', $data);
		
		$this->load->library('form_validation');
		$this->load->model('Winding_doff_Model');
     
		
		$wndmcdata=$this->Winding_doff_Model->getwndmcnodata();
		$data['wndmcdata']=$wndmcdata;
	
		
		
		$spooldata=$this->Winding_doff_Model->getSpooldata();
		$datas['spooldata']=$spooldata;
	
		$qualitydata=$this->Winding_doff_Model->getQualitydata();
		$dataq['qualitydata']=$qualitydata;

		$data_to_pass['data'] = $data;
		$data_to_pass['datas'] = $datas;
		$data_to_pass['dataq'] = $dataq;
	

	//	var_dump($dataq);

//		$this->load->view('admin/winding_doff/winding_doff_data',$data,$dataq);
		$this->load->view('admin/uandetails/Pfoutstandingdata', $data_to_pass);	
	}

    public function Pfoutstandingdata() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $pfgendate=$upfromdate;
        $upfromdate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $pfgendate=$uptodate;
        $uptodate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
 
         $sql="select dedpf.*,ifnull(pac1amt,0) pac1amt,ifnull(pac10amt,0) pac10amt,ifnull(padmchgs,0) padmchgs,
        (gac1amt+gac10amt+gadmchgs-ifnull(pac1amt,0)-ifnull(pac10amt,0)-ifnull(padmchgs,0)) oustamt,
         concat(UCASE(substr(MONTHNAME(month_end_date),1,3)),substr(month_end_date,1,4)) monname from (
            select month_end_date,company_id,sum(epf_contibution+epf_eps_diff_contribution) gac1amt,sum(epf_contibution) gepf_cont,
            sum(eps_contribution) gac10amt,
            sum(epf_eps_diff_contribution) gepfepsdf,
            round(sum(epf_contibution)*10/100,0) gadmchgs 
            from EMPMILL12.tbl_pf_generation tpg where month_end_date between '".$upfromdate."' and '".$uptodate."' 
            and is_active =1 and company_id=".$compid." 
            group by month_end_date,company_id
            ) dedpf 
            left join 
            (
            select month_end_date monthenddate,company_id companyid,sum(pac1amt) pac1amt,sum(pac10amt) pac10amt,sum(padmchgs) padmchgs from (
            select month_end_date,company_id,
            case when tphud.trrn_type=1 then round((tphud.ac_1_amount+tphud.ac_10_amount)/2,0)
            when tphud.trrn_type=2 then (tphud.ac_1_amount) 
            when tphud.trrn_type = 3 then (tphud.ac_1_amount)
            else 0 end pac1amt,
            case when tphud.trrn_type=1 then round((tphud.ac_1_amount+tphud.ac_10_amount)/2,0)
            when tphud.trrn_type=3 then (tphud.ac_10_amount) 
            else 0 end pac10amt,
            (tphud.ac_2_amount+tphud.ac_21_amount+tphud.ac_22_amount) padmchgs from EMPMILL12.tbl_pf_hdr_upload_data tphud  
            where tphud.trrn_status=3 and company_id=".$compid." 
            ) g group by month_end_date,company_id
            ) paypf on dedpf.month_end_date=paypf.monthenddate and dedpf.company_id=paypf.companyid
            order by dedpf.month_end_date
            "; 
//echo $sql;
            $query = $this->db->query($sql,$upfromdate,$uptodate,$compid,$compid );
         $records = $query->result();
         $sln=$query->num_rows();
         $grgac1amt=$grgac10amt=$grgadmchgs=$grpac1amt=$grpac10amt=$grpadmchgs=$grout=0;       
         foreach ($records as $record) {
            $grgac1amt=$grgac1amt+$record->gac1amt;
            $grgac10amt=$grgac10amt+$record->gac10amt;
            $grgadmchgs=$grgadmchgs+$record->gadmchgs;
            $grpac1amt=$grpac1amt+$record->pac1amt;
            $grpac10amt=$grpac10amt+$record->pac10amt;
            $grpadmchgs=$grpadmchgs+$record->padmchgs;
            $grout=$grout+$record->oustamt;       
            
            $data[] = [
                 $record->monname,
                 $record->gac1amt,
                 $record->gac10amt,
                 $record->gadmchgs,
                 $record->gac1amt+$record->gac10amt+$record->gadmchgs,
                 $record->pac1amt,
                 $record->pac10amt,
                 $record->padmchgs,
                 $record->pac1amt+$record->pac10amt+$record->padmchgs,
                 $record->oustamt,
             ];
            }
            $data[] = [
                'Grand Total',
                 $grgac1amt,
                 $grgac10amt,
                 $grgadmchgs,
                 $grgac1amt+$grgac10amt+$grgadmchgs,
                 $grpac1amt,
                 $grpac10amt,
                 $grpadmchgs,
                 $grpac1amt+$grpac10amt+$grpadmchgs,
                 $grout,
             ];
 
         // Return the response
        echo json_encode(['data' => $data]);
         }

         public function gen_excelpfdata() {
            // Get the parameters from the URL query string
        //	$postData = json_decode(file_get_contents('php://input'), true);
        // $this->load->view('admin/reports/pfesidata');
        
        
        $sdate = $this->input->post('upfromdate');
        $edate = $this->input->post('uptodate');
        $compid = $this->input->post('companyId');
        
        $sdate = $this->input->get('upfromdate');
        $edate = $this->input->get('uptodate');
        $compid = $this->input->get('companyId');
        
        
        
        echo 'aha-'.$sdate;
        
        //$sdate='01-06-2023';
        //$edate='30-06-2023';
        //$compid=2;
        //$payScheme = $this->input->GET('payScheme');
        
        //echo 'date-'.$sdate;
        $upfromdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
        $uptodate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
            $pfgendate=$uptodate;
          
            $sql="select k.month_end_date monname,empl_cont gac1amt,emplo_cont gac10amt,gadmchgs,
            ifnull(empl_pay,0) pac1amt,ifnull(emplo_pay,0) pac10amt
            ,ifnull(adm_pay,0) padmchgs,
            (empl_cont+emplo_cont+gadmchgs-ifnull(empl_pay,0)-ifnull(emplo_pay,0)-ifnull(adm_pay,0)) oustamt from 
            (	
            select tpg.month_end_date,sum(epf_contibution) empl_cont,sum(eps_contribution+epf_eps_diff_contribution) emplo_cont,
            round(sum(epf_contibution)*10/100,0) gadmchgs 
            from EMPMILL12.tbl_pf_generation tpg where is_active=1 and month_end_date between '".$upfromdate."' and '".$uptodate."'
            and company_id=".$compid."
            group by month_end_date  
            ) k
            left join
            (
        SELECT 
            tphud.month_end_date,
            SUM(CASE 
                    WHEN tphud.trrn_type = 1 THEN tphud.ac_1_amount
                    WHEN tphud.trrn_type = 2 THEN tphud.ac_1_amount
                    WHEN tphud.trrn_type = 3 THEN 0 
                END) AS empl_pay,
            SUM(CASE 
                    WHEN tphud.trrn_type = 1 THEN tphud.ac_10_amount
                    WHEN tphud.trrn_type = 2 THEN 0
                    WHEN tphud.trrn_type = 3 THEN tphud.ac_10_amount + tphud.ac_1_amount
                END) AS emplo_pay,
            SUM(tphud.ac_2_amount + tphud.ac_21_amount + tphud.ac_22_amount) AS adm_pay
        FROM 
            EMPMILL12.tbl_pf_hdr_upload_data tphud 
        WHERE 
            tphud.is_active = 1 and month_end_date between '".$upfromdate."' and '".$uptodate."'
            and company_id=".$compid." and tphud.trrn_status=3
        GROUP BY 
            tphud.month_end_date
            ) g on g.month_end_date=k.month_end_date
          order by k.month_end_date";
                        $query = $this->db->query($sql );
                $records = $query->result();
                $sln=$query->num_rows();
            
        
        
         
            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
        
            $cmpn="company";
           
            $cmpn="your company";
//            $sheet->setCellValue('A1', 'For the Month of '.$sdate);
        //	$active_sheet->setCellValue('A2', "Reports for Dated : ");
            // Set company name
            $companyName = "Your Company Name";
        
            $sheet->setCellValue('a1', 'Month');
            $sheet->setCellValue('b1', 'PF Deducted ');
            $sheet->setCellValue('f1', 'PF Payment');
            $sheet->setCellValue('j1', 'Outstanding');
 
            $sheet->setCellValue('A2', 'Month End Date ');
            $sheet->setCellValue('b2', 'AC 1 AMOUNT');
            $sheet->setCellValue('c2', 'AC 10 AMOUNT');
            $sheet->setCellValue('d2', 'Adm Charges');
            $sheet->setCellValue('e2', 'Total Amount');
            $sheet->setCellValue('f2', 'AC 1  Paid');
            $sheet->setCellValue('g2', 'AC 10  Paid');
            $sheet->setCellValue('h2', 'Adm Charges Paid');
            $sheet->setCellValue('i2', 'Total Amount');
            $sheet->setCellValue('j2', 'Outstanding Amount');
         
            $grgac1amt=$grgac10amt=$grgadmchgs=$grpac1amt=$grpac10amt=$grpadmchgs=$grout=0;       
               
            
            $rowIndex = 3;
            foreach ($records as $record) {
                $columnIndex = 1;
                $grgac1amt=$grgac1amt+$record->gac1amt;
                $grgac10amt=$grgac10amt+$record->gac10amt;
                $grgadmchgs=$grgadmchgs+$record->gadmchgs;
                $grpac1amt=$grpac1amt+$record->pac1amt;
                $grpac10amt=$grpac10amt+$record->pac10amt;
                $grpadmchgs=$grpadmchgs+$record->padmchgs;
                $grout=$grout+$record->oustamt;       
       
                   $value=$record->monname;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gac1amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gac10amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gadmchgs;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gac1amt+$record->gac10amt+$record->gadmchgs;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->pac1amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->pac10amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->padmchgs;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->padmchgs+$record->pac1amt+$record->pac10amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->oustamt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                $rowIndex++;
            }	
            $columnIndex = 1;
        
            $value='Grand Total';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgac1amt;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgac10amt;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgadmchgs;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgac1amt+$grgac10amt+$grgadmchgs;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpac1amt;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpac10amt;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpadmchgs;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpadmchgs+$grpac1amt+$grpac10amt;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grout;
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
 
        
        	$sheet->mergeCells('b1:E1');
            $sheet->mergeCells('f1:i1');
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
     
        //	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('a1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('j1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('b1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        	$sheet->getStyle('f1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $filename="pfdata".'.xlsx';
            // Set headers for Excel file download
        //	ob_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //	header('Content-Disposition: attachment;filename="your_excel_file.xlsx"');
        
        //		header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
            ob_clean();
        
            // Save the Excel file to output stream
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            // Save the Excel file to output stream
        //	$writer = new Xlsx($spreadsheet);
        //	$writer->save('php://output');
         
        
        
        }
         





}    