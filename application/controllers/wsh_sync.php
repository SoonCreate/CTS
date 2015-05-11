<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wsh_sync extends CI_Controller {

	/**
	 * 微信微商户接口同步解决方案
	 */

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    function goods_sync_job(){
        $erp_db = $this->load->database('erp',true,true);

    }

    //微商户
    function wsh_product(){
        $data['app_key'] = '1178';
        $data['time'] = time();
        $data['type'] = 'export';
        $data['mark'] = 'goods';
        $data['format'] = 'json';
        $sign = 'app_key='.$data['app_key'].'&app_secret=0a3f08d7ab7ef7e3ec292e65d90a0254&time='.$data['time'];
        echo $sign;
        $data['sign'] = md5($sign);
        $conf['post'] = $data;
        print_r($data);
        echo cevin_http_open('http://wsh.gaopeng.com/api/synchrodata',$conf);
//        echo cevin_http_open('http://wsh.gaopeng.com/api/synchrodata?'.http_build_query($data));
    }

    function wsh_test(){
        $string = 'app_key=1031&app_secret=5ac5967543a65584aa23d0d3817259b0&time='.time();
        $sign = md5($string);

        $data = array(
            'app_key' => '1031',
            'time' => time(),
            'type' => 'export',
            'mark' => 'orders',
            'format' => 'json',
            'sign' => $sign
        );
        $url = "http://devwsh.szsllt.com/api/synchrodata";
        $conf['post'] = $data;
        echo cevin_http_open($url,$conf);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */