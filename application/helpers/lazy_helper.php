<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

define('ROOT', dirname(FCPATH).'/');
@date_default_timezone_set('Asia/Shanghai'); 

// lazy core common function
$CI =&get_instance();

// 迅捷函数
// =======================
// 单字母懒人函数

function v( $name )
{
	global $CI;
	return $CI->input->get_post( $name );
}

// for the textarea contaings rich text
function x( $name )
{
	$name = strip_tags( $name , '<a><img><u><b><strong><i><br/><br><p>' );
	global $CI;
	return $CI->security->xss_clean( $name );	
}

// no tag = clear all tag
// and change \r\n into br/
// for the textarea only contains text
function n( $name )
{
	$name = strip_tags( $name );
	$name = str_replace( "\n" , "<br/>" , $name );
	return $name; 
}

function r( $name )
{
	$name = strip_tags( $name , '<a><img><li><ol><ul><em><strong>' );
	$name = str_replace( "\n" , "<br/>" , $name );
	return $name; 
}
// only allow a string; max length is 255 ; clear all \r\n
// for the noraml line text
function z( $name )
{
	$name = strip_tags( $name );
	$name = str_replace( "\n" , " " , $name );
	return $name; 
}

function t( $name )
{
	$name = strip_tags( $name );
	return $name;
}

//数据库转意
function s( $name )
{
	global $CI;
	return $CI->db->escape( $name );
}

function u( $name )
{
	return urlencode( $name );
}

function c( $name )
{
	global $CI;
	return $CI->config->item( $name );
}

function b( $name )
{
	return '<a href="javascript:history.back(1)">' . $name . '</a>';
}


//

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

function lazy_get_line( $sql = NULL )
{
	$data = lazy_get_data( $sql );
	if( isset($data[0]) )
	{
		return $data[0];
	}
}

function lazy_get_var( $sql = NULL )
{
	$data = lazy_get_line( $sql );
	return $data[ @reset(@array_keys( $data )) ];
}
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
function lazy_run_sql( $sql )
{
	global $CI;
	if( !$CI->db ) $CI->load->database();
	
	return $CI->db->simple_query( $sql );
}

function lazy_last_id()
{
	global $CI;
	if( !$CI->db ) $CI->load->database();
	return $CI->db->insert_id();
}





// 控制器相关迅捷函数
// =================================

function method()
{
	global $CI;
	if( $CI->uri->segment(2) )
		return $CI->uri->segment(2);
	else
		return 'index';
}

function module()
{
	global $CI;
	if( $CI->uri->segment(1) )
		return $CI->uri->segment(1);
	else
		return 'index';
}

// 模板相关迅捷函数
// =================================


function layout( $data = '' , $layout = 'default' , $base = 'index' )
{
	echo  get_layout( $data , $layout , $base );
}
function get_layout( $data = '' , $layout = 'default' , $base = 'index' )
{
	global $CI;

	if( !isset( $data['ci_module'] ) )
		$data['ci_module'] = module();
	
	if( !isset( $data['ci_method'] ) )
		$data['ci_method'] = method();
	$data['ci_layout'] = $layout;

	return $CI->load->view( 'layout/' . $layout .'/' . basename( $base ) . '.tpl.html' , $data ,true );

}


function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
function get_style()
{
	global $CI;
	$CI->load->library('session');
	$style = $CI->session->userdata('u2_style');
	if(!$style)
	{
		$style = 'default';
	}
	return $style;
}

function format_uid($uid = NULL)
{
	if($uid == NULL)
	{
		global $CI;
		$CI->load->library('session');
		$uid = $CI->session->userdata('id');
	}
	else
	{
		$uid = intval($uid);
	}
	return $uid;
}

function myhash( $id = NULL )
{
	$id = format_uid($id);

	$f1 = $id % 10000 ; 
	$f2 = (int)($id / 10000) ;
	
	$f3 = $f1 % 100;
	$f4 = (int)($f1 / 100);

	return $f2 . '/' . $f4 . '/' . $f3 . '/';
}

function myhashstr( $str )
{
	return $str{0} . $str{1} . '/' . $str{2} . $str{3} . '/' ;
}

//内容截断
function word_substr($srt,$finish)
{
	if(mb_strlen($srt , 'utf-8') < $finish)
	{
		return $srt;
	}
	return mb_substr($srt,0,$finish,'utf-8').'...';
}


function get_data_by_array( $table , $array , $fkey , $id_field = 'id' , $where = '' )
{
	$ids = array();
	foreach( $array as $item )
	{
		$ids[] = $item[$id_field];
	}
	
	if( count( $ids ) > 0 )
	{
		$sql = "SELECT * FROM `" . $table .   "` WHERE `" . $fkey . "` IN ( " . join( ' , ' , $ids ) . " ) $where";
		$data = lazy_get_data( $sql );
		
		if( is_array( $data ) )
		{
			$ret = array();
			foreach( $data as $item )
			{
				$ret[$item[$fkey]] = $item;
			}
			
			return $ret;
		}
		else
		{
			return false;
		}
		
	}	
	
	
}

/**
function check_admin()
{
	if( !is_admin() )
	{
		info_page( _text('system_limit_rights'), '/user/login', _text('system_admin_login') );
	}
}
**/
function newpassword()
{
	$password = array_merge( range( 'a' , 'z' ) , range( '0' , '9' ));
	$password = array_rand( $password , 20 );
	return $password = md5( rand( 1 , 10000 ). join( '' ,  $password ).format_uid() );
}

function get_count( $save = true )
{
	if($save)
	{
		save_count();
	}
	if( isset($GLOBALS['__sql_count']) )
	{
		return $GLOBALS['__sql_count'];
	}
	return 0;
}
function save_count()
{
	$sql = "select found_rows()";
	$GLOBALS['__sql_count'] = lazy_get_var( $sql );
}

function get_pager(  $page , $page_all , $url_base ,$request_url = NULL )
{
	$middle = NULL;
	if( $page_all < 1 ) return false;
		

	if( $page != 1 ) $first = '&nbsp;<a href="' . $url_base . '/1/' . $request_url . '" title="首页"><img src="/static/images/arrow_fat_left.gif"></a>&nbsp;';
	else $first = '&nbsp;<a title="首页"><img src="/static/images/arrow_fat_left.gif"></a>&nbsp;';

	if( $page != $page_all ) $last = '<a href="' . $url_base . '/'.$page_all .'/' .  $request_url . '" title="末页"><img src="/static/images/arrow_fat_right.gif"></a>&nbsp;';
	else $last = '&nbsp;<a title="末页"><img src="/static/images/arrow_fat_right.gif"></a>&nbsp;';

	if( $page > 1 ) $pre = '&nbsp;<a href="' . $url_base . '/' . ($page-1) . '/' .$request_url . '" title="上一页"><img src="/static/images/arrow_dash_left.gif"></a>&nbsp;';
	else $pre = '&nbsp;<a title="上一页"><img src="/static/images/arrow_dash_left.gif"></a>&nbsp;';

	if( $page < $page_all ) $next = '<a href="' . $url_base . '/' . ($page+1) . '/'.$request_url . '"  title="下一页"><img src="/static/images/arrow_dash_right.gif"></a>&nbsp;';
	else $next = '&nbsp;<a title="下一页"><img src="/static/images/arrow_dash_right.gif"></a>&nbsp;';

	$show = 3; // 前后各显示?页
	$long = $show * 2 + 1;
	$begin = $page - $show;
	if( $begin < 1 ) $begin = 1;

	//echo "first begin $begin ";

	$end = $page + $show;

	if( ($t = $end - $begin) < $long )
	{
		$end = $begin+$long-1;
	}

	//echo " first end $end ";

	if( $end > $page_all )
	{
		//echo " end > $page_all ";
		
		// if( ($t = $end - $begin) < $long ) $begin = $begin - $t;
		$moved = $end - $page_all;

		$begin = $begin - $moved;
		
		$end = $page_all;
		
		//echo " the modified end $end , beging $begin";
		
		if( $begin < 1 ) $begin = 1;
	}

	//echo " $begin - $end ";



	for( $i = $begin ; $i <= $end ; $i++ )
	{
		if( $i == $page  )
			$middle .= '<a class="current">&nbsp;' . $i . '&nbsp;</a>';
		else
			$middle .= '<a href="' . $url_base . '/' . $i .'/' .$request_url . '">&nbsp;' . $i . '&nbsp;</a>';
	}

	if( $page_all > $long )
		$middle .= '<a>&nbsp;...&nbsp;</a>';

	return '<div class="pager" >' . $first .  $pre .  $middle . $next . $last . '</div>';

}
function get_ajax_pager(  $page , $page_all , $url_base = NULL ,$extra = NULL , $jsfunc = 'show_ajax_pager' ,$request_url = NULL )
{
	
	$middle = NULL;
	if( $page_all < 1 ) return false;
		

	if( $page != 1 ) $first = '&nbsp;<a href="JavaScript:void(0)" onclick=\''.$jsfunc.'("' . $url_base . '/1/' . $request_url . ' " ," '.$extra.'" )\' title="首页"><img src="/static/images/arrow_fat_left.gif"></a>&nbsp;';
	else $first = '&nbsp;<a title="首页"><img src="/static/images/arrow_fat_left.gif"></a>&nbsp;';

	if( $page != $page_all ) $last = '<a href="JavaScript:void(0)" onclick=\''.$jsfunc.'("' . $url_base . '/'.$page_all .'/' .  $request_url .'","'.$extra.'" )\' title="末页"><img src="/static/images/arrow_fat_right.gif"></a>&nbsp;';
	else $last = '&nbsp;<a title="末页"><img src="/static/images/arrow_fat_right.gif"></a>&nbsp;';

	if( $page > 1 ) $pre = '&nbsp;<a href="JavaScript:void(0)" onclick=\''.$jsfunc.'("' . $url_base . '/' . ($page-1) . '/' .$request_url . '","'.$extra.'" )\' title="上一页"><img src="/static/images/arrow_dash_left.gif"></a>&nbsp;';
	else $pre = '&nbsp;<a title="上一页"><img src="/static/images/arrow_dash_left.gif"></a>&nbsp;';

	if( $page < $page_all ) $next = '<a href="JavaScript:void(0)" onclick=\''.$jsfunc.'("' . $url_base . '/' . ($page+1) . '/'.$request_url .'","'.$extra.'" )\'  title="下一页"><img src="/static/images/arrow_dash_right.gif"></a>&nbsp;';
	else $next = '&nbsp;<a title="下一页"><img src="/static/images/arrow_dash_right.gif"></a>&nbsp;';
	$show = 4; // 前后各显示?页
	$long = $show * 2 + 1;
	$begin = $page - $show;
	if( $begin < 1 ) $begin = 1;

	//echo "first begin $begin ";

	$end = $page + $show;

	if( ($t = $end - $begin) < $long )
	{
		$end = $begin+$long-1;
	}

	//echo " first end $end ";

	if( $end > $page_all )
	{
		//echo " end > $page_all ";
		
		// if( ($t = $end - $begin) < $long ) $begin = $begin - $t;
		$moved = $end - $page_all;

		$begin = $begin - $moved;
		
		$end = $page_all;
		
		//echo " the modified end $end , beging $begin";
		
		if( $begin < 1 ) $begin = 1;
	}

	//echo " $begin - $end ";



	for( $i = $begin ; $i <= $end ; $i++ )
	{
		if( $i == $page  )
			$middle .= '<a class="current">&nbsp;' . $i . '&nbsp;</a>';
		else
			$middle .= '<a href="JavaScript:void(0)" onclick=\''.$jsfunc.'("' . $url_base . '/' . $i .'/' .$request_url .'","'.$extra.'")\' >&nbsp;' . $i . '&nbsp;</a>';
	}

	if( $page_all > $long )
		$middle .= '<a>&nbsp;...&nbsp;</a>';

	return '<div class="pager" >' . $first .  $pre .  $middle . $next . $last . '</div>';

}

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

function elog( $error )
{
	file_put_contents( 'elog.txt' , $error ."\r\n" , FILE_APPEND );
}
function img1( $str )
{
	return trim( reset( explode( "\n" , $str ) ) );
}
function img2( $str )
{
	$m = explode( "\n" , $str );
	array_shift($m);
	return $m;
}
function jsnl2br( $str )
{
	$str = str_replace( "\r" , "" , $str );
	$str = str_replace( "\n" , "' + \"\\r\\n\" +'" , $str );
	return $str;
}
function add_slashes_on_quote( $str )
{
	return str_replace( "'" , "\\'" , $str );
}

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

//重新设置大小到当前目录，文件名为xxx_thumb.xx
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

function get_thumb_name($filename){
	$idx = strrpos($filename,'.');
	$tail = substr($filename,$idx);
	$name = substr($filename,0,$idx);
	$filename = $name."_thumb".$tail;
	return $filename;
}

//form表单字段输出
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