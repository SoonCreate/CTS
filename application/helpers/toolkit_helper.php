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
 * 系统工具包
 *
 * @package	Sooncreate
 * @category	helper
 * @author		Sooncreate Studio
 * @link
 */

// ------------------------------------------------------------------------

$CI =&get_instance();

/**
 * url生成函数
 * @param string $controller 控制器
 * @param string $action    方法
 * @param null $params  参数
 * @return mixed
 */
function _url($controller,$action,$params = null){
    $paramstr = '';
    if(!is_null($params)){
        if(is_array($params))
        {
            $paramstr = http_build_query($params);
        } else {
            $paramstr = $params;
        }
    }
//    return 'http://'._config('site_url').site_url($controller.'/'.$action.$paramstr);
    if($paramstr){
        return site_url($controller.'/'.$action.'?'.$paramstr);
    }else{
        return site_url($controller.'/'.$action);
    }

}

/**
 * 从结果集中获取第一行
 * @param object $rs    数据库查询返回的结果集
 * @return null
 */
function first_row($rs){
    $row = $rs->result_array();
    if(count($row) > 0){
        return $row[0];
    }else{
        return null;
    }
}

/**
 * 数据库更新时自动附加时间戳和最后更新者
 * @param array $data   数据
 * @return mixed
 */
function set_last_update($data){
    $data['last_update_date'] = time();
    if(_sess('uid')){
        $data['last_updated_by'] = _sess('uid');
    }else{
        //默认-1为系统自动创建
        $data['last_updated_by'] =  -1;
    }
    return $data;
}

/**
 * 数据库插入数据时自动附加时间戳和创建者
 * @param array $data   数据
 * @return mixed
 */
function set_creation_date($data){
    $data['last_update_date'] = time();
    $data['creation_date'] = time();;
    if(_sess('uid')){
        $data['last_updated_by'] = _sess('uid');
        $data['created_by'] = _sess('uid');
    }else{
        //默认-1为系统自动创建
        $data['last_updated_by'] =  -1;
        $data['created_by'] =  -1;
    }
    return $data;
}

/**
 * 返回公司名或者姓名全称
 * @param int $id   用户id
 * @param bool $only_me 如果为真，只显示自己，其他人都为"对方"
 * @param bool $render_me   显示自己名字时，如果为真，则只显示"我"
 * @return mixed|null|string
 */
function full_name($id,$only_me = FALSE,$render_me = TRUE){
    if($id == -1){
        return label('administrator');
    }else{
        if(is_null($id)){
            return label('unknown');
        }else{
//            if($id == _sess('uid') && $render_me){
//                return label('me');
//            }else{
                if($only_me && $id != _sess('uid')){
                    return "对方";
                }else{
                    global $CI;
                    $CI->load->model('user_model');
                    $um = new User_model();
                    $user = $um->find($id);
                    if(empty($user)){
                        return label('unknown');
                    }else{
                        if(is_null($user['full_name'])){
                            return $user['username'];
                        }else{
                            return $user['full_name'];
                        }

                    }
                }
//            }
        }

    }


}

/**
 * 获取session值
 * @param string $key   session字段
 * @return mixed
 */
function _sess($key){
    global $CI;
    //如果session没有在autoload里面，则需要加载
//    $CI->load->library('session');
    return $CI->session->userdata($key);
}


/**
 * 设置session
 * @param string $key   session字段
 * @param null $value   具体值
 */
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

/**
 * 消除某一个session
 * @param string $key   session字段
 */
function unset_sess($key){
    global $CI;
    $CI->session->unset_userdata($key);
}

/**
 *消除所有session
 */
function clear_all_sess(){
    global $CI;
    $CI->session->sess_destroy();
}

/**
 * 查找默认行：针对某一值集的默认选择
 * @param string $name  值集名称
 * @param string $parent_segment_value  父值集项目
 * @return array
 */
function default_line($name,$parent_segment_value){
    $valuelist_name = 'default_'.$name;
    $options = get_options($valuelist_name,$parent_segment_value);
    if(count($options) > 0){
        return $options[0];
    }else{
        return array();
    }
}

/**
 * 默认值：针对某一值集的默认选择
 * @param string $name  值集名称
 * @param string $parent_segment_value  父值集项目
 * @return null
 */
function default_value($name,$parent_segment_value){
    $valuelist_name = 'default_'.$name;
    $options = get_options($valuelist_name,$parent_segment_value);
    if(count($options) > 0){
        return $options[0]['value'];
    }else{
        return null;
    }
}

/**
 * 获取值集标签对应的值
 * @param string $valuelist_name    值集名称
 * @param string $label 标签
 * @return null
 */
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

/**
 * 获取值集值对应的标签
 * @param string $valuelist_name    值集名称
 * @param string $value 值
 * @param null $parent_segment_value    父值集项目
 * @return mixed|null|string
 */
function get_label($valuelist_name,$value,$parent_segment_value = null){
    if($value == _config('all_values')){
        $label = label('all');
    }else{
        $options = get_options($valuelist_name,$parent_segment_value);
        $label = label('unknown');
        if(count($options) > 0){
            for($i=0;$i<count($options);$i++){
                if($options[$i]["value"] == $value){
                    $label = $options[$i]["label"];
                    break;
                }
            }
        }
    }

    return $label;
}

/**
 * 获取值列表
 * @param string    $valuelist_name 值集名称
 * @param null $parent_segment_value    父值集项目
 * @param bool $all_value   是否包含所有值
 * @param bool $blank_row   是否包含空值
 * @return array
 */
function get_options($valuelist_name,$parent_segment_value = null,$all_value = FALSE,$blank_row = FALSE){
    global $CI;
    $CI->load->model('valuelist_model');
    $vlm = new Valuelist_model();
    $rt = array();
    if(is_null($parent_segment_value)){
        $rt = $vlm->find_active_options($valuelist_name)->result_array();
    }else{
        $rt = $vlm->find_active_children_options($valuelist_name,$parent_segment_value);
    }

    if($all_value){
        $data['id'] = _config('all_values');
        $data['value'] = _config('all_values');
        $data['label'] = label('all_value');
        array_unshift($rt,$data);
    }

    if($blank_row){
        $data['id'] = 'none';
        $data['value'] = '';
        $data['label'] = label('none');
        array_unshift($rt,$data);
    }

    //技术名词开关
    if(_user_config('technical_name')){
        for($i = 0 ; $i < count($rt) ; $i++){
            $rt[$i]['label'] = $rt[$i]['value'].' - '.$rt[$i]['label'] ;
        }
    }

    return $rt;
}

/**
 * 获取系统配置（非ci配置），系统级别配置
 * @param string $config_name   配置名称
 * @return array|bool|int|string
 */
function _config($config_name){
    global $CI;
    $CI->load->model('config_model');
    $cm = new Config_model();
    $value = "";
    $row = $cm->find_by(array('config_name'=>$config_name));
    if(!empty($row)){
        switch($row['data_type']){
            case 'string';
                $value = $row['config_value'];
                break;
            case 'boolean':
                $value = string_to_boolean($row['config_value']);
                break;
            case 'number' :
                $value = string_to_number($row['config_value']);
                break;
            case 'array' :
                $value = explode(',',$row['config_value']);
                break;
            default :
                $value = $row['config_value'];
                break;
        }

    }
    return $value;
}

/**
 * 获取用户配置，用户级别配置，如果无修改则返回系统级别配置
 * @param string $config_name   配置名称
 * @param null $user_id 用户id，默认为当前用户id
 * @return array|bool|int|string
 */
function _user_config($config_name,$user_id = null){
    global $CI;
    $CI->load->model('user_config_model');
    $ucm = new User_config_model();
    $value = "";
    $row = $ucm->config($config_name,$user_id);
    if(!empty($row)){
        switch($row['data_type']){
            case 'string';
                $value = $row['config_value'];
                break;
            case 'boolean':
                $value = string_to_boolean($row['config_value']);
                break;
            case 'number' :
                $value = string_to_number($row['config_value']);
                break;
            case 'array' :
                $value = explode(',',$row['config_value']);
                break;
            default :
                $value = $row['config_value'];
                break;
        }

    }
    return $value;
}

/**
 * 输出值，如果为0则不输出
 * @param string|int $value 值
 * @return string
 */
function zero_to_space($value){
    if($value == 0 || $value == '0'){
        return '';
    }else{
        return $value;
    }
}

/**
 * 字符串转布尔类型
 * @param string $s
 * @return bool
 */
function string_to_boolean($s){
    if(is_bool($s) && strcasecmp($s,'TRUE') == 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

/**
 * 布尔转字符串
 * @param bool $s
 * @return string
 */
function boolean_to_string($s){
    if($s){
        return 'true';
    }else{
        return 'false';
    }
}

/**
 * 字符串转数字
 * @param string $s
 * @return int
 */
function string_to_number($s){
    return intval($s);
}

/**
 * unicode转中文
 * @param string $s
 * @return mixed
 */
function unicode_to_word($s){
    return $code = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", (string)$s);
}

// Returns true if $string is valid UTF-8 and false otherwise.
function is_utf8($word)
{
    if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true
        || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true
        || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true)
    {
        return true;
    }
    else
    {
        return false;
    }
} // function is_utf8

/**
 * 数组混合GBK、UTF-8 换转为UTF-8
 * @param unknown_type $arr
 */
function gbktoutf8($arr){
    if(is_array($arr) && count($arr)){
        foreach($arr as $key=>$value){
            if(is_array($value)){
                $arrRs[$key] = gbktoutf8($value);
            }else{
                if(!is_utf8($value)){
                    $arrRs[$key] = iconv('GBK','UTF-8',$value);
                }else{
                    $arrRs[$key] = $value;
                }
            }
        }
        return $arrRs;
    }
    return null;
}

/**
 * 数组混合GBK、UTF-8 换转为gbk
 * @param array $arr 目标数组
 */
function utf8togbk($arr){
    if(is_array($arr) && count($arr)){
        foreach($arr as $key=>$value){
            if(is_array($value)){
                $arrRs[$key] = utf8togbk($value);
            }else{
                //判断字符编码是否utf8字符(如果不是utf8字符则转换)
                if(is_utf8($value)){
                    $arrRs[$key] = iconv('UTF-8','GBK',$value);
                }else{
                    $arrRs[$key] = $value;
                }
            }
        }
        return $arrRs;
    }
    return 0;
}

/**
 * 判断数组中是否含有这些key
 * @param array $data   数据
 * @param array $keys   字段数组
 * @return bool
 */
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

/**
 * 严重是否所有字段都拥有值
 * @param array $data   数据
 * @param array $keys   字段数组
 * @return bool
 */
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

/**
 * 验证是否必输，获取参数列表，并整合output到前端
 * @return bool
 */
function validate_required(){
    $fields = func_get_args();
    $return = true;
    foreach($fields as $field){
        if(v($field) == ""){
            add_validation_error($field,'');
            $return = false;
        }
    }
    return $return;
}

/**
 * 验证单据操作权限
 * @param string $order_type    单据类型
 * @param string $order_status  单据状态
 * @param null $order_category  单据分类
 * @param null $user_id 用户id，默认当前用户
 * @return bool
 */
function check_order_auth($order_type,$order_status,$order_category = null,$user_id = null){
    global $CI;
    $CI->load->model('auth_model');
    $am = new Auth_model();
    $data['ao_order_type'] = $order_type;
    $data['ao_order_status'] = $order_status;
    if(_config('category_control')){
        if(is_null($order_category)){
            $data['ao_order_category'] = _config('all_values');
        }else{
            $data['ao_order_category'] = $order_category;
        }
    }else{
        $data['ao_order_category'] = _config('all_values');
    }
    return $am->check_auth('category_control',$data,$user_id);
}

/**
 * 验证访问的功能是否拥有权限，根据参数个数：
 * 1. 无参数时，获取url路由中的控制器和方法
 * 2. 两个参数时，默认第一个为控制器和第二为方法
 * 3. 一个参数时，默认为系统注册的方法名
 *
 * @return bool
 */
function check_function_auth(){
    if(_sess('uid') == -1){
        return true;
    }else{
        $args = func_get_args();
        global $CI;
        $CI->load->model('auth_model');
        $am = new Auth_model();
        if(count($args) + 2 == 2){
            return $am->check_function_auth_by_router($CI->router->fetch_class(),$CI->router->fetch_method());
        }elseif(count($args) == 2){
            return $am->check_function_auth_by_router($args[0],$args[1]);
        }else{
            return $am->check_function_auth($args[0]);
        }
    }

}

/**
 * 权限对象验证
 * @param string $auth_object_name  权限对象名称
 * @param array $auth_items 权限对象项目
 * @param null $user_id 用户id，默认为当前用户id
 * @return bool
 */
function check_auth($auth_object_name,$auth_items,$user_id = null){
    if(_sess('uid') == -1){
        return true;
    }else{
        global $CI;
        $CI->load->model('auth_model');
        $am = new Auth_model();
        return $am->check_auth($auth_object_name,$auth_items,$user_id);
    }
}

/**
 * 检查会议操作权限
 * @param string $order_type 投诉单类型
 * @param string $order_category    投诉单分类
 * @param string $action    具体权限：create|edit|inactive
 * @return bool
 */
function check_meeting_auth($order_type,$order_category,$action){
    if(check_auth('meeting_control',array('ao_order_type'=>$order_type,'ao_order_category'=>$order_category,'ao_action'=>$action))){
        return true;
    }else{
        return false;
    }
}

/**
 * 单据是否允许走下一步状态：需要验证是否满足条件
 * @param string $order_type    单据类型
 * @param string $current_status    当前状态
 * @param string $next_status   下一步状态
 * @return bool
 */
function is_order_allow_next_status($order_type,$current_status,$next_status){
    global $CI;
    $CI->load->model('order_model');
    $om = new Order_model();
    return $om->is_allow_next_status($order_type,$current_status,$next_status);
}

/**
 * 检查当前状态是否为系统配置的冻结状态，一般'closed'为冻结
 * @param string $status    状态
 * @return bool
 */
function is_order_locked($status){
    $lock = _config('status_for_lock');
    if($status === $lock){
        return true;
    }else{
        return false;
    }
}

/**
 * 发送消息、通知、短信、邮件，自动根据用户配置发送相应类型的消息
 * @param int $user_id  用户id
 * @param string $subject   标题
 * @param string $message   消息内容
 * @param null $notice_id   关联站内通知
 * @return bool 是否发送成功
 */
function send_message($user_id,$subject,$message,$notice_id = null){
    global $CI;
    $CI->load->model('user_model');
    $um = new User_model();
    $user = $um->find_by(array('id'=> $user_id,'inactive_flag'=> 0));
    $send_mail = true;
    $send_sms = true;
    if(!empty($user) && !is_null($user['email']) && $user['email'] != '' && _user_config('receive_email',$user_id)){
        $send_mail = send_mail($user['email'],$subject,$message,null,null,null,null,$notice_id);
    }
    if(!empty($user) && !is_null($user['mobile_telephone']) && $user['mobile_telephone'] != '' && _user_config('receive_sms',$user_id)){
        $send_sms = send_sms($user['mobile_telephone'],$subject.' '._trim($message),$notice_id);
    }
    return $send_mail && $send_sms;
}


/**
 * 发送email邮件
 *
 * @param string $to    接收人邮件地址
 * @param string $subject  邮件标题
 * @param string $message   邮件内容
 * @param array $attach 附件，文件路径数组
 * @param null $from    发件人邮件地址，如果配置SMTP则必须是登陆的邮件地址
 * @param null $cc  抄送
 * @param null $bcc 密送
 * @param null $notice_id   关联站内通知
 * @return bool
 */
function send_mail($to,$subject,$message,$attach = array(),$from = NULL,$cc = NULL,$bcc = NULL,$notice_id = NULL){
    global $CI;
    $config['protocol']     = _config('mail_protocol');
    if(strcasecmp($config['protocol'], 'sendmail') == 0){
        $config['mailpath'] = _config('sendmail_path');
    }elseif(strcasecmp($config['protocol'], 'smtp') == 0){
        $config['smtp_host'] = _config('smtp_host');
        $config['smtp_user'] = _config('smtp_user');
        $config['smtp_pass'] = _config('smtp_pass');
        $config['smtp_port'] = _config('smtp_port');
        $config['smtp_timeout'] = _config('smtp_timeout');
    }
    $config['charset'] = _config('mail_charset');
    $config['mailtype'] = _config('mail_content_type');

    //换行设置
    $mail_wordwrap = _config('mail_wordwrap');
    if(strcasecmp($mail_wordwrap, 'true') == 0){
        $config['wordwrap'] = TRUE;
        $config['wrapchars'] = _config('mail_wrapchars');
    }else{
        $config['wordwrap'] = FALSE;
    }

    //批量抄送
    $bcc_batch_mode = _config('bcc_batch_mode');
    if(strcasecmp($bcc_batch_mode, 'true') == 0){
        $config['bcc_batch_mode'] = TRUE;
        $config['bcc_batch_size'] = _config('bcc_batch_size');
    }else{
        $config['bcc_batch_mode'] = FALSE;
    }

    $config['newline'] = _config('mail_newline');

    $CI->load->library('email',$config);
    $email = new CI_Email();
    $email->initialize($config);
    if(!is_null($from)){
        $email->from($from['email'],$from['name']);
    }else{
        $email->from(_config('mail_from'),_config('mail_from_name'));
    }

    $email->to($to);
    if(!is_null($cc)){
        $email->cc($cc);
    }
    if(!is_null($bcc)){
        $email->bcc($bcc);
    }

    $email->subject($subject);
    $email->message($message);
    //附件
    if(is_array($attach) && count($attach) > 0 ){
        foreach($attach as $a){
            $this->email->attach($a);
        }
    }

    //暂停发送，正是上线启用
    $pass = $email->send();

    //插入日志
    $CI->load->model('email_log_model');
    $elm = new Email_log_model();
    $data['notice_id'] = $notice_id;
    $data['send_to'] = $to;
    $data['subject'] = $subject;
    $data['content'] = $message;
    $data['send_cc'] = $cc;
    $data['send_bcc'] = $bcc;

    if(is_array($attach) && count($attach) > 0 ){
        $data['attach'] = implode(',',$attach);
    }

    if(!$pass){
        $data['reason'] = implode(',',$email->_debug_msg);
    }
    $elm->insert($data);

    return $pass;
//    return true;
//    echo $email->print_debugger();

}

/**
 * 信息机短信发送
 *
 * @param string $tel_number    手机号码
 * @param string $msg   短信内容
 * @param null $notice_id   关联站内短信
 * @return bool
 */
function send_sms($tel_number,$msg,$notice_id = null){
    global $CI;
    $error_message = array();
    $pass = true;
    $msg_tmp = preg_replace('/[^\x{4e00}-\x{9fa5}]/u', '', $msg);;
    //判断长度:总数不能大于1000，中文字不能大于666
    if(mb_strlen($msg) >= 1000 || mb_strlen($msg_tmp) > 666){
        array_push($error_message,_text('sms_too_long'));
        $pass = false;
    }

    $sms_number = _config('sms_number');
    $sms_ip = _config('sms_ip');
    $sms_account = _config('sms_account');

    if($sms_account == "" || $sms_ip == "" || $sms_number == ""){
        array_push($error_message,_text('sms_no_config'));
        $pass = false;
    }

    if($pass){
        try {
            //这种方式有bug：SoapFault exception: [soap:Client] Not enough message parts were received for the operation.
            //            $client = new SoapClient("http://111.1.15.163/webservice/services/sendmsg?WSDL");
            $client = new SoapClient(null,array('location'=>'http://'.$sms_ip.'/webservice/services/sendmsg','uri'=>'http://'.$sms_ip.'/'));
            $code = intval(substr($tel_number,-4,4)) * 3 + 1111;
            $message = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
                "<infos>" .
                "<info>" .
                "<msg_id><![CDATA[-1]]></msg_id>" .
                "<password><![CDATA[" . $code . "]]></password>" .
                "<src_tele_num><![CDATA[".$sms_number."]]></src_tele_num>" .
                "<dest_tele_num><![CDATA[".$tel_number."]]></dest_tele_num>" .
                "<msg><![CDATA[".$msg."]]></msg>" .
                "</info>" . "</infos>";
            $arrResult = $client->sendmsg($sms_account,$message);
            $p = xml_parser_create();
            xml_parse_into_struct($p, $arrResult, $vals, $index);
            xml_parser_free($p);
            $state = $vals[$index['STATE'][0]]['value'];
            if($state < 0){
                $pass = false;
            }
            switch($state){
                case 0 :
                    //提交成功
                    break;
                case -1 :
                    //企业帐号错误;
                    array_push($error_message,_text('sms_account_wrong'));
                    break;
                case -2 :
                    //验证码格式错误
                    array_push($error_message,_text('sms_code_type_wrong'));
                    break;
                case -3 :
                    //接入号即服务代码错误
                    array_push($error_message,_text('sms_service_number_wrong'));
                    break;
                case -4 :
                    //手机号码错误
                    array_push($error_message,_text('sms_phone_number_wrong'));
                    break;
                case -5 :
                    //消息为空
                    array_push($error_message,_text('sms_blank_content'));
                    break;
                case -6 :
                    //消息太长：不允许超出1000个字（包括中英文），实测不能超过666个中文字
                    array_push($error_message,_text('sms_too_long'));
                    break;
                case -7 :
                    //验证码不匹配
                    array_push($error_message,_text('sms_code_wrong'));
                    break;
            }
        } catch (SOAPFault $e) {
            $pass = false;
            array_push($error_message,$e);
            error_log($e) ;
        }
    }

    //插入日志
    $CI->load->model('sms_log_model');
    $slm = new Sms_log_model();
    $data['notice_id'] = $notice_id;
    $data['send_to'] = $tel_number;
    $data['content'] = $msg;
    if(!$pass){
        $data['reason'] = implode(',',$error_message);
    }
    $slm->insert($data);

    return $pass;
}

/**
 * 加载文件上传的系统配置
 * @return mixed
 */
function load_upload_config(){
    $config['upload_path'] = FCPATH._config('upload_path');
    $config['allowed_types'] = _config('upload_allowed_types');
    $config['overwrite'] =  _config('upload_overwrite');
    $config['encrypt_name'] =  _config('upload_encrypt_name');
    $config['remove_spaces'] =  _config('upload_remove_spaces');

    $config['max_size'] = _config('upload_max_size');
    $config['max_width'] = _config('upload_max_width');
    $config['max_height'] = _config('upload_max_height');
    $config['max_filename'] = _config('upload_max_filename');
    return $config;
}

/**
 * 判断链接是否存在
 *
 * @param string $url
 * @return bool
 */
function url_exists($url){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    $result = curl_exec($curl);
    if ($result !== false) {
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($statusCode == 404) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/**
 * 替代elements方法，获取post参数，如果不存在则用NULL代替
 * @return array
 */
function _data(){
    //处理post提交的数据
    return elements(func_get_args(),$_POST,NULL);
}

/**
 *刷新当前运行环境，当前处于哪个模块的哪个功能
 */
function refresh_env(){
    global $CI;
    $CI->load->model('module_line_model');
    $mlm = new Module_line_model();
    if(v('cm')){
        $ml = $mlm->find_by_view(array('id'=>v('cm')));
        if(!empty($ml)){
            //当前的功能模块id，即module_line_id
            set_sess('cm',$ml['id']);
            set_sess('mid',$ml['module_id']);
            set_sess('fid',$ml['function_id']);
        }
    }else{
        $controller = $CI->router->fetch_class();
        $action = $CI->router->fetch_method();
        $cml = $mlm->find_by_view(array('controller'=>$controller,'action'=>$action,'module_id'=>_sess('mid')));
        if(!empty($cml)){
            set_sess('cm',$cml['id']);
            set_sess('mid',$cml['module_id']);
            set_sess('fid',$cml['function_id']);
        }else{
            //如果当前连接不属于当前模块，随意获取某一mid
            $mls = $mlm->find_by_view(array('controller'=>$controller,'action'=>$action));
            if(!empty($mls)){
                //当前的功能模块id，即module_line_id
                set_sess('cm',$mls['id']);
                set_sess('mid',$mls['module_id']);
                set_sess('fid',$mls['function_id']);
            }
        }
    }

}

/**
 * 获取数据库表注释
 * @param string $table 表名
 * @return mixed|null|string
 */
function table_comment($table){
    return get_label('vl_tables',$table);
}

/**
 * 获取数据库表的某个字段的注释
 * @param string $table 表名
 * @param string $field 字段名
 * @return string
 */
function field_comment($table,$field){
    global $CI;
    $query = $CI->db->query( "select COLUMN_NAME,COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'CTS' AND  table_name = '".$table."' and COLUMN_NAME = '".$field."'" );
    $result = $query->result_array();
    if(count($result)>0){
        if(_user_config('technical_name')){
            $field = $field .' - '.$result[0]['COLUMN_COMMENT'];
        }else{
            $field = $result[0]['COLUMN_COMMENT'];
        }
    }
    return $field;
}

/**
 * 获取数据库表的字段列表，字段名和注释
 * @param string $table 表名
 * @return array
 */
function field_list($table){
    if(_user_config('technical_name')){
        //fix bug table_schema服务器版本区分大小写
        return lazy_get_data("select COLUMN_NAME as value,concat(COLUMN_NAME,' - ',COLUMN_COMMENT) as label from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'cts' AND  table_name = '".$table."'");
    }else{
        return lazy_get_data("select COLUMN_NAME as value,COLUMN_COMMENT as label from INFORMATION_SCHEMA.COLUMNS
        where TABLE_SCHEMA = 'cts' AND  table_name = '".$table."'");
    }

}

/**
 * 生成前端grid控件的结构
 * @param string $field 字段名
 * @param null $label   表单抬头标题
 * @param string $width 列宽
 * @param string $data_type 列的数据类型
 * @param bool $sortable    是否可排序
 * @return mixed
 */
function _structure($field,$label = null,$width = '140px',$data_type = 'string',$sortable = true){
    if(is_null($label)){
        $label = label($field);
    }
    $s['field'] = $field;
    $s['name'] = $label;
    $s['sortable'] = $sortable;
    //id特例
    if($field == 'id'){
        $s['width'] = '60px';
        $s['dataType'] = 'number';
    }else{
        $s['width'] = $width;
        $s['dataType'] = $data_type;
    }

    return $s;
}

/**
 * 生成前端grid控件的结构：空白列
 * @return mixed
 */
function _blank_structure(){
    $s['field'] = '';
    $s['name'] = '';
    $s['width'] = '50px';
    return $s;
}

/**
 * 构建前端grid控件的结构，参数为字段组，生成默认格式的列
 * @return array
 */
function build_structure(){
    $fields = func_get_args();
    $structure = array();
    foreach($fields as $field){
        array_push($structure,_structure($field));
    }
    return $structure;
}


/**
 * 默认上班时间
 * @param null $time    同strtotime()的time参数，可用于加减时间
 * @return bool|string  时间字符串：Y-m-d H:i:s
 */
function default_start_date($time = null){
    $default_d =  date('Y-m-d').' '._config('time_begin');
    if(is_null($time)){
        return $default_d;
    }else{
        return date('Y-m-d H:i:s',strtotime($time,strtotime($default_d)));
    }

}

/**
 * 默认下班时间
 * @param null $time    同strtotime()的time参数，可用于加减时间
 * @return bool|string  时间字符串：Y-m-d H:i:s
 */
function default_end_date($time = null){
    $default_d = date('Y-m-d').' '._config('time_end');
    if(is_null($time)){
        return $default_d;
    }else{
        return date('Y-m-d H:i:s',strtotime($time,strtotime($default_d)));
    }
}

/**
 * 通过curl方式模拟http访问，返回获取内容
 *
 * 使用：
 * echo cevin_http_open('http://www.baidu.com');
 *
 * POST数据
 * $post = array('aa'=>'ddd','ee'=>'d')
 * 或
 * $post = 'aa=ddd&ee=d';
 * echo cevin_http_open('http://www.baidu.com',array('post'=>$post));
 *
 * @param string $url   url
 * @param array $conf   配置，参考程序中的$arr
 * @return string   输出结果
 */
function cevin_http_open($url, $conf = array())
{
    if(!function_exists('curl_init') or !is_array($conf))  return FALSE;

    $post = '';
    $purl = parse_url($url);
//log_message('error',$url);
    $arr = array(
        'post' => FALSE,
        'return' => TRUE,
        'cookie' => FCPATH);
    $arr = array_merge($arr, $conf);
    $ch = curl_init();

    if($purl['scheme'] == 'https')
    {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    }

    //这是你想用PHP取回的URL地址。你也可以在用curl_init()函数初始化时设置这个选项。
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $arr['return']);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $arr['cookie']);
    //传递一个包含cookie数据的文件的名字的字符串。这个cookie文件可以是Netscape格式，或是堆存在文件中的HTTP风格的头。
    curl_setopt($ch, CURLOPT_COOKIEFILE, $arr['cookie']);
    //是否抓取跳转后的页面:设为0，则不会自动301，302跳转
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_VERBOSE,1);
    curl_setopt($ch, CURLOPT_NOPROGRESS,1);

    if($arr['post'] != FALSE)
    {
        //传递一个作为HTTP “POST”操作的所有数据的字符串
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if(is_array($arr['post']))
        {
            $post = http_build_query($arr['post']);
        } else {
            $post = $arr['post'];
        }
//        log_message('error',$post);
        //传递一个作为HTTP “POST”操作的所有数据的字符串
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
//    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');//解释gzip
//    curl_setopt($ch, CURLOPT_NOBODY, 0);
    $result = curl_exec($ch);
//    $statusCode = curl_getinfo($ch);
//    print_r($statusCode);
//    if (curl_errno($ch)) {echo 'Errno'.curl_error($ch);}
    curl_close($ch);

    return $result;
}

/**
 * 通过Fsockopen方式模拟http访问，使用方法同CURL
 *
 * @param string $url   url
 * @param array $conf   配置，参考程序中的$conf_arr
 * @return string
 */
function sw_http_open($url, $conf = array()) {
    $return = '';
    $post = '';
    $cookie = '';
    $ip = '';
    $limit = 0;
    $block = true;
    if(!is_array($conf))
    {
        return $return;
    }
    $matches = parse_url($url);
    !isset($matches['host']) && $matches['host'] = '';
    !isset($matches['path']) && $matches['path'] = '';
    !isset($matches['query']) && $matches['query'] = '';
    !isset($matches['port']) && $matches['port'] = '';
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;

    $conf_arr = array(
        'limit'=>0,
        'post'=>'',
        'cookie'=>'',
        'bysocket'=>FALSE,
        'ip'=>'',
        'timeout'=>15,
        'block'=>TRUE,
    );

    foreach (array_merge($conf_arr, $conf) as $k=>$v) ${$k} = $v;

    if($post) {
        if(is_array($post))
        {
            $post = http_build_query($post);
        }
        $out = "POST $path HTTP/1.0/r/n";
        $out .= "Accept: */*/r/n";
        //$out .= "Referer: $boardurl/r/n";
        $out .= "Accept-Language: zh-cn/r/n";
        $out .= "Content-Type: application/x-www-form-urlencoded/r/n";
        $out .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."/r/n";
        $out .= "Host: $host/r/n";
        $out .= 'Content-Length: '.strlen($post)."/r/n";
        $out .= "Connection: Close/r/n";
        $out .= "Cache-Control: no-cache/r/n";
        $out .= "Cookie: $cookie/r/n/r/n";
        $out .= $post;
    } else {
        $out = "GET $path HTTP/1.0/r/n";
        $out .= "Accept: */*/r/n";
        //$out .= "Referer: $boardurl/r/n";
        $out .= "Accept-Language: zh-cn/r/n";
        $out .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."/r/n";
        $out .= "Host: $host/r/n";
        $out .= "Connection: Close/r/n";
        $out .= "Cookie: $cookie/r/n/r/n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if(!$fp) {
        return '';
    } else {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if(!$status['timed_out']) {
            while (!feof($fp)) {
                if(($header = @fgets($fp)) && ($header == "/r/n" ||  $header == "/n")) {
                    break;
                }
            }

            $stop = false;
            while(!feof($fp) && !$stop) {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if($limit) {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}


/**
 * 数据或json导出excel
 *
 * @param array|string $data_string 数据，可为数组和json字符串
 * @param string $filename  生成的文件名
 * @param array $fields 自定义列，如果为空则，默认获取数据数组中的key
 * @throws \PHPExcel_Exception
 * @throws \PHPExcel_Reader_Exception
 */
function export_to_excel($data_string,$filename,$fields = array()){
    global $CI;
    $is_json = false;
    //数组
    if(!is_array($data_string)){
        $data = json_decode($data_string);
        if(is_null($data)){
            //纯字符串
            force_download($filename.'.xlsx', $data_string);
        }else{
            $is_json = true;
        }
    }else{
        $data = $data_string;
    }
    if(!empty($data)){
        $CI->load->library('PHPExcel');
        $CI->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle($filename)->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        if(empty($fields)){
            foreach($data[0] as $key=>$value){
                array_push($fields,$key);
            }
        }
        // Field names in the first row
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, label($field));
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach($data as $row_data){
            $col = 0;
            foreach ($fields as $field)
            {
                //json中文处理
                if($is_json){
                    $row_data[$field] = unicode_to_word($row_data[$field]);
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_data[$field]);
                $col++;
            }
            $row++;
        }

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

function now(){
    return date('Y-m-d H:i:s');
}

//用于构建后台作业的日志输出格式
function job_log_string($log){
    return now().' '.$log."\r\n";
}

//获取月份差
function interval_month($from,$to){
    return abs(date("Y",$to)-date("Y",$from))*12+date("m",$to)-date("m",$from);
}