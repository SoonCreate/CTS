<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Function_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //服务端插入数据库之前验证
        $this->add_validate('function_name','required|max_length[100]|is_unique[functions.function_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('controller','required|max_length[255]');
        $this->add_validate('action','required|max_length[255]');

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->clear_validate();
        //服务端插入数据库之前验证
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('controller','required|max_length[255]');
        $this->add_validate('action','required|max_length[255]');
        return $data;
    }
}