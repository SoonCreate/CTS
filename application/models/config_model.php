<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->add_validate('config_value','required|max_length[255]');
    }

}