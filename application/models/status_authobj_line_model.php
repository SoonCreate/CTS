<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_authobj_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_view = 'status_authobj_lines_v';
        $this->_table = 'status_authobj_lines';

        $this->add_validate('auth_value','required|max_length[255]');
    }
}