<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'module_header';

        $this->add_validate('module_name','required|max_length[100]|is_unique[module_header.module_name]|alpha_dash');
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('sort','required|numeric');

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('sort','required|numeric');
        return $data;
    }
}