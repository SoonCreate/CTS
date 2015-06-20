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
        //header('Content-Type: text/html; charset=utf-8');
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
                    echo job_log_string('物料：['. $d['prod_name'].'] 插入失败！');
                    $fcnt = $fcnt + 1;
                }
            }
            echo job_log_string('成功插入数据['.$scnt.']，失败['.$fcnt.']条');
        }
    }

    function orders_sync_job(){
        //获取远程数据
        $orders =  $this->_remote_data('orders');
        if($orders){
            $erp = $this->load->database('erp',true,true);
            //统计成功/失败条目
            $fcnt = 0;
            $scnt = 0;
            $ufcnt = 0;
            $uscnt = 0;
            foreach($orders as $o){
//            print_r($o->Products);
//            $d = $o['Products'];
                $order = $o['Orders'];
                $d['id'] = intval($order['id']);
                //判断是否ERP数据库表中已存在数据
                $od = $erp->query('select * from wsh_orders where id = '.$order['id'])->result_array();

                $d['uid'] = intval($order['uid']);
                $d['orderid'] = $order['orderid'];
                $d['ip'] = $order['ip'];
                $d['name'] = $order['name'];
                $d['mobile'] = $order['mobile'];
                $d['phone'] = $order['phone'];
                $d['zip'] = $order['zip'];
                $d['province'] = $order['province'];
                $d['city'] = $order['city'];
                $d['area'] = $order['area'];
                $d['address'] = $order['address'];
                $d['delivery_time'] = $order['delivery_time'];
                $d['logi_company'] = $order['logi_company'];
                $d['logi_no'] = $order['logi_no'];
                $d['seller_mark'] = $order['seller_mark'];
                $d['paytype'] = $order['paytype'];
                $d['alipay_trade_no'] = $order['alipay_trade_no'];
                $d['tenpay_trade_no'] = $order['tenpay_trade_no'];
                $d['wxpay_trade_no'] = $order['wxpay_trade_no'];
                $d['coupon_name'] = $order['coupon_name'];
                $d['customer_mark'] = $order['customer_mark'];
                $d['order_status'] = $order['order_status'];
                $d['createtime'] = $order['createtime'];
                $d['appeal_status'] = intval($order['appeal_status']);
                $d['seller_id'] = intval($order['seller_id']);
                $d['r_points'] = intval($order['r_points']);
                $d['totalprice'] = floatval($order['totalprice']);
                $d['seller_cut'] = floatval($order['seller_cut']);
                $d['delivery_fee'] = floatval($order['delivery_fee']);
                $d['discount'] = floatval($order['discount']);
                $d['point_discount'] = floatval($order['point_discount']);
                $d['should_pay'] = floatval($order['should_pay']);
                $d['is_income'] = intval($order['is_income']);
                $d['is_translate'] = 0;

                //urt8 转 gbk
                $d = utf8togbk($d);
                if(empty($od)){
                    $d['creation_date'] = now();
                    $lines = $order['OrdersProducts'];

                    $erp->trans_start();
                    //插入订单抬头
                    $erp->insert('wsh_orders',$d);
                    //插入订单明细行
                    if(is_array($lines)){
                        foreach($lines as $line){
                            $line = utf8togbk($line);
                            $ld['order_id'] = $order['id'];
                            $ld['mid'] = $line['product_id'];
                            $ld['product_name'] = $line['product_name'];
                            $ld['product_code'] = $line['product_code'];
                            $ld['quantity'] = intval($line['quantity']);
                            $ld['price'] = floatval($line['price']);
                            $ld['creation_date'] = now();
//                            $line = utf8togbk($line);
                            $erp->insert('wsh_order_lines',$ld);
                        }
                    }
                    $erp->trans_complete();
                    if($erp->trans_status() === TRUE){
                        $scnt = $scnt + 1;
                    }else{
                        echo job_log_string( '订单：['.$d['orderid'].'] 插入失败！');
                        $fcnt = $fcnt + 1;
                    }
                }else{
                    $row = gbktoutf8($od[0]);
                    $order_status = $row['order_status'];
                    //判断更新范围
                    if($order_status != '完成' && $order_status != '取消'){
                        $d['last_update_date'] = now();
                        if($erp->update('wsh_orders',$d,array('id'=>$d['id']))){
                            $uscnt = $uscnt + 1;
                        }else{
                            echo job_log_string( '订单：['.$d['orderid'].'] 插入失败！');
                            $ufcnt = $ufcnt + 1;
                        }
                    }
                }

            }
            echo job_log_string('成功插入数据['.$scnt.']，失败['.$fcnt.']条;成功更新数据['.$uscnt.']，失败['.$ufcnt.']条');
        }
    }

    function  users_sync_job(){
        //获取远程数据
        $users =  $this->_remote_data('users');
        if($users){
            $erp = $this->load->database('erp',true,true);
            $erp->truncate('wsh_users');
            $erp->truncate('wsh_user_address');
            echo job_log_string('wsh_users,wsh_user_address表数据清理完成');
            //统计成功/失败条目
            $fcnt = 0;
            $scnt = 0;
            foreach($users as $o){
                $user = $o['WxUserInfo'];
                $d['id'] = $user['id'];
                $d['nickname'] = $user['nickname'];
                $d['mobile'] = $user['mobile'];
                $d['sex'] = $user['sex'];
                $d['country'] = $user['country'];
                $d['province'] = $user['province'];
                $d['city'] = $user['city'];
                $d['headimgurl'] = $user['headimgurl'];
                $d['shop_id'] = $user['shop_id'];
                $d['staff_id'] = $user['staff_id'];
                $d['login_count'] = $user['login_count'];
                $d['lastloginip'] = $user['lastloginip'];
                $d['lastlogintime'] = $user['lastlogintime'];
                $d['registime'] = $user['registime'];
                $d['sign_days'] = $user['sign_days'];
                $d['sign_time'] = $user['sign_time'];
                $d['points'] = $user['points'];
                $d['creation_date'] = now();

                $d = utf8togbk($d);

                $lines = $user['user_address'];
                $erp->trans_start();
                $erp->insert('wsh_users',$d);

                if(is_array($lines)){
                    foreach($lines as $line){
                        $line['uid'] = $d['id'];
                        $line['creation_date'] = now();
                        $line = utf8togbk($line);
                        $erp->insert('wsh_user_address',$line);
                    }
                }

                $erp->trans_complete();
                if($erp->trans_status() === TRUE){
                    $scnt = $scnt + 1;
                }else{
                    echo job_log_string( '客户：['.$d['nickname'].'] 插入失败！');
                    $fcnt = $fcnt + 1;
                }
            }
            echo job_log_string('成功插入数据['.$scnt.']，失败['.$fcnt.']条');
        }
    }

    /**
     *  微商户客户同步到ERP客户
     */
    function add_user_to_erp_customer(){
        //确定导入范围为已有订单的客户
        $erp = $this->load->database('erp',true,true);
//        $sql = 'select * from wsh_users as c where
//              exists(select 1 from wsh_orders as o where c.id = o.uid)
//            and not exists(select 1 from customer as e where e.wsh_uid = c.id);';
        //修复已下达订单的客户不在wsh_users表中，直接从order表拿客户数据 20150620
        //获取uid集合
        $sql = "select distinct uid from wsh_orders as o where not exists(select 1 from customer as c where c.wsh_uid = o.uid)
              and o.order_status not in ('待付款','取消')
              and  o.province <> '到店自取'
              and  o.name <> '' ";
        $cs = $erp->query(_toGBK($sql))->result_array();

        //统计成功/失败条目
        $fcnt = 0;
        $scnt = 0;

        if(!empty($cs)){
            foreach($cs as $row){
                //获取客户信息
                $sql = "select top 1 * from wsh_users where id = ".$row['uid'];
                $users = $erp->query($sql)->result_array();
                if(empty($users)){
                    //获取单条订单数据
                    $sql = "select top 1 * from wsh_orders where uid = ".$row['uid'];
                    $rs = $erp->query($sql)->result_array();
                    $c = $rs[0];
                    $data['cust_type'] = _toGBK('微信');
                    $data['cust_id'] = $this->_customer_id();
                    $data['wsh_uid'] = $c['uid'];
                    $data['cust_name'] = $c['name'];
                    $data['tel'] = $c['mobile'];
                    $data['contact'] = $data['cust_name'];
                    $data['area'] = $c['area'];
                    $data['address'] = $c['province'].$c['city'].$c['area'].$c['address'];
                }else{
                    $c = $users[0];
                    $data['cust_type'] = _toGBK('微信');
                    $data['cust_id'] = $this->_customer_id();
                    $data['wsh_uid'] = $c['id'];
                    $data['cust_name'] = $c['nickname'];
                    $address = $this->_user_address($c['id']);
                    if($address){
                        $data['tel'] = $address['mobile'];
                        if(is_null($data['cust_name'] ) || $data['cust_name'] == ''){
                            $data['cust_name']  = $address['name'] ;
                        }
                        $data['contact'] = $address['name'] ;
                        $data['area'] = $address['area'];
                        $data['address'] = $address['province'].$address['city'].$address['area'].$address['address'];
                    }else{
                        //客户名称为必输
                        if(is_null($data['cust_name'] ) || $data['cust_name'] == ''){
                            $data['cust_name']  = '未知' ;
                        }
                        $data['tel'] = $c['mobile'];
                        $data['contact'] = $c['nickname'];
                        $data['area'] = $c['city'];
                        $data['address'] = NULL;
                    }
                }

                if($erp->insert('customer',$data)) {
                    $scnt = $scnt + 1;
                }else{
                    echo job_log_string('客户：['. $data['cust_name'].'] 插入失败！');
                    $fcnt = $fcnt + 1;
                }

            }
        }
        echo job_log_string('成功插入数据['.$scnt.']，失败['.$fcnt.']条');
    }

    function wsh_test(){
        $orders = $this->_remote_data('users');
        print_r($orders);
    }

    /**
     * 按照类型获取微商户远程接口
     * @param $type string
     * @return bool|mixed
     */
    private function _remote_data($type){
        $data['mark'] = $type;
        $data['app_key'] = '19023'; //19023
        $data['time'] = time();
        $data['type'] = 'export';
        $data['format'] = 'json';
        $sign = 'app_key='.$data['app_key'].'&app_secret=e2b5171eb23ece4287495f49a2f535e5&time='.$data['time'];//e2b5171eb23ece4287495f49a2f535e5
//        echo $sign;
        $data['sign'] = md5($sign);
        $conf['post'] = $data;
//        print_r($data);
        echo job_log_string('开始远程获取接口数据...');

        $return = cevin_http_open('http://wsh.gaopeng.com/api/synchrodata',$conf);

        echo job_log_string('断开远程连接...');

//        print_r($return);

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
            echo job_log_string('本次接口获取数据 '.count($result).' 条');
            return $result;
        }
    }

    //新建客户记录获取用户id
    function _customer_id(){
        $erp = $this->load->database('erp',true,true);
        //cust_id计算逻辑：获取最大字符串，然后自增一并补前导零
        $last_row = $erp->query('select max(cust_id) as id from customer')->result_array();
        if(empty($last_row)){
            $id = 1;
        }else{
            $id = intval($last_row[0]['id']) + 1;
        }
        $customer_id = sprintf('%06d',$id);
        return $customer_id;
    }

    //获取微商户客户地址
    function _user_address($uid){
        $erp = $this->load->database('erp',true,true);
        $row = $erp->query('select * from wsh_user_address where uid = '.$uid)->result_array();
        if(empty($row)){
            return false;
        }else{
            return $row[0];
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */