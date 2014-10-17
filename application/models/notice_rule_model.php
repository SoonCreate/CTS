<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice_rule_model extends MY_Model{
    function __construct(){
        parent::__construct();
        $this->add_validate('when_new_value','required|max_length[255]');
        $this->add_validate('when_old_value','required|max_length[255]');
    }
}