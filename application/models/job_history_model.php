<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_history_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->add_validate('job_id','required');
        $this->add_validate('status','required');
    }

}