<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Sooncreate AIP
 *
 * 速创科技AIP开源集成平台
 *
 * @package	Sooncreate
 * @author		Sooncreate Studio
 * @copyright	Copyright (c) 2014.
 * @license
 * @link		http://www.sooncreate.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * System Initialization File
 *
 * 用于与前端的数据交互，分为几种形式：message,data,validation,redirect,dialog等
 * 前端通过handleResponse方法来处理这些数据
 *
 * @package	Sooncreate
 * @category	helper
 * @author		Sooncreate Studio
 * @link
 */

// ------------------------------------------------------------------------


/**
 * 数据输出以键值形式的json字符串输出
 * @param string $key   字段
 * @param mixed $data 数据
 */
function data($key,$data){
    $output = _sess('output');
    $d[$key] = $data;
    $output['data'] = $d;
    set_sess('output',$output);
}

/**
 * 消息输出：整合系统消息模块，通过消息类和消息码查询数据库并输出
 * @param string $type I|W|E 代表 信息|警告|错误
 * @param string $class_code    消息类
 * @param string $message_code  消息码
 * @param array $args
 */
function message($type,$class_code,$message_code,$args = array()){
    global $CI;
    $CI->load->model('message_model');
    $mm = new Message_model();
    $message = $mm->find_by_view(array('class_code'=>$class_code,'message_code'=>$message_code));
    if(!empty($message)){
        $data['type'] = $type;
        $data['code'] = $class_code.'('.$message_code.')';
        $data['content'] = $message['content'];
        $data['help'] = $message['help'];
        //处理内容
        if(count($args) > 0){
            $content = $message['content'];
            foreach ($args as $p){
                $index = stripos($content,'&');
                if($index >= 0){
                    $content = substr_replace($content,$p,$index,1);
                }
            }
            $data['content'] = $content;
        }
        //用参数依次替代内容中的"&"字符
        $data['content'] = str_replace("&","",$data['content']);
        _refresh_output('message',$data);
    }else{
        message_unknown_error();
    }

}

/**
 * 消息输出：非系统定义的消息，为程序中自定义消息，一般做临时调试使用
 * @param string $type I|W|E 代表 信息|警告|错误
 * @param string $content 消息内容
 */
function custz_message($type,$content){
    $message['type'] = $type;
    $message['content'] = $content;
    _refresh_output('message',$message);
}

/**
 * 消息输出：ci中配置的多语言环境消息，一般为ci自带的系统消息
 * @param string $type  I|W|E 代表 信息|警告|错误
 * @param string $line ci语言文件中的配置
 */
function ci_translate_message($type,$line){
    $message['type'] = $type;
    $message['content'] = _text($line);
    _refresh_output('message',$message);
}

/**
 *直接输出消息：数据保存失败
 */
function message_db_failure(){
    ci_translate_message('E','message_save_failure');
}

/**
 *直接输出消息：数据保存成功
 */
function message_db_success(){
//    message('I','db','10');
    ci_translate_message('I','message_save_success');
}

/**
 *直接输出消息：没有权限操作
 */
function message_no_authority(){
    ci_translate_message('I','message_no_authority');
}

/**
 *直接输出消息：未知错误，联系管理员
 */
function message_unknown_error(){
    ci_translate_message('E','message_error_unknown');
}

/**
 * 输出前端弹出框
 *
 * @param string $url   弹出框页面对应的url
 * @param string $title 弹出框标题
 * @param bool $closable    是否可关闭
 */
function dialog($url,$title,$closable = FALSE){
    $output = _sess('output');
    $dialog['closable'] = $closable;
    $dialog['url'] = $url;
    $dialog['title'] = $title;
    $output['dialog'] = $dialog;
    set_sess('output',$output);
}

/**
 * 输出confirm提示确认框
 *
 * @param string $content   提示内容
 * @param null $title   提示标题
 * @param null $callback    点击[确认]触发的js方法
 * @param null $cancel  点击[取消]触发的js方法
 * @param string $type  I|W|E 代表 信息|警告|错误 ，会显示不同的效果，默认为错误
 */
function confirm_dialog($content,$title = null,$callback = null,$cancel = null,$type = 'E'){
    $output = _sess('output');
    $dialog['content'] = $content;
    $dialog['title'] = $title;
    $dialog['callback'] = $callback;
    $dialog['cancel'] = $cancel;
    $dialog['type'] = $type;
    $output['confirmDialog'] = $dialog;
    set_sess('output',$output);
}

/**
 *输出提交验证信息，验证会在：数据insert和update之前，验证规则在model中定义
 */
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

/**
 * 增加验证错误输出，一般用于自定义的验证程序中
 * @param string $key 字段名
 * @param string $error_message 错误消息内容
 */
function add_validation_error($key,$error_message){
    $v[$key] = $error_message;
    _refresh_output('validation',$v);
}

/**
 * 前端工作区内跳转，url组合
 * @param string $controller    控制器
 * @param string $action    方法
 * @param null $params  参数数组
 */
function redirect_to($controller,$action,$params = null){
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

/**
 * 前端工作区内跳转，直接url
 * @param string $url
 */
function redirect_url($url){
    $output = _sess('output');
    $goto['url'] = $url;
    $output['redirect'] = $goto;
    set_sess('output',$output);
}

/**
 * 前端整个页面跳转，相当于js的location替代
 * @param $url
 */
function location_url($url){
    $output = _sess('output');
    $output['location'] = $url;
    set_sess('output',$output);
}

/**
 *前端工作区页面返回
 */
function go_back(){
    $output = _sess('output');
    $goto['url'] = 'goBack';
    $output['redirect'] = $goto;
    set_sess('output',$output);
}

/**
 * 刷新output输出内容
 * @param string $type 输出类型message,data,validation,redirect,dialog等
 * @param $data
 */
function _refresh_output($type,$data){
    $output = _sess('output');
    if(!isset($output[$type])){
        $output[$type] = array();
    }
    array_push($output[$type],$data);
    set_sess('output',$output);
}

if ( ! function_exists('env_language')) {
    /**
     * 判断浏览器环境，返回语言选择
     * @return mixed
     */
    function env_language()
    {
        //判断浏览器语言
        $default_lang_arr = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $strarr = explode(",", $default_lang_arr);
        return $strarr[0];
    }
}


