<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//返回信息操作
function initial_message(){
    set_sess('message',Array());
}

//获取message
function message($type,$class,$line,$args = []){
    global $CI;
    $CI->load->model('message_model','message');
    $message = $CI->message->find_by_class_and_code($class,$line);
    if(!is_null($message)){
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
    //刷新message会话数据
    $messages = _sess('message');
    array_push($messages,$message);
    set_sess('message',$messages);
}
//临时使用的输出
function custz_message($type,$content){
    $message['type'] = $type;
    $message['content'] = $content;
    //刷新message会话数据
    $messages = _sess('message');
    array_push($messages,$message);
    set_sess('message',$messages);
}