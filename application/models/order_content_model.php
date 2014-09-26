<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_content_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

}