<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Pfuploadfileshow extends CI_Controller {

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
		$this->load->view('admin/uandetails/Pfuploadfileshow', $data_to_pass);	
	}


    public function Pfupddatalast() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $sdate=$upfromdate;
        $upfromdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
        $sdate=$uptodate;
        $uptodate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
    
    
    
         $sql="select tphud.*,
         case when trrn_status=1 then 'Reject'
         when  trrn_status=2 then 'Due for Payment'
         when  trrn_status=3 then 'Payment Confirm'
         when  trrn_status=4 then 'Cancel' end status_type,
         case when trrn_type=1 then 'Both Shares'
         when  trrn_type=2 then 'EE Share'
         when  trrn_type=3 then 'ER Share'
         when  trrn_type=4 then 'No Share' end trrn_stat_type,tplud.noofemp,main
         from EMPMILL12.tbl_pf_hdr_upload_data tphud 
         left join (select pf_hdr_upload_id,count(*) noofemp from EMPMILL12.tbl_pf_line_upload_data tplud 
         where is_active=1 group by pf_hdr_upload_id) tplud
         on tphud.pf_hdr_upload_id=tplud.pf_hdr_upload_id
         where month_end_date 
         between '".$upfromdate."' and '".$uptodate."' and is_active=1 and 
         company_id=".$compid. "  order by month_end_date desc";
     //    echo $sql;

         $query = $this->db->query($sql );
         $records = $query->result();
         $sln=$query->num_rows();
         $data=[];
         foreach ($records as $record) {
             $data[] = [
                 $record->pf_hdr_upload_id,
                 $record->month_end_date,
                 $record->trrn_no,
                 $record->trrn_stat_type,
                 $record->challan_date,
                 $record->ac_1_amount,
                 $record->ac_2_amount,
                 $record->ac_10_amount,
                 $record->ac_21_amount,
                 $record->ac_22_amount,
                 $record->trrn_amount,
                 $record->status_type,
                 $record->payment_date,
                 $record->trrn_status,
                 $record->trrn_type,
                 $record->batch_process_no,
                 $record->noofemp,
                 $record->main
            ];
          }
          
    
     // Return the response
     echo json_encode(['data' => $data]);
         }
    
         public function Pfgendatalast() {
            $compid = $this->input->post('companyId');
            $compid = $this->input->post('companyId');
            $compid = $this->session->userdata('company_id');
            $upfromdate = $this->input->post('upfromdate');
            $uptodate = $this->input->post('uptodate');
            $sdate=$upfromdate;
            $upfromdate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
            $sdate=$uptodate;
            $uptodate=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
        
        
        
             $sql="select month_end_date,sum(gross_wages) gross_wages,sum(epf_wages) epf_wages,sum(eps_wages) eps_wages,
             sum(edli_wages) edli_wages,
             sum(epf_contibution) epf_cont , sum(eps_contribution) eps_cont , sum(epf_eps_diff_contribution) epfepsdf 
             ,count(*) noofemp from EMPMILL12.tbl_pf_generation tpg 
             where month_end_date 
             between '".$upfromdate."' and '".$uptodate."' and is_active=1 and company_id=".$compid. "  
             GROUP BY month_end_date order by month_end_date desc";
  //  echo $sql;
    
             $query = $this->db->query($sql );
             $records = $query->result();
             $sln=$query->num_rows();
             $data=[];
             foreach ($records as $record) {
                 $data[] = [
                     0,
                     $record->month_end_date,
                     $record->gross_wages,
                     $record->epf_wages,
                     $record->eps_wages,
                     $record->edli_wages,
                     $record->epf_cont,
                     $record->eps_cont,
                     $record->epfepsdf ,
                     $record->noofemp , 
          
                 ];
              }
              
        
         // Return the response
         echo json_encode(['data' => $data]);
             }
        
             public function Pfupddetailsdata() {
                $compid = $this->input->post('companyId');
                $compid = $this->input->post('companyId');
                $compid = $this->session->userdata('company_id');
                $recordId = $this->input->post('recordId');
             
            
            
                 $sql="select tplud.*,tum.uan_no,tum.name_as_per_pf_online,tphud.month_end_date,tphud.trrn_no  from EMPMILL12.tbl_pf_line_upload_data tplud 
                 left join EMPMILL12.tbl_uan_master tum on tplud.uan_id =tum.uan_id 
                 join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
                 where tplud.pf_hdr_upload_id =".$recordId." order by tum.uan_no" 
                 ;
        
                 $query = $this->db->query($sql );
                 $records = $query->result();
                 $sln=$query->num_rows();
                 $data=[];
                 foreach ($records as $record) {
                     $data[] = [
                         $record->pf_line_upload_id,
                         $record->month_end_date,
                         $record->trrn_no,
                         $record->uan_no,
                         $record->name_as_per_pf_online,
                         $record->gross_wages,
                         $record->epf_wages,
                         $record->eps_wages,
                         $record->edli_wages,
                         $record->epf_contribution,
                         $record->eps_contribution,
                         $record->epf_eps_diff_contribution ,
                         $record->ncp_days ,
                          
              
                     ];
                  }
                  
            
             // Return the response
             echo json_encode(['data' => $data]);
                 }
     
                 public function Pfgendetailsdata() {
                    $compid = $this->input->post('companyId');
                    $compid = $this->input->post('companyId');
                    $compid = $this->session->userdata('company_id');
                    $recordId = $this->input->post('recordId');
                 
                
                
                     $sql="select tpg.*,tum.uan_no,tum.name_as_per_pf_online  from EMPMILL12.tbl_pf_generation tpg 
                     left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
                     where month_end_date ='".$recordId."' and tpg.is_active =1 order by uan_no
                     " 
                     ;
            
                     $query = $this->db->query($sql );
                     $records = $query->result();
                     $sln=$query->num_rows();
                     $data=[];
                     foreach ($records as $record) {
                         $data[] = [
                             $record->pf_gen_id,
                             $record->month_end_date,
                             $record->uan_no,
                             $record->name_as_per_pf_online,
                             $record->gross_wages,
                             $record->epf_wages,
                             $record->eps_wages,
                             $record->edli_wages,
                             $record->epf_contibution,
                             $record->eps_contribution,
                             $record->epf_eps_diff_contribution ,
                             $record->ncp_days ,
                              
                  
                         ];
                      }
                      
                
                 // Return the response
                 echo json_encode(['data' => $data]);
                     }
         

    public function export_excel_hdr() {
        $compid = $this->input->get('companyId');
        $upfromdate = $this->input->get('upfromdate');
        $uptodate = $this->input->get('uptodate');
        $sdate = $upfromdate;
        $upfromdate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);
        $sdate = $uptodate;
        $uptodate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);

        $sql = "select tphud.*,
         case when trrn_status=1 then 'Reject'
         when  trrn_status=2 then 'Due for Payment'
         when  trrn_status=3 then 'Payment Confirm'
         when  trrn_status=4 then 'Cancel' end status_type,
         case when trrn_type=1 then 'Both Shares'
         when  trrn_type=2 then 'EE Share'
         when  trrn_type=3 then 'ER Share'
         when  trrn_type=4 then 'No Share' end trrn_stat_type,tplud.noofemp
         from EMPMILL12.tbl_pf_hdr_upload_data tphud 
         left join (select pf_hdr_upload_id,count(*) noofemp from EMPMILL12.tbl_pf_line_upload_data tplud 
         where is_active=1 group by pf_hdr_upload_id) tplud
         on tphud.pf_hdr_upload_id=tplud.pf_hdr_upload_id
         where month_end_date 
         between '" . $upfromdate . "' and '" . $uptodate . "' and is_active=1 and 
         company_id=" . $compid . "  order by month_end_date desc";

        $query = $this->db->query($sql);
        $records = $query->result();

        if (!empty($records)) {
            $firstRecord = $records[0];
            $filename = "PF_Upload_Header_" . $firstRecord->month_end_date . "_" . $firstRecord->trrn_no . ".xlsx";
        } else {
            $filename = "PF_Upload_Header.xlsx";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('PF Upload Header');

        // Headers
        $headers = ['Record Id', 'Month End Date', 'TRRN No', 'Tran Type', 'Challan Date', 'Ac 1 Amount', 'Ac 2 Amount', 'Ac 10 Amount', 'Ac 21 Amount', 'Ac 22 Amount', 'Total Amount', 'Status', 'Payment Date', 'statusid', 'stattypid', 'Batch No', 'No of Person'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Data
        $row = 2;
        foreach ($records as $record) {
            $sheet->setCellValue('A' . $row, $record->pf_hdr_upload_id);
            $sheet->setCellValue('B' . $row, $record->month_end_date);
            $sheet->setCellValue('C' . $row, $record->trrn_no);
            $sheet->setCellValue('D' . $row, $record->trrn_stat_type);
            $sheet->setCellValue('E' . $row, $record->challan_date);
            $sheet->setCellValue('F' . $row, $record->ac_1_amount);
            $sheet->setCellValue('G' . $row, $record->ac_2_amount);
            $sheet->setCellValue('H' . $row, $record->ac_10_amount);
            $sheet->setCellValue('I' . $row, $record->ac_21_amount);
            $sheet->setCellValue('J' . $row, $record->ac_22_amount);
            $sheet->setCellValue('K' . $row, $record->trrn_amount);
            $sheet->setCellValue('L' . $row, $record->status_type);
            $sheet->setCellValue('M' . $row, $record->payment_date);
            $sheet->setCellValue('N' . $row, $record->trrn_status);
            $sheet->setCellValue('O' . $row, $record->trrn_type);
            $sheet->setCellValue('P' . $row, $record->batch_process_no);
            $sheet->setCellValue('Q' . $row, $record->noofemp);
            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function export_excel_details() {
        $compid = $this->input->get('companyId');
        $upfromdate = $this->input->get('upfromdate');
        $uptodate = $this->input->get('uptodate');
        $recordId = $this->input->get('recordId');
        $sdate = $upfromdate;
        $upfromdate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);
        $sdate = $uptodate;
        $uptodate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);

        if ($recordId) {
            $sql = "select tplud.*,tum.uan_no,tum.name_as_per_pf_online,tphud.month_end_date,tphud.trrn_no  from EMPMILL12.tbl_pf_line_upload_data tplud 
             left join EMPMILL12.tbl_uan_master tum on tplud.uan_id =tum.uan_id 
             join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
             where tplud.pf_hdr_upload_id = " . $recordId . " order by tum.uan_no";
            $query = $this->db->query($sql);
            $records = $query->result();
        } else {
            $records = []; // No data displayed if no record selected
        }

        if (!empty($records)) {
            $firstRecord = $records[0];
            $filename = "PF_Upload_Details_" . $firstRecord->month_end_date . "_" . $firstRecord->trrn_no . ".xlsx";
        } else {
            $filename = "PF_Upload_Details.xlsx";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('PF Upload Details');

        // Headers
        $headers = ['Record Id', 'Month End Date', 'TRRN No', 'UAN No', 'Name', 'Gross Wages', 'EPF Wages', 'EPS Wages', 'EDLI Wages', 'EPF Cont', 'EPS Cont', 'EPF EPS Diff', 'NCP Days'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Data
        $row = 2;
        foreach ($records as $record) {
            $sheet->setCellValue('A' . $row, $record->pf_line_upload_id);
            $sheet->setCellValue('B' . $row, $record->month_end_date);
            $sheet->setCellValue('C' . $row, $record->trrn_no);
            $sheet->setCellValue('D' . $row, $record->uan_no);
            $sheet->setCellValue('E' . $row, $record->name_as_per_pf_online);
            $sheet->setCellValue('F' . $row, $record->gross_wages);
            $sheet->setCellValue('G' . $row, $record->epf_wages);
            $sheet->setCellValue('H' . $row, $record->eps_wages);
            $sheet->setCellValue('I' . $row, $record->edli_wages);
            $sheet->setCellValue('J' . $row, $record->epf_contribution);
            $sheet->setCellValue('K' . $row, $record->eps_contribution);
            $sheet->setCellValue('L' . $row, $record->epf_eps_diff_contribution);
            $sheet->setCellValue('M' . $row, $record->ncp_days);
            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function export_excel_genhdr() {
        $compid = $this->input->get('companyId');
        $upfromdate = $this->input->get('upfromdate');
        $uptodate = $this->input->get('uptodate');
        $sdate = $upfromdate;
        $upfromdate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);
        $sdate = $uptodate;
        $uptodate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);

        $sql = "select month_end_date,sum(gross_wages) gross_wages,sum(epf_wages) epf_wages,sum(eps_wages) eps_wages,
         sum(edli_wages) edli_wages,
         sum(epf_contibution) epf_cont , sum(eps_contribution) eps_cont , sum(epf_eps_diff_contribution) epfepsdf 
         ,count(*) noofemp from EMPMILL12.tbl_pf_generation tpg 
         where month_end_date 
         between '" . $upfromdate . "' and '" . $uptodate . "' and is_active=1 and company_id=" . $compid . "  
         GROUP BY month_end_date order by month_end_date desc";

        $query = $this->db->query($sql);
        $records = $query->result();

        if (!empty($records)) {
            $firstRecord = $records[0];
            $filename = "PF_Genation_HDR_Data_" . $firstRecord->month_end_date . ".xlsx";
        } else {
            $filename = "PF_Genation_HDR_Data.xlsx";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('PF Genation HDR Data');

        // Headers
        $headers = ['Record Id', 'Month End Date', 'Gross Wages', 'EPF Wages', 'EPS Wages', 'EDLI Wages', 'EPF Cont', 'EPS Cont', 'EPF EPS Diff', 'No of Persons'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Data
        $row = 2;
        foreach ($records as $record) {
            $sheet->setCellValue('A' . $row, 0); // As in the data array
            $sheet->setCellValue('B' . $row, $record->month_end_date);
            $sheet->setCellValue('C' . $row, $record->gross_wages);
            $sheet->setCellValue('D' . $row, $record->epf_wages);
            $sheet->setCellValue('E' . $row, $record->eps_wages);
            $sheet->setCellValue('F' . $row, $record->edli_wages);
            $sheet->setCellValue('G' . $row, $record->epf_cont);
            $sheet->setCellValue('H' . $row, $record->eps_cont);
            $sheet->setCellValue('I' . $row, $record->epfepsdf);
            $sheet->setCellValue('J' . $row, $record->noofemp);
            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function export_excel_gendetails() {
        $compid = $this->input->get('companyId');
        $upfromdate = $this->input->get('upfromdate');
        $uptodate = $this->input->get('uptodate');
        $recordId = $this->input->get('recordId');
        $sdate = $upfromdate;
        $upfromdate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);
        $sdate = $uptodate;
        $uptodate = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);

        if ($recordId) {
            $sql = "select tpg.*,tum.uan_no,tum.name_as_per_pf_online  from EMPMILL12.tbl_pf_generation tpg 
             left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
             where month_end_date ='" . $recordId . "' and tpg.is_active =1 and tpg.company_id=" . $compid . " order by uan_no";
            $query = $this->db->query($sql);
            $records = $query->result();
        } else {
            $records = []; // No data displayed if no record selected
        }

        if (!empty($records)) {
            $firstRecord = $records[0];
            $filename = "PF_Genation_Details_Data_" . $firstRecord->month_end_date . ".xlsx";
        } else {
            $filename = "PF_Genation_Details_Data.xlsx";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('PF Genation Details Data');

        // Headers
        $headers = ['Record Id', 'Month End Date', 'UAN No', 'Name', 'Gross Wages', 'EPF Wages', 'EPS Wages', 'EDLI Wages', 'EPF Cont', 'EPS Cont', 'EPF EPS Diff', 'NCP Days'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Data
        $row = 2;
        foreach ($records as $record) {
            $sheet->setCellValue('A' . $row, $record->pf_gen_id);
            $sheet->setCellValue('B' . $row, $record->month_end_date);
            $sheet->setCellValue('C' . $row, $record->uan_no);
            $sheet->setCellValue('D' . $row, $record->name_as_per_pf_online);
            $sheet->setCellValue('E' . $row, $record->gross_wages);
            $sheet->setCellValue('F' . $row, $record->epf_wages);
            $sheet->setCellValue('G' . $row, $record->eps_wages);
            $sheet->setCellValue('H' . $row, $record->edli_wages);
            $sheet->setCellValue('I' . $row, $record->epf_contibution);
            $sheet->setCellValue('J' . $row, $record->eps_contribution);
            $sheet->setCellValue('K' . $row, $record->epf_eps_diff_contribution);
            $sheet->setCellValue('L' . $row, $record->ncp_days);
            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
