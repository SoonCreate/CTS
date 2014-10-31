<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_condition_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_view = 'status_conditions_v';
        $this->_table = 'status_conditions';

        $this->_validate();
    }

    function table_name($status_line_id){
        $this->load->model('status_model');
        $slm = new Status_line_model();
        $s = $slm->find_by_view(array('id'=>$status_line_id));
        if(empty($s)){
            return null;
        }else{
            return $s['table_name'];
        }
    }

    function _validate(){
        $this->add_validate('field_name','required|max_length[100]');
        $this->add_validate('target_value','required|max_length[255]');
    }
}