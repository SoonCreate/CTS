<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist_line_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'valuelist_lines_v';
    }
}