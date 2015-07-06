<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_group_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_validate();
        $this->add_validate('name','required|min_length[5]|max_length[45]|is_unique[form_groups.name]|alpha_dash');

        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->_validate();
        return $data;
    }

    private function _validate(){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
    }
}