<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('status_model');
    }

    function default_status(){
        return $this->status_model->default_status('order_status');
    }

    function is_allow_next_status($current_status,$next_status){
        return $this->status_model->is_allow_next_status('order_status',$current_status,$next_status);
    }

}