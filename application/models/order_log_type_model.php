<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_log_type_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //服务端插入数据库之前验证
        $this->add_validate('log_type','required|min_length[5]|max_length[45]|is_unique[order_log_types.log_type]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('title','required|max_length[255]');
        $this->add_validate('content','required|max_length[255]');
        $this->add_validate('field_name','required|max_length[100]');
        $this->add_validate('dll_type','required');

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }


    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('title','required|max_length[255]');
        $this->add_validate('content','required|max_length[255]');
        $this->add_validate('field_name','required|max_length[100]');
        $this->add_validate('dll_type','required');
        return set_last_update($data);
    }

}