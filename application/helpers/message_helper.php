<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//返回信息操作
function initial_message(){
    set_sess('message',Array());
}

//获取message
function message($type,$class,$line,$args = []){
    global $CI;
    $CI->load->model('message_model','message');
    $mm = new Message_model();
    $message = $mm->find_by_view(array('class_code'=>$class,'message_code'=>$line,'language'=>env_language()));
    if(!empty($message)){
        $message['type'] = $type;
        $message['code'] = $class.'('.$line.')';

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

    }
    $message['content'] = str_replace("&","",$message['content']);
    refresh_message($message);
}
//临时使用的输出
function custz_message($type,$content){
    $message['type'] = $type;
    $message['content'] = $content;
    refresh_message($message);
}

//刷新message会话数据
function refresh_message($message){
    $messages = _sess('message');
    array_push($messages,$message);
    set_sess('message',$messages);
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