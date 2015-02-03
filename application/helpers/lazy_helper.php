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
 * 懒人函数库，草稿来源互联网，加入了速创调整形成正式版
 *
 * @package	Sooncreate
 * @category	helper
 * @author		Sooncreate Studio
 * @link
 */

// ------------------------------------------------------------------------

/**
 *	常量：项目根目录
 */
define('ROOT', dirname(FCPATH).'/');
@date_default_timezone_set('Asia/Shanghai'); 

//获取全局ci变量
$CI =&get_instance();

/**
 * 替代ci的input->get_post方法
 * @param string $name 字段名
 * @return mixed
 */
function v( $name )
{
	global $CI;
	return $CI->input->get_post( $name );
}

/**
 * 针对textArea提交的内容进行过滤，避免xss攻击
 * @param string $name	字段名
 * @return mixed
 */
function x( $name )
{
	$name = strip_tags( $name , '<a><img><u><b><strong><i><br/><br><p>' );
	global $CI;
	return $CI->security->xss_clean( $name );	
}

/**
 * 去除所有的html标签
 * @param $name
 * @return mixed|string
 */
function n( $name )
{
	$name = strip_tags( $name );
	$name = str_replace( "\n" , "<br/>" , $name );
	return $name; 
}

/**
 * 针对textArea提交的内容进行过滤，替换换行符
 * @param string $name 字段名
 * @return mixed|string
 */
function r( $name )
{
	$name = strip_tags( $name , '<a><img><li><ol><ul><em><strong>' );
	$name = str_replace( "\n" , "<br/>" , $name );
	return $name; 
}


/**
 * 去除所有html标签，用空格替换换行符
 * @param string $name	字段名
 * @return mixed|string
 */
function z( $name )
{
	$name = strip_tags( $name );
	$name = str_replace( "\n" , " " , $name );
	return $name; 
}

/**
 * 仅去除所有html标签
 * @param string $name	字段名
 * @return string
 */
function t( $name )
{
	$name = strip_tags( $name );
	return $name;
}

/**
 * 数据库转意
 * @param string $name 字段名
 * @return mixed
 */
function s( $name )
{
	global $CI;
	return $CI->db->escape( $name );
}

/**
 * 替换urlecode方法
 * @param string $url	被解析的url
 * @return string
 */
function u( $url )
{
	return urlencode( $url );
}

/**
 * 获取ci系统配置
 * @param string $name	配置名
 * @return mixed
 */
function c( $name )
{
	global $CI;
	return $CI->config->item( $name );
}

/**
 * 输出返回链接
 * @param string $name	链接标签
 * @return string
 */
function b( $name )
{
	return '<a href="javascript:history.back(1)">' . $name . '</a>';
}

/**
 * 获取数据库数据
 * @param null $sql	sql字符串
 * @param null $key	单个字段返回
 * @return array
 */
function lazy_get_data( $sql = NULL , $key = NULL )
{
	global $CI;
	
	if( !isset($CI->db) ) $CI->load->database();
	
	$data = array();
	
	if( $sql != NULL )
	{
		$query = $CI->db->query( $sql );
		$result = $query->result_array(); 
	}
	else
	{
		$result = $CI->db->get()->result_array();
	}
	
	foreach( $result as $line )
	{
		if( isset( $line[$key] ) )
		{
			$data[$line[$key]] = $line;
		}
		else
		{
			$data[] = $line;
		}
	}
	return $data;
}

/**
 * 获取单行数据
 * @param null $sql	sql字符串
 * @return mixed
 */
function lazy_get_line( $sql = NULL )
{
	$data = lazy_get_data( $sql );
	if( isset($data[0]) )
	{
		return $data[0];
	}
}

/**
 * 返回第一个字段的值
 * @param null $sql
 * @return mixed
 */
function lazy_get_var( $sql = NULL )
{
	$data = lazy_get_line( $sql );
	return $data[ @reset(@array_keys( $data )) ];
}


/**
 * 返回第一个字段的值数组 data[key] => key
 * @param null $sql
 * @return array
 */
function lazy_get_vars( $sql = NULL )
{
	$data = lazy_get_data( $sql );
	$vars = array();
	if( $data )
	{
		foreach( $data as $v )
		{
			$key = $v[ @reset(@array_keys( $v )) ];
			if( $key )
			{
				$vars[$key] = $key;
			}
		}
	}
	return $vars;
}

/**
 * 直接运行sql返回结果集
 * @param $sql
 * @return mixed
 */
function lazy_run_sql( $sql )
{
	global $CI;
	if( !$CI->db ) $CI->load->database();
	
	return $CI->db->query( $sql );
}

/**
 * 获取刚插入id号
 * @return mixed
 */
function lazy_last_id()
{
	global $CI;
	if( !$CI->db ) $CI->load->database();
	return $CI->db->insert_id();
}




/*
 * 控制器相关迅捷函数
 *
 */
// =================================

/**
 * 根据url获取action
 * @return string
 */
function method()
{
	global $CI;
	if( $CI->uri->segment(2) )
		return $CI->uri->segment(2);
	else
		return 'index';
}

/**
 * 根据url获取controller
 * @return string
 */
function module()
{
	global $CI;
	if( $CI->uri->segment(1) )
		return $CI->uri->segment(1);
	else
		return 'index';
}

/**
 * 内容截断，多余的内容以'...'结束
 * @param string $str	内容字符串
 * @param int $finish	结束位置
 * @return string
 */
function word_substr($str,$finish)
{
	if(mb_strlen($str , 'utf-8') < $finish)
	{
		return $str;
	}
	return mb_substr($str,0,$finish,'utf-8').'...';
}

/**
 * 中文注释时间
 * @param int $t	时间戳
 * @param string $o	替换用的数组，见程序中的$obj
 * @return mixed|string
 */
function related_time( $t, $o='' )
{	
	$obj = array(
		0=>array('5*60'=>'刚刚'),
		1=>array('60*60'=>'%m分钟前'),
		2=>array('24*60*60'=>'%h小时前'),
		3=>array('7*24*60*60'=>'%d天前'),
		4=>array('30*24*60*60'=>'%w周前'),
		5=>array('365*24*60*60'=>'%F月前'), 
		6=>array('50*365*24*60*60'=>'%y年前'));
	
	$timestamp = strtotime($t);
	$nowstamp = time();
	$passedTime = $nowstamp - $timestamp;
	$m = ceil($passedTime / 60);
	$h = ceil($passedTime / (60*60));
	$d = ceil($passedTime / (24*60*60));
	$w = ceil($passedTime / (7*24*60*60));
	$f = ceil($passedTime / (30*24*60*60));
	$y = ceil($passedTime / (365*24*60*60));
	
	if ($o == '')
	{
		$o =  $obj;
	}
	
	for($i=0; $i<count($o); $i++)
	{
		$ret = '';
		$max = key($o[$i]);
		eval('$timeAge = '.$max.';');
		$ret = current($o[$i]);
	
		if ( $passedTime < $timeAge)
		{
			$ret = current($o[$i]);
			$ret = str_replace("%m",$m, $ret);
			$ret = str_replace("%h",$h, $ret);
			$ret = str_replace("%d",$d, $ret);
			$ret = str_replace("%w",$w, $ret);
			$ret = str_replace("%F",$f, $ret);
			$ret = str_replace("%y",$y, $ret);
			break;
		}
		
	}
	return $ret;
}

/**
 * 清除目录文件
 * @param $dir
 */
function deldir( $dir )
{ 
	if ( @rmdir( $dir )==false && is_dir($dir) ) 
	{ 
		$all = glob( $dir. '*');
		if( $all )
		{
			foreach( $all as $item )
			{
				if( !is_dir( $item ) )
				{
					@unlink($item);
				}
				else
				{
					deldir( $item.'/' );
				}
			}
			@rmdir( $dir );
		}
	 }
}

/**
 * 重新设置大小到当前目录，文件名为xxx_thumb.xx
 * @param string $source_image 文件路径
 * @param int $w	新图片宽度
 * @param int $h	新图片高度
 * @return bool
 */
function resize_photo($source_image,$w,$h){
	global $CI;
	$config['image_library'] = 'gd2';
	//$config['library_path'] = "C:\\Program Files\\ImageMagick-6.3.7-Q16\\";
	$config['source_image'] = $source_image;
	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = $w ;
	$config['height'] = $h ;

	$CI->load->library('image_lib', $config); 

	if($CI->image_lib->resize()){
		return true;
	}else{
		return false;
	}
}

/**
 * 获取缩略图名称
 * @param string $filename	文件名
 * @return string	缩略图文件名
 */
function get_thumb_name($filename){
	$idx = strrpos($filename,'.');
	$tail = substr($filename,$idx);
	$name = substr($filename,0,$idx);
	$filename = $name."_thumb".$tail;
	return $filename;
}


/**
 * 获取变量值
 * @param string $field_name 字段名称
 * @param string $value	默认值，当变量没有被赋值时，返回默认值
 * @return mixed|string
 */
function _v($field_name,$value = ''){
    if(v($field_name)){
        return v($field_name);
    }else{
        global $CI;
        $ov = $CI->load->get_var($field_name);
        if(isset($ov)){
            return $ov ;
        } else{
            return $value;
        }
    }
}