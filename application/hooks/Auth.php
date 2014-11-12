<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

    //检查是否登录
    function login_check(){
        $CI =& get_instance();
        $CI->load->config('login_check');
        $auth = $CI->config->item('login_no_check');

        $controller = $CI->router->fetch_class();
        $action = $CI->router->fetch_method();
        $controllers = $auth;
        if(!(in_array($controller, array_keys($controllers)) && in_array($action,$controllers[$controller]))){
            //需要检查
            if(!_sess('uid')){
                location_url('user/login');
                die();
            }
        }
    }

    //每次访问controller时都会检查当前控制器的权限
    function function_check(){

//        if(!check_function_auth()){
//            show_404();
//            die();
//        }else{
            refresh_env();
//        }
    }
}