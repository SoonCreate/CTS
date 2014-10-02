<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_log_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }
    
    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('reason','required');
        return set_last_update($data);
    }

    function count_by_view($where){
        $this->db->where($where);
        return $this->db->count_all_results($this->_table.'_v');
    }

    function find_all_by_view($where){
        return $this->db->get_where($this->_table.'_v',$where)->result_array();
    }

    function find_by_view($where){
        return first_row($this->db->get_where($this->_table.'_v',$where));
    }

}