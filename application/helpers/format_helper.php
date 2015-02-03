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
 * 用于格式化数据
 *
 * @package	Sooncreate
 * @category	helper
 * @author		Sooncreate Studio
 * @link
 */

// ------------------------------------------------------------------------

/**
 * 结果集换成JSON字符串
 * @param object $rs    数据库查询结果集
 * @return null|string
 */
function rs_to_json($rs){
    $rows = _format($rs->result_array());
    if(count($rows) > 0){
        return json_encode($rows[0]);
    }else{
        return null;
    }
}
/**
 * json输出数据库查询结果集
 * @param $rs
 */
function export_to_json($rs){
    echo rs_to_json($rs);
}


/**
 * 将数组转成itemStore
 * @param array $rows   数据数组
 * @param null $identifier  唯一性标识
 * @param null $label   标签（tree控件等默认会用到）
 * @return string   json字符串
 */
function to_itemStore($rows,$identifier = null,$label = null){
    $data["identifier"] = $identifier;
    $data["label"] = $label;
    $data['items'] = $rows;

    return json_encode($data);
}


/**
 * 格式化后输出itemStore json
 * @param array $rows   数据数组
 * @param null $identifier  唯一性标识
 * @param null $label   标签（tree控件等默认会用到）
 * @param bool $is_full_text    是否输出姓名和格式化时间
 * @param bool $is_related_time 是否以中文叙述时间
 */
function export_to_itemStore($rows,$identifier = null,$label = null,$is_full_text = FALSE,$is_related_time = FALSE){
    $rows = _format($rows,$is_full_text,$is_related_time);
    $data["identifier"] = $identifier;
    $data["label"] = $label;
    $data['items'] = $rows;
    echo json_encode($data);
}

/**
 * 字符串转换删除HTML标签以及换行和空格
 * @param string $str 被格式化的字符串
 * @return string
 */
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

/**
 * 截断后的参数获取
 * @param string $name 字段名
 * @return null|string
 */
function tPost( $name ){
    if(v($name)){
        return _trim(v($name));
    }else{
        return null;
    }
}

/**
 * 获取get参数，替换input->get方法
 * @param string $name
 * @return mixed
 */
function p($name){
    global $CI;
    return $CI->input->get( $name );
}

/**
 * 格式化数据
 * @param array $rows   数据数组或当条数据的数组
 * @param bool $is_full_text    是否输出姓名和格式化时间
 * @param bool $is_related_time 是否以中文叙述时间
 * @param bool $is_rs_array 是否为数据库结果集数组
 * @return mixed
 */
function _format($rows,$is_full_text = FALSE,$is_related_time = FALSE,$is_rs_array = true){
    if($is_rs_array){
        for($i = 0; $i < count($rows);$i++){
            $rows[$i] = _format_row($rows[$i],$is_full_text,$is_related_time);
        }
    }else{
        $rows = _format_row($rows,$is_full_text,$is_related_time);
    }
    return $rows;
}

/**
 * 格式化单行数据
 * @param array $row    数据
 * @param bool $is_full_text    是否输出姓名和格式化时间
 * @param bool $is_related_time 是否以中文叙述时间
 * @return mixed
 */
function _format_row($row,$is_full_text = FALSE,$is_related_time = FALSE){
    foreach ($row as $key => $value) {
        $row[$key] = _f($key,$value,$is_full_text,$is_related_time);
    }
    return $row;
}

/**
 * 格式化单个字段 key => value
 * @param string $key 字段名
 * @param mixed $value  值
 * @param bool $is_full_text    是否输出姓名和格式化时间
 * @param bool $is_related_time 是否以中文叙述时间
 * @return bool|mixed|null|string
 */
function _f($key,$value,$is_full_text = FALSE,$is_related_time = FALSE){
    if(is_null($value)){
        $value = "";
    }else{
        if($is_full_text){
            //字段结尾为flag
            if(strpos($key,'_flag') > 0 && !strpos($key,'_flag_')) {
                $value = ( $value == 1 ? label('yes') : label('no') );
            }
            //字段结尾为ed_by，为操作人
            if(strpos($key,'ed_by') > 0 && !strpos($key,'ed_by_')) {
                $value = full_name($value);
            }
            //中文叙述时间
            if($is_related_time){
                //字段结尾为date
                if(strpos($key,'_date') > 0 && !strpos($key,'_date_') && !is_null($value)) {
                    if($value){
                        $value = related_time(date('Y-m-d H:i:s',$value));
                    }else{
                        $value = '';
                    }
                }
            }else{
                if(strpos($key,'_date') > 0 && !strpos($key,'_date_') && !is_null($value)) {
                    if($value){
                        $value = date('Y-m-d H:i:s',$value);
                    }else{
                        $value = '';
                    }

                }
            }

        }else{
            if(strpos($key,'_date') > 0 && !strpos($key,'_date_') && !is_null($value)) {
                if($value){
                    $value = date('Y-m-d H:i:s',$value);
                }else{
                    $value = '';
                }
            }
        }

    }
    return $value;
}

/**
 * 在html页面中数组转字符串
 * @param $data
 * @return string
 */
function toJSString($data){
    //javascript中输出处理
    for($i=0;$i<count($data);$i++){
        $data[$i] = "'".$data[$i]."'";
    }
    return implode(',',$data);
}

/**
 * 结合系统配置，字符串截断，多余的字以'...'代替
 * @param string $str   被格式化的字符串
 * @param null $finish  截断的位置
 * @return string
 */
function word_truncate($str,$finish = null)
{
    if(is_null($finish)){
        $finish = _config('word_truncate');
    }
    return word_substr($str,$finish);
}

/**
 * 时间字符串转时间戳，空则为null
 * @param string $str   被格式化的字符串
 * @return int|null
 */
function sc_strtotime($str){
    if($str){
        return strtotime($str);
    }else{
        return null;
    }
}