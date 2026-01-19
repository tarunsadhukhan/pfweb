<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Esimaster extends CI_Controller {

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
		$this->load->view('admin/esidetails/Esimaster', $data_to_pass);	
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
 

    public function saveesi_data() {

        $companyId = $this->input->post('companyId');
        $dojdate = $this->input->post('dojdate');
        $reasoncode = $this->input->post('reasoncode');
        $incactdate = $this->input->post('incactdate');
        $esino = $this->input->post('esino');
        $ebname = $this->input->post('ebname');
        $rec_time =  date('Y-m-d H:i:s');
        $adharseeded = $this->input->post('adharseeded');
        $ebno = $this->input->post('ebno');
        $uanactive = $this->input->post('uanactive');
        $record_id = $this->input->post('record_id');
 

$incactdate=substr($incactdate,6,4).'-'.substr($incactdate,3,2).'-'.substr($incactdate,0,2);
$dojdate=substr($dojdate,6,4).'-'.substr($dojdate,3,2).'-'.substr($dojdate,0,2);

$active=1;
$qtype=2;
$entryMode='M';

if ($uanactive==1) {
        $incactdate=Null;
}
if ($reasoncode==99) {
    $reasoncode=Null;
}

$sql="select ifnull(count(*),0) cnt from EMPMILL12.tbl_esi_master where 
ip_no='$esino' AND is_active=1";
$query = $this->db->query($sql);
$records = $query->result();
$sln=$query->num_rows();
$uanf=0;     
foreach ($records as $record) {
        $uanf=$record->cnt;
}
if ($uanf>0) { 
    
    $savedata='Already Exists';
    $success=false;
}   else {     

        
     $data = array(
        'ip_no' => $esino,
        'ip_name' => $ebname,
        'date_of_esi_join' => $dojdate,
        'is_active' => $uanactive,
        'adhar_seeded' => $adharseeded,
        'exit_date' => $incactdate,
        'exit_reason' => $reasoncode, 
        'company_id' => $companyId
     
        // Exclude 'id' and 'updated_by' fields
    );
    $this->db->insert('EMPMILL12.tbl_esi_master', $data);
    $savedata='Saved';
    $success=true;
   
}    
    $response = array(
    'success' => $success,
    'savedata'=> $savedata
    );
    
        echo json_encode($response);
    
    }
       
    public function get_esidetails() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
 
 //echo 'comp id '.$compid;

        $sql="  select esi_master_id,ip_no,ip_name,date_of_esi_join,adhar_seeded,tem.is_active,exit_reason,
        emp_code,case when adhar_seeded=1 then 'Yes' else 'No' end adhseed,
        case when tem.is_active=1 then 'Yes' else 'No' end 
        uanact, date_format(exit_date,'%d-%m-%Y') exit_date,
        case when exit_reason =2 then 'Left Service' 
        when ifnull(exit_reason,99)=99 then ' '
        when exit_reason=3 then 'Retired'
        when exit_reason =5 then 'Expired'
        when exit_reason =10 then 'Retrenchment' end exit_reasonname 
        from EMPMILL12.tbl_esi_master tem 
        left join (select * from tbl_hrms_ed_esi where is_active=1)  thee on tem.ip_no =thee.esi_no 
        left join (select eb_id,emp_code from tbl_hrms_ed_official_details theod where is_active =1 ) theod
        on thee.eb_id=theod.eb_id 
        where tem.company_id =?
        ";
        $sql=$sql." order by ip_no
        ";
     //and thepd.company_id=?
     
        //  echo $sql;
    
    $query = $this->db->query($sql, array($compid ));
    $records = $query->result();
    $sln=$query->num_rows();
    $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->esi_master_id,
                $record->emp_code,
                $record->ip_no,
                $record->ip_name,
                $record->date_of_esi_join,
                $record->adhseed,
                $record->uanact,
                $record->exit_date,
                $record->exit_reasonname ,
                $record->exit_reason,
                $record->adhar_seeded,
                $record->is_active,
                
     
            ];
         }
    
        // Return the response
        echo json_encode(['data' => $data]);
    }
    
    
    public function updateesi_data() {

        
                $companyId = $this->input->post('companyId');
                $dojdate = $this->input->post('dojdate');
                $reasoncode = $this->input->post('reasoncode');
                $incactdate = $this->input->post('incactdate');
                $esino = $this->input->post('esino');
                $ebname = $this->input->post('ebname');
                $rec_time =  date('Y-m-d H:i:s');
                $adharseeded = $this->input->post('adharseeded');
                $ebno = $this->input->post('ebno');
                $uanactive = $this->input->post('uanactive');
                $record_id = $this->input->post('record_id');
         

   $incactdate=substr($incactdate,6,4).'-'.substr($incactdate,3,2).'-'.substr($incactdate,0,2);
   $dojdate=substr($dojdate,6,4).'-'.substr($dojdate,3,2).'-'.substr($dojdate,0,2);
           $active=1;
        $qtype=2;
        $entryMode='M';
     
        if ($uanactive==1) {
            $incactdate=Null;
            $reasoncode=Null;
        }
        if ($reasoncode==99) {
            $reasoncode=Null;
        }
/*         
        ip_no
ip_name
date_of_esi_join
adhar_seeded
is_active
company_id
branch_id
exit_date
exit_reason
*/
     $data = array(
        'ip_no' => $esino,
        'ip_name' => $ebname,
        'date_of_esi_join' => $dojdate,
        'is_active' => $uanactive,
        'adhar_seeded' => $adharseeded,
        'exit_date' => $incactdate,
        'exit_reason' => $reasoncode,
      
        // Exclude 'id' and 'updated_by' fields
    );   
    $this->db->where('esi_master_id', $record_id);
    $this->db->update('EMPMILL12.tbl_esi_master', $data);
    echo $this->db->last_query();
    
    $response = array(
    'success' => true,
    'savedata'=> 'Updated'
    );
    
        echo json_encode($response);
    
    }
    
       


}