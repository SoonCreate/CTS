<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configs extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('config_model');
    }

    function index(){
    }

    function create(){

    }

    function edit(){

    }

    function destroy(){

    }


}