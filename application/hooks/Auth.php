<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

    //检查是否登录
    function login_check(){
        $CI =& get_instance();
//        log_message('error','cli:'.$CI->input->is_cli_request());
//        log_message('error','session: '._sess('uid'));

        //过滤客户端job运行
        if(!$CI->input->is_cli_request() && $CI->input->server('HTTP_USER_AGENT')){
            $CI->load->config('login_check');
            $auth = $CI->config->item('login_no_check');

            $controller = $CI->router->fetch_class();
            $action = $CI->router->fetch_method();

//            log_message('error',$controller.'/'.$action);
            $controllers = $auth;
            if(!(in_array($controller, array_keys($controllers)) && in_array($action,$controllers[$controller]))){
                //需要检查
                if(!_sess('uid')){
                    $login_url = _url('user','login');
                    $message  = label('need').'<a href="'.$login_url.'">'.label('re_login').'</a>';
                    $title = label('session_inactive');
                    $callback = 'redirect("'.$login_url.'")';
                    if($_POST){
                        confirm_dialog($message,$title,$callback);
                        die(json_encode(_sess('output')));
                    }else{
                        $data['heading'] = $title;
                        $data['message'] = $message;
                        $data['callback'] = $callback;
                        die($CI->load->view('error',$data,true));
                    }

                }
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