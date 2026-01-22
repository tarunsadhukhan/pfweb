<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pfupload_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->database('empmill12', TRUE);
    }

    /**
     * Get UAN name by UAN number and company ID
     */
    public function getUanName($uanno, $companyId) {
        $sql = "SELECT uan_id, name_as_per_pf_online 
                FROM EMPMILL12.tbl_uan_master
                WHERE is_active = 1 AND uan_no = ? AND company_id = ?";
        $query = $this->db->query($sql, array($uanno, $companyId));
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return array(
                'found' => true,
                'name' => $row->name_as_per_pf_online,
                'uanid' => $row->uan_id
            );
        }
        return array('found' => false, 'name' => '', 'uanid' => 0);
    }

    /**
     * Get employee name by EB number and company ID
     */
    public function getEbName($ebno, $companyId) {
        $sql = "SELECT emp_code, CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', IFNULL(last_name, ' ')) AS wname,
                thep.pf_no, thep.pf_uan_no, thepd.eb_id
                FROM tbl_hrms_ed_personal_details thepd 
                LEFT JOIN (SELECT eb_id, emp_code FROM tbl_hrms_ed_official_details theod WHERE is_active = 1) theod 
                    ON theod.eb_id = thepd.eb_id 
                LEFT JOIN (SELECT * FROM tbl_hrms_ed_pf thep WHERE is_active = 1) thep 
                    ON theod.eb_id = thep.eb_id
                WHERE theod.emp_code = ? AND thepd.company_id = ?";
        
        $query = $this->db->query($sql, array($ebno, $companyId));
        
        $result = array(
            'found' => false,
            'name' => '',
            'uanno' => '',
            'pfno' => '',
            'uanid' => 0,
            'ebfound' => ''
        );
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result['found'] = true;
            $result['name'] = $row->wname;
            $result['uanno'] = $row->pf_uan_no;
            $result['pfno'] = $row->pf_no;
        }
        
        // Check if EB exists in UAN master
        $sql2 = "SELECT uan_id, name_as_per_pf_online 
                 FROM EMPMILL12.tbl_uan_master
                 WHERE is_active = 1 AND eb_no = ? AND company_id = ?";
        $query2 = $this->db->query($sql2, array($ebno, $companyId));
        
        if ($query2->num_rows() > 0) {
            $row2 = $query2->row();
            $result['ebfound'] = $row2->name_as_per_pf_online;
            $result['uanid'] = $row2->uan_id;
        }
        
        return $result;
    }

    /**
     * Insert new UAN master record
     */
    public function insertUanMaster($data) {
        $this->db->insert('EMPMILL12.tbl_uan_master', $data);
        return $this->db->insert_id();
    }

    /**
     * Update UAN master record
     */
    public function updateUanMaster($record_id, $data) {
        $this->db->where('uan_id', $record_id);
        return $this->db->update('EMPMILL12.tbl_uan_master', $data);
    }

    /**
     * Check if PF upload data already exists for the month
     */
    public function checkPfUploadExists($gdate, $upshare, $companyId) {
        $sql = "SELECT pf_hdr_upload_id FROM EMPMILL12.tbl_pf_hdr_upload_data 
                WHERE month_end_date = ? AND trrn_type = ? AND company_id = ? 
                AND is_active = 1 AND trrn_status IN (2, 3)";
        $query = $this->db->query($sql, array($gdate, $upshare, $companyId));
        return $query->num_rows() > 0;
    }

    /**
     * Check PF upload header exists with status
     */
    public function getPfUploadHeader($gdate, $upshare, $companyId) {
        $sql = "SELECT pf_hdr_upload_id FROM EMPMILL12.tbl_pf_hdr_upload_data 
                WHERE month_end_date = ? AND trrn_type in (1,2,3) AND company_id = ? 
                AND is_active = 1 AND trrn_status IN (2,3) and main=1";
        $query = $this->db->query($sql, array($gdate,  $companyId));
        
        if ($query->num_rows() > 0) {
            return $query->row()->pf_hdr_upload_id;
        }
        return 0;
    }

    /**
     * Insert PF header upload data
     */
    public function insertPfHdrUploadData($gdate, $upshare, $companyId, $main = 1) {
        $sql = "INSERT INTO EMPMILL12.tbl_pf_hdr_upload_data (
                    trrn_amount, trrn_status, month_end_date, ac_1_amount, ac_2_amount,
                    ac_10_amount, ac_21_amount, ac_22_amount, trrn_type, is_active,
                    company_id, batch_process_no, main
                ) 
                SELECT 0 tramt, 2 stat, ?, 0 ac1, 0 ac2, 0 ac10, 0 ac21, 0 ac22, ?, 1 act, ?,
                    (SELECT IFNULL(MAX(batch_process_no), 0) + 1 mbatchno FROM EMPMILL12.tbl_pf_hdr_upload_data), ?";
        $this->db->query($sql, array($gdate, $upshare, $companyId, $main));
    }

    /**
     * Get max PF header ID and batch number
     */
    public function getMaxPfHdrId() {
        $sql = "SELECT MAX(pf_hdr_upload_id) maxpfhdrid, MAX(batch_process_no) mbatchno 
                FROM EMPMILL12.tbl_pf_hdr_upload_data";
        $query = $this->db->query($sql);
        $row = $query->row();
        return array(
            'maxpfhdrid' => $row->maxpfhdrid,
            'mbatchno' => $row->mbatchno
        );
    }

    /**
     * Get PF line upload summary for header update
     */
    public function getPfLineSummary($maxpfhdrid) {
        $sql = "SELECT SUM(epf_contribution) epf_contribution, SUM(eps_contribution) eps_contribution,
                SUM(epf_eps_diff_contribution) epf_eps_diff_contribution,
                SUM(epf_contribution + eps_contribution + epf_eps_diff_contribution) pfcont,
                CASE WHEN SUM(epf_contribution) > 0 THEN ROUND(SUM(epf_wages) * 1/100, 0) ELSE 0 END admchgs 
                FROM EMPMILL12.tbl_pf_line_upload_data 
                WHERE pf_hdr_upload_id = ?";
        $query = $this->db->query($sql, array($maxpfhdrid));
        return $query->row();
    }

    /**
     * Get PF line upload summary with gross wages
     */
    public function getPfLineSummaryGross($maxpfhdrid) {
        $sql = "SELECT SUM(epf_contribution) epf_contribution, SUM(eps_contribution) eps_contribution,
                SUM(epf_eps_diff_contribution) epf_eps_diff_contribution,
                SUM(epf_contribution + eps_contribution + epf_eps_diff_contribution) pfcont,
                CASE WHEN SUM(epf_contribution) > 0 THEN ROUND(SUM(gross_wages) * 1/100, 0) ELSE 0 END admchgs 
                FROM EMPMILL12.tbl_pf_line_upload_data 
                WHERE pf_hdr_upload_id = ?";
        $query = $this->db->query($sql, array($maxpfhdrid));
        return $query->row();
    }

    /**
     * Update PF header with calculated amounts
     */
    public function updatePfHdrAmounts($maxpfhdrid, $trnamt, $epfcont, $epscont, $admchgs) {
        $sql = "UPDATE EMPMILL12.tbl_pf_hdr_upload_data SET 
                    trrn_amount = ?,
                    ac_1_amount = ?,
                    ac_10_amount = ?,
                    ac_2_amount = ROUND(? / 2, 0),
                    ac_21_amount = ROUND(? / 2, 0)
                WHERE pf_hdr_upload_id = ?";
        $this->db->query($sql, array($trnamt, $epfcont, $epscont, $admchgs, $admchgs, $maxpfhdrid));
    }

    /**
     * Update PF header status to inactive
     */
    public function updatePfHdrStatusInactive($maxpfhdrid) {
        $sql = "UPDATE EMPMILL12.tbl_pf_hdr_upload_data SET trrn_status = 1 WHERE pf_hdr_upload_id = ?";
        $this->db->query($sql, array($maxpfhdrid));
    }

    /**
     * Get pending PF generation data (for dates before cutoff)
     */
    public function getPendingPfGenDataOld($gdate, $companyId, $trtp) {
        $sql = "SELECT tpg.*, NULL AS puanid
                FROM EMPMILL12.tbl_pf_generation tpg
                JOIN EMPMILL12.tbl_uan_master tum ON tum.uan_id = tpg.uan_id
                WHERE tpg.month_end_date = ?
                    AND tpg.is_active = 1
                    AND tpg.company_id = ?
                    AND tum.adhar_seeded = 1
                    AND NOT EXISTS (
                        SELECT 1
                        FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                        JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                            ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id AND tplud.is_active = 1
                        WHERE tphud.trrn_status IN (2, 3)
                            AND tphud.company_id = ?
                            AND tphud.trrn_type IN ({$trtp})
                            AND tphud.is_active = 1
                            AND tphud.month_end_date = ?
                            AND tplud.uan_id = tpg.uan_id
                    )";
        $query = $this->db->query($sql, array($gdate, $companyId, $companyId, $gdate));
        return $query->num_rows();
    }

    /**
     * Get pending PF generation data (for dates after cutoff)
     */
    public function getPendingPfGenDataNew($gdate, $companyId, $trtp) {
        // Use NOT EXISTS logic to find pending PF generation data for new dates
        $sql = "SELECT tpg.*, NULL AS puanid
                FROM EMPMILL12.tbl_pf_generation tpg
                JOIN EMPMILL12.tbl_uan_master tum ON tum.uan_id = tpg.uan_id
                WHERE tpg.month_end_date = ?
                    AND tpg.is_active = 1
                    AND tpg.company_id = ?
                    AND tum.adhar_seeded = 1
                    AND NOT EXISTS (
                        SELECT 1
                        FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                        JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                            ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id AND tplud.is_active = 1
                        WHERE tphud.trrn_status IN (2, 3)
                            AND tphud.company_id = ?
                            AND tphud.trrn_type IN ({$trtp})
                            AND tphud.is_active = 1
                            AND tphud.month_end_date = ?
                            AND tplud.uan_id = tpg.uan_id
                            AND IFNULL(tphud.main, 0) > 1
                    )";
//                    echo $sql;
//                    echo $trtp;
        $query = $this->db->query($sql, array($gdate, $companyId, $companyId, $gdate));
        return $query->num_rows();
    }

    /**
     * Insert PF line upload data - All EPF+EPS (upshare=1, old dates)
     */
    public function insertPfLineAllOld($maxpfhdrid, $gdate, $companyId, $upshare) {
  
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
            pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages, edli_wages,
            epf_contribution, eps_contribution, epf_eps_diff_contribution, ncp_days, pf_gen_id, is_active
        )
        SELECT ?, tpg.uan_id, tum.uan_no, tpg.gross_wages, tpg.epf_wages,
            tpg.eps_wages, tpg.edli_wages, ROUND(tpg.epf_wages * 0.1, 0) AS epf_contribution,
            ROUND(tpg.eps_wages * 0.0833, 0) AS eps_contribution,
            ROUND(tpg.epf_wages * 0.1, 0) - ROUND(tpg.eps_wages * 0.0833, 0) AS epf_eps_diff_contribution,
            tpg.ncp_days, tpg.pf_gen_id, 1 AS is_active
        FROM EMPMILL12.tbl_pf_generation AS tpg
        LEFT JOIN EMPMILL12.tbl_uan_master AS tum ON tpg.uan_id = tum.uan_id
        WHERE tpg.month_end_date = ?
            AND tum.adhar_seeded = 1
            AND tpg.company_id = ?
            AND tpg.is_active = 1
            AND NOT EXISTS (
                SELECT 1
                FROM EMPMILL12.tbl_pf_line_upload_data tplud
                JOIN EMPMILL12.tbl_pf_hdr_upload_data tphud ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                WHERE tplud.is_active = 1
                    AND tphud.is_active = 1
                    AND tphud.trrn_status IN (2,3)
                    AND tphud.month_end_date = ?
                    AND tplud.pf_gen_id = tpg.pf_gen_id
                    AND tplud.uan_id = tpg.uan_id
                    and tphud.company_id=?
            )";
//echo $sql;
//echo $maxpfhdrid . ' - ' . $gdate . ' - ' . $companyId . "\n";
    $this->db->query($sql, array($maxpfhdrid, $gdate, $companyId, $gdate, $companyId));
    }

    /**
     * Insert PF line upload data - All EPF+EPS (upshare=1, new dates)
     */
    public function insertPfLineAllNew($maxpfhdrid,$gdate, $curhdrid, $upshare) {
        $upshr='';
        if ($upshare==1){
            $upshr='1,2,3';
        }
        if ($upshare==2){
            $upshr='1,2';
        }
        if ($upshare==3){
            $upshr='1,3';
        }
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                ) 
                SELECT ?, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active 
                FROM EMPMILL12.tbl_pf_line_upload_data tpg
                WHERE pf_hdr_upload_id = ?
                AND NOT EXISTS (
                    SELECT 1 
                    FROM EMPMILL12.tbl_pf_line_upload_data tplud
                    INNER JOIN EMPMILL12.tbl_pf_hdr_upload_data tphud 
                        ON tplud.pf_hdr_upload_id = tphud.pf_hdr_upload_id 
                    WHERE tplud.is_active = 1 
                        AND IFNULL(tphud.main, 0) > 1 
                        AND tphud.month_end_date = ?
                        AND tplud.pf_gen_id = tpg.pf_gen_id 
                        AND tplud.uan_id = tpg.uan_id
                        AND tphud.trrn_type not in ($upshr)
                        and tphud.trrn_status in (2,3)

                )";

//        echo $sql;
//        echo $maxpfhdrid . ' - ' . $gdate . ' - ' . $curhdrid . "\n";
        $this->db->query($sql, array($maxpfhdrid, $curhdrid, $gdate));
    }

    /**
     * Insert PF line upload data - EPF Only (upshare=2, old dates)
     */
    public function insertPfLineEpfOnlyOld($maxpfhdrid, $gdate, $companyId) {
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages,epf_wages, eps_wages, edli_wages,
                    epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                )
                SELECT ?, tpg.uan_id, tum.uan_no, tpg.gross_wages,tpg.epf_wages, 0 AS eps_wages,
                    0 AS edli_wages, ROUND(tpg.gross_wages * 0.10, 0) AS epf_contribution,
                    0 AS eps_contribution, 0 AS epf_eps_diff_contribution,
                    tpg.ncp_days, tpg.pf_gen_id, 1 AS is_active
                FROM EMPMILL12.tbl_pf_generation tpg
                JOIN EMPMILL12.tbl_uan_master tum ON tum.uan_id = tpg.uan_id
                WHERE tpg.month_end_date = ?
                    AND tpg.is_active = 1
                    AND tpg.company_id = ?
                    AND tum.adhar_seeded = 1
                    AND NOT EXISTS (
                        SELECT 1
                        FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                        JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                            ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id AND tplud.is_active = 1
                        WHERE tphud.trrn_status IN (2, 3)
                            AND tphud.company_id = ?
                            AND tphud.trrn_type IN (1, 2)
                            AND tphud.is_active = 1
                            AND tphud.month_end_date = tpg.month_end_date
                            AND tplud.uan_id = tpg.uan_id
                    )";
        $this->db->query($sql, array($maxpfhdrid, $gdate, $companyId, $companyId));
    }

    /**
     * Insert PF line upload data - EPF Only (upshare=2, new dates)
     */
    public function insertPfLineEpfOnlyNew($maxpfhdrid, $gdate, $curhdrid, $upshare) {
    
    $upshr = '';
        if ($upshare == 1) {
            $upshr = '1,2,3';
        }
        if ($upshare == 2) {
            $upshr = '1,2';
        }
        if ($upshare == 3) {
            $upshr = '1,3';
        }

        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                )
                SELECT ?, uan_id, uan_no, gross_wages, epf_wages, 0 eps_wages,
                    0 edli_wages, epf_contribution, 0 eps_contribution, 0 epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                FROM EMPMILL12.tbl_pf_line_upload_data tpg
                WHERE pf_hdr_upload_id = ?
                AND NOT EXISTS (
                    SELECT 1
                    FROM EMPMILL12.tbl_pf_line_upload_data tplud
                    INNER JOIN EMPMILL12.tbl_pf_hdr_upload_data tphud
                        ON tplud.pf_hdr_upload_id = tphud.pf_hdr_upload_id
                    WHERE tplud.is_active = 1
                        AND IFNULL(tphud.main, 0) > 1
                        AND tphud.month_end_date = ?
                        AND tplud.pf_gen_id = tpg.pf_gen_id
                        AND tplud.uan_id = tpg.uan_id
                        AND tphud.trrn_type not in ($upshr)
                        AND tphud.trrn_status in (2,3)
                )";
//        echo $sql;
//        echo $maxpfhdrid . ' - ' . $gdate . ' - ' . $curhdrid . ' - ' . $upshr . "\n";
    
    $this->db->query($sql, array($maxpfhdrid, $curhdrid, $gdate));
        // Update header after insert
//        $this->updatePfHdrAfterLineInsert($maxpfhdrid);
    }
//     * Insert PF line upload data - EPS Only (upshare=3, old dates)
    /**
     * Insert PF line upload data - EPS Only (upshare=3, old dates)
     */
    public function insertPfLineEpsOnlyOld($maxpfhdrid, $gdate, $companyId) {
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                ) 
                SELECT ?, tpg.uan_id, tum.uan_no, tpg.gross_wages, tpg.epf_wages,
                    eps_wages, 0 edli_wages, 0 epf_contibution, eps_contribution,
                    epf_eps_diff_contribution, 0 ncp_days, tpg.pf_gen_id, 1 AS active 
                FROM EMPMILL12.tbl_pf_generation AS tpg
                LEFT JOIN EMPMILL12.tbl_uan_master AS tum ON tpg.uan_id = tum.uan_id
                LEFT JOIN (
                    SELECT tplud.pf_gen_id, tplud.uan_id uanid, SUM(tplud.eps_contribution) epscontribution 
                    FROM EMPMILL12.tbl_pf_line_upload_data AS tplud
                    WHERE tplud.is_active = 1  
                    GROUP BY tplud.pf_gen_id, tplud.uan_id
                ) x ON x.pf_gen_id = tpg.pf_gen_id 
                WHERE tpg.month_end_date = ?
                    AND tum.adhar_seeded = 1
                    AND tpg.company_id = ?
                    AND tpg.is_active = 1
                    AND x.epscontribution IS NULL";
        $this->db->query($sql, array($maxpfhdrid, $gdate, $companyId));
    }

    /**
     * Insert PF line upload data - EPS Only (upshare=3, new dates)
     */
    public function insertPfLineEpsOnlyNew($maxpfhdrid, $curhdrid, $upshare,$gdate) {
        $upshr = '';
        if ($upshare == 1) {
            $upshr = '1,2,3';
        }
        if ($upshare == 2) {
            $upshr = '1,3';
        }
        if ($upshare == 3) {
            $upshr = '1,2';
        }


        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                )
                SELECT ?, uan_id, uan_no, 0 gross_wages, 0 epf_wages,  eps_wages,
                    0 edli_wages, 0 epf_contribution,  eps_contribution,  epf_eps_diff_contribution,
                    0 ncp_days, pf_gen_id, is_active
                FROM EMPMILL12.tbl_pf_line_upload_data tpg
                WHERE pf_hdr_upload_id = ?
                AND NOT EXISTS (
                    SELECT 1
                    FROM EMPMILL12.tbl_pf_line_upload_data tplud
                    INNER JOIN EMPMILL12.tbl_pf_hdr_upload_data tphud
                        ON tplud.pf_hdr_upload_id = tphud.pf_hdr_upload_id
                    WHERE tplud.is_active = 1
                        AND IFNULL(tphud.main, 0) > 1
                        AND tphud.month_end_date = ?
                        AND tplud.pf_gen_id = tpg.pf_gen_id
                        AND tplud.uan_id = tpg.uan_id
                        AND tphud.trrn_type not in ($upshr)
                        AND tphud.trrn_status in (2,3)
                )";
        $this->db->query($sql, array($maxpfhdrid, $curhdrid, $gdate));
    }

    /**
     * Get PF generation data for display
     */
    public function getPfGenData($pfgendate, $compid) {
        $sql = "SELECT tum.uan_no, tum.name_as_per_pf_online, tpg.* 
                FROM EMPMILL12.tbl_pf_generation tpg 
                LEFT JOIN EMPMILL12.tbl_uan_master tum ON tpg.uan_id = tum.uan_id 
                WHERE tpg.is_active = 1 AND month_end_date = ? AND tpg.company_id = ? 
                ORDER BY uan_no";
        $query = $this->db->query($sql, array($pfgendate, $compid));
        return $query->result();
    }

    /**
     * Get PF generation data totals
     */
    public function getPfGenDataTotals($pfgendate) {
        $sql = "SELECT '' uan_no, 'Grand Total' name_as_per_pf_online, 
                SUM(gross_wages) gross_wages, SUM(epf_wages) epf_wages,
                SUM(eps_wages) eps_wages, SUM(edli_wages) edli_wages, 
                SUM(epf_contibution) epf_contibution, SUM(eps_contribution) eps_contribution,
                SUM(epf_eps_diff_contribution) epf_eps_diff_contribution, 
                SUM(ncp_days) ncp_days, ' ' remarks 
                FROM (
                    SELECT tum.uan_no, tum.name_as_per_pf_online, tpg.* 
                    FROM EMPMILL12.tbl_pf_generation tpg 
                    LEFT JOIN EMPMILL12.tbl_uan_master tum ON tpg.uan_id = tum.uan_id 
                    WHERE tpg.is_active = 1 AND month_end_date = ?
                ) g";
        $query = $this->db->query($sql, array($pfgendate));
        return $query->row();
    }

    /**
     * Cancel/deactivate PF generation data for a month
     */
    public function cancelPfGenData($pfgendate, $companyId) {
        $sql = "UPDATE EMPMILL12.tbl_pf_generation SET is_active = 0 
                WHERE company_id = ? AND month_end_date = ?";
        $this->db->query($sql, array($companyId, $pfgendate));
    }

    /**
     * Check if PF data exists for a date
     */
    public function checkPfDataExists($pfgendate) {
        $sql = "SELECT tum.uan_no, tum.name_as_per_pf_online, tpg.* 
                FROM EMPMILL12.tbl_pf_generation tpg 
                LEFT JOIN EMPMILL12.tbl_uan_master tum ON tpg.uan_id = tum.uan_id 
                WHERE tpg.is_active = 1 AND month_end_date = ?";
        $query = $this->db->query($sql, array($pfgendate));
        return $query->num_rows();
    }

    /**
     * Get PF generation data for Excel export
     */
    public function getPfGenDataForExcel($pfgendate, $compid) {
        $sql = "SELECT tum.uan_no, tum.name_as_per_pf_online, tpg.* 
                FROM EMPMILL12.tbl_pf_generation tpg 
                LEFT JOIN EMPMILL12.tbl_uan_master tum ON tpg.uan_id = tum.uan_id 
                WHERE tpg.is_active = 1 AND month_end_date = ? AND tpg.company_id = ? 
                ORDER BY uan_no";
        $query = $this->db->query($sql, array($pfgendate, $compid));
        return $query->result();
    }

    /**
     * Insert PF line data with selected UAN IDs - EPF+EPS
     */
    public function insertPfLineSelectedAll($maxpfhdrid, $gdate, $companyId, $uanIds) {
        $uanIdList = implode(',', array_map('intval', $uanIds));
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                ) 
                SELECT ?, tpg.uan_id, tum.uan_no, tpg.gross_wages, tpg.epf_wages,
                    eps_wages, edli_wages, epf_contibution, eps_contribution,
                    epf_eps_diff_contribution, ncp_days, tpg.pf_gen_id, 1 AS active 
                FROM EMPMILL12.tbl_pf_generation AS tpg
                LEFT JOIN EMPMILL12.tbl_uan_master AS tum ON tpg.uan_id = tum.uan_id
                LEFT JOIN (
                    SELECT tplud.pf_gen_id, tplud.uan_id uanid, SUM(tplud.epf_contribution) epfcontribution 
                    FROM EMPMILL12.tbl_pf_line_upload_data AS tplud
                    WHERE tplud.is_active = 1  
                    GROUP BY tplud.pf_gen_id, tplud.uan_id
                ) x ON x.pf_gen_id = tpg.pf_gen_id 
                WHERE tpg.month_end_date = ?
                    AND tum.adhar_seeded = 1
                    AND tpg.company_id = ?
                    AND tpg.is_active = 1
                    AND x.epfcontribution IS NULL
                    AND tum.uan_id IN ({$uanIdList})";
        $this->db->query($sql, array($maxpfhdrid, $gdate, $companyId));
    }

    /**
     * Insert PF line data with selected UAN IDs - EPF Only
     */
    public function insertPfLineSelectedEpf($maxpfhdrid, $gdate, $companyId, $uanIds) {
        $uanIdList = implode(',', array_map('intval', $uanIds));
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                ) 
                SELECT ?, tpg.uan_id, tum.uan_no, tpg.gross_wages, tpg.epf_wages,
                    0 eps_wages, edli_wages, epf_contibution, 0 eps_contribution,
                    0 epf_eps_diff_contribution, ncp_days, tpg.pf_gen_id, 1 AS active 
                FROM EMPMILL12.tbl_pf_generation AS tpg
                LEFT JOIN EMPMILL12.tbl_uan_master AS tum ON tpg.uan_id = tum.uan_id
                LEFT JOIN (
                    SELECT tplud.pf_gen_id, tplud.uan_id uanid, SUM(tplud.epf_contribution) epfcontribution 
                    FROM EMPMILL12.tbl_pf_line_upload_data AS tplud
                    WHERE tplud.is_active = 1  
                    GROUP BY tplud.pf_gen_id, tplud.uan_id
                ) x ON x.pf_gen_id = tpg.pf_gen_id 
                WHERE tpg.month_end_date = ?
                    AND tum.adhar_seeded = 1
                    AND tpg.company_id = ?
                    AND tpg.is_active = 1
                    AND x.epfcontribution IS NULL
                    AND tum.uan_id IN ({$uanIdList})";
        $this->db->query($sql, array($maxpfhdrid, $gdate, $companyId));
    }

    /**
     * Insert PF line data with selected UAN IDs - EPS Only
     */
    public function insertPfLineSelectedEps($maxpfhdrid, $gdate, $companyId, $uanIds) {
        $uanIdList = implode(',', array_map('intval', $uanIds));
        $sql = "INSERT INTO EMPMILL12.tbl_pf_line_upload_data (
                    pf_hdr_upload_id, uan_id, uan_no, gross_wages, epf_wages, eps_wages,
                    edli_wages, epf_contribution, eps_contribution, epf_eps_diff_contribution,
                    ncp_days, pf_gen_id, is_active
                ) 
                SELECT ?, tpg.uan_id, tum.uan_no, tpg.gross_wages, tpg.epf_wages,
                    eps_wages, 0 edli_wages, 0 epf_contibution, eps_contribution,
                    epf_eps_diff_contribution, 0 ncp_days, tpg.pf_gen_id, 1 AS active
                FROM EMPMILL12.tbl_pf_generation AS tpg
                LEFT JOIN EMPMILL12.tbl_uan_master AS tum ON tpg.uan_id = tum.uan_id
                LEFT JOIN (
                    SELECT tplud.pf_gen_id, tplud.uan_id uanid, SUM(tplud.epf_contribution) epscontribution 
                    FROM EMPMILL12.tbl_pf_line_upload_data AS tplud
                    WHERE tplud.is_active = 1  
                    GROUP BY tplud.pf_gen_id, tplud.uan_id
                ) x ON x.pf_gen_id = tpg.pf_gen_id 
                WHERE tpg.month_end_date = ?
                    AND tum.adhar_seeded = 1
                    AND tpg.company_id = ?
                    AND tpg.is_active = 1
                    AND x.epscontribution IS NULL
                    AND tum.uan_id IN ({$uanIdList})";
        $this->db->query($sql, array($maxpfhdrid, $gdate, $companyId));
    }

}
