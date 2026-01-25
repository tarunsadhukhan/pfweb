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

	public function summaryreport() {
		$company_id = $this->session->userdata('company_id');

		if (strlen($company_id)==0) { 
			redirect('admin/login/logout');
		}

		$this->load->view('admin/uandetails/Pfsummaryreport');
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





    private function _getSummaryRecords($fromdate_formatted, $todate_formatted, $compid) {
        $sql = "select date_format(gen.month_end_date,'%d-%m-%Y') monthenddate,
	gen.*,
	upl.*,
	pay.*,gen.epfcont_g -pay.epfcont_p epfcont_od,gen.epscont_g -pay.epscont_p epscont_od,gen.epfepsdiff_g -pay.epfepsdiff_p epfepsdiff_od,
	gen.admchgs_g -pay.admchgs_p admchgs_od,
	upl.epfcont_d -pay.epfcont_p epfcont_ou,upl.epscont_d -pay.epscont_p epscont_ou,upl.epfepsdiff_d  -pay.epfepsdiff_p epfepsdiff_ou,
	upl.admchgs_d -pay.admchgs_p admchgs_ou,
	gen.epfcont_g -upl.epfcont_d epfcont_pu,gen.epscont_g -upl.epscont_d epscont_pu,gen.epfepsdiff_g -upl.epfepsdiff_d epfepsdiff_pu,
	gen.admchgs_g -upl.admchgs_d admchgs_pu
        from (
                select tpg.month_end_date,sum(tpg.epf_contibution) epfcont_g,
                sum(tpg.eps_contribution) epscont_g,
                sum(tpg.epf_eps_diff_contribution) epfepsdiff_g,
                round(sum((tpg.epf_wages))*.01,0) admchgs_g,
                sum(tpg.epf_contibution)+sum(tpg.eps_contribution)+sum(tpg.epf_eps_diff_contribution) +
                round(sum((tpg.epf_wages))*.01,0) total_g
                from EMPMILL12.tbl_pf_generation tpg where tpg.is_active =1 and tpg.month_end_date between '$fromdate_formatted' and '$todate_formatted' group by tpg.month_end_date
                ) gen
                left join (
				select month_end_date ,sum(epfcont_d) epfcont_d,sum(epscont_d ) epscont_d,sum(epfepsdiff_d) epfepsdiff_d,
				sum(ac2amt_d+ac21amt_d+ac22amt_d) admchgs_d,
				sum(epfcont_d)+sum(epscont_d )+sum(epfepsdiff_d)+sum(ac2amt_d+ac21amt_d+ac22amt_d) total_d
				from (
				select tphud.month_end_date, sum(tplud.epf_contribution) epfcont_d,sum(tplud.eps_contribution ) epscont_d,
				sum(tplud.epf_eps_diff_contribution ) epfepsdiff_d,
				(tphud.ac_2_amount) ac2amt_d,(tphud.ac_21_amount ) ac21amt_d,(tphud.ac_22_amount ) ac22amt_d,
				tphud.trrn_amount ,tphud.ac_1_amount ,tphud.ac_10_amount
				from EMPMILL12.tbl_pf_hdr_upload_data tphud
				join EMPMILL12.tbl_pf_line_upload_data tplud  on tphud.pf_hdr_upload_id =tplud.pf_hdr_upload_id and tplud.is_active =1
				where tphud.is_active=1 and tphud.month_end_date between '$fromdate_formatted' and '$todate_formatted' and tphud.company_id = $compid
				and tphud.trrn_status in (2,3) AND tphud.main not in (1)
				group by tphud.month_end_date,tphud.ac_2_amount,tphud.ac_21_amount ,tphud.ac_22_amount,
				tphud.trrn_amount ,tphud.ac_1_amount ,tphud.ac_10_amount
				) g
				group by month_end_date
                ) upl on gen.month_end_date =upl.month_end_date
				left join (
				select month_end_date ,sum(epfcont_p) epfcont_p,sum(epscont_p ) epscont_p,sum(epfepsdiff_p) epfepsdiff_p,
				sum(ac2amt_p+ac21amt_p+ac22amt_p) admchgs_p,
				sum(epfcont_p)+sum(epscont_p )+sum(epfepsdiff_p)+sum(ac2amt_p+ac21amt_p+ac22amt_p) total_p
 				from (
				select tphud.month_end_date, sum(tplud.epf_contribution) epfcont_p,sum(tplud.eps_contribution ) epscont_p,
				sum(tplud.epf_eps_diff_contribution ) epfepsdiff_p,
				(tphud.ac_2_amount) ac2amt_p,(tphud.ac_21_amount ) ac21amt_p,(tphud.ac_22_amount ) ac22amt_p,
				tphud.trrn_amount ,tphud.ac_1_amount ,tphud.ac_10_amount
				from EMPMILL12.tbl_pf_hdr_upload_data tphud
				join EMPMILL12.tbl_pf_line_upload_data tplud  on tphud.pf_hdr_upload_id =tplud.pf_hdr_upload_id and tplud.is_active =1
				where tphud.is_active=1 and tphud.month_end_date between '$fromdate_formatted' and '$todate_formatted' and tphud.company_id = $compid
				and tphud.trrn_status in (3) AND tphud.main not in (1)
				group by tphud.month_end_date,tphud.ac_2_amount,tphud.ac_21_amount ,tphud.ac_22_amount,
				tphud.trrn_amount ,tphud.ac_1_amount ,tphud.ac_10_amount
				) g
				group by month_end_date
                ) pay on gen.month_end_date =pay.month_end_date
                order by gen.month_end_date desc";
//echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getSummaryData() {
        $compid = $this->session->userdata('company_id');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');

        // Format dates from dd-mm-yyyy to yyyy-mm-dd
        $fromdate_formatted = substr($fromdate, 6, 4) . '-' . substr($fromdate, 3, 2) . '-' . substr($fromdate, 0, 2);
        $todate_formatted = substr($todate, 6, 4) . '-' . substr($todate, 3, 2) . '-' . substr($todate, 0, 2);

        $records = $this->_getSummaryRecords($fromdate_formatted, $todate_formatted, $compid);

        $data = [];
        foreach ($records as $record) {
            $epfcont_g = $record->epfcont_g ?? 0;
            $epscont_g = $record->epscont_g ?? 0;
            $epfespsdiff_g = $record->epfepsdiff_g ?? 0;
            $admchgs_g = $record->admchgs_g ?? 0;

            $epfcont_d = $record->epfcont_d ?? 0;
            $epscont_d = $record->epscont_d ?? 0;
            $epfespsdiff_d = $record->epfepsdiff_d ?? 0;
            $admchgs_d = $record->admchgs_d ?? 0;

            $epfcont_p = $record->epfcont_p ?? 0;
            $epscont_p = $record->epscont_p ?? 0;
            $epfespsdiff_p = $record->epfepsdiff_p ?? 0;
            $admchgs_p = $record->admchgs_p ?? 0;

 

            if ( $epfcont_d<=0) {
                $epfcont_d=$epfcont_g;
                $admchgs_d=$record->admchgs_g;
            }
            if ($epfcont_d>($epscont_d+$epfespsdiff_d)) {
               $epscont_d=round(($epfcont_d*8.33)/10,0) ;
               $epfespsdiff_d=$epfcont_d-$epscont_d    ;
            }

            $epfcont_od=$epfcont_g - $epfcont_p;
            $epscont_od=$epscont_g - $epscont_p;
            $epfespsdiff_od=$epfespsdiff_g - $epfespsdiff_p;
            $admchgs_od=$admchgs_g - $admchgs_p;


            $epfcont_ou=$epfcont_d - $epfcont_p;
            $epscont_ou=$epscont_d - $epscont_p;
            $epfespsdiff_ou=$epfespsdiff_d - $epfespsdiff_p;
            $admchgs_ou=$admchgs_d - $admchgs_p;

            $epfcont_pu =$epfcont_g - $epfcont_d ;
            $epscont_pu =$epscont_g - $epscont_d ;
            $epfespsdiff_pu =$epfespsdiff_g - $epfespsdiff_d ;
            $admchgs_pu =$admchgs_g - $admchgs_d ;

            $total_g_adm = $epfcont_g + $epscont_g + $epfespsdiff_g + $admchgs_g;
            $total_g = $epfcont_g + $epscont_g + $epfespsdiff_g ;
  
            $total_d_adm=$epfcont_d + $epscont_d + $epfespsdiff_d + $admchgs_d;
            $total_d=$epfcont_d + $epscont_d + $epfespsdiff_d ;
  
            $total_p_adm= $epfcont_p + $epscont_p + $epfespsdiff_p + $admchgs_p;
            $total_p= $epfcont_p + $epscont_p + $epfespsdiff_p;
            
            $total_od=$total_g-$total_p;    
            $total_od_adm=$total_g_adm-$total_p_adm;

            $total_ou=$total_d-$total_p;
            $total_ou_adm=$total_d_adm-$total_p_adm;
            
            $total_pu=$total_g -$total_d;
            $total_pu_adm=$total_g_adm -$total_d_adm;   


 
            
             $data[] = [
                $record->monthenddate,
                $epfcont_g,
                $epscont_g,
                $epfespsdiff_g,
                $admchgs_g,
                $total_g_adm,
                $total_g,

                $epfcont_d ,
                $epscont_d ,
                $epfespsdiff_d ,
                $admchgs_d ,
                $total_d_adm,
                $total_d,

                $epfcont_p ,
                $epscont_p ,
                $epfespsdiff_p,
                $admchgs_p ,
                $total_p_adm,
                $total_p,

                $epfcont_od ?? 0,
                $epscont_od ?? 0,
                $epfespsdiff_od ?? 0,
                $admchgs_od ?? 0,
                $total_od_adm,
                $total_od,

                $epfcont_ou,
                $epscont_ou,
                $epfespsdiff_ou,
                $admchgs_ou,
                $total_ou_adm,
                $total_ou,

                $epfcont_pu ,
                $epscont_pu ,
                $epfespsdiff_pu ,
                $admchgs_pu ,
                $total_p_adm,
                $total_pu
            ];
        }

        echo json_encode(['data' => $data]);
    }

    public function exportSummaryExcel() {
        $compid = $this->session->userdata('company_id');
        $company_name = $this->session->userdata('company_name');
        $fromdate = $this->input->get('fromdate');
        $todate = $this->input->get('todate');

        // Format dates
        $fromdate_formatted = substr($fromdate, 6, 4) . '-' . substr($fromdate, 3, 2) . '-' . substr($fromdate, 0, 2);
        $todate_formatted = substr($todate, 6, 4) . '-' . substr($todate, 3, 2) . '-' . substr($todate, 0, 2);

        $records = $this->_getSummaryRecords($fromdate_formatted, $todate_formatted, $compid);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $filename = 'PF_Summary_Report_' . date('Y-m-d') . '.xlsx';

        // Styles
        $bold16 = [
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $bold12 = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $bold10 = [
            'font' => ['bold' => true, 'size' => 10],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        $greenBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '00FF00']
                ]
            ]
        ];

        // Header rows
        $sheet->mergeCells('A1:AK1');
        $sheet->setCellValue('A1', $company_name);
        $sheet->getStyle('A1')->applyFromArray($bold16);
        $sheet->getStyle('A1:AK1')->applyFromArray($borderStyle);


        $sheet->mergeCells('A2:AK2');
        $sheet->setCellValue('A2', "PF Dues & Outstanding Report for the Period from $fromdate To $todate");
        $sheet->getStyle('A2')->applyFromArray($bold16);
        $sheet->getStyle('A2:AK2')->applyFromArray($borderStyle);

        $rng='b3:g3';
        $txt='PF Deducted';
        $sheet->mergeCells($rng);
        $sheet->setCellValue('b3', $txt);
        
        $rng='h3:m3';
        $txt='PF Uploaded';
        $sheet->mergeCells($rng);
        $sheet->setCellValue('h3', $txt);

        $rng='n3:s3';
        $txt='PF Payment';
        $sheet->mergeCells($rng);
        $sheet->setCellValue('n3', $txt);

        $rng='t3:y3';
        $txt='PF Outstanding As per Deduction';
        $sheet->mergeCells($rng);
        $sheet->setCellValue('t3', $txt);

        $rng='z3:ae3';
        $txt='PF Outstanding As per Upload';
        $sheet->mergeCells($rng);
        $sheet->setCellValue('z3', $txt);

        $rng='af3:ak3';
        $txt='Upload Pending';
        $sheet->mergeCells($rng);
        $sheet->setCellValue('af3', $txt);

        $rng='a3:ak3';
        $sheet->getStyle($rng)->applyFromArray($bold16);
        $sheet->getStyle($rng)->applyFromArray($borderStyle);
        // Wrap text for headers
        $sheet->getStyle('A1:AK4')->getAlignment()->setWrapText(true);


        // Table headers - matching pfsummaryTable exactly
        $headers = ['Month End Date', 'EPF Cont G', 'EPS Cont G', 'EPF EPS Diff G', 'Adm Chgs G', 'Total G_Adm', 'Total G',
            'EPF Cont D', 'EPS Cont D', 'EPF EPS Diff D', 'Adm Chgs D', 'Total D_Adm', 'Total D',
            'EPF Cont P', 'EPS Cont P', 'EPF EPS Diff P', 'Adm Chgs P', 'Total P_Adm', 'Total P',
            'EPF Cont OD', 'EPS Cont OD', 'EPF EPS Diff OD', 'Adm Chgs OD', 'Total OD_Adm', 'Total OD',
            'EPF Cont OU', 'EPS Cont OU', 'EPF EPS Diff OU', 'Adm Chgs OU', 'Total OU_adm', 'Total OU',
            'EPF Cont PU', 'EPS Cont PU', 'EPF EPS Diff PU', 'Adm Chgs PU', 'Total PU_Adm', 'Total PU'];
        $sheet->fromArray($headers, NULL, 'A4');
        $sheet->getStyle('A4:AK4')->applyFromArray($bold12);
        $sheet->getStyle('A4:AK4')->applyFromArray($borderStyle);

        // Data rows
        $row = 5;
        foreach ($records as $record) {
                        $epfcont_g = $record->epfcont_g ?? 0;
            $epscont_g = $record->epscont_g ?? 0;
            $epfespsdiff_g = $record->epfepsdiff_g ?? 0;
            $admchgs_g = $record->admchgs_g ?? 0;

            $epfcont_d = $record->epfcont_d ?? 0;
            $epscont_d = $record->epscont_d ?? 0;
            $epfespsdiff_d = $record->epfepsdiff_d ?? 0;
            $admchgs_d = $record->admchgs_d ?? 0;

            $epfcont_p = $record->epfcont_p ?? 0;
            $epscont_p = $record->epscont_p ?? 0;
            $epfespsdiff_p = $record->epfepsdiff_p ?? 0;
            $admchgs_p = $record->admchgs_p ?? 0;

 

            if ( $epfcont_d<=0) {
                $epfcont_d=$epfcont_g;
                $admchgs_d=$record->admchgs_g;
            }
            if ($epfcont_d>($epscont_d+$epfespsdiff_d)) {
               $epscont_d=round(($epfcont_d*8.33)/10,0) ;
               $epfespsdiff_d=$epfcont_d-$epscont_d    ;
            }

            $epfcont_od=$epfcont_g - $epfcont_p;
            $epscont_od=$epscont_g - $epscont_p;
            $epfespsdiff_od=$epfespsdiff_g - $epfespsdiff_p;
            $admchgs_od=$admchgs_g - $admchgs_p;


            $epfcont_ou=$epfcont_d - $epfcont_p;
            $epscont_ou=$epscont_d - $epscont_p;
            $epfespsdiff_ou=$epfespsdiff_d - $epfespsdiff_p;
            $admchgs_ou=$admchgs_d - $admchgs_p;

            $epfcont_pu =$epfcont_g - $epfcont_d ;
            $epscont_pu =$epscont_g - $epscont_d ;
            $epfespsdiff_pu =$epfespsdiff_g - $epfespsdiff_d ;
            $admchgs_pu =$admchgs_g - $admchgs_d ;

            $total_g_adm = $epfcont_g + $epscont_g + $epfespsdiff_g + $admchgs_g;
            $total_g = $epfcont_g + $epscont_g + $epfespsdiff_g ;
  
            $total_d_adm=$epfcont_d + $epscont_d + $epfespsdiff_d + $admchgs_d;
            $total_d=$epfcont_d + $epscont_d + $epfespsdiff_d ;
  
            $total_p_adm= $epfcont_p + $epscont_p + $epfespsdiff_p + $admchgs_p;
            $total_p= $epfcont_p + $epscont_p + $epfespsdiff_p;
            
            $total_od=$total_g-$total_p;    
            $total_od_adm=$total_g_adm-$total_p_adm;

            $total_ou=$total_d-$total_p;
            $total_ou_adm=$total_d_adm-$total_p_adm;
            
            $total_pu=$total_g -$total_d;
            $total_pu_adm=$total_g_adm -$total_d_adm;   



            $sheet->setCellValue('A' . $row, $record->monthenddate);
            $sheet->setCellValue('B' . $row, $epfcont_g);
            $sheet->setCellValue('C' . $row, $epscont_g);
            $sheet->setCellValue('D' . $row, $epfespsdiff_g);
            $sheet->setCellValue('E' . $row, $admchgs_g);
            $sheet->setCellValue('F' . $row, $total_g_adm);
            $sheet->setCellValue('G' . $row, $total_g);
            $sheet->setCellValue('H' . $row, $epfcont_d);
            $sheet->setCellValue('I' . $row, $epscont_d);
            $sheet->setCellValue('J' . $row, $epfespsdiff_d);
            $sheet->setCellValue('K' . $row, $admchgs_d);
            $sheet->setCellValue('L' . $row, $total_d_adm);
            $sheet->setCellValue('M' . $row, $total_d);
            $sheet->setCellValue('N' . $row, $epfcont_p);
            $sheet->setCellValue('O' . $row, $epscont_p);
            $sheet->setCellValue('P' . $row, $epfespsdiff_p);
            $sheet->setCellValue('Q' . $row, $admchgs_p);
            $sheet->setCellValue('R' . $row, $total_p_adm);
            $sheet->setCellValue('S' . $row, $total_p);
            $sheet->setCellValue('T' . $row, $epfcont_od);
            $sheet->setCellValue('U' . $row, $epscont_od);
            $sheet->setCellValue('V' . $row, $epfespsdiff_od);
            $sheet->setCellValue('W' . $row, $admchgs_od);
            $sheet->setCellValue('X' . $row, $total_od_adm);
            $sheet->setCellValue('Y' . $row, $total_od);
            $sheet->setCellValue('Z' . $row, $epfcont_ou);
            $sheet->setCellValue('AA' . $row, $epscont_ou);
            $sheet->setCellValue('AB' . $row, $epfespsdiff_ou);
            $sheet->setCellValue('AC' . $row, $admchgs_ou);
            $sheet->setCellValue('AD' . $row, $total_ou_adm);
            $sheet->setCellValue('AE' . $row, $total_ou);
            $sheet->setCellValue('AF' . $row, $epfcont_pu);
            $sheet->setCellValue('AG' . $row, $epscont_pu);
            $sheet->setCellValue('AH' . $row, $epfespsdiff_pu);
            $sheet->setCellValue('AI' . $row, $admchgs_pu);
            $sheet->setCellValue('AJ' . $row, $total_pu_adm);
            $sheet->setCellValue('AK' . $row, $total_pu);

            // Check if all outstanding columns are zero
            $outstanding = $epfcont_od + $epscont_od + $epfespsdiff_od + $admchgs_od;
            if ($outstanding == 0) {
                $sheet->getStyle("A{$row}:AK{$row}")->applyFromArray($greenBorderStyle);
            } else {
                $sheet->getStyle("A{$row}:AK{$row}")->applyFromArray($borderStyle);
            }
            $row++;
        }

        // Grand Total row
        $sheet->setCellValue('A' . $row, 'Grand Total');
        $sheet->getStyle("A{$row}:AK{$row}")->applyFromArray($bold10);

        // Add SUM formulas for numeric columns (skip column A which is the label)
        for ($col = 2; $col <= 37; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->setCellValue("{$colLetter}{$row}", "=SUM({$colLetter}5:{$colLetter}" . ($row - 1) . ")");
        }
        $sheet->getStyle("A{$row}:AK{$row}")->applyFromArray($borderStyle);

        // Apply borders to the entire used range
        $sheet->getStyle("A1:AK{$row}")->applyFromArray($borderStyle);

        // Set auto width for all columns
        foreach (range('A', 'AK') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
