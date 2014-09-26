<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //服务端插入数据库之前验证
        $this->add_validate('url_name','required|max_length[20]|is_unique[urls.url_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('controller','required|max_length[255]');
        $this->add_validate('action','required|max_length[255]');

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