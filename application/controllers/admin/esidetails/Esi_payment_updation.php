<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Esi_payment_updation extends CI_Controller {

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
		$this->load->view('admin/esidetails/Esi_payment_updation', $data_to_pass);	
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
        
        
        $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $companyId = $this->input->post('companyId');
        $active=1;
        $qtype=2;
        $entryMode='M';
        
        $sql="insert into EMPMILL12.tbl_pf_generation(uan_id,gross_wages,epf_wages,eps_wages,edli_wages,epf_contibution,eps_contribution,
		epf_eps_diff_contribution,ncp_days,remarks,is_active,psch_id,month_end_date,company_id )
		select tum.uan_id,IFNULL(gwages,0) gwages,ifnull(epfwages,0) epfwages,ifnull(epswages,0) epswages,ifnull(edliwages,0) edliwages,
		ifnull(epfcont,0) epfcont,ifnull(epsamt,0) epsamt,ifnull(epfepsdf,0) epfepsdf,
		CEIL(ifnull(ncpdays,0)) ncpdays,remarks,1,pschmid,'".$pfgendate."',".$companyId." from (
		select *  from EMPMILL12.tbl_uan_master tum where 
 		tum.is_active=1 and (tum.date_of_uan_inactive>='".$stdate."' or date_of_uan_inactive is null)
 		and tum.company_id=".$companyId." 
 		) tum left join		
		(
		select pf_no,pf_uan_no,round(pfgross,0) gwages,round(pfgross,0) epfwages,round(pfgross,0) epswages,round(pfgross,0) edliwages,
		pfamount epfcont,
		round((pfamount/10*8.33),0) epsamt,
		pfamount-round((pfamount/10*8.33),0) epfepsdf, case when (30-days)>=0 then (30-days) else 0 end ncpdays,
		'             ' remarks,1 act,pschmid from (
            select * from (
                select eb_id,
		max( case when COMPONENT_ID=6 then amount else 0 end ) Days,
		max( case when COMPONENT_ID=7 then amount else 0 end ) pfgross,
		max( case when COMPONENT_ID=18 then amount else 0 end ) PFamount,102 pschmid 
		from (
		select tpep.PAYPERIOD_ID,tpp.FROM_DATE,tpp.TO_DATE, tpep.EMPLOYEEID eb_id,
		COMPONENT_ID,tpc.NAME,AMOUNT,tpep.PAYSCHEME_ID  from 
		tbl_pay_employee_payroll tpep
		left join tbl_pay_period tpp on tpep.PAYPERIOD_ID =tpp.ID 
		left join tbl_pay_components tpc on tpep.COMPONENT_ID =tpc.ID 
		where  tpep.COMPONENT_ID in (7,6,18)  
		and tpp.FROM_DATE ='".$stdate."' AND tpp.TO_DATE ='".$endate."' and tpep.PAYSCHEME_ID=102 
		and tpep.BUSINESSUNIT_ID =".$companyId."  and tpp.STATUS =3
		) g  group by eb_id
     union all
	SELECT EMPLOYEEID eb_id,round((WORKING_HOURS+HL_HRS+NS_HRS)/8,2)+STL_D days,pf_gross pfgross,epf pfamount,125 pschmid from ( 
	SELECT 
        EMPLOYEEID, 
        MAX(CASE WHEN COMPONENT_ID = 178 THEN amount ELSE 0 END) AS WORKING_HOURS,
        MAX(CASE WHEN COMPONENT_ID = 180 THEN amount ELSE 0 END) AS HL_HRS,
        MAX(CASE WHEN COMPONENT_ID = 179 THEN amount ELSE 0 END) AS NS_HRS,
        MAX(CASE WHEN COMPONENT_ID = 183 THEN amount ELSE 0 END) AS STL_D,
           MAX(CASE WHEN COMPONENT_ID = 134 THEN amount ELSE 0 END) AS PF_GROSS, 
       MAX(CASE WHEN COMPONENT_ID = 18 THEN amount ELSE 0 END) AS EPF,
       MAX(CASE WHEN COMPONENT_ID = 149 THEN amount ELSE 0 END) AS ESI_GROSS, 
       MAX(CASE WHEN COMPONENT_ID = 19 THEN amount ELSE 0 END) AS ESIC,
       MAX( case when COMPONENT_ID = 224 THEN amount else 0 end ) AS TOTAL_EARNING                  
        FROM (
        SELECT 
            EMPLOYEEID, 
            COMPONENT_ID, 
            SUM(amount) AS amount 
        FROM 
            tbl_pay_employee_payroll k 
        LEFT JOIN 
            tbl_pay_period tpp ON k.PAYPERIOD_ID = tpp.ID 
        WHERE 
        tpp.FROM_DATE >='".$stdate."' AND tpp.TO_DATE <='".$endate."'
            AND tpp.STATUS =3 
            AND k.STATUS =1 
            AND k.PAYSCHEME_ID in (125)
            AND k.BUSINESSUNIT_ID =".$companyId."
        GROUP BY 
            EMPLOYEEID, COMPONENT_ID
           ) G GROUP BY EMPLOYEEID  
		) k
           union all
	SELECT EMPLOYEEID eb_id,round((WORKING_HOURS+HL_HRS+NS_HRS)/8,2)+STL_D days,pf_gross pfgross,epf pfamount,151 pschmid from ( 
	SELECT 
        EMPLOYEEID, 
        MAX(CASE WHEN COMPONENT_ID = 178 THEN amount ELSE 0 END) AS WORKING_HOURS,
        MAX(CASE WHEN COMPONENT_ID = 180 THEN amount ELSE 0 END) AS HL_HRS,
        MAX(CASE WHEN COMPONENT_ID = 179 THEN amount ELSE 0 END) AS NS_HRS,
        MAX(CASE WHEN COMPONENT_ID = 183 THEN amount ELSE 0 END) AS STL_D,
           MAX(CASE WHEN COMPONENT_ID = 134 THEN amount ELSE 0 END) AS PF_GROSS, 
       MAX(CASE WHEN COMPONENT_ID = 18 THEN amount ELSE 0 END) AS EPF,
       MAX(CASE WHEN COMPONENT_ID = 149 THEN amount ELSE 0 END) AS ESI_GROSS, 
       MAX(CASE WHEN COMPONENT_ID = 19 THEN amount ELSE 0 END) AS ESIC,
       MAX( case when COMPONENT_ID = 224 THEN amount else 0 end ) AS TOTAL_EARNING               
        FROM (
        SELECT 
            EMPLOYEEID, 
            COMPONENT_ID, 
            SUM(amount) AS amount 
        FROM 
            tbl_pay_employee_payroll k 
        LEFT JOIN 
            tbl_pay_period tpp ON k.PAYPERIOD_ID = tpp.ID 
        WHERE 
        tpp.FROM_DATE >='".$stdate."' AND tpp.TO_DATE <='".$endate."'
            AND tpp.STATUS =3 
            AND k.STATUS =1
            AND k.PAYSCHEME_ID in (151)
            AND k.BUSINESSUNIT_ID = ".$companyId." 
        GROUP BY 
            EMPLOYEEID, COMPONENT_ID
           ) G GROUP BY EMPLOYEEID  
		) k ) v where pfamount>0
      ) g left join 		
		(select * from tbl_hrms_ed_pf thep where is_active=1) thep on thep.eb_id=g.eb_id
		) pfdata on pfdata.pf_no=tum.pf_no
		";
/*
      $sql="	insert into EMPMILL12.tbl_pf_generation(uan_id,gross_wages,epf_wages,eps_wages,edli_wages,epf_contibution,eps_contribution,
      epf_eps_diff_contribution,ncp_days,remarks,is_active,psch_id,month_end_date,company_id )
      select tum.uan_id,IFNULL(gwages,0) gwages,ifnull(epfwages,0) epfwages,ifnull(epswages,0) epswages,ifnull(edliwages,0) edliwages,
      ifnull(epfcont,0) epfcont,ifnull(epsamt,0) epsamt,ifnull(epfepsdf,0) epfepsdf,
      CEIL(ifnull(ncpdays,0)) ncpdays,remarks,1,pschmid,'2024-04-30',2 from (
      select *  from EMPMILL12.tbl_uan_master tum where 
       tum.is_active=1 and (tum.date_of_uan_inactive>='2024-04-01' or date_of_uan_inactive is null)
       and tum.company_id=2 
       ) tum left join		
      (
      select pf_no,pf_uan_no,round(pfgross,0) gwages,round(pfgross,0) epfwages,round(pfgross,0) epswages,round(pfgross,0) edliwages,
      pfamount epfcont,
      round((pfamount/10*8.33),0) epsamt,
      pfamount-round((pfamount/10*8.33),0) epfepsdf, case when (30-days)>=0 then (30-days) else 0 end ncpdays,
      '             ' remarks,1 act,pschmid from (
      select * from (
      select eb_id,
      max( case when COMPONENT_ID=6 then amount else 0 end ) Days,
      max( case when COMPONENT_ID=7 then amount else 0 end ) pfgross,
      max( case when COMPONENT_ID=18 then amount else 0 end ) PFamount,102 pschmid 
      from (
      select tpep.PAYPERIOD_ID,tpp.FROM_DATE,tpp.TO_DATE, tpep.EMPLOYEEID eb_id,
      COMPONENT_ID,tpc.NAME,AMOUNT,tpep.PAYSCHEME_ID  from 
      tbl_pay_employee_payroll tpep
      left join tbl_pay_period tpp on tpep.PAYPERIOD_ID =tpp.ID 
      left join tbl_pay_components tpc on tpep.COMPONENT_ID =tpc.ID 
      where  tpep.COMPONENT_ID in (7,6,18)  
      and tpp.FROM_DATE ='2024-04-01' AND tpp.TO_DATE ='2024-04-30' and tpep.PAYSCHEME_ID=102 
      and tpep.BUSINESSUNIT_ID =2  and tpp.STATUS =3
      ) g  group by eb_id
   union all
  SELECT EMPLOYEEID eb_id,round((WORKING_HOURS+HL_HRS+NS_HRS)/8,2)+STL_D days,pf_gross pfgross,epf pfamount,125 pschmid from ( 
  SELECT 
      EMPLOYEEID, 
      MAX(CASE WHEN COMPONENT_ID = 178 THEN amount ELSE 0 END) AS WORKING_HOURS,
      MAX(CASE WHEN COMPONENT_ID = 180 THEN amount ELSE 0 END) AS HL_HRS,
      MAX(CASE WHEN COMPONENT_ID = 179 THEN amount ELSE 0 END) AS NS_HRS,
      MAX(CASE WHEN COMPONENT_ID = 183 THEN amount ELSE 0 END) AS STL_D,
         MAX(CASE WHEN COMPONENT_ID = 134 THEN amount ELSE 0 END) AS PF_GROSS, 
     MAX(CASE WHEN COMPONENT_ID = 18 THEN amount ELSE 0 END) AS EPF,
     MAX(CASE WHEN COMPONENT_ID = 149 THEN amount ELSE 0 END) AS ESI_GROSS, 
     MAX(CASE WHEN COMPONENT_ID = 19 THEN amount ELSE 0 END) AS ESIC,
     MAX( case when COMPONENT_ID = 224 THEN amount else 0 end ) AS TOTAL_EARNING                  
      FROM (
      SELECT 
          EMPLOYEEID, 
          COMPONENT_ID, 
          SUM(amount) AS amount 
      FROM 
          tbl_pay_employee_payroll k 
      LEFT JOIN 
          tbl_pay_period tpp ON k.PAYPERIOD_ID = tpp.ID 
      WHERE 
      tpp.FROM_DATE >='2024-04-01' AND tpp.TO_DATE <='2024-04-30'
          AND tpp.STATUS =3 
          AND k.STATUS =1 
          AND k.PAYSCHEME_ID in (125)
          AND k.BUSINESSUNIT_ID =2
      GROUP BY 
          EMPLOYEEID, COMPONENT_ID
         ) G GROUP BY EMPLOYEEID  
      ) k
         union all
  SELECT EMPLOYEEID eb_id,round((WORKING_HOURS+HL_HRS+NS_HRS)/8,2)+STL_D days,pf_gross pfgross,epf pfamount,151 pschmid from ( 
  SELECT 
      EMPLOYEEID, 
      MAX(CASE WHEN COMPONENT_ID = 178 THEN amount ELSE 0 END) AS WORKING_HOURS,
      MAX(CASE WHEN COMPONENT_ID = 180 THEN amount ELSE 0 END) AS HL_HRS,
      MAX(CASE WHEN COMPONENT_ID = 179 THEN amount ELSE 0 END) AS NS_HRS,
      MAX(CASE WHEN COMPONENT_ID = 183 THEN amount ELSE 0 END) AS STL_D,
         MAX(CASE WHEN COMPONENT_ID = 134 THEN amount ELSE 0 END) AS PF_GROSS, 
     MAX(CASE WHEN COMPONENT_ID = 18 THEN amount ELSE 0 END) AS EPF,
     MAX(CASE WHEN COMPONENT_ID = 149 THEN amount ELSE 0 END) AS ESI_GROSS, 
     MAX(CASE WHEN COMPONENT_ID = 19 THEN amount ELSE 0 END) AS ESIC,
     MAX( case when COMPONENT_ID = 224 THEN amount else 0 end ) AS TOTAL_EARNING               
      FROM (
      SELECT 
          EMPLOYEEID, 
          COMPONENT_ID, 
          SUM(amount) AS amount 
      FROM 
          tbl_pay_employee_payroll k 
      LEFT JOIN 
          tbl_pay_period tpp ON k.PAYPERIOD_ID = tpp.ID 
      WHERE 
      tpp.FROM_DATE >='2024-04-01' AND tpp.TO_DATE <='2024-04-30'
          AND tpp.STATUS =3 
          AND k.STATUS =1
          AND k.PAYSCHEME_ID in (151)
          AND k.BUSINESSUNIT_ID = 2 
      GROUP BY 
          EMPLOYEEID, COMPONENT_ID
         ) G GROUP BY EMPLOYEEID  
                 ) k ) v where pfamount>0  
    ) g 
    left join 		
      (select * from tbl_hrms_ed_pf thep where is_active=1) thep on thep.eb_id=g.eb_id
      ) pfdata on pfdata.pf_no=tum.pf_no
   ";      
*/
        
   //     echo $sql;

//        $query = $this->db->query($sql);
        
        $this->db->query($sql);
    
    
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
 
    public function update_monthesidata() {

       // $pfgendate = $this->input->post('pfgendate');
         
      //  $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $companyId = $this->input->post('companyId');
 /*   
        var companyId=$('#companyId').val();
        var record_id=$('#record_id').val();
        var uploadgross = $('#uploadgross').val();
        var uploadesi = $('#uploadesi').val();
        var onlineesi = $('#onlineesi').val();
        var paymentesi = $('#paymentesi').val();
        var challanno = $('#challanno').val();
        var paymentdate = $('#paymentdate').val();
 */
      
        $record_id = $this->input->post('record_id');
        $uploadgross = $this->input->post('uploadgross');
        $uploadesi = $this->input->post('uploadesi');
        $onlineesi = $this->input->post('onlineesi');
        $paymentesi = $this->input->post('paymentesi');
        $challanno = $this->input->post('challanno');
        $paymentdate = $this->input->post('paymentdate');
         

        $pfgendate = $paymentdate;
        $chaldate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        if (strlen($chaldate)<5) {
            $chaldate=NULL;
        }

        $active=1;
        $actv=1;

        $qtype=2;
        $entryMode='M';
 
        $data = array(
            'esi_online_amount' => $onlineesi,
            'esi_online_payment_amount' => $paymentesi,
            'challan_no' => $challanno,
            'Payment_date' => $chaldate,
          
        );   
        $this->db->where('esi_upload_hdr_file_id', $record_id);
        $this->db->update('EMPMILL12.tbl_esi_upload_hdr_file', $data);

     
    
    $response = array(
    'success' => true,
    'savedata'=> 'Updated'
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
      
public function get_esidataupload() {
    $compid = $this->input->post('companyId');
    $compid = $this->input->post('companyId');
    $compid = $this->session->userdata('company_id');
    $incactdate = $this->input->post('upfromdate');
    $upfromdate=substr($incactdate,6,4).'-'.substr($incactdate,3,2).'-'.substr($incactdate,0,2);
    $incactdate = $this->input->post('uptodate');
    $uptodate=substr($incactdate,6,4).'-'.substr($incactdate,3,2).'-'.substr($incactdate,0,2);
 
    

     $sql="select * from EMPMILL12.tbl_esi_upload_hdr_file teuhf where company_id=$compid and is_active=1
     and month_end_date between '$upfromdate' and '$uptodate'
     order by month_end_date desc
     "; 
     $query = $this->db->query($sql );
     $records = $query->result();
     $sln=$query->num_rows();
 
 
     foreach ($records as $record) {
         $data[] = [
             
             $record->esi_upload_hdr_file_id,
             $record->month_end_date,
             $record->esi_upload_gross,
             $record->esi_upload_amount,
             $record->no_of_persons,
             $record->esi_online_amount,
             $record->esi_online_payment_amount,
             $record->challan_no,
             $record->Payment_date,
              
  
         ];
      }
      

 // Return the response
 echo json_encode(['data' => $data]);
     }

     public function create_pfuplodfile() {
        $batchno = $this->input->get('batchno');
        $compid = $this->input->get('companyId');
        $sp = "#~#";
        $sql = "select tphud.*,
            concat(UCASE(substr(MONTHNAME(month_end_date), 1, 3)), substr(month_end_date, 1, 4), '_', batch_process_no) flname 
            from EMPMILL12.tbl_pf_hdr_upload_data tphud 
            where is_active = 1 and batch_process_no = ?";
        
        $query = $this->db->query($sql, array($batchno));
        $data = $query->result_array();
        $files = [];
        
        foreach ($data as $row) {
            $fl = $row['flname'];
            $hdrid = $row['pf_hdr_upload_id'];
            $fileContainer = $fl . ".txt"; // Ensure file has a proper extension
            $filePointer = fopen($fileContainer, "w+");
            $files[] = $fileContainer;
            
            $sqll = "select tplud.*, tum.uan_no uanno, tum.name_as_per_pf_online, 0 refund 
                     from EMPMILL12.tbl_pf_line_upload_data tplud 
                     left join EMPMILL12.tbl_uan_master tum on tum.uan_id = tplud.uan_id 
                     where tplud.pf_hdr_upload_id = ?";
            
            $lquery = $this->db->query($sqll, array($hdrid));
            $ldata = $lquery->result_array();
            $logMsg = '';
            
            foreach ($ldata as $lrow) {
                $logMsg .= $lrow['uanno'] . $sp . $lrow['name_as_per_pf_online'] . $sp . $lrow['gross_wages'] . $sp . $lrow['epf_wages'] .
                           $sp . $lrow['eps_wages'] . $sp . $lrow['edli_wages'] . $sp . $lrow['epf_contribution'] .
                           $sp . $lrow['eps_contribution'] . $sp . $lrow['epf_eps_diff_contribution'] . $sp . $lrow['ncp_days'] .
                           $sp . $lrow['refund'] . "\r\n";
            }
            
            fputs($filePointer, $logMsg);
            fclose($filePointer);
        }
        
        $zipname = 'pffiles.zip';
        $zip = new ZipArchive;
        
        if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        } else {
            exit("Cannot create ZIP file.");
        }
        
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename=' . $zipname);
        header('Content-Length: ' . filesize($zipname));
        
        readfile($zipname);
        
        // Clean up files
        foreach ($files as $file) {
            unlink($file);
        }
        unlink($zipname);
        
        exit();
    }
        

}