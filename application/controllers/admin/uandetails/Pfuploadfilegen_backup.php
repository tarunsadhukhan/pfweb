<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Pfuploadfilegen extends CI_Controller {

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
		$this->load->view('admin/uandetails/Pfuploadfilegen', $data_to_pass);	
	}


    public function getuanname() {
        $uanno = $this->input->post('uanno');
        $companyId = $this->input->post('companyId');
      	
    
        $sql="select uan_id,name_as_per_pf_online  from  EMPMILL12.tbl_uan_master
        where is_active=1 and uan_no=? and  company_id =? "; 
        $query = $this->db->query($sql, array($uanno,$companyId ));
        $records = $query->result();
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
 
 public   function add_months($date) {
//        $sdate=$date('Y-m-d');
        $sdate = $date->format('Y-m-d');
//echo 'start '.$sdate;        
        $mn=substr($sdate,5,2);
        $myr=substr($sdate,0,4);
        $ld='';
        $yr=substr($sdate,0,4);
         $mn++;
      
        if ($mn>12) {$mn=1; $yr++;}
  //      echo 'next month add '.$mn.'=='.$yr.'==='.$myr."</br>" ;
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
//echo 'days ='.$ld;
        $sdate=$yr.'-'.$mn.'-'.$ld;
//      echo 'nnnn '.$sdate;
        $date = new DateTime($sdate);
//echo 'next month '.$date->format('Y-m-d')."</br>";
       
//        $date->modify("+{$months} months");
        
        
        
        return $date->format('Y-m-d');


    }

    function format_date($date) {
      //  $date = new DateTime($date);
        return $date->format('Y-m-d');
    }
    

    public function gen_monthpfupdatan() {
        echo 'kakak';

        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        $tableDataArray = json_decode($tableData, true);
        $pfgendate=$upfromdate;
        $start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
    
        $pfgendate=$uptodate;
        $end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $mbno=0;

        $current_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);
        
    }


    public function gen_createpfupdata() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        // Decode the JSON data
        $tableDataArray = json_decode($tableData, true);
//    var_dump($tableDataArray);
        // Process the data as needed
    $pfgendate=$upfromdate;
    $start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

    $pfgendate=$uptodate;
    $end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
    $mbno=0;
    $msg='NA';
    $batchpnos='';
    $current_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);
//echo $current_date->format('Y-m-d');  // Example output: 2025-10-20
//echo "<br>";
//echo $end_date->format('Y-m-d');
    
      $gdate= $current_date->format('Y-m-d') ; // Output the month
      $pfmonth = $current_date->format('m'); // Get month
      $pfyear = $current_date->format('Y');  // Get year
      $pfdays = $current_date->format('d');  // Get day

//      --  1 all emp uploaded for both   1  - 1  11
  //    --  2 some emp uploaded for both  2  - 1  21 
  //    --  3 all emp uploaded for epf cont 1 -2  12
  //    --  4 some emp uploaded for epf cont 2 -2 22
  //    --  5 all emp uploaded for eps cont 1 -3  13 
  //    --  6 some emp uploaded for eps cont 2 -3 23 


//  echo date("Y-m-d H:i:s");
            echo $gdate;

            $sql="select pf_hdr_upload_id from EMPMILL12.tbl_pf_hdr_upload_data where month_end_date='$gdate' 
            and trrn_type=$upshare and company_id=$companyId and is_active=1 and trrn_status in (2,3) ";
//echo $sql;
            $query = $this->db->query($sql);
            $records = $query->result();
            $row1 = $query->row();
            if ( $query->num_rows()>0 ) {
                $response = array(
                    'success' => false,
                    'savedata'=> 'PF Upload Data Already Created for the Month',
                    'batchno'=> $batchpnos,
                    );
                    
                        echo json_encode($response);
                        return;
            }
  
               if ($gdate<='2025-08-31') {
        $main=0;
    } else {$main=1; }



            $sql="insert into EMPMILL12.tbl_pf_hdr_upload_data (
            trrn_amount,
            trrn_status,
            month_end_date,
            ac_1_amount,
            ac_2_amount,
            ac_10_amount,
            ac_21_amount,
            ac_22_amount,
            trrn_type,
            is_active,
            company_id,batch_process_no,main ) 
            select 0 tramt,2 stat,'$gdate',0 ac1,0 ac2,0 ac10,0 ac21,0 ac22,$upshare,1 act,$companyId,
            (select ifnull(max(batch_process_no),0)+1 mbatchno from EMPMILL12.tbl_pf_hdr_upload_data),$main " ;
            $query = $this->db->query($sql);
  //          echo date("Y-m-d H:i:s");
            
            $sql="select max(pf_hdr_upload_id) maxpfhdrid,max(batch_process_no) mbatchno from EMPMILL12.tbl_pf_hdr_upload_data ";
            $query = $this->db->query($sql);
            $records = $query->result();
            $ebfound='';
            $row1 = $query->row();
            $maxpfhdrid=$row1->maxpfhdrid;
            
                $mbno=$row1->mbatchno;
                    $batchpnos=$batchpnos.",".$mbno;

                    $this->genpfup11($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid);    

        $sql="select sum(epf_contribution) epf_contribution,sum(eps_contribution) eps_contribution,sum(epf_eps_diff_contribution) epf_eps_diff_contribution,
        sum(epf_contribution+eps_contribution+epf_eps_diff_contribution) pfcont,
        case when sum(epf_contribution)>0 then round(sum(epf_wages)*1/100,0)  else 0 end admchgs from EMPMILL12.tbl_pf_line_upload_data 
        where pf_hdr_upload_id=$maxpfhdrid";
    //    echo $sql;
        $query = $this->db->query($sql);
            $records = $query->result();
            $ebfound='';
            $row1 = $query->row();
            $trnamt=$row1->pfcont+$row1->admchgs;
            $epfcont=$row1->epf_contribution+round($row1->eps_contribution*1.67/10,0);
            $epscont=round($row1->eps_contribution*8.33/10,0) ;
            $epfdiffcont=$row1->eps_contribution-$epscont;
            
            if ($trnamt>0) {
                $sqlu="update EMPMILL12.tbl_pf_hdr_upload_data set trrn_amount=$trnamt,
                ac_1_amount=$epfcont,
                ac_10_amount=$epscont,
                ac_2_amount=round($row1->admchgs/2,0),
                ac_21_amount=round($row1->admchgs/2,0)
                where pf_hdr_upload_id=$maxpfhdrid";    
                $query = $this->db->query($sqlu);
            }   else 
            {
                $sqlu="update EMPMILL12.tbl_pf_hdr_upload_data set trrn_status=4  where pf_hdr_upload_id=$maxpfhdrid";    
                
            } 



    $response = array(
    'success' => true,
    'savedata'=> $msg,
    'batchno'=> $batchpnos,
    );
    
        echo json_encode($response);




                }
    

        public function gen_monthpfupdatapy() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        // Decode the JSON data
        $tableDataArray = json_decode($tableData, true);
//    var_dump($tableDataArray);
        // Process the data as needed
    $pfgendate=$upfromdate;
    $start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

    $pfgendate=$uptodate;
    $end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
    $mbno=0;
    $msg='NA';
    $batchpnos='';
    $current_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);
 
    $pfprvdate= '2025-08-31';
    
    $periodfromdate= $start_date;
    $periodtodate  = $end_date;         
    $excfilename="pfuploadgen.py";
    $excfilename="pfupdgen.py";
        $python     = $this->config->item('python_bin', 'python');
        if (empty($python)) {
            // fallback to system python if config not set
            $python = 'python';
        }
    $scriptPath = FCPATH . "Python\\".$excfilename;

        $payload = json_encode([
            "periodfromdate" => $periodfromdate,
            "periodtodate"   => $periodtodate,
            "company_id"     => (int)$companyId,
            "upshare"     => (int)$upshare,
            "upallsel"     => (int)$upallsel,
            "tableData"     => $tableDataArray
        ], JSON_UNESCAPED_SLASHES);

        $cmd = "\"$python\" \"$scriptPath\"";

$descriptorspec = [
    0 => ["pipe", "r"], // stdin
    1 => ["pipe", "w"], // stdout
    2 => ["pipe", "w"], // stderr
];

$process = proc_open($cmd, $descriptorspec, $pipes);

//echo 'Processing...';   


if (!is_resource($process)) {
    echo json_encode(["success"=>false, "reason"=>"Unable to start python"]);
    return;
}

fwrite($pipes[0], $payload);
fclose($pipes[0]);

$stdout = stream_get_contents($pipes[1]);
fclose($pipes[1]);

$stderr = stream_get_contents($pipes[2]);
fclose($pipes[2]);

$exitCode = proc_close($process);

// Try to decode full stdout as JSON. If that fails, try the last line (common when debug prints precede JSON).


 
/* $respn = json_encode($decoded, JSON_UNESCAPED_SLASHES);
echo $respn;

$respn = json_encode($decoded, JSON_UNESCAPED_SLASHES);
 */$decoded = json_decode($stdout, true);

if ($decoded === null) {
    // try last line (in case of debug text before JSON)
    $lines = preg_split("/\r\n|\n|\r/", trim($stdout));
    $last  = end($lines);
    $maybe = json_decode($last, true);

    if ($maybe !== null) {
        $decoded = $maybe;
    } else {
        // fallback so $decoded is ALWAYS defined
        $decoded = [
            'status'       => 'error',
            'message'      => 'Invalid JSON from Python',
            'raw_stdout'   => $stdout,
            'stderr'       => $stderr,
            'exit_code'    => $exitCode
        ];
    }
}

// ---- NOW $decoded IS GUARANTEED TO EXIST ----

// Expecting python to return something like:
// { "status": "processed", "processmonth": [], "companyId": 2, "upshare": 1, "upsel": 2 }

$response = [
    'success'      => true,
    'status'       => isset($decoded['status']) ? $decoded['status'] : null,
    'processmonth' => isset($decoded['processmonth']) ? $decoded['processmonth'] : [],
    'batchno'      => $batchpnos ?? '',
    'python_stderr'=> $stderr,
    'python_exit'  => $exitCode
];

// 🔴 IMPORTANT: echo ONLY ONE JSON here
echo json_encode($response);
}

    public function gen_monthpfupdata() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        // Decode the JSON data
        $tableDataArray = json_decode($tableData, true);
//    var_dump($tableDataArray);
        // Process the data as needed
    $pfgendate=$upfromdate;
    $start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

    $pfgendate=$uptodate;
    $end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
    $mbno=0;
    $msg='NA';
    $batchpnos='';
    $current_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);
 
    $pfprvdate= '2025-08-31';
    

    while ($current_date <= $end_date) {
        $gdate= $current_date->format('Y-m-d') ; // Output the month
        $pfmonth = $current_date->format('m'); // Get month
        $pfyear = $current_date->format('Y');  // Get year
        $pfdays = $current_date->format('d');  // Get day

//      --  1 all emp uploaded for both   1  - 1  11
  //    --  2 some emp uploaded for both  2  - 1  21 
  //    --  3 all emp uploaded for epf cont 1 -2  12
  //    --  4 some emp uploaded for epf cont 2 -2 22
  //    --  5 all emp uploaded for eps cont 1 -3  13 
  //    --  6 some emp uploaded for eps cont 2 -3 23 


//  echo date("Y-m-d H:i:s");
            $curhdrid=0;

            
            $sql="select pf_hdr_upload_id from EMPMILL12.tbl_pf_hdr_upload_data where month_end_date='$gdate' 
            and trrn_type=$upshare and company_id=$companyId and is_active=1 and trrn_status in (2,3)";  
            $query = $this->db->query($sql);
            $records = $query->result();
            $row1 = $query->row();
            $cnt=$query->num_rows();
            echo $cnt.'--'.$sql;
            if ( $cnt>0 ) {
                $curhdrid=$row1->pf_hdr_upload_id; 
            } else {
            if ($gdate>$pfprvdate) {
                $curhdrid=0;
                $msg="Create All Data for the Month First";
                $response = array(
                'success' => false,
                'savedata'=> $msg,
                'batchno'=> 0,
                );
                echo json_encode($response);
                return;
            }    
            }     
 
            if ($upshare==1) {
                $trtp='1';
             }
            if ($upshare==2) {
                $trtp='1,2';
             }
            if ($upshare==3) {
                $trtp='1,3';
             }
             $ocnt=0;
             $ccnt=0;
             if ($gdate<=$pfprvdate) {
                $sql="SELECT
                    tpg.*,
                    NULL AS puanid
                FROM EMPMILL12.tbl_pf_generation tpg
                JOIN EMPMILL12.tbl_uan_master tum
                    ON tum.uan_id = tpg.uan_id
                WHERE
                    tpg.month_end_date = '$gdate'
                    AND tpg.is_active = 1
                    AND tpg.company_id = $companyId
                    AND tum.adhar_seeded = 1
                    AND NOT EXISTS (
                        SELECT 1
                        FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                        JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                            ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                        AND tplud.is_active = 1
                        WHERE
                            tphud.trrn_status IN (2,3)
                            AND tphud.company_id = $companyId
                            AND tphud.trrn_type IN ($trtp)
                            AND tphud.is_active = 1
                            AND tphud.month_end_date = '$gdate'
                            AND tplud.uan_id = tpg.uan_id
                    )
                ";
                $query = $this->db->query($sql);
                $records = $query->result();
                $row1 = $query->row();
                $ocnt=$query->num_rows();
            //    $curhdrid=0;
            } else {
                $curhdrid=0;
                $sql="SELECT
                    main.*,
                    supp.puanid
                FROM
                (
                    SELECT
                        tphud.month_end_date,
                        tplud.*
                    FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                    JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                        ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                    AND tplud.is_active = 1
                    WHERE
                        tphud.trrn_status IN (2,3)
                        AND tphud.company_id = $companyId
                        AND tphud.is_active = 1
                        AND tphud.month_end_date = '$gdate'
                        AND tphud.main = 1
                ) AS main
                LEFT JOIN
                (
                    SELECT DISTINCT
                        tphud.month_end_date,
                        tplud.uan_id AS puanid
                    FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                    JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                        ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                    AND tplud.is_active = 1
                    WHERE
                        tphud.trrn_status IN (2,3)
                        AND tphud.company_id = $companyId
                        AND tphud.trrn_type IN ($trtp)
                        AND tphud.month_end_date = '$gdate'
                        AND tphud.main <> 1
                ) AS supp
                    ON main.month_end_date = supp.month_end_date
                AND main.uan_id = supp.puanid
                                ";
//                                echo 'check cover '.$sql;
                                $query = $this->db->query($sql);
                                $records = $query->result();
                                $row1 = $query->row();
                                $ccnt=$query->num_rows();
                            //    $curhdrid=0;
                                
            }
             echo 'ocnt='.$ocnt.'--ccnt='.$ccnt;   

            if (($ocnt+$ccnt)==0) {
                $msg="Already All Data Generated/No PF Generation Data Found for the Month";
                $response = array(
                'success' => false,
                'savedata'=> $msg,
                'batchno'=> 0,
                );
                echo json_encode($response);
                return;
            }     
 

            $sql="insert into EMPMILL12.tbl_pf_hdr_upload_data (
            trrn_amount,
            trrn_status,
            month_end_date,
            ac_1_amount,
            ac_2_amount,
            ac_10_amount,
            ac_21_amount,
            ac_22_amount,
            trrn_type,
            is_active,
            company_id,batch_process_no,main ) 
            select 0 tramt,2 stat,'$gdate',0 ac1,0 ac2,0 ac10,0 ac21,0 ac22,$upshare,1 act,$companyId,
            (select ifnull(max(batch_process_no),0)+1 mbatchno from EMPMILL12.tbl_pf_hdr_upload_data),9 " ;
            $query = $this->db->query($sql);
  //          echo date("Y-m-d H:i:s");
            
            $sql="select max(pf_hdr_upload_id) maxpfhdrid,max(batch_process_no) mbatchno from EMPMILL12.tbl_pf_hdr_upload_data ";
            $query = $this->db->query($sql);
            $records = $query->result();
            $ebfound='';
            $row1 = $query->row();
            $maxpfhdrid=$row1->maxpfhdrid;
            $mbno=$row1->mbatchno;
            $batchpnos=$batchpnos.",".$mbno;


            //        echo $maxpfhdrid;
    //    echo date("Y-m-d H:i:s");
 


        if ($upallsel==1) {
                if ($upshare==1) {
                    $this->genpfup111($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$pfprvdate,$curhdrid);    
                } 
                if ($upshare==2) {
                    echo 'working '.$curhdrid;
                    $this->genpfup12($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$pfprvdate,$curhdrid);    
                } 
                if ($upshare==3) {
                    $this->genpfup13($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$pfprvdate,$curhdrid);
                } 

        }
        
        if ($upallsel==2) {
            if ($upshare==1) {
                genpfup21($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$tableDataArray);;    
            } 
            if ($upshare==2) {
                echo 'working';
                genpfup22($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$tableDataArray);;    
            } 
            if ($upshare==3) {
                genpfup23($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$tableDataArray);;    
            } 


        }
      //  echo date("Y-m-d H:i:s");

        $sql="select sum(epf_contribution) epf_contribution,sum(eps_contribution) eps_contribution,sum(epf_eps_diff_contribution) epf_eps_diff_contribution,
        sum(epf_contribution+eps_contribution+epf_eps_diff_contribution) pfcont,
        case when sum(epf_contribution)>0 then round(sum(gross_wages)*1/100,0)  else 0 end 
        admchgs from EMPMILL12.tbl_pf_line_upload_data 
        where pf_hdr_upload_id=$maxpfhdrid";
  //      echo $sql;
            $query = $this->db->query($sql);
            $records = $query->result();
            $ebfound='';
            $row1 = $query->row();
            $trnamt=$row1->pfcont+$row1->admchgs;
            $epfcont=$row1->epf_contribution+round($row1->eps_contribution*1.67/100,0);
            $epscont=round($row1->eps_contribution*8.33/100,0) ;
            $epfdiffcont=$row1->eps_contribution-$epscont;
            
            if ($trnamt>0) {
                $sqlu="update EMPMILL12.tbl_pf_hdr_upload_data set trrn_amount=$trnamt,
                ac_1_amount=$epfcont,
                ac_10_amount=$epscont,
                ac_2_amount=round($row1->admchgs/2,0),
                ac_21_amount=round($row1->admchgs/2,0)
                where pf_hdr_upload_id=$maxpfhdrid";    
                $query = $this->db->query($sqlu);
            }   else 
            {
                $sqlu="update EMPMILL12.tbl_pf_hdr_upload_data set trrn_status=4  where pf_hdr_upload_id=$maxpfhdrid";    
                $query = $this->db->query($sqlu);
                
            } 
//            echo $sqlu;
      //  echo date("Y-m-d H:i:s");


    $current_date = $this->add_months($current_date);
    $current_date = new DateTime($current_date);
     
//echo 'add month '.$current_date->format('Y-m-d');  // Example output: 2025-10-20
//echo "<br>";
//echo $end_date->format('Y-m-d');



    }

    $msg='PF Upload Data Generated Successfully';
//echo 'all compe';
    $response = array(
    'success' => true,
    'savedata'=> $msg,
    'batchno'=> $batchpnos,
    );
    
        echo json_encode($response);


} 

function  genpfup11($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid)   {
    $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
             SELECT $maxpfhdrid,
    tpg.uan_id,
    tum.uan_no,
    tpg.gross_wages,
    tpg.epf_wages,
    eps_wages,
     edli_wages,
     epf_contibution,
    eps_contribution,
     epf_eps_diff_contribution,
     ncp_days,
    tpg.pf_gen_id,
    1 AS active 
  FROM EMPMILL12.tbl_pf_generation AS tpg
  LEFT JOIN EMPMILL12.tbl_uan_master AS tum
    ON tpg.uan_id = tum.uan_id
  LEFT JOIN (
  SELECT
      tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epfcontribution from EMPMILL12.tbl_pf_line_upload_data AS tplud
      where tplud.is_active=1  
      group by tplud.pf_gen_id,tplud.uan_id
  )  x   
    ON x.pf_gen_id = tpg.pf_gen_id 
   WHERE tpg.month_end_date = '$gdate'
    AND tum.adhar_seeded   = 1
    AND tpg.company_id     = $companyId
    AND tpg.is_active      = 1
    and x.epfcontribution is null";


    
  $this->db->query($sql);

}

function  genpfup111($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$pfprvdate,$curhdrid)   {


if ($gdate <= $pfprvdate) { 
    $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
             SELECT $maxpfhdrid,
    tpg.uan_id,
    tum.uan_no,
    tpg.gross_wages,
    tpg.epf_wages,
    eps_wages,
     edli_wages,
     epf_contibution,
    eps_contribution,
     epf_eps_diff_contribution,
     ncp_days,
    tpg.pf_gen_id,
    1 AS active
  FROM EMPMILL12.tbl_pf_generation AS tpg
  LEFT JOIN EMPMILL12.tbl_uan_master AS tum
    ON tpg.uan_id = tum.uan_id
  LEFT JOIN (
  SELECT
      tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epfcontribution from EMPMILL12.tbl_pf_line_upload_data AS tplud
      where tplud.is_active=1  
      group by tplud.pf_gen_id,tplud.uan_id
  )  x   
    ON x.pf_gen_id = tpg.pf_gen_id 
   WHERE tpg.month_end_date = '$gdate'
    AND tum.adhar_seeded   = 1
    AND tpg.company_id     = $companyId
    AND tpg.is_active      = 1
    and x.epfcontribution is null";
//echo 'prev '.$pfprvdate.'='.$gdate;

} else {

    	            $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
select tpg.* from (                    SELECT $maxpfhdrid,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active from EMPMILL12.tbl_pf_line_upload_data where  pf_hdr_upload_id = $curhdrid
                    ) as tpg
  					LEFT JOIN (
					SELECT
      				tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epfcontribution 
      				from EMPMILL12.tbl_pf_line_upload_data AS tplud
      				left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id 
      				where tplud.is_active=1  and ifnull(tphud.main,0)>0 
      				group by tplud.pf_gen_id,tplud.uan_id
  )  x   on x.pf_gen_id = tpg.pf_gen_id and x.uanid=tpg.uan_id
   WHERE x.epfcontribution is null ";
//echo 'next '.$pfprvdate.'='.$gdate;

}


  $this->db->query($sql);
}




function  genpfup12($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$pfprvdate,$curhdrid)   {
if ($gdate<= $pfprvdate ) {
        echo '1st less date';        
    $sql="INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
        pf_hdr_upload_id,
        uan_id,
        uan_no,
        gross_wages,
        eps_wages,
        edli_wages,
        epf_contribution,
        eps_contribution,
        epf_eps_diff_contribution,
        ncp_days,
        pf_gen_id,
        is_active
    )
            SELECT
                $maxpfhdrid                                           AS pf_hdr_upload_id,
                tpg.uan_id,
                tum.uan_no,
                tpg.gross_wages,
                0                                              AS eps_wages,
                0                                              AS edli_wages,
                ROUND(tpg.gross_wages * 0.10, 0)           AS epf_contribution,
                0                                              AS eps_contribution,
                0                                              AS epf_eps_diff_contribution,
                tpg.ncp_days,
                tpg.pf_gen_id,
                1                                              AS is_active
            FROM EMPMILL12.tbl_pf_generation tpg
            JOIN EMPMILL12.tbl_uan_master tum
                ON tum.uan_id = tpg.uan_id
            WHERE
                tpg.month_end_date = '2023-10-31'
                AND tpg.is_active = 1
                AND tpg.company_id = 2
                AND tum.adhar_seeded = 1
                AND NOT EXISTS (
                    SELECT 1
                    FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                    JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                        ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                    AND tplud.is_active = 1
                    WHERE
                        tphud.trrn_status IN (2, 3)
                        AND tphud.company_id = 2
                        AND tphud.trrn_type IN (1, 2)
                        AND tphud.is_active = 1
                        AND tphud.month_end_date = tpg.month_end_date
                        AND tplud.uan_id = tpg.uan_id
                )";
            //                    and pf_hdr_upload_id = $curhdrid

                } else 
{
                            echo '2nd1st nect date';        

    $sql="INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
        pf_hdr_upload_id,
        uan_id,
        uan_no,
        gross_wages,
        eps_wages,
        edli_wages,
        epf_contribution,
        eps_contribution,
        epf_eps_diff_contribution,
        ncp_days,
        pf_gen_id,
        is_active
    )
select tpg.* from (
                    SELECT $maxpfhdrid,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    0 eps_wages,
                    0 edli_wages,
                    epf_contribution,
                    0 eps_contribution,
                    0 epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active from EMPMILL12.tbl_pf_line_upload_data where  pf_hdr_upload_id = $curhdrid
                    ) as tpg
  					LEFT JOIN (
					SELECT
      				tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epfcontribution 
      				from EMPMILL12.tbl_pf_line_upload_data AS tplud
      				left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id 
      				where tplud.is_active=1  and ifnull(tphud.main,0)>0 
      				group by tplud.pf_gen_id,tplud.uan_id
  )  x   on x.pf_gen_id = tpg.pf_gen_id and x.uanid=tpg.uan_id
   WHERE x.epfcontribution is null ";

}

echo $sql;
$query = $this->db->query($sql);
}

function  genpfup13($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$maxpfhdrid,$pfprvdate,$curhdrid)   {
if ($pfprvdate <= $gdate) {        
    $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
               SELECT $maxpfhdrid,
    tpg.uan_id,
    tum.uan_no,
    tpg.gross_wages,
    tpg.epf_wages,
    eps_wages,
    0 edli_wages,
    0 epf_contibution,
    eps_contribution,
    epf_eps_diff_contribution,
    0 ncp_days,
    tpg.pf_gen_id,
    1 AS active 
  FROM EMPMILL12.tbl_pf_generation AS tpg
  LEFT JOIN EMPMILL12.tbl_uan_master AS tum
    ON tpg.uan_id = tum.uan_id
  LEFT JOIN (
  SELECT
      tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.eps_contribution) epscontribution from EMPMILL12.tbl_pf_line_upload_data AS tplud
      where tplud.is_active=1  
      group by tplud.pf_gen_id,tplud.uan_id
  )  x   
    ON x.pf_gen_id = tpg.pf_gen_id 
   WHERE tpg.month_end_date = '$gdate'
    AND tum.adhar_seeded   = 1
    AND tpg.company_id     = $companyId
    AND tpg.is_active      = 1
    and x.epscontribution is null";

} else {
    	            $sql="select tpg.* from (
                    SELECT $maxpfhdrid,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    0 edli_wages,
                    0 epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    0 ncp_days,
                    pf_gen_id,
                    is_active from EMPMILL12.tbl_pf_line_upload_data where  pf_hdr_upload_id = $curhdrid
                    ) as tpg
  					LEFT JOIN (
                    SELECT
      				tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.eps_contribution) epscontribution 
      				from EMPMILL12.tbl_pf_line_upload_data AS tplud
      				left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id 
      				where tplud.is_active=1  and ifnull(tphud.main,0)>0 
      				group by tplud.pf_gen_id,tplud.uan_id) x   on x.pf_gen_id = tpg.pf_gen_id and x.uanid=tpg.uan_id
                    where x.epscontribution is null
                    ";

                }

$query = $this->db->query($sql);

}


function  genpfup21($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$tableDataArray)   {
        
    $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
             SELECT $maxpfhdrid,
    tpg.uan_id,
    tum.uan_no,
    tpg.gross_wages,
    tpg.epf_wages,
    eps_wages,
     edli_wages,
     epf_contibution,
    eps_contribution,
     epf_eps_diff_contribution,
     ncp_days,
    tpg.pf_gen_id,
    1 AS active 
  FROM EMPMILL12.tbl_pf_generation AS tpg
  LEFT JOIN EMPMILL12.tbl_uan_master AS tum
    ON tpg.uan_id = tum.uan_id
  LEFT JOIN (
  SELECT
      tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epfcontribution from EMPMILL12.tbl_pf_line_upload_data AS tplud
      where tplud.is_active=1  
      group by tplud.pf_gen_id,tplud.uan_id
  )  x   
    ON x.pf_gen_id = tpg.pf_gen_id 
   WHERE tpg.month_end_date = '$gdate'
    AND tum.adhar_seeded   = 1
    AND tpg.company_id     = $companyId
    AND tpg.is_active      = 1
    and x.epfcontribution is null
    and tum.uan_id in ($tableDataArray)";

    $this->db->query($sql);
      
    
}

function  genpfup22($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$tableDataArray)   {
        
    $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
             SELECT $maxpfhdrid,
    tpg.uan_id,
    tum.uan_no,
    tpg.gross_wages,
    tpg.epf_wages,
    0 eps_wages,
     edli_wages,
     epf_contibution,
    0 eps_contribution,
    0 epf_eps_diff_contribution,
     ncp_days,
    tpg.pf_gen_id,
    1 AS active 
  FROM EMPMILL12.tbl_pf_generation AS tpg
  LEFT JOIN EMPMILL12.tbl_uan_master AS tum
    ON tpg.uan_id = tum.uan_id
  LEFT JOIN (
  SELECT
      tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epfcontribution from EMPMILL12.tbl_pf_line_upload_data AS tplud
      where tplud.is_active=1  
      group by tplud.pf_gen_id,tplud.uan_id
  )  x   
    ON x.pf_gen_id = tpg.pf_gen_id 
   WHERE tpg.month_end_date = '$gdate'
    AND tum.adhar_seeded   = 1
    AND tpg.company_id     = $companyId
    AND tpg.is_active      = 1
    and x.epfcontribution is null
    and tum.uan_id in ($tableDataArray)";

    $this->db->query($sql);
      
    
}
 

function  genpfup23($companyId,$pfmonth,$pfyear,$pfdays,$gdate,$upshare,$tableDataArray)   {
        
    $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
             SELECT $maxpfhdrid,
    tpg.uan_id,
    tum.uan_no,
    tpg.gross_wages,
    tpg.epf_wages,
    eps_wages,
    0 edli_wages,
    0 epf_contibution,
     eps_contribution,
     epf_eps_diff_contribution,
    0 ncp_days,
    tpg.pf_gen_id,
    1 AS active
  FROM EMPMILL12.tbl_pf_generation AS tpg
  LEFT JOIN EMPMILL12.tbl_uan_master AS tum
    ON tpg.uan_id = tum.uan_id
  LEFT JOIN (
  SELECT
      tplud.pf_gen_id  ,tplud.uan_id uanid,sum(tplud.epf_contribution) epscontribution from EMPMILL12.tbl_pf_line_upload_data AS tplud
      where tplud.is_active=1  
      group by tplud.pf_gen_id,tplud.uan_id
  )  x   
    ON x.pf_gen_id = tpg.pf_gen_id 
   WHERE tpg.month_end_date = '$gdate'
    AND tum.adhar_seeded   = 1
    AND tpg.company_id     = $companyId
    AND tpg.is_active      = 1
    and x.epscontribution is null
    and tum.uan_id in ($tableDataArray)";

    $this->db->query($sql);
      
    
}





    public function gen_monthpfupdataold() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        // Decode the JSON data
        $tableDataArray = json_decode($tableData, true);
//    var_dump($tableDataArray);
        // Process the data as needed
    $pfgendate=$upfromdate;
    $start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

    $pfgendate=$uptodate;
    $end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
$mbno=0;
$msg='NA';

$batchpnos='';
    $current_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);
    while ($current_date <= $end_date) {
    $gdate= $current_date->format('Y-m-d') ; // Output the month
      $pfmonth = $current_date->format('m'); // Get month
      $pfyear = $current_date->format('Y');  // Get year
      $pfdays = $current_date->format('d');  // Get day
      
//echo $pfmonth.'=='.$pfyear.'==='.$pfdays;

  //  echo "The time is " . date("h:i:sa")."</br>";
    $cm=",";			
    //check already data uploded or not (if not calculate figure)
        $msg ='upload only';
    if ($upallsel==1) {
        //all uan
            $sql="select 	ifnull(sum(epf_contibution),0) epf_contibution,
            ifnull(sum(eps_contribution),0) eps_contribution,
            ifnull(sum(epf_eps_diff_contribution),0) epf_eps_diff_contribution
            from (
            SELECT tpg.*, pf_line_upload_id  
            FROM EMPMILL12.tbl_pf_generation tpg
            LEFT JOIN (
            select tplud.pf_line_upload_id,tplud.uan_id,tphud.month_end_date,tphud.trrn_status,tphud.trrn_type  
            from EMPMILL12.tbl_pf_line_upload_data tplud
            left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
            where tphud.is_active = 1 
                    AND tphud.trrn_status IN (2, 3) and trrn_type in (1,$upshare) and month_end_date='$gdate'
            ) tplud on tpg.month_end_date =tplud.month_end_date and tpg.uan_id=tplud.uan_id
            left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id
            where tpg.month_end_date ='$gdate' and tum.adhar_seeded =1 and tpg.company_id=$companyId and tpg.is_active=1
            ) g where pf_line_upload_id is null ";
            
            $sql="select tpg.*,tum.uan_no,tplud.uanid   from EMPMILL12.tbl_pf_generation tpg
            left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id
            left join ( select  tplud.uan_id uanid,tphud.month_end_date  from EMPMILL12.tbl_pf_line_upload_data tplud 
            left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id 
            and tphud.is_active = 1   AND tphud.trrn_status IN (2, 3) and trrn_type in (1,$upshare) ) tplud on tpg.uan_id =tplud.uanid
            and tpg.month_end_date =tplud.month_end_date
            where tpg.month_end_date ='$gdate' and tum.adhar_seeded =1 and tpg.company_id=$companyId and tpg.is_active=1
 			and tplud.uanid is null";
            $query = $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
            $records = $query->result();
            $ebfound='';
            $row1 = $query->row();
                $ac1=$ac10=$ac21=$ac22=$ac2=0;
                if ( $row1->epf_contibution>0 ) {
                    $epf=$row1->epf_contibution;
                    $eps=$row1->eps_contribution;
                    $epdf=$row1->epf_eps_diff_contribution;
                    if  ($upshare==1) { 
                        $ac2=round(($epf+$eps+$epdf)*.5/100,0);
                        $ac21=$ac2;
                        $tamt=$epf+$eps+$epdf+$ac2+$ac21;
                        $ac1=$epf+$epdf;
                        $ac10=$eps;
  //                      echo $ac1.' ==1==';
                    }     
                    if  ($upshare==2) { 
                        $ac2=0;
                        $ac21=0;    
                        $tamt=$epf;
                        $ac1=$epf;
                        $ac10=0;
    //                    echo $ac1.' ==2==';
                    }     
                    if  ($upshare==3) { 
                        $ac2=0;
                        $ac21=0;    
                        $tamt=$eps+$epdf;
                        $ac1=$epdf;
                        $ac10=$eps;
      //                  echo $ac1.' ==3==';
                    }     
                    }       
//                    echo $ac1.' ==123=='.$upshare;

            if ($ac1==0) {          
                    $msg="No Data Found to Upload";
    //                echo "The time is " . date("h:i:sa")."</br>";
                } else {
                $sql="select ifnull(max(batch_process_no),0)+1 mbatchno from EMPMILL12.tbl_pf_hdr_upload_data";
                $query = $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
                $records = $query->result();
                $ebfound='';
                $row1 = $query->row();
                $mbno=$row1->mbatchno;
                    $batchpnos=$batchpnos.",".$mbno;
                $sql="insert into EMPMILL12.tbl_pf_hdr_upload_data (
                    trrn_amount,
                    trrn_status,
                    month_end_date,
                    ac_1_amount,
                    ac_2_amount,
                    ac_10_amount,
                    ac_21_amount,
                    ac_22_amount,
                    trrn_type,
                    is_active,
                    company_id,batch_process_no ) values (".$tamt.",2,'".$gdate."',".$ac1.$cm.$ac2.$cm.$ac10.$cm.$ac21.$cm."0,".$upshare.$cm."1".$cm.$companyId.$cm.$mbno.")";          
                    //header insert
//                 echo $sql;
                    $this->db->query($sql);
                    $sql="select max(pf_hdr_upload_id) maxpfhdrid from EMPMILL12.tbl_pf_hdr_upload_data ";
                    $query = $this->db->query($sql);
                    $records = $query->result();
                        $ebfound='';
                            $row1 = $query->row();
                            $maxpfhdrid=$row1->maxpfhdrid;
                   $zr=0;               
                   $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
                SELECT ".$maxpfhdrid.$cm."uan_id".$cm."uan_no";
                if ($upshare==1) {
                      $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm."eps_wages".$cm."edli_wages".$cm."epf_contibution".$cm.
                      "eps_contribution".$cm."epf_eps_diff_contribution".$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
                }
                if ($upshare==2) {
                    $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm.$zr.$cm."edli_wages".$cm."epf_contibution".$cm.
                    $zr.$cm.$zr.$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
              }
              if ($upshare==3) {
                $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm."eps_wages".$cm."edli_wages".$cm.$zr.$cm.
                "eps_contribution".$cm."epf_eps_diff_contribution".$cm.$zr.$cm."g.pf_gen_id".$cm."1 "; 
             }
                $sql=$sql."   FROM
                    (  SELECT tpg.*, pf_line_upload_id,tum.uan_no   
                   FROM EMPMILL12.tbl_pf_generation tpg
                   LEFT JOIN (
                   select tplud.pf_line_upload_id,tplud.uan_id,tphud.month_end_date,tphud.trrn_status,tphud.trrn_type  
                   from EMPMILL12.tbl_pf_line_upload_data tplud
                   left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
                   where tphud.is_active = 1 
                           AND tphud.trrn_status IN (2, 3) and trrn_type in (1,$upshare) and month_end_date='$gdate'
                   ) tplud on tpg.month_end_date =tplud.month_end_date and tpg.uan_id=tplud.uan_id
                   left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id
                   where tpg.month_end_date ='$gdate' and tum.adhar_seeded =1 and tpg.company_id=$companyId 
                   and tpg.is_active=1
                   ) g where pf_line_upload_id is null ";
//echo $sql;
$sql="insert into EMPMILL12.tbl_pf_line_upload_data (pf_hdr_upload_id,uan_id,
uan_no,
gross_wages,
epf_wages,
eps_wages,
edli_wages,
epf_contribution,
eps_contribution,
epf_eps_diff_contribution,
ncp_days,
remarks,
pf_gen_id,
is_active ) 
SELECT $maxpfhdrid,tum.uan_id,uan_no,";
if ($upshare==1) {
    $sql=$sql."gross_wages,epf_wages,eps_wages,edli_wages,epf_contibution,
    eps_contribution,epf_eps_diff_contribution,case when tpg.ncp_days=0 then $pfdays else tpg.ncp_days end ncp_days
    ,'' rem,tpg.pf_gen_id,1 "; 
}
if ($upshare==2) {
//  $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm.$zr.$cm."edli_wages".$cm."epf_contibution".$cm.
//  $zr.$cm.$zr.$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
  $sql=$sql."gross_wages,epf_wages,0 eps_wages,0 edli_wages,epf_contibution,
  0 eps_contribution,0 epf_eps_diff_contribution,case when tpg.ncp_days=0 then $pfdays else tpg.ncp_days end ncp_days
  ,'' rem,tpg.pf_gen_id,1 "; 
}
if ($upshare==3) {
//$sql=$sql.$cm."gross_wages".$cm.$zr.$cm."eps_wages".$cm."edli_wages".$cm.$zr.$cm.
//"eps_contribution".$cm."epf_eps_diff_contribution".$cm.$zr.$cm."g.pf_gen_id".$cm."1 "; 
$sql=$sql."gross_wages,0 epf_wages, eps_wages, edli_wages,0 epf_contibution,
 eps_contribution, epf_eps_diff_contribution,0 ncp_days,'' rem,tpg.pf_gen_id,1 "; 
}
$sql=$sql." from EMPMILL12.tbl_uan_master tum 
left join (select * from EMPMILL12.tbl_pf_generation tpg where tpg.month_end_date ='$gdate' and is_active =1) tpg
on tum.uan_id = tpg.uan_id
where  (tum.company_id =2 and tum.is_active =1 and adhar_seeded=1 ) and (tum.uan_active =1  or 
( month(tum.date_of_uan_inactive)=$pfmonth and year(tum.date_of_uan_inactive)=$pfyear ))
";
//echo $sql;



                   $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
                   $msg =' All Data Uploaded Sucessfully';
//                   echo "The time is " . date("h:i:sa")."</br>";
        
                }
        
        
        } else {
          // selective uan
          $sql="select 	ifnull(sum(epf_contibution),0) epf_contibution,
          ifnull(sum(eps_contribution),0) eps_contribution,
          ifnull(sum(epf_eps_diff_contribution),0) epf_eps_diff_contribution
          from (
          SELECT tpg.*, pf_line_upload_id  
          FROM EMPMILL12.tbl_pf_generation tpg
          LEFT JOIN (
          select tplud.pf_line_upload_id,tplud.uan_id,tphud.month_end_date,tphud.trrn_status,tphud.trrn_type  
          from EMPMILL12.tbl_pf_line_upload_data tplud
          left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
          where tphud.is_active = 1 
                  AND tphud.trrn_status IN (2, 3) and trrn_type=? and month_end_date=?
          ) tplud on tpg.month_end_date =tplud.month_end_date and tpg.uan_id=tplud.uan_id
          left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id
          where tpg.month_end_date =? and tum.adhar_seeded =1 and tpg.company_id=? and tpg.is_active=1
          ) g where pf_line_upload_id is null and uan_id in ( ";
      
          foreach ($tableDataArray as $row) {
            // Do something with each row
            // For example, insert into database
            // $this->db->insert('your_table_name', $row)
    //        echo $row[0]."=".$row[1];
            $sql=$sql.$row[0].$cm;
          }
          $string = $sql;
          $string = substr($string, 0, -1);
          $sql=$string.")";
      //    echo $sql,$upshare,$gdate,$gdate,$companyId;
          $query = $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
          $records = $query->result();
          $ebfound='';
          $row1 = $query->row();
          $ac1=$ac10=$ac21=$ac22=$ac2=0;
  //       echo  $gdate,$row1->epf_contibution;
  //       echo '=======';
              if ( $row1->epf_contibution>0 ) {
                  $epf=$row1->epf_contibution;
                  $eps=$row1->eps_contribution;
                  $epdf=$row1->epf_eps_diff_contribution;
                 // echo $row1;
    //              echo $epdf;      

                  if  ($upshare==1) { 
                      $ac2=round(($epf+$eps+$epdf)*.5/100,0);
                      $ac21=$ac2;
                      $tamt=$epf+$eps+$epdf+$ac2+$ac21;
                      $ac1=$epf+$epdf;
                      $ac10=$eps;
                  }     
                  if  ($upshare==2) { 
                      $ac2=0;
                      $ac21=0;    
                      $tamt=$epf;
                      $ac1=$epf;
                      $ac10=0;
                  }     
                  if  ($upshare==3) { 
                      $ac2=0;
                      $ac21=0;    
                      $tamt=$eps+$epdf;
                      $ac1=$epdf;
                      $ac10=$eps;
                  }     
                  }       
//                  echo $ac1,'ananan';
            if ($ac1==0) {          
                    $msg="No Data Found to Upload";
            } else {
                $sql="select ifnull(max(batch_process_no),0)+1 mbatchno from EMPMILL12.tbl_pf_hdr_upload_data";
                $query = $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
                $records = $query->result();
                $ebfound='';
                $row1 = $query->row();
                $mbno=$row1->mbatchno;
                $batchpnos=$batchpnos.",".$mbno;
                $sql="insert into EMPMILL12.tbl_pf_hdr_upload_data (
                    trrn_amount,
                    trrn_status,
                    month_end_date,
                    ac_1_amount,
                    ac_2_amount,
                    ac_10_amount,
                    ac_21_amount,
                    ac_22_amount,
                    trrn_type,
                    is_active,
                    company_id,batch_process_no ) values (".$tamt.",2,'".$gdate."',".$ac1.$cm.$ac2.$cm.$ac10.$cm.$ac21.$cm."0,".$upshare.$cm."1".$cm.$companyId.$cm.$mbno.")";          
                    //header insert
                    $this->db->query($sql);
                    $sql="select max(pf_hdr_upload_id) maxpfhdrid from EMPMILL12.tbl_pf_hdr_upload_data ";
                    $query = $this->db->query($sql);
                    $records = $query->result();
                        $ebfound='';
                            $row1 = $query->row();
                            $maxpfhdrid=$row1->maxpfhdrid;
                   $zr=0;               
                   $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id,
                    uan_id,
                    uan_no,
                    gross_wages,
                    epf_wages,
                    eps_wages,
                    edli_wages,
                    epf_contribution,
                    eps_contribution,
                    epf_eps_diff_contribution,
                    ncp_days,
                    pf_gen_id,
                    is_active ) 
                SELECT ".$maxpfhdrid.$cm."uan_id".$cm."uan_no";
                if ($upshare==1) {
                      $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm."eps_wages".$cm."edli_wages".$cm."epf_contibution".$cm.
                      "eps_contribution".$cm."epf_eps_diff_contribution".$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
                }
                if ($upshare==2) {
                    $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm.$zr.$cm."edli_wages".$cm."epf_contibution".$cm.
                    $zr.$cm.$zr.$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
              }
              if ($upshare==3) {
                $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm."eps_wages".$cm.$zr.$cm.$zr.$cm.
                "eps_contribution".$cm."epf_eps_diff_contribution".$cm.$zr.$cm."g.pf_gen_id".$cm."1 "; 
              }   
              $sql=$sql."   FROM
              (  SELECT tpg.*, pf_line_upload_id,tum.uan_no   
             FROM EMPMILL12.tbl_pf_generation tpg
             LEFT JOIN (
             select tplud.pf_line_upload_id,tplud.uan_id,tphud.month_end_date,tphud.trrn_status,tphud.trrn_type  
             from EMPMILL12.tbl_pf_line_upload_data tplud
             left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
             where tphud.is_active = 1 
                     AND tphud.trrn_status IN (2, 3) and trrn_type in (1,?) and month_end_date=?
             ) tplud on tpg.month_end_date =tplud.month_end_date and tpg.uan_id=tplud.uan_id
             left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id
             where tpg.month_end_date =? and tum.adhar_seeded =1 and tpg.company_id=? and tpg.is_active=1
             ) g where pf_line_upload_id is null 
             and uan_id in ( ";
          foreach ($tableDataArray as $row) {
            // Do something with each row
            // For example, insert into database
            // $this->db->insert('your_table_name', $row)
       //     echo $row[0]."=".$row[1];
            $sql=$sql.$row[0].$cm;
          }
          $string = $sql;
          $string = substr($string, 0, -1);
          $sql=$string.")";
             $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
             $msg =' Selective Data Uploaded Sucessfully';
  
      }  
 //         $msg=  "Selective Data Uploaded Sucessfully";
        
        }                
                    //check already uploaded or not (if not calculate figure)
  //                  echo "The time is " . date("h:i:sa")."</br>";
	
    $current_date = $this->add_months($current_date);
    $current_date = new DateTime($current_date);


}

    $response = array(
    'success' => true,
    'savedata'=> $msg,
    'batchno'=> $batchpnos,
    );
    
        echo json_encode($response);

}


    public function gen_monthpfupdata1() {

        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        // Decode the JSON data
        $tableDataArray = json_decode($tableData, true);
    
        // Process the data as needed
        foreach ($tableDataArray as $row) {
            // Do something with each row
            // For example, insert into database
            // $this->db->insert('your_table_name', $row);
        }

$pfgendate=$upfromdate;
$start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

$pfgendate=$uptodate;
$end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

$current_date = new DateTime($start_date);
$end_date = new DateTime($end_date);

while ($current_date <= $end_date) {

    $gdate= $current_date->format('Y-m-d') . "<br>"; // Output the month
 /*   
    $sql="select
	ifnull(sum(epf_contibution),0) epf_contibution,
	ifnull(sum(eps_contribution),0) eps_contribution,
	ifnull(sum(epf_eps_diff_contribution),0) epf_eps_diff_contribution
from
	(
	SELECT
		tpg.*,
		tplud.pf_line_upload_id
	FROM
		(
		SELECT
			tpg.*
		FROM
			EMPMILL12.tbl_pf_generation tpg
		left join EMPMILL12.tbl_uan_master tum on
			tpg.uan_id = tum.uan_id
		WHERE
			tpg.is_active = 1
			AND month_end_date =?
			AND tpg.company_id = ?
			and tum.adhar_seeded = 1 ) tpg
	LEFT JOIN (
		SELECT
			tplud.pf_line_upload_id,
			tplud.uan_id uanid,
			tphud.month_end_date
		FROM
			EMPMILL12.tbl_pf_line_upload_data tplud
		LEFT JOIN EMPMILL12.tbl_pf_hdr_upload_data tphud ON
			tplud.pf_hdr_upload_id = tphud.pf_hdr_upload_id
 		WHERE
			tphud.month_end_date = ?
			AND tphud.trrn_status IN (2, 3)
				AND tphud.is_active = 1
				AND tphud.trrn_type = ?
				and tphud.company_id = ? ) tplud ON
		tpg.uan_id = tplud.uanid
		AND tpg.month_end_date = tplud.month_end_date
	where
		tplud.pf_line_upload_id is null ) g";
 */
echo 'checking data';
 $sql="select 	ifnull(sum(epf_contibution),0) epf_contibution,
 ifnull(sum(eps_contribution),0) eps_contribution,
 ifnull(sum(epf_eps_diff_contribution),0) epf_eps_diff_contribution
from (
    SELECT tpg.*, pf_line_upload_id  
    FROM EMPMILL12.tbl_pf_generation tpg
    LEFT JOIN (
    select tplud.pf_line_upload_id,tplud.uan_id,tphud.month_end_date,tphud.trrn_status,tphud.trrn_type  
    from EMPMILL12.tbl_pf_line_upload_data tplud
    left join EMPMILL12.tbl_pf_hdr_upload_data tphud on tplud.pf_hdr_upload_id =tphud.pf_hdr_upload_id
    where tphud.is_active = 1 
          AND tphud.trrn_status IN (2, 3) and trrn_type=? and month_end_date=?
    ) tplud on tpg.month_end_date =tplud.month_end_date and tpg.uan_id=tplud.uan_id
    left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id
    where tpg.month_end_date =? and tum.adhar_seeded =1 and tpg.company_id=?
    ) g where pf_line_upload_id is null ";
    

        //      echo $sql."</br>";
  //      echo 'gdate '.$gdate."</br>";
  //  $query = $this->db->query($sql, array($gdate,$companyId,$gdate,$upshare,$companyId ));
    $query = $this->db->query($sql, array($upshare,$gdate,$gdate,$companyId ));
    
    $records = $query->result();
//	$query1=$this->db->query($sql);
    $ebfound='';
        $row1 = $query->row();
        if ( $row1->epf_contibution>0 ) {
            $epf=$row1->epf_contibution;
            $eps=$row1->eps_contribution;
            $epdf=$row1->epf_eps_diff_contribution;
            if  ($upshare==1) { 
                $ac2=round(($epf+$eps+$epdf)*.5/100,0);
                $ac21=$ac2;
                $tamt=$epf+$eps+$epdf+$ac2+$ac21;
                $ac1=$epf+$epdf;
                $ac10=$eps;
                
            }     
            if  ($upshare==2) { 
                $ac2=0;
                $ac21=0;    
                $tamt=$epf;
                $ac1=$epf;
                $ac10=0;
            }     
            if  ($upshare==3) { 
                $ac2=0;
                $ac21=0;    
                $tamt=$eps+$epdf;
                $ac1=$epdf;
                $ac10=$eps;
            }     
            $cm=",";
    //        echo 'more than 0  =6='.$gdate.'=7='.$epf.'=8=epf amt'."</br>";
              $sql="insert into EMPMILL12.tbl_pf_hdr_upload_data (
              trrn_amount,
              trrn_status,
              month_end_date,
              ac_1_amount,
              ac_2_amount,
              ac_10_amount,
              ac_21_amount,
              ac_22_amount,
              trrn_type,
              is_active,
              company_id ) values (".$tamt.",2,'".$gdate."',".$ac1.$cm.$ac2.$cm.$ac10.$cm.$ac21.$cm."0,".$upshare.$cm."1".$cm.$companyId.")";          
              //header insert
              $this->db->query($sql);
              $sql="select max(pf_hdr_upload_id) maxpfhdrid from EMPMILL12.tbl_pf_hdr_upload_data ";
              $query = $this->db->query($sql);
              $records = $query->result();
                  $ebfound='';
                      $row1 = $query->row();
                      $maxpfhdrid=$row1->maxpfhdrid;
             $zr=0;               
            //line details insert
            $sql="insert into EMPMILL12.tbl_pf_line_upload_data (
                pf_hdr_upload_id,
                uan_id,
                uan_no,
                gross_wages,
                epf_wages,
                eps_wages,
                edli_wages,
                epf_contribution,
                eps_contribution,
                epf_eps_diff_contribution,
                ncp_days,
                pf_gen_id,
                is_active ) 
            SELECT ".$maxpfhdrid.$cm."uan_id".$cm."uan_no";
            if ($upshare==1) {
                  $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm."eps_wages".$cm."edli_wages".$cm."epf_contibution".$cm.
                  "eps_contribution".$cm."epf_eps_diff_contribution".$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
            }
            if ($upshare==2) {
                $sql=$sql.$cm."gross_wages".$cm."epf_wages".$cm.$zr.$cm."edli_wages".$cm."epf_contibution".$cm.
                $zr.$cm.$zr.$cm."ncp_days".$cm."g.pf_gen_id".$cm."1 "; 
          }
          if ($upshare==3) {
            $sql=$sql.$cm."gross_wages".$cm.$zr.$cm."eps_wages".$cm."edli_wages".$cm.$zr.$cm.
            "eps_contribution".$cm."epf_eps_diff_contribution".$cm.$zr.$cm."g.pf_gen_id".$cm."1 "; 
      }
            $sql=$sql."   FROM
        (
            SELECT
                tpg.*,uan_no
            FROM
                EMPMILL12.tbl_pf_generation tpg
            left join EMPMILL12.tbl_uan_master tum on
                tpg.uan_id = tum.uan_id
            WHERE
                tpg.is_active = 1
                AND month_end_date = ?
                AND tpg.company_id = ?
                and tum.adhar_seeded = 1 ) tpg
        LEFT JOIN (
            SELECT
                tplud.pf_line_upload_id,
                tplud.uan_id uanid,
                tphud.month_end_date,tplud.pf_gen_id
            FROM
                EMPMILL12.tbl_pf_line_upload_data tplud
            LEFT JOIN EMPMILL12.tbl_pf_hdr_upload_data tphud ON
                tplud.pf_hdr_upload_id = tphud.pf_hdr_upload_id
            WHERE
                tphud.month_end_date = ?
                AND tphud.trrn_status IN (2, 3)
                    AND tphud.is_active = 1
                    AND tphud.trrn_type = ?
                    and tphud.company_id = ? ) tplud ON
            tpg.uan_id = tplud.uanid
            AND tpg.month_end_date = tplud.month_end_date
        where
            tplud.pf_line_upload_id is null ";
//    echo $sql;
            //            $query = $this->db->query($sql, array($gdate,$companyId,$gdate,$upshare,$companyId ));
            $this->db->query($sql, array($gdate,$companyId,$gdate,$upshare,$companyId));

        } else {
    //    echo 'is 0 =1='.$gdate.'=2=No EPF'."</br>";    
            

        }    
//    $current_date=add_months($current_date);
    $current_date = $this->add_months($current_date);
$current_date = new DateTime($current_date);
//echo 'current month='.$current_date;

   
}

 
 
// Format the date as desired
 



        $companyId = $this->input->post('companyId');
        $active=1;
        $qtype=2;
        $entryMode='M';
        
        
//        $this->db->query($sql);
    
    
    $response = array(
    'success' => true,
    'savedata'=> 'saved'
    );
    
        echo json_encode($response);
    
    }
 


    public function get_pfgendata() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
       // $uanno = $this->input->post('uanno');
       $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
 
 //echo 'comp id '.$compid.'  pf '.$pfgendate;
$sql="select tum.uan_no,tum.name_as_per_pf_online,tpg.* from EMPMILL12.tbl_pf_generation tpg 
 left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
 where tpg.is_active=1 and month_end_date='".$pfgendate."' and tpg.company_id=".$compid." order by uan_no";
/*
        $sql="select tum.*,CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS wname ,
        case when tum.adhar_seeded=1 then 'Yes' else 'No' end adhseed,case when uan_active=1 then 'Yes' else 'No' end 
        uanact, date_format(date_of_uan_inactive,'%d-%m-%Y') dateofinactive
        from EMPMILL12.tbl_uan_master tum 
        left join (select * from tbl_hrms_ed_official_details theod where is_active =1) theod on tum.eb_no =theod.emp_code
        left join tbl_hrms_ed_personal_details thepd on thepd.eb_id =theod.eb_id and thepd.company_id=tum.company_id
        where tum.is_active =1 and tum.company_id =? and thepd.company_id=?";
        $sql=$sql." order by eb_no
        ";
 */
        //echo $sql;
    
    $query = $this->db->query($sql, array($compid,$compid ));
    $records = $query->result();
    $sln=$query->num_rows();
    $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->pf_gen_id,
                $record->uan_no,
                $record->name_as_per_pf_online,
                $record->gross_wages,
                $record->epf_wages,
                $record->eps_wages,
                $record->edli_wages,
                $record->epf_contibution,
                $record->eps_contribution,
                $record->epf_eps_diff_contribution,
                $record->ncp_days,
                $record->remarks,
                
     
            ];
         }
         $sql="select '' uan_no,'Grand Total' name_as_per_pf_online,sum(gross_wages) gross_wages,sum(epf_wages) epf_wages,
         sum(eps_wages) eps_wages,sum(edli_wages) edli_wages,sum(epf_contibution) epf_contibution,sum(eps_contribution) eps_contribution,
         sum(epf_eps_diff_contribution) epf_eps_diff_contribution,sum(ncp_days) ncp_days,' ' remarks from (
         select tum.uan_no,tum.name_as_per_pf_online,tpg.* from EMPMILL12.tbl_pf_generation tpg 
         left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
         where tpg.is_active=1 and month_end_date='".$pfgendate."' ) g";
        /*
                $sql="select tum.*,CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS wname ,
                case when tum.adhar_seeded=1 then 'Yes' else 'No' end adhseed,case when uan_active=1 then 'Yes' else 'No' end 
                uanact, date_format(date_of_uan_inactive,'%d-%m-%Y') dateofinactive
                from EMPMILL12.tbl_uan_master tum 
                left join (select * from tbl_hrms_ed_official_details theod where is_active =1) theod on tum.eb_no =theod.emp_code
                left join tbl_hrms_ed_personal_details thepd on thepd.eb_id =theod.eb_id and thepd.company_id=tum.company_id
                where tum.is_active =1 and tum.company_id =? and thepd.company_id=?";
                $sql=$sql." order by eb_no
                ";
         */
                //echo $sql;
            
            $query = $this->db->query($sql, array($compid,$compid ));
            $records = $query->result();
            $sln=$query->num_rows();
        
            foreach ($records as $record) {
                $data[] = [
                    '',
                    $record->uan_no,
                    $record->name_as_per_pf_online,
                    $record->gross_wages,
                    $record->epf_wages,
                    $record->eps_wages,
                    $record->edli_wages,
                    $record->epf_contibution,
                    $record->eps_contribution,
                    $record->epf_eps_diff_contribution,
                    $record->ncp_days,
                    $record->remarks,
                    
         
                ];
             }
             

        // Return the response
        echo json_encode(['data' => $data]);
    }

    public function cancel_monthpfdata() {

        $pfgendate = $this->input->post('pfgendate');
         
        $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $companyId = $this->input->post('companyId');
        $active=1;
        $qtype=2;
        $entryMode='M';
        
        $sql="update EMPMILL12.tbl_pf_generation set is_active=0 where company_id=".$companyId." and month_end_date='".$pfgendate."'";

 //        $query = $this->db->query($sql);
        
        $this->db->query($sql);
    
    
    $response = array(
    'success' => true,
    'savedata'=> 'saved'
    );
    
        echo json_encode($response);
    
    }
 



 
    public function get_pfdataexists() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
       $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
  
         $sql="
         select tum.uan_no,tum.name_as_per_pf_online,tpg.* from EMPMILL12.tbl_pf_generation tpg 
         left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
         where tpg.is_active=1 and month_end_date='".$pfgendate."'" ;
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
    
 


public function gen_excelpfdata() {
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
  
     $sql="select tum.uan_no,tum.name_as_per_pf_online,tpg.* from EMPMILL12.tbl_pf_generation tpg 
     left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
     where tpg.is_active=1 and month_end_date='".$pfgendate."' and tpg.company_id=".$compid." order by uan_no";
        $query = $this->db->query($sql );
        $records = $query->result();
        $sln=$query->num_rows();
    


 
	// Create a new Spreadsheet object
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();

    $cmpn="company";
   
    $cmpn="your company";
	$sheet->setCellValue('A1', 'For the Month of '.$sdate);
//	$active_sheet->setCellValue('A2', "Reports for Dated : ");
	// Set company name
	$companyName = "Your Company Name";

	$sheet->setCellValue('A2', 'UAN No ');
	$sheet->setCellValue('b2', 'Name');
	$sheet->setCellValue('c2', 'Gross Wages');
	$sheet->setCellValue('d2', 'EPF Wages');
	$sheet->setCellValue('e2', 'EPS Wages');
	$sheet->setCellValue('f2', 'EDLI Wages');
	$sheet->setCellValue('g2', 'EPF Cont');
	$sheet->setCellValue('h2', 'EPS Cont');
	$sheet->setCellValue('i2', 'EPF EPS Diff');
	$sheet->setCellValue('j2', 'NCP Days');
	$sheet->setCellValue('k2', 'Remarks');
	$sheet->setCellValue('l2', 'Pay Schm Id');

    
	$rowIndex = 3;
	foreach ($records as $record) {
		$columnIndex = 1;
//		foreach ($record as $value) {
            $value=$record->uan_no;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->name_as_per_pf_online;
			$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->gross_wages;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->epf_wages;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->eps_wages;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->edli_wages;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->epf_contibution;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->eps_contribution;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->epf_eps_diff_contribution;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->ncp_days;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->remarks;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->psch_id;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            




            //		}
		$rowIndex++;
	}	



//	$sheet->mergeCells('A1:E1');
//	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
//	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $filename="pfdata_".$date.'.xlsx';
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
      


    public function gen_createpfupdatapy() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        // Decode the JSON data
        $tableDataArray = json_decode($tableData, true);
//    var_dump($tableDataArray);
        // Process the data as needed
    $pfgendate=$upfromdate;
    $start_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);

    $pfgendate=$uptodate;
    $end_date=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
$mbno=0;
$msg='NA';
$batchpnos='';
    $current_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);
//echo $current_date->format('Y-m-d');  // Example output: 2025-10-20
//echo "<br>";
//echo $end_date->format('Y-m-d');
    
      $gdate= $current_date->format('Y-m-d') ; // Output the month
      $pfmonth = $current_date->format('m'); // Get month
      $pfyear = $current_date->format('Y');  // Get year
      $pfdays = $current_date->format('d');  // Get day

$payload = [
        "companyId"      => $companyId,
        "upfromdate"     => $start_date,
        "uptodate"       => $end_date,
        "upshare"        => $upshare,
        "upallsel"       => $upallsel,
        "tableData"      => $tableDataArray
    ];


    $py     = "d:\\python311\\python.exe";
    $script = "D:\\pyproj\\pytst\\createpfdatapy.py";

    $tmpDir = FCPATH . "tmp\\";
    if (!is_dir($tmpDir)) {
        @mkdir($tmpDir, 0777, true);
    }

    $payloadFile  = $tmpDir . "pf_payload_" . date("Ymd_His") . "_" . mt_rand(1000,9999) . ".json";
    $responseFile = $tmpDir . "pf_response_" . date("Ymd_His") . "_" . mt_rand(1000,9999) . ".json";

    file_put_contents($payloadFile, json_encode($payload, JSON_UNESCAPED_UNICODE));

    // 7) Execute python with args: input.json output.json
    // Use escapeshellarg for safety; on Windows it’s still helpful.
    $cmd = "\"{$py}\" \"{$script}\" \"{$payloadFile}\" \"{$responseFile}\" 2>&1";

    $output = shell_exec($cmd);

    // 8) If python wrote response JSON, read it
    if (!file_exists($responseFile)) {
        // Cleanup
        @unlink($payloadFile);

        echo json_encode([
            'success'  => false,
            'savedata' => "Python did not create response file. Output: " . $output,
            'batchno'  => ''
        ]);
        return;
    }

    $pyRespRaw = file_get_contents($responseFile);
    $pyResp = json_decode($pyRespRaw, true);

    // Cleanup temp files
    @unlink($payloadFile);
    @unlink($responseFile);

    if (!is_array($pyResp)) {
        echo json_encode([
            'success'  => false,
            'savedata' => "Invalid JSON from python. Raw: " . $pyRespRaw,
            'batchno'  => ''
        ]);
        return;
    }

    // 9) Return to view (same structure your JS expects)
    echo json_encode([
        'success'  => (bool)($pyResp['success'] ?? false),
        'savedata' => $pyResp['message'] ?? 'NA',
        'batchno'  => $pyResp['batchno'] ?? ''
    ]);


    }




}