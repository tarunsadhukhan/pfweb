<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Uanmaster extends CI_Controller {

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
		$this->load->view('admin/uandetails/Uanmaster', $data_to_pass);	
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
        $sql="select emp_code,CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS wname,
        thep.pf_no,thep.pf_uan_no,thepd.eb_id,thee.esi_no
        from tbl_hrms_ed_personal_details thepd 
        left join (select eb_id,emp_code from tbl_hrms_ed_official_details theod where is_active=1 ) theod on theod.eb_id=thepd.eb_id 
        left join (select * from tbl_hrms_ed_pf thep where is_active=1 ) thep on theod.eb_id=thep.eb_id
        left join (select * from tbl_hrms_ed_esi thee where is_active=1 ) thee on theod.eb_id=thee.eb_id
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
            $esino=$row1->esi_no;
        } else {    
            $name="";
            $uanno="";
            $pfno="";
            $esino='';
        
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
                'pfno'=>$pfno,
                'esino'=>$esino
            );
        } else {
            $response = array(
                'success' => false,
                'name' => $name,
                'uanid' => $uanid,
                'ebfound'=>$ebfound,
                'uanno'=>$uanno,
                'pfno'=>$pfno,
                'esino'=>$esino
                
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
         
        $sql="select ifnull(count(*),0) cnt from EMPMILL12.tbl_uan_master where 
        (uan_no='$uanno' or eb_no='$ebno') and uan_active=1";
        $query = $this->db->query($sql);
        $records = $query->result();
        $sln=$query->num_rows();
        $uanf=0;     
        foreach ($records as $record) {
                $uanf=$record->cnt;
        }
//        echo $sql;
//        echo $uanf;
        if ($uanf>0) { 
            
            $savedata='Already Exists';
            $success=false;
        }   else {     

        
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
    $savedata='saved';
    $success=true;

}
    
    $response = array(
    'success' => $success,
    'savedata'=> $savedata
    );
    
        echo json_encode($response);
    
    }
       
    public function get_uandetails() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
 
 //echo 'comp id '.$compid;

        $sql="select tum.*,CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS wname ,
        case when tum.adhar_seeded=1 then 'Yes' else 'No' end adhseed,case when uan_active=1 then 'Yes' else 'No' end 
        uanact, date_format(date_of_uan_inactive,'%d-%m-%Y') dateofinactive
        from EMPMILL12.tbl_uan_master tum 
        left join (
            select company_id,emp_code,first_name,middle_name,last_name from tbl_hrms_ed_official_details theod 
             join tbl_hrms_ed_personal_details thepd on thepd.eb_id =theod.eb_id and thepd.company_id =?
             where theod.is_active =1
             ) thepd
            on tum.eb_no =thepd.emp_code  
            where tum.is_active =1 and tum.company_id =?
  ";


  $sql="select tum.*,' ' eb_no,' ' wname,
  case when tum.adhar_seeded=1 then 'Yes' else 'No' end adhseed,case when uan_active=1 then 'Yes' else 'No' end 
  uanact, date_format(date_of_uan_inactive,'%d-%m-%Y') dateofinactive
  from EMPMILL12.tbl_uan_master tum 
 where tum.is_active =1 and tum.company_id =$compid";

        $sql=$sql." order by uan_no
        ";
     //and thepd.company_id=?
     
      //    echo $sql;
    
    $query = $this->db->query($sql);
    $records = $query->result();
    $sln=$query->num_rows();
    $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->uan_id,
                $record->eb_no,
                $record->wname,
                $record->uan_no,
                $record->name_as_per_pf_online,
                $record->pf_no,
                $record->adhseed,
                $record->uanact,
                $record->dateofinactive,
                $record->adhar_seeded,
                $record->uan_active,
                
     
            ];
         }
    
        // Return the response
        echo json_encode(['data' => $data]);
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
    
       


}