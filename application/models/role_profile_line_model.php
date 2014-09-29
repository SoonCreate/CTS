<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_profile_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    function find_all_from_view($where){
        return $this->db->get_where($this->_table.'_v',$where)->result_array();
    }

}