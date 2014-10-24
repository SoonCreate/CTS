<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('status_model');
        $this->load->model('status_line_model');
    }

    public function index()
    {
        $sm = new Status_model();
        render($sm->find_all());
    }

    function create(){

    }

    function edit(){

    }

    function destroy(){

    }

    function items(){

    }


}