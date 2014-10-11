<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authobj_line_model extends MY_Model{
    function __construct(){
        parent::__construct();

        $this->add_validate('valuelist_id','required|numeric');
        $this->add_validate('object_id','required|numeric');
        $this->add_validate('default_value','required');

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('default_value','required');
        return $data;
    }
}