<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
	

class Pfindividualsummary extends CI_Controller {

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
		$this->load->view('admin/uandetails/Pfindividualsummary', $data_to_pass);	
	}

    public function Pfindividualata() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $uanid = $this->input->post('uanid');
        $pfgendate=$upfromdate;
        $upfromdate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $pfgendate=$uptodate;
        $uptodate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
 
        
         $sql="select uan_no,name_as_per_pf_online,sum(gac1amt) gac1amt,sum(gac10amt) gac10amt,sum(pac1amt) pac1amt,sum(pac10amt) pac10amt,
        sum(oustamt) oustamt from (
        select tpg.uan_id,tum.uan_no,tum.name_as_per_pf_online,epf_contibution gac1amt,eps_contribution+epf_eps_diff_contribution gac10amt,
         ifnull(pac1amt,0) pac1amt,ifnull(pac10amt,0) pac10amt,epf_contibution+eps_contribution+epf_eps_diff_contribution-ifnull(pac1amt,0)-ifnull(pac10amt,0)
         oustamt,
         concat(UCASE(substr(MONTHNAME(month_end_date),1,3)),substr(month_end_date,1,4)) monname 
         from EMPMILL12.tbl_pf_generation tpg 
         left join (
         select pf_gen_id,sum(pac1amt) pac1amt,sum(pac10amt) pac10amt from (
         select tplud.pf_hdr_upload_id,pf_gen_id,epf_contribution  pac1amt,eps_contribution+epf_eps_diff_contribution 
         pac10amt from EMPMILL12.tbl_pf_line_upload_data tplud 
         left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id=tphud.pf_hdr_upload_id
         where tphud.trrn_status in (3) and tphud.is_active =1 ) g group by pf_gen_id
          ) tplud  on tpg.pf_gen_id =tplud.pf_gen_id 
         left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
         where tpg.is_active=1   
         and tpg.company_id=".$compid." and month_end_date between '".$upfromdate."' and '".$uptodate."'";    
         if ($uanid>0) {
            $sql = $sql . " and tpg.uan_id=" . $uanid ;
         }
            $sql = $sql . " ) a group by uan_no,name_as_per_pf_online ";
         $sql=$sql." order by uan_no";
//echo $sql;
            $query = $this->db->query($sql );
         $records = $query->result();
         $sln=$query->num_rows();
         $grgac1amt=$grgac10amt=$grgadmchgs=$grpac1amt=$grpac10amt=$grpadmchgs=$grout=0;       
         foreach ($records as $record) {
            $grgac1amt=$grgac1amt+$record->gac1amt;
            $grgac10amt=$grgac10amt+$record->gac10amt;
            $grpac1amt=$grpac1amt+$record->pac1amt;
            $grpac10amt=$grpac10amt+$record->pac10amt;
            $grout=$grout+$record->oustamt;       
            $data[] = [
                 $record->uan_no,
                 $record->name_as_per_pf_online,
                 $record->gac1amt,
                 $record->gac10amt,
                 $record->gac1amt+$record->gac10amt,
                 $record->pac1amt,
                 $record->pac10amt,
                 $record->pac1amt+$record->pac10amt,
                 $record->oustamt,
             ];
            }
            $data[] = [
                '',
                'Grand Total',
                 $grgac1amt,
                 $grgac10amt,
                 $grgac1amt+$grgac10amt,
                 $grpac1amt,
                 $grpac10amt,
                 $grpac1amt+$grpac10amt,
                 $grout,
             ];
 
         // Return the response
        echo json_encode(['data' => $data]);
         }




         public function getuanname() {
            $uanno = $this->input->post('uanno');
            $companyId = $this->input->post('companyId');
            $ebno = $this->input->post('ebno');
            
        
            $sql="select uan_id,name_as_per_pf_online  from  EMPMILL12.tbl_uan_master
            where is_active=1 and uan_no=? and  company_id =? "; 
            $query = $this->db->query($sql, array($uanno,$companyId ));
            $records = $query->result();
        //	$query1=$this->db->query($sql);
            $name='';
            if ( $query->num_rows()>0 ) {
                 $row1 = $query->row();
                $name=$row1->name_as_per_pf_online;
                $uanid=$row1->uan_id;
         
            } else {    
                $name="";
                $uanid=0;
            
            }	
            if ($name) {
                $response = array(
                    'success' => true,
                    'name' => $name,
                    'uanid' => $uanid,
                );
            } else {
                $response = array(
                    'success' => false,
                    'name' => $name,
                    'uanid' => $uanid,
                    
                );
            }
        
            echo json_encode($response);
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
        $uanid = $this->input->get('uanid');
        $uanno = $this->input->get('uanno');
        
        echo 'aha-'.$sdate;
        
        //$sdate='01-06-2023';
        //$edate='30-06-2023';
        //$compid=2;
        //$payScheme = $this->input->GET('payScheme');
        
        //echo 'date-'.$sdate;
        $upfromdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
        $uptodate=substr($edate,6,4).'-'.substr($edate,3,2).'-'.substr($edate,0,2);
            $pfgendate=$uptodate;
          
         $sql="select uan_no,name_as_per_pf_online,sum(gac1amt) gac1amt,sum(gac10amt) gac10amt,sum(pac1amt) pac1amt,sum(pac10amt) pac10amt,
sum(oustamt) oustamt from (
select tpg.uan_id,tum.uan_no,tum.name_as_per_pf_online,epf_contibution gac1amt,eps_contribution+epf_eps_diff_contribution gac10amt,
         ifnull(pac1amt,0) pac1amt,ifnull(pac10amt,0) pac10amt,epf_contibution+eps_contribution+epf_eps_diff_contribution-ifnull(pac1amt,0)-ifnull(pac10amt,0)
         oustamt,
         concat(UCASE(substr(MONTHNAME(month_end_date),1,3)),substr(month_end_date,1,4)) monname 
         from EMPMILL12.tbl_pf_generation tpg 
         left join (
         select pf_gen_id,sum(pac1amt) pac1amt,sum(pac10amt) pac10amt from (
         select tplud.pf_hdr_upload_id,pf_gen_id,epf_contribution  pac1amt,eps_contribution+epf_eps_diff_contribution 
         pac10amt from EMPMILL12.tbl_pf_line_upload_data tplud 
         left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id=tphud.pf_hdr_upload_id
         where tphud.trrn_status in (3) and tphud.is_active =1 ) g group by pf_gen_id
          ) tplud  on tpg.pf_gen_id =tplud.pf_gen_id 
         left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
         where tpg.is_active=1   and  company_id=".$compid." and
         month_end_date between '".$upfromdate."' and '".$uptodate."'";    
         if ($uanid>0) {
            $sql = $sql . " and tpg.uan_id=" . $uanid ;
         }
            $sql = $sql . " ) a group by uan_no,name_as_per_pf_online ";
         $sql=$sql." order by uan_no ";
//echo $sql;
                        $query = $this->db->query($sql );
                $records = $query->result();
                $sln=$query->num_rows();
            
        
        
         
            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Summary');
            $cmpn="company";
           
            $cmpn="your company";
//            $sheet->setCellValue('A1', 'For the Month of '.$sdate);
        //	$active_sheet->setCellValue('A2', "Reports for Dated : ");
            // Set company name
            $companyName = "Your Company Name";
        
            $sheet->setCellValue('a1', 'Uan No');
            $sheet->setCellValue('b1', 'Name');
            
            $sheet->setCellValue('c1', 'PF Deducted ');
            $sheet->setCellValue('f1', 'PF Payment');
            $sheet->setCellValue('i1', 'Outstanding');
 
            $sheet->setCellValue('c2', 'EE Contribution');
            $sheet->setCellValue('d2', 'ER Contribution');
            $sheet->setCellValue('e2', 'Total Amount');
            $sheet->setCellValue('f2', 'EE Contribution');
            $sheet->setCellValue('g2', 'ER Contribution');
            $sheet->setCellValue('h2', 'Total Amount');
            $sheet->setCellValue('i2', 'Outstanding Amount');
         
            $grgac1amt=$grgac10amt=$grgadmchgs=$grpac1amt=$grpac10amt=$grpadmchgs=$grout=0;       
            
            $rowIndex = 3;
            foreach ($records as $record) {
                $columnIndex = 1;
                $grgac1amt=$grgac1amt+$record->gac1amt;
                $grgac10amt=$grgac10amt+$record->gac10amt;
             //   $grgadmchgs=$grgadmchgs+$record->gadmchgs;
                $grpac1amt=$grpac1amt+$record->pac1amt;
                $grpac10amt=$grpac10amt+$record->pac10amt;
            //    $grpadmchgs=$grpadmchgs+$record->padmchgs;
                $grout=$grout+$record->oustamt;       
                $cell = Coordinate::stringFromColumnIndex($columnIndex) . $rowIndex;
  
                   $value=$record->uan_no;
//                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value,DataType::TYPE_STRING);
                $sheet->setCellValueExplicit($cell, (string)$record->uan_no, DataType::TYPE_STRING);
                  $columnIndex++;
                   $value=$record->name_as_per_pf_online;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gac1amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gac10amt;
                    
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->gac1amt+$record->gac10amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->pac1amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->pac10amt;
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->pac1amt+$record->pac10amt;
                    $value='=sum(f'.$rowIndex.':g'.$rowIndex.')';
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                    $columnIndex++;
                    $value=$record->oustamt;
                    $v=$record->gac1amt+$record->gac10amt-($record->pac1amt+$record->pac10amt);
                    $value='=(e'.$rowIndex.'-h'.$rowIndex.')';
                    $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                $rowIndex++;
            }	
            $columnIndex = 1;
            $rowind=$rowIndex-1;
            $value='';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value='Grand Total';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgac1amt;
            $value='=sum(c1:c'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgac10amt;
            $value='=sum(d1:d'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grgac1amt+$grgac10amt;
            $value='=sum(e1:e'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpac1amt;
            $value='=sum(f1:f'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpac10amt;
            $value='=sum(g1:g'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpac1amt+$grpac10amt;
            $value='=sum(h1:h'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
            $value=$grpac1amt+$grpac10amt;
            $value='=sum(i1:i'.$rowind.')';
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $columnIndex++;
              $rowIndex++;
             $columnIndex=1;
  
        
        	$sheet->mergeCells('c1:e1');
            $sheet->mergeCells('f1:h1');
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
        $sheet->getStyle('i1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('c1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('f1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();   // e.g. "N"
        $rangeAll   = "A1:{$highestCol}{$highestRow}";

// 1) Border for ALL cells
$sheet->getStyle($rangeAll)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);

        $sheet->getStyle("A1:{$highestCol}1")->getFont()->setBold(true);
$sheet->getStyle("A{$highestRow}:{$highestCol}{$highestRow}")->getFont()->setBold(true); 
        
// 2) Bold selected ROWS (example: header row 1, total row = $highestRow)
$sheet->getStyle("A1:{$highestCol}1")->getFont()->setBold(true);
$sheet->getStyle("A{$highestRow}:{$highestCol}{$highestRow}")->getFont()->setBold(true); // optional

// 3) Bold selected COLUMNS (example: Col A and Col D)
$sheet->getStyle("A1:A{$highestRow}")->getFont()->setBold(true);
$sheet->getStyle("D1:D{$highestRow}")->getFont()->setBold(true);

// 4) Shaded fill (shadow-like) for header row
$sheet->getStyle("A1:{$highestCol}1")->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFD9D9D9'], // light gray
    ],
]);

// 5) Shaded fill for selected columns (example: Col A + D)
$sheet->getStyle("A1:A{$highestRow}")->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFF2F2F2'],
    ],
]);
$sheet->getStyle("D1:D{$highestRow}")->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFF2F2F2'],
    ],
]);

// 6) Optional: "shadow effect" look for table outer border (thick border outside)
$sheet->getStyle($rangeAll)->applyFromArray([
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_MEDIUM,
        ],
    ],
]);


        $filename="pfdata_Summary".'.xlsx';
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