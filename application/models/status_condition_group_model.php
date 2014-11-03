<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_condition_group_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_table = 'status_condition_groups';

        $this->add_validate('group_name','required|max_length[255]');
    }
}