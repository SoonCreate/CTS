<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends MY_Model{

    function __construct(){
        parent::__construct();

        $this->add_validate('message_code','required|max_length[20]|alpha_dash');
        $this->add_validate('class_id','required');
        $this->add_validate('content','required|max_length[255]');

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update(){
        $this->clear_validate();
        $this->add_validate('content','required|max_length[255]');
    }

}