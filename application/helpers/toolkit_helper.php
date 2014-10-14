<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//渲染函数
function render($data = NULL){
    render_by_layout('wso',NULL,$data);
}

function render_view($view = NULL,$data = NULL){
    render_by_layout('wso',$view,$data);
}

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
//function render($data = NULL){
//    $CI =  &get_instance();
//    $CI->load->view($CI->router->fetch_directory().'/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method(),$data);
//}

//function redirect_to($controller,$action,$params = null){
//    redirect(_url($controller,$action,$params));
//}

function render_link($url,$label,$title = '',$class = ''){
    $module_id = _sess('mid');
    $link = '';
    $params = array();
    if(is_array($url)){
        $controller = $url[0];
        $action = $url[1];
        if(isset($url[2])){
            $params = $url[2];
        }
        $CI =  &get_instance();
        $CI->load->model('module_line_model');
        $mlm = new Module_line_model();
        $cml = $mlm->find_by_view(array('controller'=>$controller,'action'=>$action,'module_id'=>_sess('mid')));
        if(!empty($cml)){
            $params['cm'] = $cml['id'];
        }else{
            //如果当前连接不属于当前模块，随意获取某一mid
            $mls = $mlm->find_all_by_view(array('controller'=>$controller,'action'=>$action));
            if(!empty($mls)){
                $ml = $mls[0];
                $params['cm'] = $ml['id'];
                $module_id = $ml['module_id'];
            }
        }
        $link = _url($controller,$action,$params);
    }else{
        $link = $url;
    }
    echo '<a href="#" title="'.$title.'" class="'.$class.'" onclick="goto(\''.$module_id.'\',\''.$link.'\');">'.$label.'</a>';

}

function render_error($heading = '',$message = ''){
    $CI =  &get_instance();
    $data['heading'] = $heading;
    $data['message'] = $message;
    $CI->load->view('error',$data);
}

function render_form_error($field){
    echo '<dd><div id="error_'._sess('cm').'_'.$field.'"></div></dd>';
}

function _url($controller,$action,$params = null){
    $paramstr = '';
    if(!is_null($params)){
        $i = 0;
        foreach($params as $key=>$value){
            if($i < 1){
                $paramstr = $paramstr . '?'.$key .'=' . $value;
            } else{
                $paramstr = $paramstr . '&'.$key .'=' . $value;
            }
            $i = $i + 1;
        }
    }
//    return 'http://'._config('site_url').site_url($controller.'/'.$action.$paramstr);
    return site_url($controller.'/'.$action.$paramstr);
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
    if(_sess('uid')){
        $data['last_updated_by'] = _sess('uid');
    }else{
        $data['last_updated_by'] =  -1;
    }
    return $data;
}

function set_creation_date($data){
    $data['last_update_date'] = time();
    $data['creation_date'] = time();;
    if(_sess('uid')){
        $data['last_updated_by'] = _sess('uid');
        $data['created_by'] = _sess('uid');
    }else{
        $data['last_updated_by'] =  -1;
        $data['created_by'] =  -1;
    }
    return $data;
}

//姓名或公司名
function full_name($id){
    if($id == -1){
        return label('administrator');
    }else{
        if(is_null($id)){
            return label('unknow');
        }else{
            global $CI;
            $CI->load->model('user_model');
            $um = new User_model();
            $user = $um->find($id);
            if(empty($user)){
                return label('unknow');
            }else{
                if(is_null($user['full_name'])){
                    return $user['username'];
                }else{
                    return $user['full_name'];
                }

            }
        }

    }


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

function get_label($valuelist_name,$value,$parent_segment_value = null){
    $options = get_options($valuelist_name,$parent_segment_value);
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
function get_options($valuelist_name,$parent_segment_value = null,$all_value = FALSE){
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
        $data['value'] = _config('all_values');
        $data['label'] = label('all_value');
        array_unshift($rt,$data);
    }
    return $rt;
}

//输出到view里面的option
function render_options($valuelist_name,$parent_segment_value = null,$all_value = FALSE){
    $options = get_options($valuelist_name,$parent_segment_value ,$all_value);
    foreach($options as $o){
        echo '<option value="'.$o['value'].'">'.$o['label'].'</option>';
    }
}

//输出到view里的radio
function render_radio($name,$valuelist_name,$parent_segment_value = null){
    $options = get_options($valuelist_name,$parent_segment_value );
    for($i=0;$i<count($options);$i++){
        if($i>0){
            echo '<input name="'.$name.'" id="'.$options[$i]['value'].'" type="radio" value="'.$options[$i]['value'].
                '"/><label for="'.$options[$i]['value'].'">'.$options[$i]['label'].'</label>';
        }else{
            echo '<input name="'.$name.'" id="'.$options[$i]['value'].'" type="radio" value="'.$options[$i]['value'].
                '" checked/><label for="'.$options[$i]['value'].'">'.$options[$i]['label'].'</label>';
        }
    }
}

//根据值输出options
function render_options_with_value(){
    $args = func_get_args();
    $value = '';
    if(count($args) == 2){
        $options = get_options($args[0]);
        $value = $args[1];
    }elseif(count($args) == 3){
        $options = get_options($args[0],$args[1]);
        $value = $args[2];
    }elseif(count($args) > 3){
        $options = get_options($args[0],$args[1],$args[3]);
        $value = $args[2];
    }
    foreach($options as $o){
        if($o['value'] ==  $value){
            echo '<option value="'.$o['value'].'" selected>'.$o['label'].'</option>';
        }else{
            echo '<option value="'.$o['value'].'">'.$o['label'].'</option>';
        }
    }
    if(count($args) +  2 == 2){
        echo '<option value=""></option>';
    }

}

function render_radio_with_value(){
    $args = func_get_args();
    if(count($args) === 3){
        $options = get_options($args[1] );
        if($args[2]){
            foreach($options as $o){
                if($o['value'] === $args[2]){
                    echo '<input name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                        '" checked/><label for="'.$o['value'].'">'.$o['label'].'</label>';
                }else{
                    echo '<input name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                        '"/><label for="'.$o['value'].'">'.$o['label'].'</label>';
                }
            }
        }else{
            render_radio($args[0],$args[1]);
        }
    }elseif(count($args) > 3){
        $options = get_options($args[1],$args[2] );
        foreach($options as $o){
            if($o['value'] === $args[3]){
                echo '<input name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                    '" checked/><label for="'.$o['value'].'">'.$o['label'].'</label>';
            }else{
                echo '<input name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                    '"/><label for="'.$o['value'].'">'.$o['label'].'</label>';
            }
        }
    }elseif(count($args) +  2 == 2){
        echo '';
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

function string_to_boolean($s){
    if(strcasecmp($s,'TRUE') == 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function string_to_number($s){
    return intval($s);
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

//判断是否为分类控制，再进行权限判断。默认为分类为all
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
            $data['ao_order_category'] = $order_status;
        }
    }else{
        $data['ao_order_category'] = _config('all_values');
    }
    return $am->check_auth('category_control',$data,$user_id);
}

function check_function_auth(){
    $args = func_get_args();
    $CI =  &get_instance();
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

//验证当前用户是否拥有权限
function check_auth($auth_object_name,$auth_items,$user_id = null){
    $CI =  &get_instance();
    $CI->load->model('auth_model');
    $am = new Auth_model();
    return $am->check_auth($auth_object_name,$auth_items,$user_id);
}

function is_order_allow_next_status($current_status,$next_status){
    global $CI;
    $CI->load->model('order_model');
    $om = new Order_model();
    return $om->is_allow_next_status($current_status,$next_status);
}

function is_order_locked($status){
    $lock = _config('status_for_lock');
    if($status === $lock){
        return true;
    }else{
        return false;
    }
}

//邮件发送方法
function send_mail($to,$subject,$message,$from = NULL,$cc = NULL,$bcc = NULL){
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
        $config['wrapchars'] = string_to_number(_config('mail_wrapchars'));
    }else{
        $config['wordwrap'] = FALSE;
    }

    //批量抄送
    $bcc_batch_mode = _config('bcc_batch_mode');
    if(strcasecmp($bcc_batch_mode, 'true') == 0){
        $config['bcc_batch_mode'] = TRUE;
        $config['bcc_batch_size'] = string_to_number(_config('bcc_batch_size'));
    }else{
        $config['bcc_batch_mode'] = FALSE;
    }

    $config['newline'] = _config('mail_newline');

    print_r($config);

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
    //暂停发送，正是上线启用
//    $email->send();
//    echo $email->print_debugger();

}

function load_upload_config(){
    $config['upload_path'] = FCPATH._config('upload_path');
    $config['allowed_types'] = _config('upload_allowed_types');
    $config['overwrite'] =  string_to_boolean(_config('upload_overwrite'));
    $config['encrypt_name'] =  string_to_boolean(_config('upload_encrypt_name'));
    $config['remove_spaces'] =  string_to_boolean(_config('upload_remove_spaces'));

    $config['max_size'] = string_to_number(_config('upload_max_size'));
    $config['max_width'] = string_to_number(_config('upload_max_width'));
    $config['max_height'] = string_to_number(_config('upload_max_height'));
    $config['max_filename'] = string_to_number(_config('upload_max_filename'));
    return $config;
}

//判断链接是否存在
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

function _data(){
    //处理post提交的数据
    return elements(func_get_args(),$_POST,NULL);
}

//输出文件链接
function render_file_link($file){
    echo '<a href="'.base_url(_config('upload_path')).'/'.$file['file_name'].'" title="'.$file['description'].'">'.$file['client_name'].'</a>';
}

//刷新环境
function refresh_env(){
    global $CI;
    $CI->load->model('module_line_model');
    $mlm = new Module_line_model();
    $ml = $mlm->find_by_view(array('id'=>v('cm')));
    if(!empty($ml)){
        //当前的功能模块id，即module_line_id
        set_sess('cm',$ml['id']);
        set_sess('mid',$ml['module_id']);
        set_sess('fid',$ml['function_id']);
    }
}

function run_validation($data,$validate)
{
    global $CI;
    if(!empty($validate))
    {
        foreach($data as $key => $val)
        {
            $_POST[$key] = $val;
        }

        $CI->load->library('form_validation');

        if(is_array($validate))
        {
            $CI->form_validation->set_rules($validate);
            return $CI->form_validation->run();
        }
        else
        {
            return $CI->form_validation->run($validate);
        }
    }
    else
    {
        return TRUE;
    }
}