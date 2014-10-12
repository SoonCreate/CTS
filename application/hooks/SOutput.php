<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用于controller调用前和调用后的信息反馈
 */

class SOutput {

    function output(){
        $o = _sess('output');
        if($o){
            echo json_encode($o);
        }
    }

    //初始化
    function initial_output(){
        $CI =  &get_instance();
        $method = $CI->router->fetch_method();
        //判断是否为私有函数，如果为私有函数则不初始化
        $index = strpos($method,'_');
        if($index === FALSE || $index > 0){
            unset_sess('output');
        }
    }
}