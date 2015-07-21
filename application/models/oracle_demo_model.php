<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oracle_demo_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('oracle',true,true);
        $this->_table ='PLM_CUS_TIPART';
    }
}