<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('TabsModel');
    }

    public function index() {
        $data['table1'] = $this->TabsModel->get_table1_data();
        $data['table2'] = $this->TabsModel->get_table2_data();
        $data['table3'] = $this->TabsModel->get_table3_data();
        
        $this->load->view('admin/uandetails/tabs_view', $data);
    }
}
