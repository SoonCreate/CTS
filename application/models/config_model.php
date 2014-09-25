<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //设置钩子
        $this->before_update = array('before_update');
    }

    function find_value_by_name($config_name){
        $value = '';
        $row = $this->find_by(array('config_name'=>$config_name));
        if(!empty($row)){
            $value = $row['config_value'];
        }
        return $value;
    }

    function before_update($data){
        return set_last_update($data);
    }

}