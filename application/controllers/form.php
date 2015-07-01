<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('form_group_model');
        $this->load->model('form_model');
    }

    public function index()
    {
        $fm = new Form_model();
    }

    function form_tree(){

    }

    function create(){

    }

    function edit(){

    }

    function destroy(){

    }

    function form_group(){

    }

    function form_group_create(){

    }

    function form_group_edit(){

    }

    function form_group_destroy(){

    }

    function fields(){

    }

    function field_update(){

    }


}