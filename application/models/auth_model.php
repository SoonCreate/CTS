<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('order_model');
    }

    //权限验证，输入权限对象，以及子项值
    function check_auth($auth_object_name,$auth_items){
        $profile_objects = $this->find_profiles_by_object_name($auth_object_name)->result_array();
        if(count($profile_objects)>0){
            $pass = true;
            //循环拥有多少种相同权限对象的组合
            foreach($profile_objects as $o){
                //单个权限对象验证
                $pass = $pass && $this->check_auth_item($o,$auth_items);
            }
            return $pass;

        }else{
            //用户没有当前权限对象
            return false;
        }
    }

    //当前用户的该权限对象列表
    function find_profiles_by_object_name($object_name){
        return  $this->db->get_where('user_auth_v',
            array('user_id' => _sess('uid'),
                'object_name' => $object_name));
    }

    function find_profile_line_by_item_name($profile_id,$auth_item_name){
        return $this->db->get_where('role_profile_lines_v',array('profile_id'=>$profile_id,'auth_item_name'=>$auth_item_name));
    }

    //检查单个权限对象值
    function check_auth_item($profile_object,$auth_items){
        $pass = true;
        foreach($auth_items as $key => $value){
            $line = $this->find_profile_line_by_item_name($profile_object['profile_id'],$key);
            if($line['auth_value'] != _config('all_values')){
                if(!in_array($value,explode(',',$line['auth_value']))){
                    $pass = $pass && false;
                }
            }
        }
        return $pass;
    }

}