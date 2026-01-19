<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weaving_daily_data_Model extends  CI_Model   {


    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->database('empmill12', TRUE);  // Loads the default database (Doff entry database)
//        $this->load->database('vowsls', TRUE);  // Loads the default database (Doff entry database)
    }





    
}    