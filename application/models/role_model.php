<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //服务端插入数据库之前验证
        $this->add_validate('role_name','required|min_length[5]|max_length[20]|is_unique[roles.role_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function find_all_active_roles(){
        return $this->find_all_by(array('inactive_flag'=>0));
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('inactive_flag','required');
        return set_last_update($data);
    }
}