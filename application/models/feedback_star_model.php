<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback_star_model extends MY_Model{
    function __construct(){
        parent::__construct();
        $this->add_validate('feedback_type','required');
        $this->add_validate('feedback_desc','required');
        $this->add_validate('stars','required');
        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->clear_validate();
        $this->add_validate('stars','required');
        return $data;
    }
}