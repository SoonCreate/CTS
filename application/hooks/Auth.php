<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
    //每次访问controller时都会检查当前控制器的权限
    function function_check(){
        if(!check_function_auth()){
            show_error("你没有权限访问此功能",500,'权限错误');
            die();
        }
    }
}