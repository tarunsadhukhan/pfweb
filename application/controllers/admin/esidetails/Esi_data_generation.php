<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Esi_data_generation extends CI_Controller {

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
		$this->load->view('admin/esidetails/Esi_data_generation', $data_to_pass);	
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
        $esiyear=substr($pfgendate,6,4);
        $esidays=substr($pfgendate,0,2);
        
        $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
        $companyId = $this->input->post('companyId');
        $active=1;
        $qtype=2;
        $entryMode='M';
		$company_id = $this->session->userdata('company_id');
        
        if ($companyId==2) {
                        $sql="	insert into EMPMILL12.tbl_esi_data_geneated_file (month_end_date,company_id,esi_master_id,esi_gross,
                        esi_days,esi_amount,reason_code,exit_date ) 
                        select '$pfgendate' month_end_date,$companyId company_id , esi_master_id ,esi_gross ,
                        case when esi_days>$esidays then $esidays else esi_days end esi_days  ,esi_amount,
                        reason_code,exit_date from (
                        select tem.esi_master_id,tem.ip_no,tem.ip_name,ifnull(mesi.esi_days,0) esi_days,
                        ifnull(mesi.esi_gross,0) esi_gross,esi_amount,
                        case
                            when is_active=1 and ifnull(mesi.esi_gross, 0)= 0
                            then 11
                            when is_active=1 and ifnull(mesi.esi_gross, 0)>0 then 0 
                            when is_active=0 and exit_reason>0 then exit_reason
                        end reason_code ,
                        case when is_active=0 then tem.exit_date
                        else null end exit_date,is_active 
                        from EMPMILL12.tbl_esi_master tem 
                        left join (
                                    select EMPLOYEEID,esi_no,  		    
                            max( case when esirem='esic' then amount else 0 end ) AS esi_amount,
                        max( case when esirem='esicgross' then amount else 0 end ) AS esi_gross,
                            max( case when esirem='wrkhrs' then ceiling(amount/8) else 0 end ) AS esi_days
                        from (
                            select EMPLOYEEID ,esirem,sum(AMOUNT) AMOUNT from 
                            (
                            SELECT
                            COMPONENT_ID,
                            tpc.NAME,
                            k.EMPLOYEEID ,
                            case when k.COMPONENT_ID =19 then 'esic' 
                            when k.COMPONENT_ID =149 then 'esicgross'
                            when k.COMPONENT_ID =178 then 'wrkhrs'
                            when k.COMPONENT_ID =179 then 'wrkhrs'
                            when k.COMPONENT_ID =180 then 'wrkhrs'
                            when k.COMPONENT_ID =183 then 'wrkhrs' end esirem,
                            case when k.COMPONENT_ID =183 then AMOUNT*8 
                            ELSE AMOUNT end  AMOUNT 
                            FROM
                            tbl_pay_employee_payroll k
                        JOIN vowsls.tbl_pay_employee_payscheme tpep ON 	tpep.EMPLOYEEID = k.EMPLOYEEID
                        left join tbl_pay_period tpp on tpp.ID=k.PAYPERIOD_ID
                        left join	tbl_pay_components tpc on tpc.ID=k.COMPONENT_ID
                        where month(tpp.FROM_DATE)=$esimonth and year(tpp.FROM_DATE )=$esiyear
                        and tpp.PAYSCHEME_ID in (125) and tpep.STATUS=1 
                        and tpp.STATUS =3  and COMPONENT_ID in (19,149,180,179,178,183)
                        union all
                            SELECT
                            COMPONENT_ID,
                            tpc.NAME,
                            k.EMPLOYEEID ,
                            case when k.COMPONENT_ID =19 then 'esic' 
                            when k.COMPONENT_ID =149 then 'esicgross'
                            when k.COMPONENT_ID =178 then 'wrkhrs'
                            when k.COMPONENT_ID =179 then 'wrkhrs'
                            when k.COMPONENT_ID =180 then 'wrkhrs'
                            when k.COMPONENT_ID =183 then 'wrkhrs' end esirem,
                            case when k.COMPONENT_ID =183 then AMOUNT*8 
                            ELSE AMOUNT end  AMOUNT 
                            FROM
                            tbl_pay_employee_payroll k
                        JOIN vowsls.tbl_pay_employee_payscheme tpep ON 	tpep.EMPLOYEEID = k.EMPLOYEEID
                        left join tbl_pay_period tpp on tpp.ID=k.PAYPERIOD_ID
                        left join	tbl_pay_components tpc on tpc.ID=k.COMPONENT_ID
                        where month(tpp.FROM_DATE)=$esimonth and year(tpp.FROM_DATE )=$esiyear
                        and tpp.PAYSCHEME_ID in (151) and tpep.STATUS=1 
                        and tpp.STATUS =3  and COMPONENT_ID in (19,149,180,179,178,183)
                        union all
                        SELECT
                            COMPONENT_ID,
                            tpc.NAME,
                            k.EMPLOYEEID ,
                            case when k.COMPONENT_ID =19 then 'esic' 
                            when k.COMPONENT_ID =224 then 'esicgross'
                            when k.COMPONENT_ID =178  then 'wrkhrs'
                            when k.COMPONENT_ID =179 then 'wrkhrs'
                            when k.COMPONENT_ID =102 then 'wrkhrs'
                            end esirem,
                                AMOUNT 
                            FROM
                            tbl_pay_employee_payroll k
                        JOIN vowsls.tbl_pay_employee_payscheme tpep ON 	tpep.EMPLOYEEID = k.EMPLOYEEID
                        left join tbl_pay_period tpp on tpp.ID=k.PAYPERIOD_ID
                        left join	tbl_pay_components tpc on tpc.ID=k.COMPONENT_ID
                        where month(tpp.FROM_DATE)=$esimonth and year(tpp.FROM_DATE )=$esiyear
                        and tpp.PAYSCHEME_ID in (161) and tpep.STATUS=1 
                        and tpp.STATUS =3  and COMPONENT_ID in (19,224,102,178,179)
                        union all
                        SELECT
                            COMPONENT_ID,
                            tpc.NAME,
                            k.EMPLOYEEID ,
                            case when k.COMPONENT_ID =19 then 'esic' 
                            when k.COMPONENT_ID =66 then 'esicgross'
                            when k.COMPONENT_ID =6  then 'wrkhrs'
                            when k.COMPONENT_ID =179 then 'wrkhrs'
                            when k.COMPONENT_ID =102 then 'wrkhrs'
                            end esirem,
                            case when k.COMPONENT_ID =6 then AMOUNT*8 
                            ELSE AMOUNT end  AMOUNT 
                            FROM
                            tbl_pay_employee_payroll k
                        JOIN vowsls.tbl_pay_employee_payscheme tpep ON 	tpep.EMPLOYEEID = k.EMPLOYEEID
                        left join tbl_pay_period tpp on tpp.ID=k.PAYPERIOD_ID
                        left join tbl_pay_components tpc on tpc.ID=k.COMPONENT_ID
                        where month(tpp.FROM_DATE)=$esimonth and year(tpp.FROM_DATE )=$esiyear
                        and tpp.PAYSCHEME_ID in (102) and tpep.STATUS=1 
                        and tpp.STATUS =3  and COMPONENT_ID in (19,66,6)
                        ) g group by EMPLOYEEID ,esirem
                        ) h left join (select * from tbl_hrms_ed_esi thee where is_active=1) thee on h.EMPLOYEEID=thee.eb_id
                        group by EMPLOYEEID,esi_no
                        ) mesi on mesi.esi_no=tem.ip_no
                        where ( tem.is_active =1 ) or ( MONTH(tem.exit_date)=$esimonth and year(tem.exit_date)=$esiyear)
                        ) v 


                
                ";      
        }

        
/*           $sql="update  EMPMILL12.tbl_esi_data_geneated_file set is_active=0 where month_end_date='$pfgendate' 
          and company_id=$companyId";
          $this->db->query($sql);
 */            

   $sql="	insert into EMPMILL12.tbl_esi_data_geneated_file (month_end_date,company_id,esi_master_id,esi_gross,
   esi_days,esi_amount,reason_code,exit_date ) select '$pfgendate' month_end_date,$companyId company_id , esi_master_id ,esi_gross ,
   case when esi_days>$esidays then $esidays else esi_days end esi_days  ,esi_amount,
   reason_code,exit_date from (
SELECT
  tem.esi_master_id,
  tem.ip_no,
  tem.ip_name,
  COALESCE(mesi.esi_days, 0)   AS esi_days,
  COALESCE(mesi.esi_gross, 0)  AS esi_gross,
  COALESCE(mesi.esi_amount, 0) AS esi_amount,
  CASE
    WHEN tem.is_active = 1 AND COALESCE(mesi.esi_gross, 0) = 0 THEN 11
    WHEN tem.is_active = 1 AND COALESCE(mesi.esi_gross, 0) > 0 THEN 0
    WHEN tem.is_active = 0 AND tem.exit_reason > 0              THEN tem.exit_reason
    ELSE NULL
  END AS reason_code,
  CASE WHEN tem.is_active = 0 THEN tem.exit_date ELSE NULL END AS exit_date,
  tem.is_active,
  tem.company_id
FROM EMPMILL12.tbl_esi_master AS tem
LEFT JOIN (
  SELECT
    k.esi_no,
    MAX(CASE WHEN k.p_type = 'D' THEN CEILING(k.tvalue ) ELSE 0 END) AS esi_days,
    MAX(CASE WHEN k.p_type = 'G' THEN ROUND(k.tvalue, 0)    ELSE 0 END) AS esi_gross,
    MAX(CASE WHEN k.p_type = 'C' THEN k.tvalue              ELSE 0 END) AS esi_amount
  FROM (
    SELECT
      thee.esi_no,
      tpep.COMPONENT_ID,
      tpeol.p_type,
      tpeol.company_id,
      SUM(tpep.AMOUNT * tpeol.amultiply) AS tvalue
    FROM tbl_pay_employee_payroll AS tpep
    JOIN tbl_pay_period AS tpp
      ON tpep.PAYPERIOD_ID = tpp.ID
    LEFT JOIN EMPMILL12.tbl_pf_esi_online_link AS tpeol
      ON tpep.PAYSCHEME_ID = tpeol.payschm_id
     AND tpep.COMPONENT_ID = tpeol.component_id
     AND tpeol.company_id  = $companyId and tpeol.pf_esi='E'
    LEFT JOIN tbl_hrms_ed_esi AS thee
      ON thee.eb_id = tpep.EMPLOYEEID
     AND thee.is_active = 1
    WHERE tpp.STATUS not in (4)
      AND tpep.STATUS = 1
      AND tpeol.payschm_id IS NOT NULL
      AND month(tpp.FROM_DATE)=$esimonth and year(tpp.FROM_DATE )=$esiyear
    GROUP BY
      thee.esi_no, tpep.COMPONENT_ID, tpeol.p_type, tpeol.company_id
  ) AS k
  GROUP BY k.esi_no
) AS mesi
ON tem.ip_no = mesi.esi_no
where 		(tem.is_active=1 or  (MONTH(tem.exit_date)= $esimonth
and year(tem.exit_date)= $esiyear))
    and tem.company_id =$companyId
) g";
 

 //       echo $sql;

//        $query = $this->db->query($sql);
        
        $this->db->query($sql);
    
    
    $response = array(
    'success' => true,
    'savedata'=> 'saved'
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

$sql="   select esi_data_gen_file_id,ip_no,ip_name,esi_days,esi_gross,esi_amount,reason_code ,tedgf.exit_date 
from EMPMILL12.tbl_esi_data_geneated_file tedgf 
join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
where tedgf.month_end_date = '$pfgendate' and tedgf.is_active =1 and tem.company_id = $compid
";
  //   echo $sql;
    $query = $this->db->query($sql, array($compid,$compid ));
    $records = $query->result();
    $sln=$query->num_rows();
    $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->esi_data_gen_file_id,
                $esimonth,
                $record->ip_no,
                $record->ip_name,
                $record->esi_days,
                $record->esi_gross,
                $record->esi_amount,
                $record->reason_code,
                $record->exit_date,
                 
     
            ];
         }

         $sql="   select ' ' esi_data_gen_file_id,' ' ip_no,' ' ip_name,sum(esi_days) esi_days ,
         sum(esi_gross) esi_gross ,sum(esi_amount) esi_amount ,' ' reason_code ,' ' exit_date from(
         select esi_data_gen_file_id,ip_no,ip_name,esi_days,esi_gross,esi_amount,reason_code ,tedgf.exit_date 
         from EMPMILL12.tbl_esi_data_geneated_file tedgf 
         join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
         where tedgf.month_end_date = '$pfgendate' and tedgf.is_active =1 and tem.company_id = $compid
         ) g ";
             $query = $this->db->query($sql, array($compid,$compid ));
            $records = $query->result();
            $sln=$query->num_rows();
            if ($sln>0) { 
            foreach ($records as $record) {
                if ( $record->esi_days>0) {
                $data[] = [
                    '',
                    'Grand Total',
                    '',
                    '',
                    $record->esi_days,
                    $record->esi_gross,
                    $record->esi_amount,
                    '',
                    '',
                        
         
                ];
                       }       }
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
        $sql="select count(*) cnt from EMPMILL12.tbl_esi_upload_data_file teudf 
        join EMPMILL12.tbl_esi_data_geneated_file tedgf on teudf.esi_data_gen_file_id =tedgf.esi_data_gen_file_id 
        where month_end_date='$pfgendate' and teudf.is_active =1 and tedgf.company_id=$companyId
        ";
//        echo $sql;
        $query = $this->db->query($sql);
        $records = $query->result();
        foreach ($records as $record) {
                $sln=$record->cnt;
        }        
      if ($sln>0) {
            $msg="Cannot Cancel , Already Challan Upload file created";
            $msgno=1;
        } else {
        $sql="update EMPMILL12.tbl_esi_data_geneated_file set is_active=0 where company_id=".$companyId." 
        and month_end_date='".$pfgendate."'";
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
  
       $sql="   select esi_data_gen_file_id,ip_no,ip_name,esi_days,esi_gross,esi_amount,reason_code ,tedgf.exit_date 
       from EMPMILL12.tbl_esi_data_geneated_file tedgf 
       join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
       where tedgf.month_end_date = '$pfgendate' and tedgf.is_active =1 and tem.company_id = $compid
       ";
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



//echo 'aha-'.$sdate;

//$sdate='01-06-2023';
//$edate='30-06-2023';
//$compid=2;
//$payScheme = $this->input->GET('payScheme');

//echo 'date-'.$sdate;
 	$date=substr($sdate,6,4).'-'.substr($sdate,3,2).'-'.substr($sdate,0,2);
    $pfgendate=$date;
  
     $sql=" select 1 rem,'$sdate' month_end_date , esi_data_gen_file_id,ip_no,ip_name,esi_days,esi_gross,
     esi_amount,reason_code ,tedgf.exit_date 
     from EMPMILL12.tbl_esi_data_geneated_file tedgf 
 join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
 where tedgf.month_end_date = '$date' and tedgf.is_active =1 and tem.company_id = $compid
 union all
 select 2 rem,'$date' month_end_date,' ' esi_data_gen_file_id,'Grand Total ' ip_no,' ' ip_name,sum(esi_days) esi_days ,
      sum(esi_gross) esi_gross ,sum(esi_amount) esi_amount ,' ' reason_code ,' ' exit_date from(
    select 1 rem,esi_data_gen_file_id,ip_no,ip_name,esi_days,esi_gross,esi_amount,reason_code ,tedgf.exit_date 
     from EMPMILL12.tbl_esi_data_geneated_file tedgf 
 join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
 where tedgf.month_end_date = '$date' and tedgf.is_active =1 and tem.company_id = $compid
 ) g
 ";

$sql="select
	v.*,
	tpep.PAY_SCHEME_ID  PAYSCHEME_ID
from
	(
	select
		1 rem,
		'$date' month_end_date ,
		esi_data_gen_file_id,
		ip_no,
		ip_name,
		esi_days,
		esi_gross,
		esi_amount,
		reason_code ,
		tedgf.exit_date
	from
		EMPMILL12.tbl_esi_data_geneated_file tedgf
	join EMPMILL12.tbl_esi_master tem on
		tem.esi_master_id = tedgf.esi_master_id
		where
		tedgf.month_end_date = '$date'
		and tedgf.is_active = 1
		and tem.company_id = $compid
) v
	left join vowsls.tbl_hrms_ed_esi thee on thee.esi_no =ip_no and thee.is_active =1
	left join vowsls.tbl_hrms_ed_personal_details thepd on thee.eb_id=thepd.eb_id and thepd.is_active =1   
	left join vowsls.tbl_hrms_ed_official_details theod on thepd.eb_id=theod.eb_id and theod.is_active =1   
	left join vowsls.tbl_pay_employee_payscheme tpep on tpep.EMPLOYEEID =thee.eb_id and tpep.STATUS =1 
	where thepd.company_id =$compid
";

/*  union all
 select 2 rem,'$date' month_end_date,' ' esi_data_gen_file_id,'Grand Total ' ip_no,' ' ip_name,0 esi_days ,
      0 esi_gross ,0 esi_amount ,' ' reason_code ,' ' exit_date from(
    select 1 rem,esi_data_gen_file_id,ip_no,ip_name,esi_days,esi_gross,esi_amount,reason_code ,tedgf.exit_date 
     from EMPMILL12.tbl_esi_data_geneated_file tedgf 
 join EMPMILL12.tbl_esi_master tem on tem.esi_master_id =tedgf.esi_master_id 
 where tedgf.month_end_date = '$date' and tedgf.is_active =1 and tem.company_id = $compid
 */

echo $sql;
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

	$sheet->setCellValue('A2', 'IP No ');
	$sheet->setCellValue('b2', 'IP Name');
	$sheet->setCellValue('c2', 'ESI Days');
	$sheet->setCellValue('d2', 'ESIC Gross');
	$sheet->setCellValue('e2', 'ESI Amount');
	$sheet->setCellValue('f2', 'Reason Code');
	$sheet->setCellValue('g2', 'Exit Date');
    $sheet->setCellValue('h2', 'Pay Scheme');
    
 
    
	$rowIndex = 3;
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
			$columnIndex++;
            $value=$record->esi_gross;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->esi_amount;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->reason_code;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->exit_date;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            $value=$record->PAYSCHEME_ID;
        	$sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
			$columnIndex++;
            
 
        
            $cl='A'.$rowIndex.":h".$rowIndex;
            $sheet->getStyle($cl)->applyFromArray($styleArray);
        
        

            //		}
		$rowIndex++;
	}	

 
    $sheet->getColumnDimension('B')->setAutoSize(TRUE);
    $sheet->getColumnDimension('c')->setAutoSize(TRUE);
    $sheet->getColumnDimension('d')->setAutoSize(TRUE);
    $sheet->getColumnDimension('e')->setAutoSize(TRUE);
    $sheet->getColumnDimension('f')->setAutoSize(TRUE);
    $sheet->getColumnDimension('g')->setAutoSize(TRUE);
  
	$sheet->getColumnDimension('A')->setWidth(20);


	$sheet->mergeCells('A1:g1');
	$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $filename="esidata_".$sdate.'.xlsx';
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