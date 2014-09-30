<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    function find_all_by_view($where){
        return $this->get_where($this->_table.'_v',$where)->result_array();
    }
}