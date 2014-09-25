<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //服务端插入数据库之前验证
        $this->add_validate('username','required|min_length[5]|max_length[12]|is_unique[users.username]|alpha_dash');
        $this->add_validate('password','required');
        $this->add_validate('email','required|valid_email');
        $this->add_validate('mobile_telephone','required|numeric');
        $this->add_validate_255('phone_number','address','contact');

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

}