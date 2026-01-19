<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uanmaster_Model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
//        $this->load->database('vowsls', TRUE);  // Loads the default database (Doff entry database)
    }

    public function getspgqualityselData($date, $compid,$spgquality_id) {
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $sql="select ";
    
    
        $sql="select wqm.quality_code wnd_q_code,wqm.quality_name QUALITY,ifnull(tpwqm.spg_actual_count,0) spg_actual_count  from tbl_prod_weaving_quality_mapping tpwqm 
        left join weaving_quality_master wqm on tpwqm.quality_id =wqm.quality_id and wqm.company_id =tpwqm.company_id 
        where mapping_date ='".$date."' and tpwqm.company_id =".$company_id." and tpwqm.quality_type =2 and tpwqm.is_active =1";
    
    
    
        
    
        $sql='select q_code wnd_q_code,concat(q_code,"-",std_count,"LBS-",subgroup_type) QUALITY from spining_master where company_id='.$company_id.'  and is_active=1 order by q_code';
        $otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $resultq = $otherdb->query($sql)->result_array();
    //	echo $otherdb->last_query();
    //	var_dump($resultq);
        return $resultq;
    
    
    }
    
    

}