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
 * 用于渲染模版的控件库
 *
 * @package	Sooncreate
 * @category	helper
 * @author		Sooncreate Studio
 * @link
 */

 // ------------------------------------------------------------------------

/**
 * 加载wso模版，代替原来的view函数，自动加载action命名的view文件
 * @param null $data
 */
function render($data = NULL){
    render_by_layout('wso',NULL,$data);
}

/**
 * 加载wso模版，另指定view文件
 * @param null $view
 * @param null $data
 */
function render_view($view = NULL,$data = NULL){
    render_by_layout('wso',$view,$data);
}

/**
 * 用于默认加载url对应默认路由后的controller/action，查找对应的view文件
 * @param null $layout  模版名称，位于view目录下，以layout_开头
 * @param null $view
 * @param null $data
 */
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

/**
 * 生成用于前端使用的超链接，js的goto方法
 *
 * @param mixed $url  url字符串或者数组
 * @param string $label    显示的标签
 * @param string $title 对应a标签的title，注释
 * @param string $class 定义a标签的style
 * @param string $noRender  对应goto方法的noRender参数，如果为true则不跳转，出现提示框
 * @return string
 */
function render_link($url,$label,$title = '',$class = '',$noRender = 'false'){
    $g = _parse_ciUrl($url);
    if(isset($g['blank_flag']) && $g['blank_flag']){
        return '<a href="'.$g['url'].'" title="'.$title.'" class="'.$class.'" target="_blank">'.$label.'</a>';
    }else{
        return '<a href="#" title="'.$title.'" class="'.$class.'" onclick="goto(\''.$g['url'].'\',\''.$g['module_id'].'\','.$noRender.');">'.$label.'</a>';
    }

}

/**
 * 解析url
 * @param mixed $url  url字符串或者数组
 * @return mixed    哈希数组返回：url字符串和模块id，模块id用于前端模块选择
 */
function _parse_ciUrl($url){
    //默认当前模块
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
        //优先获取当前模块下注册的功能
        $cml = $mlm->find_by_view(array('controller'=>$controller,'action'=>$action,'module_id'=>_sess('mid')));
        if(!empty($cml)){
            $params['cm'] = $cml['id'];
            //是否为打开新窗口
            $g['blank_flag'] = $cml['blank_flag'];
        }else{
            //如果当前连接不属于当前模块，随意获取某一mid
            $mls = $mlm->find_all_by_view(array('controller'=>$controller,'action'=>$action));
            if(!empty($mls)){
                $ml = $mls[0];
                $params['cm'] = $ml['id'];
                $module_id = $ml['module_id'];
                $g['blank_flag'] = $ml['blank_flag'];
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


/**
 * 控件头
 * @param string $name 字段名称
 * @param null $label   自定义标签
 * @param bool $required    是否必输项
 * @param bool $auto_label_tag 自动生成label tag
 * @return string
 */
function _dijit_header($name,$label = null,$required = false,$auto_label_tag = true){
    $has_tag_label = render_label($name,$required,$label);
    $label = label($name,$label);
    if($auto_label_tag){
        $label = $has_tag_label;
    }else{
        if($required){
            $label = '<label>*'.$label.'</label>';
        }else{
            $label = '<label>'.$label.'</label>';
        }
    }
    return '<dl class="row dl-horizontal"> <dt>'.$label.'</dt><dd>';
}

/**
 * 控件结尾，自动带上报错dom
 * @param string $name
 * @return string
 */
function _dijit_footer($name){
    return  render_form_error($name).'</dd></dl>';
}

/**
 * 与render_link函数功能相近
 * @param string $url
 * @param string $label
 * @param string $title
 * @param string $class 用于显示标签前方的图片字体
 * @param string $noRender
 * @return string
 */
function render_link_button($url,$label,$title = '',$class = '',$noRender = 'false'){
    $bt =  '<button data-dojo-type="sckj/form/Button">';
    if($class){
        $bt = $bt . '<i class="'.$class.' icon-1x"></i>';
    }
    $bt =  $bt .$label.'</button>';
    return render_link($url,$bt,$title,null,$noRender);
}

/**
 * 用于提示“整页”错误
 * @param string $message   报错内容
 * @param string $heading   报错抬头
 */
function render_error($message = '',$heading = ''){
    if($heading == ''){
        $heading = label('error');
    }
    $data['heading'] = $heading;
    $data['message'] = $message;
    render_view('error',$data);
}

/**
 *  用于“整页”显示无权限报错
 */
function render_no_auth_error(){
    global $CI;
    $CI->load->model('message_model','message');
    $mm = new Message_model();
    $message = $mm->find_by_view(array('class_code'=>'system','message_code'=>'20'));
    if(!empty($message)){
        render_error($message['content']);
    }
}

/**
 * 用于form验证失败后的报错提示的显示，一般位于控件dom后面，显示于下方
 * @param string $field    字段名
 * @return string   domNode内容
 */
function render_form_error($field){
    return '<div id="error_'.$field.'_'._sess('cm').'_'._sess('mid').'" class="dijitBottonMessageError"></div>';
}


/**
 * 用于select控件的option项目
 * @param string $valuelist_name   值集名称
 * @param null $parent_segment_value    所属父值集项目
 * @param bool $all_value   是否可勾选“所有值”
 * @param bool $blank_row   是否可勾选“空值”
 * @return string   domNode
 */
function render_options($valuelist_name,$parent_segment_value = null,$all_value = FALSE,$blank_row = FALSE){
    $options = get_options($valuelist_name,$parent_segment_value ,$all_value,$blank_row);
    return render_options_by_array($options);
}

/**
 * 已知options数组的情况下，生产option项目
 * @param array $options  来自方法get_options或现成的数组
 * @return string   domNode
 */
function render_options_by_array($options = array()){
    $echo = "";
    foreach($options as $o){
        $echo = $echo . '<option value="'.$o['value'].'">'.$o['label'].'</option>';
    }
    return $echo;
}


/**
 * radio控件，结合值集输出
 * @param string $name
 * @param null $label   如果为null，默认输出label($name)
 * @param string $valuelist_name
 * @param null $parent_segment_value
 * @param bool $disabled
 * @return string
 */
function render_radio_group($name,$label = null,$valuelist_name,$parent_segment_value = null,$disabled = FALSE){
    $options = get_options($valuelist_name,$parent_segment_value );
    $label = label($name,$label);
    //输出开始
    $echo = _dijit_header($name,$label,false,true);
    //如果有值则循环选择值，无值则选择第一个
    $value = _v($name);

    if($disabled){
        $disabled = 'disabled';
    }else{
        $disabled = '';
    }

    if($value){
        for($i=0;$i<count($options);$i++){
            $checked = '';
            if($options[$i]['value'] == $value){
                $checked = 'checked';
            }
            $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$name.'" id="'.$options[$i]['value'].'"
            type="radio" value="'.$options[$i]['value'].'" '.$checked.' '.$disabled.' />'.render_label($options[$i]['value'],false,$options[$i]['label']);
        }
    }else{

        for($i=0;$i<count($options);$i++){
            $checked = '';
            if($i == 0){
                $checked = 'checked';
            }
            $echo = $echo. '<input data-dojo-type="sckj/form/RadioButton" name="'.$name.'" id="'.$options[$i]['value'].'"
            type="radio" value="'.$options[$i]['value'].'" '.$checked.' '.$disabled.' />'.render_label($options[$i]['value'],false,$options[$i]['label']);
        }
    }
    //输出结束
    $echo = $echo ._dijit_footer($name);
    return $echo;
}


/**
 * 单个复选框
 * @param string $name
 * @param int $checked_value    选中后的值，默认为1
 * @param null $label   标签
 * @param bool $checked 是否默认被选中
 * @param bool $disabled 是否失效
 * @param array $attributes 其他参数，参照dojo CheckBox API 文档
 * @return string   domNode
 */
function render_single_checkbox($name,$checked_value = 1,$label = null,$checked = FALSE,$disabled = FALSE,$attributes = array()){
    $echo = _dijit_header($name,$label,false);
    $echo = $echo .'<input name="'.$name.'" data-dojo-type="sckj/form/CheckBox" type="checkbox" value="'.$checked_value.'" ';
    if($checked){
        $echo = $echo . ' checked ';
    }else{
        if(_v($name) == $checked_value){
            $echo = $echo . ' checked ';
        }
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    //其他属性依次输出
    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.' = '.'"'.$value.'"';
        }
    }

    $echo = $echo .' />';

    $echo = $echo ._dijit_footer($name);
    return $echo;
}

/**
 * 输出文件链接，点击即下载
 * @param array $file  文件对象，来自数据库
 * @return string
 */
function render_file_link($file){
    return '<a href="'._url('welcome','file_download',array('name'=>$file['client_name'],'path'=>base_url(_config('upload_path')).'/'.$file['file_name'])).'"
    title="'.$file['description'].'">'.$file['client_name'].'</a>';
}

/**
 * 表单头，与前端配合实现ajax提交
 * @param string $controller 控制器
 * @param string $action    函数
 * @param string $beforeSubmit  前端js方法名，设置钩子：form提交前运行
 * @param string $remoteFail    前端js方法名，设置钩子：form提交后，服务端运行失败时运行
 * @param string $remoteSuccess 前端js方法名，设置钩子：form提交后，服务端运行成功时运行
 * @param string $remoteNoBack  前端js方法名，设置钩子：form提交后，服务端无返回值时运行
 * @return string   domNode
 */
function render_form_open($controller,$action,$beforeSubmit = 'null',$remoteFail= 'null',$remoteSuccess= 'null',$remoteNoBack= 'null'){
    return  '<form id="'.$controller.'_'.$action.'" method="post" action="'._url($controller,$action).'"
    onsubmit="return formSubmit(this,'.$beforeSubmit.','.$remoteFail.','.$remoteSuccess.','.$remoteNoBack.');">';
}

/**
 * 文件上传form，同render_form_open
 * @param $controller
 * @param $action
 * @param string $beforeSubmit
 * @param string $remoteFail
 * @param string $remoteSuccess
 * @param string $remoteNoBack
 * @return string
 */
function render_file_form_open($controller,$action,$beforeSubmit = 'null',$remoteFail= 'null',$remoteSuccess= 'null',$remoteNoBack= 'null'){
    return  '<form encType="multipart/form-data" id="'.$controller.'_'.$action.'" method="post" action="'._url($controller,$action).'"
    onsubmit="return formSubmit(this,'.$beforeSubmit.','.$remoteFail.','.$remoteSuccess.','.$remoteNoBack.');">';
}

/**
 * 表单结尾
 * @param bool $with_submit_button  默认不附带提交按钮
 * @param null $label   提交按钮标签
 * @param string $class 提交按钮样式
 * @return string   domNode
 */
function render_form_close($with_submit_button = false,$label = null,$class = 'success'){
    $echo = '';
    //有参数则输出submit按钮
    if($with_submit_button){
        $echo = $echo . render_submit_button($label,$class);
    }
    return $echo .'</form>';
}

/**
 * 文本框控件，根据类型区分输出input还是password
 * @param string $name  字段
 * @param bool $required    是否必输
 * @param null $label   标签
 * @param array $attributes 其他参数，参照dojo TextBox API 文档
 * @param string $type  输出类型
 * @param bool $disabled    是否不能修改，即无效
 * @param string $remark    备注，位于控件后方
 * @return string   domNode
 */
function _render_input_by_type($name,$required = FALSE,$label = null,$attributes = array(),$type = 'text',$disabled = FALSE,$remark = ""){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo .'<input name="'.$name.'"  value="'._v($name).'" type="'.$type.'" data-dojo-type="sckj/form/TextBox" trim="true" ';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }
    //输出参数
    $echo = $echo . ' data-dojo-props = " ';
    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.': '.'\''.$value.'\'';
        }
    }
    $echo = $echo . ' " ';
    $echo = $echo. '/>'.$remark. render_form_error($name).'</dd></dl>';
    return $echo;
}

/**
 * 文本框，同_render_input_by_type
 * @param $name
 * @param bool $required
 * @param bool $disabled
 * @param null $label
 * @param array $attributes 其他参数，参照dojo TextBox API 文档
 * @param string $remark
 * @return string
 */
function render_form_input($name,$required = FALSE,$disabled = FALSE,$label = null,$attributes = array(),$remark = ""){
    return _render_input_by_type($name,$required,$label,$attributes,'text',$disabled,$remark);
}

/**
 * 可通过值集选择的输入框控件
 * @param string $name 字段
 * @param string $valuelist_name    值集
 * @param string $parentSegmentValue 父值集
 * @param bool $required    是否必输
 * @param bool $disabled    是否失效
 * @param null $label   标签
 * @param bool $muliple 是否多选
 * @param bool $all_value   是否可选所有值
 * @param bool $pagination  是否分页
 * @param string $page_size 单页条目数
 * @param array $attributes 其他参数，参照dojo TextBox API 文档
 * @return string   domNode
 */
function render_input_with_options($name,$valuelist_name,$parentSegmentValue = 'undefined',$required = FALSE,$disabled = FALSE,$label = null,
                                  $muliple = true,$all_value = false,$pagination = false,$page_size = 'undefined',$attributes = array()){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo. '<input name="'.$name.'" id="'.$name.'" value="'._v($name).'"  data-dojo-type="sckj/form/ScTextBox" trim="true" ';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    $echo = $echo . ' data-dojo-props = " ';

    if(!is_array($attributes) || (is_array($attributes) && empty($attributes))){
        $attributes = array('vlDialogOptions'=>'{
        valuelistName : \''.$valuelist_name.'\',parentSegmentValue : \''.$parentSegmentValue.'\',pagination:'.boolean_to_string($pagination).',selectRowMultiple:'.
            boolean_to_string($muliple).',allValue:'.boolean_to_string($all_value).',pageSize:'.$page_size.',valueSegment:\'value\'}');
    }
    foreach($attributes as $key=>$value){
        $echo = $echo. $key.': '.$value;
    }
    $echo = $echo . ' " />';
    $echo = $echo . _dijit_footer($name);
    return $echo;
}


/**
 * 来自远程数据支撑的文本框
 * @param string $name  字段
 * @param string $data_url  数据来源url
 * @param bool $required    是否必输
 * @param bool $disabled    是否失效
 * @param null $label   标签
 * @param bool $muliple 是否多选
 * @param bool $pagination  是否分页
 * @param int $page_size    单页条目数
 * @param array $attributes 其他参数，参照dojo TextBox API 文档
 * @return string   domNode
 */
function render_form_input_data($name,$data_url,$required = FALSE,$disabled = FALSE,$label = null,
                                $muliple = true,$pagination = false,$page_size = 10,$attributes = array()){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo. '<input name="'.$name.'" id="'.$name.'" value="'._v($name).'"  data-dojo-type="sckj/form/ScTextBox" trim="true" ';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    $echo = $echo . ' data-dojo-props = " ';

    if(!is_array($attributes) || (is_array($attributes) && empty($attributes))){
        $attributes = array('gridDialogOptions'=>'{
        dataUrl : \''.$data_url.'\',pagination:'.boolean_to_string($pagination).',selectRowMultiple:'.boolean_to_string($muliple).',pageSize:'.$page_size.'}');
    }
    foreach($attributes as $key=>$value){
        $echo = $echo. $key.': '.$value;
    }
    $echo = $echo . ' "/>';
    $echo = $echo . _dijit_footer($name);
    return $echo;
}

/**
 * 密码类型文本框
 * @param string $name  字段
 * @param bool $required    是否必输
 * @param null $label   标签
 * @param array $attributes 其他参数
 * @param bool $disabled    是否失效
 * @return string   domNode
 */
function render_form_password($name,$required = FALSE,$label = null,$attributes = array(),$disabled = FALSE){
    return _render_input_by_type($name,$required,$label,$attributes,'password',$disabled);
}

/**
 * 隐藏文本框控件
 * @param string $name  字段
 * @param null $value   默认值，优先级高于系统变量
 * @return string   domNode
 */
function render_form_hidden($name,$value = null){
    if(is_null($value)){
        return  '<input id="'.$name.'" name="'.$name.'" type="hidden" value="'._v($name).'" />';
    }else{
        return  '<input id="'.$name.'" name="'.$name.'" type="hidden" value="'.$value.'" />';
    }

}

/**
 * 单独日期选择控件
 * @param string $name 字段
 * @param bool $required    是否必输
 * @param bool $disabled    是否失效
 * @param null $label   标签
 * @param array $attributes 其他参数
 * @param null $datetime    附带单独时间选择控件，domNode
 * @return string   domNode
 */
function render_form_dateTextBox($name,$required = FALSE,$disabled = FALSE,$label = null,$attributes = array(),$datetime = null){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo. '<input name="'.$name.'" id="'.$name.'" value="'._v($name).'" type="text" data-dojo-type="sckj/form/DateTextBox" trim="true" data-dojo-props ="constraints: {
            datePattern: \'y-M-d\'
        }"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.' = '.'"'.$value.'"';
        }
    }

    $echo = $echo. '/>';
    if(!is_null($datetime)){
        $echo = $echo . $datetime;
    }
    $echo = $echo._dijit_footer($name);
    return $echo;
}

/**
 * 单独时间选择控件，配合单独日期选择控件存在
 * @param string $name
 * @param bool $required
 * @param bool $disabled
 * @param array $attributes
 * @param string $h 用于计算间隔增长：小时
 * @param string $m 用于计算间隔增长：分钟
 * @param string $s 用于计算间隔增长：秒
 * @return string
 */
function render_form_timeTextBox($name,$required = FALSE,$disabled = FALSE,$attributes = array(),$h = '00',$m = '15',$s = '00'){
    $echo = '<input data-dojo-type="sckj/form/TimeTextBox" name="'.$name.'" id="'.$name.'" value="'._v($name).'" data-dojo-props ="constraints: {
            timePattern: \'HH:mm:ss\',
            clickableIncrement: \'T'.$h.':'.$m.':'.$s.'\',
            visibleIncrement:\'T'.$h.':'.$m.':'.$s.'\'
        }" ';
    if($required){
        $echo = $echo. ' required ';
    }
    if($disabled){
        $echo = $echo. ' disabled ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.' = '.'"'.$value.'"';
        }
    }

    return $echo.'/>';
}

/**
 * 日期+时间组合控件，格式"y-M-d HH:mm:ss"
 * @param $name
 * @param bool $required
 * @param bool $disabled
 * @param null $label
 * @param bool $work_time   自动配合系统配置的正常工作上班时间，默认为false
 * @param array $attributes
 * @return string
 */
function render_form_dateTimeBox($name,$required = FALSE,$disabled = FALSE,$label = null,$work_time = false,$attributes = array()){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo. '<input name="'.$name.'" id="'.$name.'" value="'._v($name).'" type="text" data-dojo-type="sckj/form/DateTimeTextBox" trim="true" ';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }
    //是否默认工作时间
    if($work_time){
        $echo = $echo . ' minTime="T'._config('time_begin').'" maxTime="T'._config('time_end').'" ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.' = '.'"'.$value.'"';
        }
    }

    $echo = $echo. '/>';

    $echo = $echo._dijit_footer($name);
    return $echo;
}

/**
 * 输入框下拉列表控件
 * @param string $name
 * @param bool $required
 * @param bool $disabled
 * @param null $label
 * @param string $data  json字符串，为下拉列表所展示的数据
 * @param null $search_attr 数据查询字段
 * @param null $label_attr  数据展示字段
 * @param bool $multi   是否允许输入多个值，如果为真，则调用MultiComboBox
 * @param array $attributes 其他参数
 * @return string
 */
function render_form_comboBox($name,$required = FALSE,$disabled = FALSE,$label = null,$data,$search_attr = null,$label_attr = null,$multi = false,$attributes = array()){
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

    //设置dataStore
    $echo = '<div data-dojo-type="dojo/store/Memory" data-dojo-id="stateStore_'._sess('cm').'" data-dojo-props=\''.
        'data: '.$data.'\'></div>';

    $echo = $echo . _dijit_header($name,$label,$required);

    $echo = $echo. '<input data-dojo-type="'.$dojo_type.'" data-dojo-props="store:stateStore_'._sess('cm').', searchAttr:\''.
        $search_attr.'\',labelAttr:\''.$label_attr.'\'"'.
           'name="'.$name.'" id="'.$name.'" value="'._v($name).'"';

    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. ' '.$key.' = '.'"'.$value.'"';
        }
    }

    $echo = $echo. '/>'._dijit_footer($name);
    return $echo;
}


/**
 * 文本域控件
 * @param string $name
 * @param bool $required
 * @param bool $disabled
 * @param null $label
 * @param array $attributes
 * @return string
 */
function render_form_textArea($name,$required = FALSE,$disabled = FALSE,$label = null,$attributes = array()){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo. '<textarea name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Textarea" style="height:60px!important"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.'= '.'"'.$value.'"';
        }
    }

    $echo = $echo. ' />'._v($name).'</textarea>'._dijit_footer($name);
    return $echo;
}


/**
 * 下拉菜单结合值集控件
 * @param string $name
 * @param string $valuelist_name   值集
 * @param bool $required
 * @param null $label
 * @param bool $disabled
 * @param array $attributes
 * @param null $parentSegmentValue  父值集
 * @param bool $allValue    是否包含所有值项目
 * @param bool $blankValue  是否包含空值项目
 * @return string
 */
function render_select_with_options($name,$valuelist_name,$required = FALSE,$label = null,
                                    $disabled = false,$attributes = array(),$parentSegmentValue = null,$allValue = false,$blankValue = false){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo . '<select name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Select" value="'._v($name).'"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.'= '.'"'.$value.'"';
        }
    }

    $echo = $echo. ' >';
    $echo = $echo. render_options($valuelist_name,$parentSegmentValue,$allValue,$blankValue);
    $echo = $echo.   '</select> '._dijit_footer($name);
    return $echo;
}


/**
 * 已有opitons情况下的下拉列表控件
 * @param string $name
 * @param string $options
 * @param bool $required
 * @param bool $disabled
 * @param null $label
 * @param array $attributes
 * @return string
 */
function render_select_add_options($name,$options,$required = FALSE,$disabled = false,$label = null,$attributes = array()){
    $echo = _dijit_header($name,$label,$required);
    $echo = $echo . '<select name="'.$name.'" id="'.$name.'" data-dojo-type="sckj/form/Select" value="'._v($name).'"';
    if($required){
        $echo = $echo. ' required ';
    }

    if($disabled){
        $echo = $echo. ' disabled ';
    }

    if(is_array($attributes)){
        foreach($attributes as $key=>$value){
            $echo = $echo. $key.'= '.'"'.$value.'"';
        }
    }

    $echo = $echo. ' >';
    $echo = $echo. $options;
    $echo = $echo.   '</select> '._dijit_footer($name);
    return $echo;
}

/**
 * 表单头
 * @param string $title 标题
 * @return string
 */
function render_form_header($title){
    return '<div class="row paneltitle"><h3>'.label($title).'</h3></div>';
}

/**
 * 提交按钮控件
 * @param null $label   标签
 * @param string $class 样式
 * @return string
 */
function render_submit_button($label = null,$class = 'success'){
    $label = label('submit',$label);
    return '<button type="submit" data-dojo-type="dijit/form/Button" class="'.$class.'" >'.$label.'</button>';
}

/**
 * 普通按钮控件按
 * @param string $label_name    字段
 * @param string $onclick   onclick事件
 * @param string $class 样式
 * @return string
 */
function render_button($label_name,$onclick = "",$class = 'normal'){
    return '<button type="button" data-dojo-type="dijit/form/Button" class="'.$class.'" onclick="'.$onclick.'">'.label($label_name).'</button>';
}

/**
 * 按钮组，默认带提交按钮
 * @param array $buttons    按钮组
 * @param bool $has_submit  是否包含提交按钮
 * @return string
 */
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

/**
 * label生成
 * @param string $name  字段
 * @param bool $required    是否必输，自动生成前部的 * 号
 * @param null $label   默认以$name为标签，可替换成$label
 * @return string
 */
function render_label($name,$required = FALSE,$label = null){
    $label = label($name,$label);
    if($required){
        return '<label for="'.$name.'_'._sess('cm').'_'._sess('mid').'">'.'* '.$label."</label>";
    }else{
        return '<label for="'.$name.'_'._sess('cm').'_'._sess('mid').'">'.$label."</label>";
    }
}

/**
 * 当前页路径
 * @param null $current_page    当前页标签
 * @return string
 */
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

/**
 * 单据功能点按钮，位于单据顶部，通过后台配置实现
 * @param int $order_id   唯一性标识
 * @param string $order_type    单据类型
 * @param string $current_status    当前状态
 * @return string
 */
function render_order_button_group($order_id,$order_type,$current_status){
    global $CI;
    $CI->load->model('status_function_model');
    $CI->load->model('status_line_model');
    $CI->load->model('status_model');
    $slm = new Status_line_model();
    $sfm = new Status_function_model();
    $status_code = default_value('status',$order_type);
    $line = $slm->find_by_view(array('status_code'=>$status_code,'step_value'=>$current_status));
    $buttons = array();
    if(!empty($line)){
        $sfm->order_by('sort');
        $sfm->order_by('label');
        $functions = $sfm->find_all_by_view(array('status_line_id'=>$line['id']));
        foreach($functions as $fn){
            if(check_function_auth($fn['function_name'])){
                $no_render = 'true';
                if($fn['render_flag']){
                    $no_render = 'false';
                }
                array_push($buttons,render_link_button(array($fn['controller'],$fn['action'],array('id'=>$order_id)),
                    $fn['label'],$fn['description'],$fn['display_class'],$no_render));
            }
        }
    }
    return join('&nbsp;',$buttons);
}


/**
 * 通过参数自动判断，并输出options
 * @return string
 */
function render_options_with_value(){
    $args = func_get_args();
    $value = '';
    $echo = '';
    $options = array();
    if(count($args) == 2){
        $options = get_options($args[0]);
        $value = $args[1];
    }elseif(count($args) == 3){
        $options = get_options($args[0],$args[1]);
        $value = $args[2];
    }elseif(count($args) == 4){
        $options = get_options($args[0],$args[1],$args[3]);
        $value = $args[2];
    }elseif(count($args) > 4){
        $options = get_options($args[0],$args[1],$args[3],$args[4]);
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