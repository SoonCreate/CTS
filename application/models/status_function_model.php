<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_function_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_view = 'status_functions_v';
        $this->_table = 'status_functions';

        $this->_validate();
    }

    function _validate(){
        $this->add_validate('label','required|max_length[255]');
        $this->add_validate('sort','required|numeric');
    }
}