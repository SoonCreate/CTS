<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

}