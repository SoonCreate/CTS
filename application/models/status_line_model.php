<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_view = 'status_lines_v';
        $this->_table = 'status_lines';

        $this->add_validate('step','required|max_length[20]');
        $this->_validate();

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->clear_validate();
        $this->_validate();
        return $data;
    }

    function _validate(){
        $this->add_validate('step_value','required|max_length[255]');
        $this->add_validate('step_desc','required|max_length[255]');
    }
}