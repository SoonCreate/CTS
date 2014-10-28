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

function render_link($url,$label,$title = '',$class = '',$noRender = 'false'){
    $g = url_goto($url);
    return '<a href="#" title="'.$title.'" class="'.$class.'" onclick="goto(\''.$g['url'].'\',\''.$g['module_id'].'\','.$noRender.');">'.$label.'</a>';
}

function url_goto($url){
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
    $g['url'] = $link;
    $g['module_id'] = $module_id;
    return $g;
}

function render_link_button($url,$label,$title = '',$class = '',$noRender = 'false'){
    $label =  '<button data-dojo-type="sckj/form/Button">'.$label.'</button>';
    return render_link($url,$label,$title,$class,$noRender);
}

function render_error($message = '',$heading = ''){
    if($heading == ''){
        $heading = label('error');
    }
    $data['heading'] = $heading;
    $data['message'] = $message;
    render_view('error',$data);
}

function render_no_auth_error(){
    global $CI;
    $CI->load->model('message_model','message');
    $mm = new Message_model();
    $message = $mm->find_by_view(array('class_code'=>'system','message_code'=>'20','language'=>env_language()));
    if(!empty($message)){
        render_error($message['content']);
    }
}

function render_form_error($field){
    return '<div id="error_'.$field.'_'._sess('cm').'"></div>';
}

//输出到view里面的option
function render_options($valuelist_name,$parent_segment_value = null,$all_value = FALSE,$blank_row = FALSE){
    $options = get_options($valuelist_name,$parent_segment_value ,$all_value,$blank_row);
    $echo = "";
    foreach($options as $o){
        $echo = $echo . '<option value="'.$o['value'].'">'.$o['label'].'</option>';
    }
    return $echo;
}

function render_options_by_array($options){
    if(is_array($options)){
        $echo = "";
        foreach($options as $o){
            $echo = $echo . '<option value="'.$o['value'].'">'.$o['label'].'</option>';
        }
        return $echo;
    }else{
        return '';
    }
}

//输出到view里的radio
function render_radio($name,$valuelist_name,$parent_segment_value = null){
    $options = get_options($valuelist_name,$parent_segment_value );
    $echo = "";
    for($i=0;$i<count($options);$i++){
        if($i>0){
            $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$name.'" id="'.$options[$i]['value'].'" type="radio" value="'.$options[$i]['value'].
                '"/><label for="'.$options[$i]['value'].'">'.$options[$i]['label'].'</label>';
        }else{
            $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$name.'" id="'.$options[$i]['value'].'" type="radio" value="'.$options[$i]['value'].
                '" checked/><label for="'.$options[$i]['value'].'">'.$options[$i]['label'].'</label>';
        }
    }
    return $echo;
}

function render_single_checkbox($name,$value,$label = null,$checked = FALSE,$id = null){
    $echo = '';
    $echo = $echo . '<dl class="row dl-horizontal"> <dt>'.render_label($name,false,$label).'</dt>';
    $echo = $echo .'<dd><input name="'.$name.'" ';
    if(is_null($id)){
       $id = $name;
    }
    $echo = $echo . 'id="'.$id.'"';
    $echo = $echo .' data-dojo-type="sckj/form/CheckBox" type="checkbox" value="'.$value.'" ';
    if($checked){
        $echo = $echo . ' checked ';
    }else{
        if(_v($name) == $value){
            $echo = $echo . ' checked ';
        }
    }

    $echo = $echo .' />';

    $echo = $echo .'</dd></dl>';
    return $echo;
}

//根据值输出options
function render_options_with_value(){
    $args = func_get_args();
    $value = '';
    $echo = '';
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
            $echo = $echo. '<option value="'.$o['value'].'" selected>'.$o['label'].'</option>';
        }else{
            $echo =$echo. '<option value="'.$o['value'].'">'.$o['label'].'</option>';
        }
    }
    if(count($args) +  2 == 2){
        $echo = $echo.'<option value=""></option>';
    }
    return $echo;
}

function render_radio_with_value(){
    $args = func_get_args();
    $echo = '';
    if(count($args) === 3){
        $options = get_options($args[1] );
        if($args[2]){
            foreach($options as $o){
                if($o['value'] === $args[2]){
                    $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                        '" checked/><label for="'.$o['value'].'">'.$o['label'].'</label>';
                }else{
                    $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                        '"/><label for="'.$o['value'].'">'.$o['label'].'</label>';
                }
            }
        }else{
            $echo = $echo . render_radio($args[0],$args[1]);
        }
    }elseif(count($args) > 3){
        $options = get_options($args[1],$args[2] );
        foreach($options as $o){
            if($o['value'] === $args[3]){
                $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                    '" checked/><label for="'.$o['value'].'">'.$o['label'].'</label>';
            }else{
                $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$args[0].'" id="'.$o['value'].'" type="radio" value="'.$o['value'].
                    '"/><label for="'.$o['value'].'">'.$o['label'].'</label>';
            }
        }
    }elseif(count($args) +  2 == 2){
        $echo = $echo. '';
    }
    return $echo;
}

//输出文件链接
function render_file_link($file){
    return '<a href="'.base_url(_config('upload_path')).'/'.$file['file_name'].'" title="'.$file['description'].'">'.$file['client_name'].'</a>';
}

function render_form_open($controller,$action,$beforeSubmit = 'null',$remoteFail= 'null',$remoteSuccess= 'null',$remoteNoBack= 'null'){
    return  '<form id="'.$controller.'_'.$action.'" method="post" action="'._url($controller,$action).'"
    onsubmit="return formSubmit(this,'.$beforeSubmit.','.$remoteFail.','.$remoteSuccess.','.$remoteNoBack.');">';
}

function render_file_form_open($controller,$action,$beforeSubmit = 'null',$remoteFail= 'null',$remoteSuccess= 'null',$remoteNoBack= 'null'){
    return  '<form encType="multipart/form-data" id="'.$controller.'_'.$action.'" method="post" action="'._url($controller,$action).'"
    onsubmit="return formSubmit(this,'.$beforeSubmit.','.$remoteFail.','.$remoteSuccess.','.$remoteNoBack.');">';
}

function render_form_close(){
    return '</form>';
}

//控件综合输出
function render_form_input($name,$required = FALSE,$attributes = array(),$disabled = FALSE){
    return _render_input_by_type($name,$required,$attributes,'text',$disabled);
}

function render_form_password($name,$required = FALSE,$attributes = array(),$disabled = FALSE){
    return _render_input_by_type($name,$required,$attributes,'password',$disabled);
}

function render_form_hidden($name,$value = null){
    if(is_null($value)){
        return  '<input name="'.$name.'" type="hidden" value="'._v($name).'" />';
    }else{
        return  '<input name="'.$name.'" type="hidden" value="'.$value.'" />';
    }

}

function render_form_datetextbox($name,$required = FALSE,$attributes = array(),$disabled = FALSE,$datetime = null){
    $echo = '';
    $echo = $echo. '<dl class="row dl-horizontal"><dt>'.render_label($name,$required).'</dt>
    <dd><input name="'.$name.'" id="'.$name.'" value="'._v($name).'" type="text" data-dojo-type="sckj/form/DateTextBox" trim="true"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    foreach($attributes as $key=>$value){
        $echo = $echo. $key.' = '.'"'.$value.'"';
    }

    $echo = $echo. '/>';
    if(!is_null($datetime)){
        $echo = $echo . $datetime;
    }
    $echo = $echo.render_form_error($name).'</dd></dl>';
    return $echo;
}

function render_form_timebox($name){
    return '<input data-dojo-type="sckj/form/TimeTextBox" name="'.$name.'" id="'.$name.'" value="'._v($name).'" />';
}

function _render_input_by_type($name,$required = FALSE,$attributes = array(),$type = 'text',$disabled = FALSE){
    $echo = '';
    $echo = $echo. '<dl class="row dl-horizontal"><dt>'.render_label($name,$required).'</dt>
    <dd><input name="'.$name.'" id="'.$name.'" value="'._v($name).'" type="'.$type.'" data-dojo-type="sckj/form/TextBox" trim="true" ';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    foreach($attributes as $key=>$value){
        $echo = $echo. $key.'= '.'"'.$value.'"';
    }

    $echo = $echo. '/>'. render_form_error($name).'</dd></dl>';
    return $echo;
}

function render_form_combobox($name,$data,$required = FALSE,$search_attr = null,$label_attr = null,$multi = false,$attributes = array(),$disabled = FALSE){
    if(is_null($search_attr)){
        $search_attr = $name;
    }
    if(is_null($label_attr)){
        $label_attr = $name;
    }

    $dojo_type = 'sckj/form/ComboBox';
    if($multi){
        $dojo_type = 'sckj/form/MultiComboBox';
    }

    $echo = '';
    $echo = $echo. '<div data-dojo-type="dojo/store/Memory" data-dojo-id="stateStore_'._sess('cm').'" data-dojo-props=\''.
        'data: '.$data.'\'></div>';
    $echo = $echo. '<dl class="row dl-horizontal"><dt>'.render_label($name,$required).'</dt>
    <dd><input data-dojo-type="'.$dojo_type.'" data-dojo-props="store:stateStore_'._sess('cm').', searchAttr:\''.
        $search_attr.'\',labelAttr:\''.$label_attr.'\'"'.
           'name="'.$name.'" id="'.$name.'" value="'._v($name).'"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    foreach($attributes as $key=>$value){
        $echo = $echo. ' '.$key.' = '.'"'.$value.'"';
    }

    $echo = $echo. '/>'.render_form_error($name).'</dd></dl>';
    return $echo;
}

function render_form_textarea($name,$required = FALSE,$attributes = array(),$disabled = FALSE){
    $echo = '';
    $echo = $echo. '<dl class="row dl-horizontal"><dt>'.render_label($name,$required).'</dt>
        <dd><textarea name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Textarea" style="height:60px!important"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    foreach($attributes as $key=>$value){
        $echo = $echo. $key.'= '.'"'.$value.'"';
    }

    $echo = $echo. ' />'._v($name).'</textarea>'.render_form_error($name).'</dd></dl>';
    return $echo;
}

//根据值集输出select
function render_select_with_options($name,$valuelist_name,$required = FALSE,$attributes = array()){
    $echo = '';
    $echo = $echo . '<dl class="row dl-horizontal"> <dt>'.render_label($name).'</dt>';
    $echo = $echo. '<dd> <select name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Select" value="'._v($name).'"';
    if($required){
        $echo = $echo. ' required ';
    }

    foreach($attributes as $key=>$value){
        $echo = $echo. $key.'= '.'"'.$value.'"';
    }

    $echo = $echo. ' >';
    $echo = $echo. render_options_with_value($valuelist_name,_v($name));
    $echo = $echo.   '</select> '.render_form_error($name).'</dd></dl>';
    return $echo;
}

//对于已有options的时候，无需再查valuelist
function render_select_add_options($name,$options,$required = FALSE,$attributes = array()){
    $echo = '';
    $echo = $echo . '<dl class="row dl-horizontal"> <dt>'.render_label($name).'</dt>';
    $echo = $echo. '<dd> <select name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Select" value="'._v($name).'"';
    if($required){
        $echo = $echo. ' required ';
    }

    foreach($attributes as $key=>$value){
        $echo = $echo. $key.'= '.'"'.$value.'"';
    }

    $echo = $echo. ' >';
    $echo = $echo. $options;
    $echo = $echo.   '</select> '.render_form_error($name).'</dd></dl>';
    return $echo;
}

function render_form_header($title){
    return '<div class="row paneltitle"><h3>'.label($title).'</h3></div>';
}

function render_submit_button(){
    return '<button type="submit" data-dojo-type="sckj/form/Button" class="success">'.label('submit').'</button>';
}

function render_button($name,$onclick = "",$class = 'normal'){
    return '<button type="button" data-dojo-type="sckj/form/Button" class="'.$class.'" onclick="'.$onclick.'">'.label($name).'</button>';
}

function render_button_group($buttons = array(),$has_submit = TRUE){
    $echo = '';
    $echo = $echo .'<div class="fixbottom">';
    if($has_submit){
        $echo = $echo. render_submit_button();
    }
    foreach($buttons as $b){
        $echo = $echo . $b;
    }
    $echo = $echo . '</div>';
    return $echo;
}

function render_label($name,$required = FALSE,$label = null){
    if(is_null($label)){
        $label = label($name);
    }
    if($required){
        return '<label for="'.$name.'_'._sess('cm').'_'._sess('mid').'">'.'* '.$label."</label>";
    }else{
        return '<label for="'.$name.'_'._sess('cm').'_'._sess('mid').'">'.$label."</label>";
    }
}

//输出当前页地址
function render_path($current_page = null){
    global $CI;
    $CI->load->model('module_line_model');
    $mlm = new Module_line_model();
    $line = $mlm->find_by_view(array('id'=>_sess('cm')));
    if(is_null($current_page)){
        return '<div>页面路径：'.$line['module_desc'].' > '.$line['function_desc'].'</div>';
    }else{
        return '<div>页面路径：'.$line['module_desc'].' > '.$line['function_desc'].' > '.$current_page.'</div>';
    }
}