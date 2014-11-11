<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//不检查
$config['login_no_check'] = array(
    'user' => array('login','register','get_code','check_code','forget_password'),
    'welcome' => array('index','demo_env')
);