<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Pfdatageneration extends CI_Controller {

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
		$this->load->view('admin/uandetails/Pfdatageneration', $data_to_pass);	
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
 
    
    public function gen_monthpfdata() {

        $pfgendate = $this->input->post('pfgendate');
        $stdate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.'01';
        $mn=substr($pfgendate,3,2);
        $myr=substr($pfgendate,6,4)/4;
                $compid = $this->session->userdata('company_id');
//echo 'comp id '.$compid;
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

        $companyId = $compid;

      //  echo 'comp id '.$companyId;
        $active=1;

        $qtype=2;
        $entryMode='M';
    
    
        

        
    $sql="		
    insert into EMPMILL12.tbl_pf_generation(uan_id,gross_wages,epf_wages,eps_wages,edli_wages,
epf_contibution,eps_contribution,
epf_eps_diff_contribution,ncp_days,refund,is_active,psch_id,month_end_date,company_id )
 select tum.uan_id,case when IFNULL(gwages,0)<=15000 then  ifnull(gwages,0) else 15000 end gwages,
case when ifnull(gwages,0)<=15000 then ifnull(gwages,0) else 15000 end epfwages,case when 
ifnull(gwages,0)<=15000 then ifnull(gwages,0) else 15000 end epswages,case when ifnull(gwages,0)<=15000 
then ifnull(gwages,0) else 15000 end edliwages,
ifnull(epf_amount,0) epfcont,ifnull(epsamt,0) epsamt,ifnull(epfepsdf,0) epfepsdf,
CEIL(ifnull(ncpdays,0)) ncpdays,0 refund,1,0,'$pfgendate',$companyId  from EMPMILL12.tbl_uan_master tum 
 left join (		
 select pf_uan_no,round(pfgross,0) gwages,round(pfgross,0) epfwages,
round(pfgross,0) epswages,round(pfgross,0) edliwages,
epf_amount epf_amount,
round((epf_amount/10*8.33),0) epsamt,
epf_amount-round((epf_amount/10*8.33),0) epfepsdf, case when ($esidays-pf_days)>=0 then ($esidays-pf_days) 
else 0 end ncpdays,
0 refund,1 act from (
            select EMPLOYEEID,pf_uan_no,  		    
         max( case when esirem='epf' then amount else 0 end ) AS epf_amount,
      max( case when esirem='pfgross' then amount else 0 end ) AS pfgross,
        max( case when esirem='wrkhrs' then ceiling(amount/8) else 0 end ) AS pf_days
       from (
        select EMPLOYEEID ,esirem,sum(AMOUNT) AMOUNT from 
        (
          SELECT
        COMPONENT_ID,
        tpc.NAME,
        k.EMPLOYEEID ,
        case when k.COMPONENT_ID =18 then 'epf' 
        when k.COMPONENT_ID =134 then 'pfgross'
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
    and tpp.STATUS =3  and COMPONENT_ID in (18,134,180,179,178,183)
       union all
          SELECT
        COMPONENT_ID,
        tpc.NAME,
        k.EMPLOYEEID ,
        case when k.COMPONENT_ID =18 then 'epf' 
        when k.COMPONENT_ID =134 then 'pfgross'
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
    and tpp.STATUS =3  and COMPONENT_ID in (18,134,180,179,178,183)
    union all
    SELECT
        COMPONENT_ID,
        tpc.NAME,
        k.EMPLOYEEID ,
        case when k.COMPONENT_ID =19 then 'esic' 
        when k.COMPONENT_ID =224 then 'pfgross'
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
        case when k.COMPONENT_ID =18 then 'epf' 
        when k.COMPONENT_ID =7 then 'pfgross'
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
    and tpp.STATUS =3  and COMPONENT_ID in (7,6,18)
    ) g group by EMPLOYEEID ,esirem
    ) h left join (select * from tbl_hrms_ed_pf thep 
     where is_active=1) thep on h.EMPLOYEEID=thep.eb_id
    group by EMPLOYEEID,pf_uan_no
    ) k 			where epf_amount>0		
    )
    pfdata on pfdata.pf_uan_no=tum.uan_no
    where 
     tum.is_active=1 and (tum.date_of_uan_inactive>='$stdate' or date_of_uan_inactive is null)
     and tum.company_id=$companyId"; 


    if ($pfgendate<='2025-08-31') {
        $main=1;
    } else {$main=0; }


    $sql="insert into EMPMILL12.tbl_pf_generation(uan_id,gross_wages,epf_wages,eps_wages,edli_wages,
    epf_contibution,eps_contribution,
    epf_eps_diff_contribution,ncp_days,refund,is_active,psch_id,month_end_date,company_id )
    select uan_id,gwages,epfwages,epswages,edliwages,round(epfwages*.1,0) epfcont,round(epswages*8.33/100,0) epsamt, 
    round(epfwages*.1,0)-round(epswages*8.33/100,0) epfepsdf,CEIL(ifnull(ncpdays,$ld)) ncpdays,0 refund,1 act,pschmid,'$pfgendate' mnd,$compid compid from (
    select pf_uan_no,tum.uan_no,tum.uan_id,case when IFNULL(gwages,0)<=15000 then  ifnull(gwages,0) else 15000 end gwages,
    case when ifnull(gwages,0)<=15000 then ifnull(gwages,0) else 15000 end epfwages,case when 
    ifnull(gwages,0)<=15000 then ifnull(gwages,0) else 15000 end epswages,case when ifnull(gwages,0)<=15000 
    then ifnull(gwages,0) else 15000 end edliwages,
    ifnull(epf_amount,0) epfcont,0 refund,1,0,'$pfgendate',$companyId compid,
    case when month(tum.date_of_uan_inactive)=month('$stdate') and year(tum.date_of_uan_inactive)=year('$stdate') then day(tum.date_of_uan_inactive)-1
    else $ld-Days end ncpdays, pschmid from EMPMILL12.tbl_uan_master tum 
    left join (		
    SELECT
        k.pf_uan_no,
        MAX(CASE WHEN k.p_type = 'G' THEN ROUND(k.tvalue, 0)    ELSE 0 END) AS gwages,
        MAX(CASE WHEN k.p_type = 'C' THEN k.tvalue              ELSE 0 END) AS epf_amount,
        MAX(CASE WHEN k.p_type = 'D' THEN CEILING(k.tvalue/8) ELSE 0 END) AS Days,
        1 act,pschmid
        FROM (
      SELECT
          thep.pf_uan_no,tpep.PAYSCHEME_ID pschmid,
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
         AND tpeol.company_id  = $companyId  and tpeol.pf_esi='P'
        LEFT JOIN tbl_hrms_ed_pf AS thep
          ON thep.eb_id = tpep.EMPLOYEEID
         AND thep.is_active = 1
        WHERE tpp.STATUS not in (4)
          AND tpep.STATUS = 1
          AND tpeol.payschm_id IS NOT NULL
          and month(tpp.FROM_DATE)=$esimonth and year(tpp.FROM_DATE )=$esiyear
          GROUP BY
          thep.pf_uan_no, tpep.COMPONENT_ID, tpeol.p_type, tpeol.company_id,tpep.PAYSCHEME_ID 
          ) AS k
      GROUP BY k.pf_uan_no,pschmid
      )
          pfdata on pfdata.pf_uan_no=tum.uan_no
        where 
        tum.is_active=1 and (tum.date_of_uan_inactive>='$stdate' or date_of_uan_inactive is null)
        and tum.company_id=$companyId 
            ) g
    ";        

//echo $sql;


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
  //      echo $sql;
    
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
                $record->refund,
                
     
            ];
         }
         $sql="select '' uan_no,'Grand Total' name_as_per_pf_online,sum(gross_wages) gross_wages,sum(epf_wages) epf_wages,
         sum(eps_wages) eps_wages,sum(edli_wages) edli_wages,sum(epf_contibution) epf_contibution,sum(eps_contribution) eps_contribution,
         sum(epf_eps_diff_contribution) epf_eps_diff_contribution,sum(ncp_days) ncp_days,0 refund from (
         select tum.uan_no,tum.name_as_per_pf_online,tpg.* from EMPMILL12.tbl_pf_generation tpg 
         left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
         where tpg.is_active=1 and month_end_date='$pfgendate' and tpg.company_id=$compid ) g";
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
         //       echo $sql;
            
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
                    $record->refund,
                    
         
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
        $sln=0;
        $msgno=1;
        $sql="select count(*) cnt from EMPMILL12.tbl_pf_hdr_upload_data where 
        month_end_date='".$pfgendate."' and trrn_status in (2,3) and company_id=$companyId";
    //    echo $sql;
        $query = $this->db->query($sql);
        $records = $query->result();
        foreach ($records as $record) {
                $sln=$record->cnt;
        }        
      if ($sln>0) {
            $msg="Cannot Cancel , Already Challan Upload file created";
            $msgno=1;
        } else {
        $sql="update EMPMILL12.tbl_pf_generation set is_active=0 where company_id=".$companyId." and month_end_date='".$pfgendate."'";
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
 



 
    public function get_pfdataexists() {
        $compid = $this->input->post('companyId');
        $compid = $this->input->post('companyId');
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
       $pfgendate=substr($pfgendate,6,4).'-'.substr($pfgendate,3,2).'-'.substr($pfgendate,0,2);
  
         $sql="
         select tum.uan_no,tum.name_as_per_pf_online,tpg.* from EMPMILL12.tbl_pf_generation tpg 
         left join EMPMILL12.tbl_uan_master tum on tpg.uan_id =tum.uan_id 
         where tpg.is_active=1 and month_end_date='$pfgendate' and tpg.company_id=$compid" ;
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
	$sheet->setCellValue('k2', 'Refund');
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
            $value=$record->refund;
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
      


}