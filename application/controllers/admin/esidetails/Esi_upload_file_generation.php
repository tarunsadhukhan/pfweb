<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;	

class Esi_upload_file_generation extends CI_Controller {

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
		$this->load->view('admin/esidetails/Esi_upload_file_generation', $data_to_pass);	
	}


    public function getuanname() {
        $uanno = $this->input->post('uanno');
        $companyId = $this->input->post('companyId');
        $ebno = $this->input->post('ebno');
        
        $sql="select uan_id,name_as_per_pf_online  from  EMPMILL12.tbl_uan_master
        where is_active=1 and uan_no=? and  company_id =? and eb_no<>?"; 
        $query = $this->db->query($sql, array($uanno,$companyId ));
        $records = $query->result();
    //	$query1=$this->db->query($sql);
        $debno='';
        if ( $query->num_rows()>0 ) {
             $row1 = $query->row();
            $debno=$row1->eb_no;
        } else {    
            $debno="";
        
        }	
    
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
                'debno'=>$debno
            );
        } else {
            $response = array(
                'success' => false,
                'name' => $name,
                'uanid' => $uanid,
                'debno'=>$debno
                
            );
        }
    
        echo json_encode($response);
    }
    
    public function getebname() {
        $ebno = $this->input->post('ebno');
        $companyId = $this->input->post('companyId');
        $sql="select emp_code,CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS wname,thep.pf_no,thep.pf_uan_no,thepd.eb_id
        from tbl_hrms_ed_personal_details thepd 
        left join (select eb_id,emp_code from tbl_hrms_ed_official_details theod where is_active=1 ) theod on theod.eb_id=thepd.eb_id 
        left join (select * from tbl_hrms_ed_pf thep where is_active=1 ) thep on theod.eb_id=thep.eb_id
        where theod.emp_code=? and thepd.company_id=?
        "; 
        $query = $this->db->query($sql, array($ebno,$companyId ));
        $records = $query->result();
    //	$query1=$this->db->query($sql);
        $name='';
        if ( $query->num_rows()>0 ) {
             $row1 = $query->row();
            $name=$row1->wname;
            $uanno=$row1->pf_uan_no;
            $pfno=$row1->pf_no;
        } else {    
            $name="";
            $uanno="";
            $pfno="";
        
        }	
        $sql="select uan_id,name_as_per_pf_online  from  EMPMILL12.tbl_uan_master
        where is_active=1 and eb_no=? and  company_id =? "; 
        $query = $this->db->query($sql, array($ebno,$companyId ));
        $records = $query->result();
    //	$query1=$this->db->query($sql);
        $ebfound='';
        if ( $query->num_rows()>0 ) {
             $row1 = $query->row();
            $ebfound=$row1->name_as_per_pf_online;
            $uanid=$row1->uan_id;
        } else {    
            $uanid=0;
            $ebfound="";
        }	
 
                

    
        if ($name) {
            $response = array(
                'success' => true,
                'name' => $name,
                'uanid' => $uanid,
                'ebfound'=>$ebfound,
                'uanno'=>$uanno,
                'pfno'=>$pfno
            );
        } else {
            $response = array(
                'success' => false,
                'name' => $name,
                'uanid' => $uanid,
                'ebfound'=>$ebfound,
                'uanno'=>$uanno,
                'pfno'=>$pfno
                
            );
        }
    
        echo json_encode($response);
    }
 

    public function saveuan_data() {

        $incactdate = $this->input->post('incactdate');
        $uanno = $this->input->post('uanno');
        $rec_time =  date('Y-m-d H:i:s');
        $uanname = $this->input->post('uanname');
        $ebno = $this->input->post('ebno');
        $adharseeded = $this->input->post('adharseeded');
        $uanactive = $this->input->post('uanactive');
        $pfno = $this->input->post('pfno');
        

        $companyId = $this->input->post('companyId');
        $incactdate=substr($incactdate,6,4).'-'.substr($incactdate,3,2).'-'.substr($incactdate,0,2);
        $active=1;
        $qtype=2;
        $entryMode='M';
     
        if ($uanactive==1) {
            $incactdate=Null;
        }
         
        
     $data = array(
        'uan_no' => $uanno,
        'name_as_per_pf_online' => $uanname,
        'pf_no' => $pfno,
        'uan_active' => $uanactive,
        'is_active' => $active,
        'adhar_seeded' => $adharseeded,
        'date_of_uan_inactive' => $incactdate,
        'eb_no' => $ebno,
        'company_id' => $companyId
     
        // Exclude 'id' and 'updated_by' fields
    );
    $this->db->insert('EMPMILL12.tbl_uan_master', $data);
    
    
    $response = array(
    'success' => true,
    'savedata'=> 'saved'
    );
    
        echo json_encode($response);
    
    }
 
    
    public function gen_monthesidata() {

        $pfgendate = $this->input->post('pfgendate');
        $stdate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.'01';
        $mn=substr($pfgendate,3,2);
        $myr=substr($pfgendate,6,4)/4;
        $ld='';
        switch ($mn) {
            case "01":
                $ld = '31';
                break;
            case "02":
                $ld = '28';
                $number = $myr;
                if ($number % 4 == 0) {
                    $ld = '29';
                }
                break;
            case "03":
                $ld = '31';
                break;
            case "04":
                $ld = '30';
                break;
            case "05":
                $ld = '31';
                break;
            case "06":
                $ld = '30';
                break;
            case "07":
                $ld = '31';
                break;
            case "08":
                $ld = '31';
                break;
            case "09":
                $ld = '30';
                break;
            case "10":
                $ld = '31';
                break;
            case "11":
                $ld = '30';
                break;
            case "12":
                $ld = '31';
                break;
            default:
                echo "Invalid day.";
                break;
        }

        $endate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.$ld;
        
        $esimonth=substr($pfgendate,3,2);
        $compid = $this->session->userdata('company_id');
        $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $companyId = $this->input->post('companyId');
        $active=1;
        $qtype=2;
        $entryMode='M';
        

        $sql="select * from EMPMILL12.tbl_esi_upload_hdr_file 
	    where month_end_date ='$pfgendate' and is_active =1 and company_id =$compid ";
        $query = $this->db->query($sql, array($compid,$compid ));
        $records = $query->result();
        $sln=$query->num_rows();
echo 'sln '.$sln;
        if ($sln==0) {           
	
        $sql="insert into EMPMILL12.tbl_esi_upload_hdr_file (month_end_date,no_of_persons,esi_upload_gross,esi_upload_amount,
        company_id
        )
        SELECT '$pfgendate' month_end_date,count(*) cnt,sum(esi_gross) esi_gross,sum(esi_amount) esi_amount ,$compid
        FROM EMPMILL12.tbl_esi_data_geneated_file tedgf 
        where month_end_date ='$pfgendate' and is_active =1 and company_id =$compid ";
            echo $sql;
        $this->db->query($sql);

        $sql="select * from EMPMILL12.tbl_esi_upload_hdr_file 
	    where month_end_date ='$pfgendate' and is_active =1 and company_id =$compid ";
        $query = $this->db->query($sql, array($compid,$compid ));
        $records = $query->result();
        $rcid=0;
        foreach ($records as $record) {
           $rcid= $record->esi_upload_hdr_file_id;
        }        

        echo $rcid;
        $sql="INSERT INTO EMPMILL12.tbl_esi_upload_data_file (esi_data_gen_file_id,esi_upload_hdr_file_id) 
        SELECT tedgf.esi_data_gen_file_id , $rcid hdrid
        FROM EMPMILL12.tbl_esi_data_geneated_file tedgf 
        WHERE tedgf.month_end_date = '$pfgendate'
          AND tedgf.is_active = 1 
          AND tedgf.company_id = $compid";
          $this->db->query($sql);
          $savedata="Data Saved ";
          $success=true;

    } else {    

        $savedata="Already Exists";
        $success=false;

    }
        
    $response = array(
    'success' => $success,
    'savedata'=> $savedata
    );
    
        echo json_encode($response);
    
    }
 


    public function get_esigendata() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
        $esimonth = $this->input->post('pfgendate');
       // $uanno = $this->input->post('uanno');
       $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
 
 //echo 'comp id '.$compid.'  pf '.$pfgendate;

$sql="select * from EMPMILL12.tbl_esi_upload_hdr_file 
where month_end_date ='$pfgendate' and is_active =1 and company_id =$compid

";
  //   echo $sql;
    $query = $this->db->query($sql, array($compid,$compid ));
    $records = $query->result();
    $sln=$query->num_rows();
    $data = [];
        foreach ($records as $record) {
            $data[] = [
                 $record->esi_upload_hdr_file_id,
                $record->month_end_date,
                $record->esi_upload_gross,
                $record->esi_upload_amount,
                $record->esi_online_amount,
                $record->esi_online_payment_amount,
                $record->Payment_date,
                  
     
            ];
         }

 
        // Return the response
        echo json_encode(['data' => $data]);
    }

    public function cancel_monthesidata() {

        $pfgendate = $this->input->post('pfgendate');
         
        $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $companyId = $this->input->post('companyId');
        $active=1;
        $qtype=2;
        $entryMode='M';
        $sln=0;
        $msgno=1;

        

        $sql="select ifnull(esi_online_amount,0) online_esi_amount_payable  
        from EMPMILL12.tbl_esi_upload_hdr_file  
        where month_end_date='$pfgendate' and is_active =1 and company_id=$companyId
        ";
//        echo $sql;
        $query = $this->db->query($sql);
        $records = $query->result();
        foreach ($records as $record) {
                $sln=$record->online_esi_amount_payable;
        }        
      if ($sln>0) {
            $msg="Cannot Cancel , Already Challan Upload file created";
            $msgno=1;
        } else {
        $sql="update EMPMILL12.tbl_esi_upload_hdr_file set is_active=0 where company_id=".$companyId." 
        and month_end_date='".$pfgendate."'";
        $this->db->query($sql);

        $sql="UPDATE EMPMILL12.tbl_esi_upload_data_file tedf
JOIN EMPMILL12.tbl_esi_upload_hdr_file tehf
  ON tedf.esi_upload_hdr_file_id = tehf.esi_upload_hdr_file_id
SET tedf.is_active = 0
WHERE tehf.month_end_date = '$pfgendate' 
  AND tehf.company_id = $companyId";
      $this->db->query($sql);

        $msg="Data Cancel Succesfully";
        $msgno=2;
    }
    
    $response = array(
    'success' => true,
    'savedata'=> $msg,
    'msgno'=> $msgno,
    
    );
    
        echo json_encode($response);
    
    }
 



 
    public function get_esidataexists() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
       $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
  
       $sql="select * from EMPMILL12.tbl_esi_upload_hdr_file 
       where month_end_date ='$pfgendate' and is_active =1 and company_id =$compid
       
       ";
//echo $sql;

                          $query = $this->db->query($sql, array($compid,$compid ));
            $records = $query->result();
            $sln=$query->num_rows();
        
            $response = array(
                'success' => true,
                'savedata'=> 'checked',
                'noofrows'=>$sln
            );
                
                    echo json_encode($response);
                 }
    
 


    public function updateuan_data() {
        $incactdate = $this->input->post('incactdate');
        $uanno = $this->input->post('uanno');
        $rec_time =  date('Y-m-d H:i:s');
        $uanname = $this->input->post('uanname');
        $ebno = $this->input->post('ebno');
        $adharseeded = $this->input->post('adharseeded');
        $uanactive = $this->input->post('uanactive');
        $pfno = $this->input->post('pfno');
        $record_id = $this->input->post('record_id');
         

        $companyId = $this->input->post('companyId');
        $incactdate=substr($incactdate,6,4).'-'.substr($incactdate,3,2).'-'.substr($incactdate,0,2);
        $active=1;
        $qtype=2;
        $entryMode='M';
     
        if ($uanactive==1) {
            $incactdate=Null;
        }
         
        
     $data = array(
        'uan_no' => $uanno,
        'name_as_per_pf_online' => $uanname,
        'pf_no' => $pfno,
        'uan_active' => $uanactive,
        'is_active' => $active,
        'adhar_seeded' => $adharseeded,
        'date_of_uan_inactive' => $incactdate,
        'eb_no' => $ebno,
        'company_id' => $companyId
     
        // Exclude 'id' and 'updated_by' fields
    );   
    $this->db->where('uan_id', $record_id);
    $this->db->update('EMPMILL12.tbl_uan_master', $data);
    
    
    $response = array(
    'success' => true,
    'savedata'=> 'Updated'
    );
    
        echo json_encode($response);
    
    }
    
 


public function gen_excelesidata() {
	// Get the parameters from the URL query string
//	$postData = json_decode(file_get_contents('php://input'), true);
// $this->load->view('admin/reports/pfesidata');


$sdate = $this->input->post('doffrepdate');
$compid = $this->input->post('companyId');

$sdate = $this->input->get('doffrepdate');
$compid = $this->input->get('companyId');



echo 'aha-'.$sdate;

//$sdate='01-06-2023';
//$edate='30-06-2023';
//$compid=2;
//$payScheme = $this->input->GET('payScheme');

//echo 'date-'.$sdate;
 	$date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
    $pfgendate=$date;
  
     $sql="select ip_no,ip_name,tedgf.esi_days,tedgf.esi_gross,tedgf.reason_code,date_format(tedgf.exit_date,'%d-%m-%Y') exit_date from
     EMPMILL12.tbl_esi_upload_data_file tedf
     join EMPMILL12.tbl_esi_data_geneated_file tedgf on tedf.esi_data_gen_file_id=tedgf.esi_data_gen_file_id 
     join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
     where tedf.is_active=1 and tedgf.month_end_date ='$date' and tedgf.company_id =$compid
 ";
        $query = $this->db->query($sql );
        $records = $query->result();
        $sln=$query->num_rows();
	// Create a new Spreadsheet object
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

    $styleArray = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array('argb' => '#000000'),
            ),
        ),
    );
    
    
    $styleArray1 = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                'color' => array('argb' => '#000000'),
            ),
        ),
    );
    
    
    
    $styleArray2 = [
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 90,
            'startColor' => [
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
    

    $cmpn="company";
   
    $cmpn="your company";
	$sheet->setCellValue('A1', 'For the Month of '.$sdate);
//	$active_sheet->setCellValue('A2', "Reports for Dated : ");
	// Set company name
	$companyName = "Your Company Name";
  
	$sheet->setCellValue('A1', 'IP Number ');
	$sheet->setCellValue('b1', 'IP Name');
	$sheet->setCellValue('c1', 'No of Days for which wages paid/payable during the month');
	$sheet->setCellValue('d1', 'Total Monthly Wages');
	$sheet->setCellValue('e1', 'Reason Code for Zero workings days(numeric only; provide 0 for all other reasons- Click on the link for reference)');
	$sheet->setCellValue('f1', 'Last Working Day');
  
    $sheet->getStyle('A1:f1')->getFill()->setFillType(Fill::FILL_SOLID);
$sheet->getStyle('A1:f1')->getFill()->getStartColor()->setARGB('33ffff'); // Red background

$sheet->getStyle('A1:f1')->getAlignment()->setWrapText(true);
$sheet->getStyle('A1:f1')->getFont()->setBold(true);

// Write the spreadsheet to a file
    
	$rowIndex = 2;
	foreach ($records as $record) {
		$columnIndex = 1;
//		foreach ($record as $value) {
            $value=$record->ip_no;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $cll='a'.$rowIndex;
            $sheet->getCell($cll)
            ->setValueExplicit(
                $record->ip_no,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );
      
    
    
            $columnIndex++;
            $value=$record->ip_name;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->esi_days;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $cll='c'.$rowIndex;
            $sheet->getCell($cll)
            ->setValueExplicit(
                $value,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );
    

            $columnIndex++;
            $value=$record->esi_gross;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $cll='d'.$rowIndex;
            $sheet->getCell($cll)
            ->setValueExplicit(
                $value,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );
			$columnIndex++;
            $value=$record->reason_code;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
            $cll='e'.$rowIndex;
            $sheet->getCell($cll)
            ->setValueExplicit(
                $value,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );
			$columnIndex++;
            $value=$record->exit_date;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
    /*
            $cll='f'.$rowIndex;
            $sheet->getCell($cll)
            ->setValueExplicit(
                $value,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            );
			$columnIndex++;
      */      
 
        
      //      $cl='A'.$rowIndex.":f".$rowIndex;
      //      $sheet->getStyle($cl)->applyFromArray($styleArray);
        
        

            //		}
		$rowIndex++;
	}	

 
    
  
	$sheet->getColumnDimension('A')->setWidth(17);
    $sheet->getColumnDimension('b')->setWidth(31);
    $sheet->getColumnDimension('c')->setWidth(28);
    $sheet->getColumnDimension('d')->setWidth(28);
    $sheet->getColumnDimension('e')->setWidth(31);
    $sheet->getColumnDimension('f')->setWidth(31);
    $sheet->setTitle('Sheet1');

     $filename="MC_Template_".$sdate.'.xlsx';
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