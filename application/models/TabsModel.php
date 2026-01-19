<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabsModel extends CI_Model {

    public function get_table1_data() {
        $query = $this->db->get('company_master');
        return $query->result_array();
    }

    public function get_table2_data() {
        $query = $this->db->get('state_master');
        return $query->result_array();
    }

    public function get_table3_data() {
        $query = $this->db->get('status_master');
        return $query->result_array();
    }
}
