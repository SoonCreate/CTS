<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends MY_Model{

    function __construct(){
        parent::__construct();


        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function before_insert($data){
        $this->clear_validate();
        //服务端插入数据库之前验证
        $this->add_validate('role_name','required|min_length[5]|max_length[20]|is_unique[roles.role_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        return set_creation_date($data);
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        return set_last_update($data);
    }
}