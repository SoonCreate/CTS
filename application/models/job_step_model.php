<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_step_model extends MY_Model{

    function __construct(){
        parent::__construct();
//        $this->load->model('variant_line_model');
        $this->_validate();
        $this->add_validate('job_id','required');
        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->_validate();
        return $data;
    }

    private function _validate(){
        $this->clear_validate();
        $this->add_validate('step','required|min_length[5]|max_length[45]|alpha_dash');
    }

}