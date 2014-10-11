<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_profile_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    //用来匹配权限对象以及项目完全相同的profile是否存在
    function object_is_exists($role_id,$object_id,$items){
        $this->load->model('role_profile_line_model');
        $rplm = new Role_profile_line_model();
        $profiles = $this->find_all_by(array('object_id'=>$object_id,'role_id'=>$role_id));
        $exists = false;
        if(!empty($profiles)){
            foreach($profiles as $p){
                $pass = false;
                $lines = $rplm->find_all_by(array('profile_id'=>$p['id']));
                foreach($lines as $l){
                    //默认值比较function auth line的：'object_line_id'=>'default_value'
                    if($items[$l['object_line_id']] != $l['auth_value']){
                        $pass = true;
                        break;
                    }
                }
                if(!$pass){
                    $exists = true;
                    break;
                }
            }
            return $exists;
        }else{
            return false;
        }
    }
}