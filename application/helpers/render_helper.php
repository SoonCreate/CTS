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
    echo '<a href="#" title="'.$title.'" class="'.$class.'" onclick="goto(\''.$link.'\',\''.$module_id.'\');">'.$label.'</a>';

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

//输出文件链接
function render_file_link($file){
    echo '<a href="'.base_url(_config('upload_path')).'/'.$file['file_name'].'" title="'.$file['description'].'">'.$file['client_name'].'</a>';
}

function render_form_open($controller,$action,$beforeSubmit = 'null',$remoteFail= 'null',$remoteSuccess= 'null',$remoteNoBack= 'null'){
    echo '<form id="'.$controller.'_'.$action.'" method="post" action="'._url($controller,$action).'"
    onsubmit="return formSubmit(this,'.$beforeSubmit.','.$remoteFail.','.$remoteSuccess.','.$remoteNoBack.');">';
}

function render_form_close(){
    echo '</form>';
}

//控件综合输出
function render_form_input($name,$required = FALSE,$attributes = array()){
    echo '<dl class="row dl-horizontal"><dt>'.render_label($name,$required).'</dt>
    <dd><input name="'.$name.'" id="'.$name.'" type="text" data-dojo-type="sckj/form/TextBox" ';
    if($required){
        echo 'required';
    }
    echo '/></dd>';
    render_form_error($name);
    echo '</dl>';
}

function render_form_textarea($name,$required = FALSE,$attributes = array()){
    echo '<dl class="row dl-horizontal"><dt>'.render_label($name,$required).'</dt>
        <dd><textarea name="'.$name.'" id="'.$name.'" type="text" data-dojo-type="sckj/form/Textarea"';
    if($required){
        echo 'required';
    }
    echo '/></textarea></dd>';
    render_form_error($name);
    echo '</dl>';
}

//根据值集输出select
function render_select_with_options($name,$valuelist_name,$attributes = array()){
    echo '<dl class="row dl-horizontal"> <dt>'.render_label($name).'</dt>';
    echo '<dd> <select name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Select">';
    render_options($valuelist_name);
    echo   '</select> </dd>';
    render_form_error($name);
    echo '</dl>';
}

function render_form_header($title){
    echo '<div class="row paneltitle"><h3>'.label($title).'</h3></div>';
}

function render_submit_button(){
    echo '<button type="submit" data-dojo-type="sckj/form/Button" class="success">'.label('submit').'</button>';
}

function render_label($name,$required = FALSE){
    if($required){
        return '<label for="'._sess('cm').'_'.$name.'">'.'* '.label($name)."</label>";
    }else{
        return '<label for="'._sess('cm').'_'.$name.'">'.label($name)."</label>";
    }
}