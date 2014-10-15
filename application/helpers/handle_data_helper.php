<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//输出数据
function data($key,$data){
    $output = _sess('output');
    $d[$key] = $data;
    $output['data'] = $d;
    set_sess('output',$output);
}

//输出消息
function message($type,$class_code,$message_code,$args = []){
    global $CI;
    $CI->load->model('message_model','message');
    $mm = new Message_model();
    $message = $mm->find_by_view(array('class_code'=>$class_code,'message_code'=>$message_code,'language'=>env_language()));
    if(!empty($message)){
        $message['type'] = $type;
        $message['code'] = $class_code.'('.$message_code.')';

        //处理内容
        if(count($args) > 0){
            $content = $message['content'];
            foreach ($args as $p){
                $index = stripos($content,'&');
                if($index >= 0){
                    $content = substr_replace($content,$p,$index,1);
                }
            }
            $message['content'] = $content;
        }
        $message['content'] = str_replace("&","",$message['content']);
        _refresh_output('message',$message);
    }else{
        message_unknow_error();
    }

}

//数据库操作返回消息
function message_db_failure(){
    message('E','db','20');
}
//数据库操作成功
function message_db_success(){
    message('I','db','10');
}
//没有权限
function message_no_authority(){
    message('E','system','20');
}
//未知消息
function message_unknow_error(){
    message('E','system','10');
}

//输出验证form验证
function validation_error(){
    if ( function_exists('form_error')) {;
        foreach($_POST as $key=>$value){
            $v = array();
            $e = form_error($key,"<span>","</span>");
            if($e != ''){
                $v[$key] = $e;
                _refresh_output('validation',$v);
            }
        }

    }
}

//前端跳转
function redirect_to($controller,$action,$params){
    $CI =  &get_instance();
    $CI->load->model('module_line_model');
    $mlm = new Module_line_model();

    $goto['target'] = _sess('mid');

    $cml = $mlm->find_by_view(array('controller'=>$controller,'action'=>$action,'module_id'=>_sess('mid')));
    if(!empty($cml)){
        $params['cm'] = $cml['id'];
    }else{
        //如果当前连接不属于当前模块，随意获取某一mid
        $mls = $mlm->find_all_by_view(array('controller'=>$controller,'action'=>$action));
        if(!empty($mls)){
            $ml = $mls[0];
            $params['cm'] = $ml['id'];
            $goto['target'] = $ml['module_id'];
        }
    }

    $output = _sess('output');
    $goto['url'] = _url($controller,$action,$params);
    $output['redirect'] = $goto;
    set_sess('output',$output);
}

//刷新输出缓存
function _refresh_output($type,$data){
    $output = _sess('output');
    if(!isset($output[$type])){
        $output[$type] = array();
    }
    array_push($output[$type],$data);
    set_sess('output',$output);
}

//view 中输出label
if ( ! function_exists('env_language')) {
    function env_language()
    {
        //判断浏览器语言
        $default_lang_arr = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $strarr = explode(",", $default_lang_arr);
        return $strarr[0];
    }
}


