<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_content_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //服务端插入数据库之前验证
        $this->add_validate('content','required');
    }

}