<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_model','status');
        $this->load->model('order_model','order');
        $this->_table = 'role_profile_lines_v';
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

    //检查单个权限对象值
    function check_auth_item($profile_object,$auth_items){
        $pass = true;
        foreach($auth_items as $key => $value){
            $line = $this->find_by(array('profile_id'=>$profile_object['profile_id'],'auth_item_name'=>$key));
            if($line['auth_value'] != _config('all_values')){
                if(!in_array($value,explode(',',$line['auth_value']))){
                    $pass = $pass && false;
                }
            }
        }
        return $pass;
    }

    //return array()
    function can_create_order_types(){
        $return = array();
        $profile_objects = $this->find_profiles_by_object_name('category_control')->result_array();
        if(count($profile_objects)>0){
            //循环拥有多少种相同权限对象的组合
            foreach($profile_objects as $o){
                $l_order_type = $this->find_by(array('profile_id'=>$o['profile_id'],'auth_item_name'=>'ao_order_type'));
                $l_order_status = $this->find_by(array('profile_id'=>$o['profile_id'],'auth_item_name'=>'ao_order_status'));
                //拥有初始化状态权限
                if($l_order_status['auth_value'] == _config('all_values') ||
                    in_array($this->order->default_status(),explod(',',$l_order_status['auth_value']))){
                    if($l_order_type['auth_value'] == _config('all_values')){
                        //所有
                        $opts = get_options('ao_order_type');
                        foreach($opts as $op){
                            array_push($return,$op['value']);
                        }
                    }else{
                        //少数
                        $return = $return + explode(',',$line['auth_value']);
                    }
                }
            }

        }
        //返回消除重复项的最终值
        return array_unique($return);
    }

}