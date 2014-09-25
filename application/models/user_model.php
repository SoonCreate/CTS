<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //服务端插入数据库之前验证
        $this->validate = array(
            array('field' => 'username','label' => 'username',
                'rules' => 'required|min_length[5]|max_length[12]|is_unique[users.username]|callback_username_check'),
            array('field' => 'password','label' => 'password','rules' => 'required'),
            array('email' => 'email','label' => 'email','rules' => 'required|valid_email'),
        );
        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function username_check($username){
        if ($username == 'test'){
            $this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

}