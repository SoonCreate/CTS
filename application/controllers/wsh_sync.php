<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wsh_sync extends CI_Controller {

	/**
	 * 微信微商户接口同步解决方案
	 */

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    //微商户 商品信息同步
    function goods_sync_job(){
        $data['app_key'] = '1178';
        $data['time'] = time();
        $data['type'] = 'export';
        $data['mark'] = 'goods';
        $data['format'] = 'json';
        $sign = 'app_key='.$data['app_key'].'&app_secret=0a3f08d7ab7ef7e3ec292e65d90a0254&time='.$data['time'];
//        echo $sign;
        $data['sign'] = md5($sign);
        $conf['post'] = $data;
//        print_r($data);
        $return = cevin_http_open('http://wsh.gaopeng.com/api/synchrodata',$conf);
        $goods =  json_decode($return,true) ;

//        print_r($goods);
//        echo cevin_http_open('http://wsh.gaopeng.com/api/synchrodata?'.http_build_query($data));

        $erp = $this->load->database('erp',true,true);
        $erp->truncate('wsh_goods');
        custz_message('I',now().': wsh_goods表数据清理完成');
        $fcnt = 0;
        $scnt = 0;
        foreach($goods as $o){
//            print_r($o->Products);
//            $d = $o['Products'];
            $p = $o['Products'];
            $d['id'] = intval($p['id']);
            $d['retail_price'] = floatval($p['retail_price']);
            $d['detail_pic'] =  $p['detail_pic'];
            $d['description'] = $p['description'];
            $d['detail'] = $p['detail'];
            $d['status'] = $p['status'];
            $d['prod_name'] = $p['prod_name'];
            $d['hot'] = $p['hot'];
            $d['sales'] = $p['sales'];
            $d['is_recommend'] = $p['is_recommend'];
            $d['class_id'] = $p['class_id'];
            $d['keyword'] = $p['keyword'];
            $d['fee'] = $p['fee'];
            $d['quota'] = $p['quota'];
            $d['fx_class_id'] = $p['fx_class_id'];
            $d['discount_id'] = $p['discount_id'];
            $d['kind_id_1'] = $p['kind_id_1'];
            $d['kind_id_2'] = $p['kind_id_2'];
            $d['reserves'] = $p['reserves'];
            $d['issale'] = $p['issale'];
            $d['pre_sale'] = $p['pre_sale'];
            $d['sku'] =  NULL;
            $d['sort'] = $p['order'];
            //urt8 转 gbk
            $d = utf8togbk($d);
            if($erp->insert('wsh_goods',$d)){
                $scnt = $scnt + 1;
            }else{
                $fcnt = $fcnt + 1;
            }
        }
        custz_message('I',now().': 成功插入数据['.$scnt.']，失败['.$fcnt.']条。');
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