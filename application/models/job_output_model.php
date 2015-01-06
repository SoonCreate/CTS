<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_output_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->add_validate('history_id','required');
        $this->add_validate('output_type','required');
    }

}