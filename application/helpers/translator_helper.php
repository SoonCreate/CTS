<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//输出label语言文件下的注释
function label($name){
    $line = _text('label_'.$name);
    if(!$line){
        $words = explode('_',$name);
        $pass = true;
        $lines = array();
        for($i =0;$i<count($words);$i++){
            $w = _text('label_'.$words[$i]);
            if(!$w){
                $pass = false;
                break;
            }else{
                array_push($lines,$w);
            }
        }
        if($pass){
            $line = join('',$lines);
        }else{
            for($i =0;$i<count($words);$i++){
                $words[$i] = ucfirst($words[$i]);
            }
            $line = join(' ',$words);
        }
    }
    return $line;
}

//根据浏览器语言支持多语言环境
function _text($line,$param = array())
{
    $CI = & get_instance();
    //浏览器语言环境
    $default_lang = env_language();

    //根据$line 获取文件名
    $filename = substr($line,0,stripos($line,'_'));

    // 根据浏览器类型设置语言
//    if( $default_lang == 'en-us' || $default_lang == 'en'){
//        $CI->config->set_item('language', 'english');
//        // 根据设置的语言类型加载语言包
//        $CI->load->language($filename,'english');
//    }else{
//        $CI->config->set_item('language', 'zh-CN');
//        $CI->load->language($filename,'zh-CN');
//    }

    $CI->config->set_item('language', $default_lang);
    $CI->load->language($filename,$default_lang);

    // 根据语言包中的某个语言标记的翻译，判断是否使用了语言包
    $line = $CI->lang->line($line);
    if(is_array($param) && count($param) > 0) {
        array_unshift($param, $line);
        $line = call_user_func_array('sprintf', $param);
    }
    return $line;
}

//view 中输出label
if ( ! function_exists('env_language')) {
    function env_language()
    {
        //判断浏览器语言
        $default_lang_arr = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $strarr = explode(",", $default_lang_arr);
        if(strpos($strarr[0],'zh') == 0){
            return 'zh-CN';
        }else{
            return 'en-us';
        }
    }
}

//view 中输出label
if ( ! function_exists('lang'))
{
    function lang($line, $id = '')
    {
        if ($id != '')
        {
            $line = '<label for="'._sess('cm').'_'.$id.'">'.label($line)."</label>";
        }else{
            $line = '<label for="'._sess('cm').'_'.$line.'">'.label($line)."</label>";
        }

        return $line;
    }
}