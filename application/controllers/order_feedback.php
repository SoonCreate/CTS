<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_feedback extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_model');
    }

    function index(){
        render();
    }

    function show(){

    }

}