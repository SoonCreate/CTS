<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * 微信微商户接口同步解决方案，主要负责后台作业运行
 *
 * @package	Sooncreate
 * @category	Controller
 * @author		Sooncreate Studio
 * @link
 */

// ------------------------------------------------------------------------
class Wsh_sync extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    /**
     *微商户 商品信息同步 ，后台作业
     */
    function goods_sync_job(){
        //获取远程数据
        $goods =  $this->_remote_data('goods');
        if($goods){
            $erp = $this->load->database('erp',true,true);
            $erp->truncate('wsh_goods');
            echo job_log_string('wsh_goods表数据清理完成');
            //统计成功/失败条目
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
                $d['creation_date'] = now();
                //urt8 转 gbk
                $d = utf8togbk($d);
                if($erp->insert('wsh_goods',$d)){
                    $scnt = $scnt + 1;
                }else{
                    $fcnt = $fcnt + 1;
                }
            }
            echo job_log_string('成功插入数据['.$scnt.']，失败['.$fcnt.']条。');
        }
    }

    function wsh_test(){
        $orders = $this->_remote_data('orders');
        print_r($orders[0]);
    }

    /**
     * 按照类型获取微商户远程接口
     * @param $type string
     * @return bool|mixed
     */
    private function _remote_data($type){
        $data['mark'] = $type;
        $data['app_key'] = '1178';
        $data['time'] = time();
        $data['type'] = 'export';
        $data['format'] = 'json';
        $sign = 'app_key='.$data['app_key'].'&app_secret=0a3f08d7ab7ef7e3ec292e65d90a0254&time='.$data['time'];
//        echo $sign;
        $data['sign'] = md5($sign);
        $conf['post'] = $data;
//        print_r($data);
        $return = cevin_http_open('http://wsh.gaopeng.com/api/synchrodata',$conf);
        $result = json_decode($return,true) ;
        //错误返回记录
        if(isset($result['errCode'])){
            switch($result['errCode']){
                case '40001':
                    custz_message('E','40001：参数缺失') ;
                    break;
                case '40002':
                    custz_message('E','40002：无效app_key') ;
                    break;
                case '40003':
                    custz_message('E','40003：无效签名') ;
                    break;
                case '40004':
                    custz_message('E','40004：无效format') ;
                    break;
            }
            return false;
        }else{
            return $result;
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */