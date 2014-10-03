<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meeting_file_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //服务端插入数据库之前验证
        $this->add_validate('description','required|max_length[255]');
        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }
    
    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

    function find_all_by_view($where){
        return $this->db->get_where($this->_table.'_v',$where)->result_array();
    }

}