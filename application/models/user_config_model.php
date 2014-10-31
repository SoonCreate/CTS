<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_config_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->add_validate('config_value','required|max_length[255]');
    }

    function config($name,$user_id = null){
        if(is_null($user_id)){
            $user_id = _sess('uid');
        }
        $uc = $this->find_by_view(array('config_name'=>$name,'user_id'=>$user_id));
        if(empty($uc)){
            $this->load->model('config_model');
            $cm = new Config_model();
            return $cm->find_by(array('config_name'=>$name));
        }else{
            return $uc;
        }
    }
}