<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Variant_model extends MY_Model{

    function __construct(){
        parent::__construct();
//        $this->load->model('variant_line_model');
        $this->_validate();
        $this->add_validate('function_id','required');
        //设置钩子
        array_unshift($this->before_update,'before_update');
        $this->_table = 'function_variants';
    }

    function find_my_variants($function_id){
        $this->db->where(array('created_by'=>_sess('uid'),'function_id'=>$function_id));
        $this->db->or_where(array('share_flag'=>1));
        return $this->db->get($this->_table)->result_array();
    }

    function before_update($data){
        $this->_validate();
        return $data;
    }

    private function _validate(){
        $this->clear_validate();
        $this->add_validate('variant_name','required|min_length[5]|max_length[45]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('method','required');
    }

}