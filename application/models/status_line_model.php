<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'status_lines_v';
    }
}