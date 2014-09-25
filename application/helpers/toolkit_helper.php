<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//渲染函数
//function render($view = NULL,$data = NULL){
//    render_by_layout('sc',$view,$data);
//}

//模板
function render_by_layout($layout = NULL,$view = NULL,$data = NULL){
    $CI =  &get_instance();
    if(is_null($view)){
        $view = $CI->router->fetch_directory().'/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method();
    }
    if(is_null($layout)){
        $CI->load->view($view,$data);
    }else{
        $CI->layout->setlayout($layout);
        $CI->layout->view($view,$data);
    }
}

//渲染函数
function render($view = NULL){
    $CI =  &get_instance();
    //判断是否存在view同名模版
    if(is_null($view)){
        $CI->load->view($CI->router->fetch_directory().'/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method());
    }else{
        $CI->load->view($view);
    }
}

//是否登录
function is_login()
{
    return _sess('uid');
}
//检查登陆，如果用户未登录或失效则调到登陆界面
function check_login()
{
    if( !is_login() )
    {
        redirect_to_login();
        die();
    }
}

//重定向到登陆界面
function redirect_to_login(){
    redirect(url('bc/user','login'));
}

//将结果集装换成JSON
function first_row($rs){
    $row = $rs->result_array();
    if(count($row) > 0){
        return $row[0];
    }else{
        return null;
    }
}


//设置时间戳
function set_last_update($data){
    $data['last_update_date'] = time();
    $data['last_updated_by'] = _sess('uid');
    return $data;
}

function set_creation_date($data){
    $data['last_update_date'] = time();
    $data['last_updated_by'] = _sess('uid');
    $data['creation_date'] = time();;
    $data['created_by'] = _sess('uid');
    return $data;
}

//获取session值
function _sess($key){
    global $CI;
//    $CI->load->library('session');
    return $CI->session->userdata($key);
}
//设置session
function set_sess($key,$value = NULL){
    global $CI;
//    $CI->load->library('session');
    if(is_array($key)){
        $newdata = $key;
    }else{
        $newdata[$key] = $value;
    }
    $CI->session->set_userdata($newdata);
}

function unset_sess($key){
    global $CI;
    $CI->session->unset_userdata($key);
}

function clear_all_sess(){
    global $CI;
    $CI->session->sess_destroy();
}


//获取值集对应的值
function get_value($valuelist_name,$label){
    $options = get_options($valuelist_name);
    $value = null;
    if(count($options) > 0){
        for($i=0;$i<count($options);$i++){
            if($options[$i]["label"] == $label){
                $value = $options[$i]["value"];
                break;
            }
        }
    }
    return $value;
}

function get_label($valuelist_name,$value){
    $options = get_options($valuelist_name);
    $label = _text('label_unknow');
    if(count($options) > 0){
        for($i=0;$i<count($options);$i++){
            if($options[$i]["value"] == $value){
                $label = $options[$i]["label"];
                break;
            }
        }
    }
    return $label;
}

//获取值列表
function get_options($valuelist_name){
    global $CI;
    $CI->load->model('valuelist_model');
    return $CI->valuelist_model->find_active_options($valuelist_name)->result_array();
}

//输出到view里面的option
function render_options($valuelist_name){
    $options = get_options($valuelist_name);
    foreach($options as $o){
        echo '<option value="'.$o['value'].'">'.$o['label'].'</option>';
    }
}

function _config($config_name){
    global $CI;
    $CI->load->model('config_model');
    return $CI->config_model->find_value_by_name($config_name);
}

//判断结果集是否大于0条数据
function is_exists($rs){
    if(count($rs->result_array()) > 0){
        return true;
    }else{
        return false;
    }
}

//如果为0则不输出
function format_zero_to_space($value){
    if($value == 0 || $value == '0'){
        return '';
    }else{
        return $value;
    }
}

//判断数组中是否含有这些key
function is_all_set($data,$keys){
    if(count($keys)>0 && $data && count($data) > 0){
        $return = true;
        $data_keys = array_keys($data);
        foreach ($keys as $key) {
            if(!in_array($key,$data_keys)){
                $return = false;
                break;
            }
        }
        return $return;
    }else{
        return false;
    }
}

function is_all_has_value($data,$keys){
    if(count($keys)>0 && $data && count($data) > 0){
        $return = true;
        $data_keys = array_keys($data);
        foreach ($keys as $key) {
            if(!in_array($key,$data_keys)){
                $return = false;
                break;
            }else{
                //存在则判断值
                if(n($data[$key]) == ""){
                    $return = false;
                    break;
                }
            }
        }
        return $return;
    }else{
        return false;
    }
}

//输出label语言文件下的注释
function label($str){
    return _text('label_'.$str);
}

//判断是否为分类控制，再进行权限判断。默认为分类为all
function check_auth($order_type,$order_status,$order_category = null){
    global $CI;
    $CI->load->model('auth_model');
    $data['ao_order_type'] = $order_type;
    $data['ao_order_status'] = $order_status;
    if(_config('category_control')){
        if(is_null($order_category)){
            $data['ao_order_status'] = _config('all_values');
        }else{
            $data['ao_order_status'] = $order_status;
        }
    }else{
        $data['ao_order_status'] = _config('all_values');
    }
    return $CI->auth_model->check_auth('category_control',$data);
}