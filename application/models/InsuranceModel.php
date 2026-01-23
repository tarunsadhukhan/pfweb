<?php
class InsuranceModel extends CI_Model {
    public function getMonthlyData($insurance_no) {
        $this->db->where('insurance_no', $insurance_no);
        $query = $this->db->get('insurance_monthly');
        return $query->result_array();
    }
    public function getRecord($recid) {
        $this->db->where('recid', $recid);
        $query = $this->db->get('insurance_monthly');
        return $query->row_array();
    }
    public function saveRecord($data) {
        if (isset($data['recid']) && $data['recid']) {
            $this->db->where('recid', $data['recid']);
            return $this->db->update('insurance_monthly', $data);
        } else {
            return $this->db->insert('insurance_monthly', $data);
        }
    }
    public function deleteRecord($recid) {
        $this->db->where('recid', $recid);
        return $this->db->delete('insurance_monthly');
    }

    // Custom SQL query for EB No lookup. Change table name if needed.
    public function get_ipno_name_by_ebno($ipno, $ebno) {
        $company_id = $this->session->userdata('company_id');

        $sql = "SELECT thee.esi_no AS ipno,
                       CONCAT(B.worker_name, ' ', B.middle_name, ' ', B.last_name) AS name
                FROM worker_master B
                LEFT JOIN tbl_hrms_ed_esi thee ON B.eb_id = thee.eb_id AND thee.is_active = 1 ";
            if (!empty($ipno)) {
                $sql .= " WHERE thee.esi_no = ? AND B.company_id = ? LIMIT 1";
                $params = array($ipno, $company_id);
            } else {
                $sql .= " WHERE B.eb_no = ? AND B.company_id = ? LIMIT 1";
                $params = array($ebno, $company_id);
            }
     //   echo json_encode($params);
     //   echo $sql;
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }


public function get_monthly_esi_data($upfromdate, $uptodate, $companyId, $ebno, $ipno, $name): array
{
    $sql = "SELECT * FROM EMPMILL12.esidetails WHERE 1=1";
    $params = array();
    if (!empty($ipno)) {
        $sql .= " AND ipno = ?";
        $params[] = $ipno;
    }
    $sql .= " ORDER BY month_end_date";
    return $this->db->query($sql, $params)->result_array();
}





    }