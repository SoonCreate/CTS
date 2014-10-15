<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_model','status');
        $this->load->model('order_model','order');
        $this->load->model('valuelist_model');
        $this->load->model('role_module_line_model');
        $this->load->model('function_model');
        $this->_table = 'role_profile_lines_v';
    }

    //权限验证，输入权限对象，以及子项值
    function check_auth($auth_object_name,$auth_items,$user_id = null){
        $profile_objects = $this->find_profiles_by_object_name($auth_object_name,$user_id)->result_array();
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

    //检查是否有运行当前功能的权限
    function check_function_auth($function_name){
        //检查该功能是否在系统中注册，如果未注册则不参与权限验证
        $fm = new Function_model();
        $fn = $fm->find_by(array('function_name'=>$function_name));
        if(empty($fn)){
            return true;
        }else{
            return $this->_check_function_auth($fn['id']);
        }

    }

    function check_function_auth_by_router($controller,$action){
        //检查该功能是否在系统中注册，如果未注册则不参与权限验证
        $fm = new Function_model();
        $fn = $fm->find_by(array('controller'=>$controller,'action'=>$action));
        if(empty($fn)){
            return true;
        }else {
            return $this->_check_function_auth($fn['id']);
        }
    }

    function _check_function_auth($function_id){
        $rmlm = new Role_module_line_model();
        $r = $rmlm->find_all_by_view(array('function_id' => $function_id));
        if (empty($r)) {
            return false;
        } else {
            return true;
        }
    }

    //当前用户的该权限对象列表
    function find_profiles_by_object_name($object_name,$user_id = null){
        if(is_null($user_id)){
            $user_id = _sess('uid');
        }
        return  $this->db->get_where('user_auth_v',
            array('user_id' => $user_id,
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
                        $return = array_merge($return,explode(',',$l_order_type['auth_value'])) ;
                    }
                }
            }

        }
        //返回消除重复项的最终值
        return array_unique($return);
    }

    //能选择的分类
    function can_choose_order_categories($order_type,$status){
        $return = array();
        $profile_objects = $this->find_profiles_by_object_name('category_control')->result_array();
        if(count($profile_objects)>0){
            //循环拥有多少种相同权限对象的组合
            foreach($profile_objects as $o){
                $l_order_type = $this->find_by(array('profile_id'=>$o['profile_id'],'auth_item_name'=>'ao_order_type'));
                $l_order_status = $this->find_by(array('profile_id'=>$o['profile_id'],'auth_item_name'=>'ao_order_status'));
                $l_order_categories = $this->find_by(array('profile_id'=>$o['profile_id'],'auth_item_name'=>'ao_order_category'));
                //拥有初始化状态权限
                if($l_order_type['auth_value'] == _config('all_values') ||
                    in_array($order_type,explode(',',$l_order_type['auth_value']))){

                    if($l_order_status['auth_value'] == _config('all_values')||
                        in_array($status,explode(',',$l_order_status['auth_value']))){

                        if($l_order_categories['auth_value'] == _config('all_values')){
                            $vlm = new Valuelist_model();
                            //所有
                            $opts = $vlm->find_active_children_options('vl_order_category',$order_type);
                            foreach($opts as $op){
                                array_push($return,$op['value']);
                            }
                        }else{
                            //少数
                            $return = array_merge($return,explode(',',$l_order_categories['auth_value'])) ;
                        }

                    }
                }

            }
        }

        //返回消除重复项的最终值
        return array_unique($return);
    }

    //默认展示拥有权限的模块
    function can_choose_modules(){
        $this->db->distinct();
        $this->db->order_by('module_sort');
        $this->db->select('module_name,module_id,module_desc,module_display_class');
        return $this->db->get_where('user_functions_v',array('user_id'=>_sess('uid'),'display_flag'=>1))->result_array();
    }

    //默认展示拥有权限的模块下的功能
    function can_choose_functions($module_id){
        $this->db->distinct();
        $this->db->order_by('sort');
        $this->db->select('function_name,function_id,function_desc,controller,action,id,function_display_class');
        return $this->db->get_where('user_functions_v',array('user_id'=>_sess('uid'),'display_flag'=>1,'module_id'=>$module_id))->result_array();
    }

    function can_choose_managers($order){
        $return = array();
        $profiles = $this->db->get_where('user_auth_v',
            array('object_name' => 'category_control'))->result_array();
        if(count($profiles) > 0){
            foreach($profiles as $p){
                if(check_order_auth($order['order_type'],'allocated',$order['category'],$p['user_id'])){
                    array_push($return,$p['user_id']);
                }
            }
        }
        return array_unique($return);
    }

}