<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_log_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //设置钩子
        array_unshift($this->before_update,'before_update');
    }
    function before_update($data){
        $this->clear_validate();
        $this->add_validate('reason','required');
        return $data;
    }

}