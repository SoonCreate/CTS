<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'module_header';

        $this->add_validate('module_name','required|max_length[100]|is_unique[module_header.module_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('sort','required|numeric');

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
        $this->add_validate('sort','required|numeric');
        return set_last_update($data);
    }
}