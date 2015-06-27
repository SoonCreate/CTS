<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//不检查
$config['login_no_check'] = array(
    'user' => array('login','register','get_code','check_code','forget_password','logout','third_part_login'),
    'welcome' => array('index','demo_env','demo','test'),
    'wsh_sync'=> array('goods_sync_job','orders_sync_job','users_sync_job','wsh_test','add_user_to_erp_customer'),
    'po'=>array('test')
);