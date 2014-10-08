<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuelist extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    public function index()
    {
        $this->load->model('valuelist_model');
        $vm = new Valuelist_model();
        $data['objects'] = _format_row($vm->find_all());
        render($data);
    }


}