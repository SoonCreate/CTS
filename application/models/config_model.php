<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->add_validate('config_value','required|max_length[255]');
    }

    function find_value_by_name($config_name){
        $value = '';
        $row = $this->find_by(array('config_name'=>$config_name));
        if(!empty($row)){
            $value = $row['config_value'];
        }
        return $value;
    }

}