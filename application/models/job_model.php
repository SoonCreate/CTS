<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_validate();
        $this->add_validate('job_name','required|min_length[5]|max_length[45]|is_unique[jobs.job_name]|alpha_dash');
        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->_validate();
        return $data;
    }

    private function _validate(){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('output_type','required');
        $this->add_validate('first_exec_date','required');
    }

}