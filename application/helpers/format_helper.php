<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//将结果集装换成JSON
function rs_to_json($rs){
    $rows = _format($rs->result_array());
    if(count($rows) > 0){
        return json_encode($rows[0]);
    }else{
        return null;
    }
}
//直接输出json字符串
function export_to_json($rs){
    echo rs_to_json($rs);
}


function rs_to_itemStore($rs,$identifier = null,$label = null){
    $row = $rs->result_array();
    $data["identifier"] = $identifier;
    $data["label"] = $label;
    $data['items'] = $row;

    return json_encode($data);
}

//直接输出json到itemStore
function export_to_itemStore($rs,$identifier = null,$label = null){
    $rows = _format($rs->result_array());
    $data["identifier"] = $identifier;
    $data["label"] = $label;
    $data['items'] = $rows;
    echo json_encode($data);
}

//字符串转移删除HTML标签以及换行和空格
function _trim( $str )
{
    $str = trim($str);
    $str = strip_tags($str);
    $str = str_replace("\t","",$str);
    $str = str_replace("\r\n","",$str);
    $str = str_replace("\r","",$str);
    $str = str_replace("\n","",$str);
    return trim($str);
}

//post参数获取
function tpost( $name ){
    if(v($name)){
        return _trim(v($name));
    }else{
        return null;
    }
}

//获取参数
function p($name){
    global $CI;
    return $CI->input->get( $name );
}

//get参数获取
function tget($name){
    if(p($name)){
        return _trim(p($name));
    }else{
        return null;
    }
}

//处理checkbox的勾选返回结果
function xchecked($flag){
    if($flag){
        if($flag == "on"){
            return 1;
        }
    } else{
        return 0;
    }

}

//转换数据库的时间和操作者为系统使用格式
function _format($rows,$is_rs_array = true){
    if($is_rs_array){
        for($i = 0; $i < count($rows);$i++){
            $rows[$i] = _format_row($rows[$i]);
        }
    }else{
        $rows = _format_row($rows);
    }
    return $rows;
}
//格式化函数
function _format_row($row){
    foreach ($row as $key => $value) {
        $row[$key] = _f($key,$value);
    }
    return $row;
}

function _f($key,$value){
    if(is_null($value)){
        $value = "";
    }else{
        if(strpos($key,'_flag') > 0 && !strpos($key,'_flag_')) {
            $value = ( $value == 1 ? "YES" : "NO" );
        }
        if(strpos($key,'_date') > 0 && !strpos($key,'_date_')) {
            $value = date('Y-m-d H:i:s',$value);
        }

        if(strpos($key,'ed_by') > 0 && !strpos($key,'ed_by_')) {
            $value = full_name($value);
        }
    }
    return $value;
}

//在html页面中数组转字符串
function toJSString($data){
    //javascript中输出处理
    for($i=0;$i<count($data);$i++){
        $data[$i] = "'".$data[$i]."'";
    }
    return implode(',',$data);
}