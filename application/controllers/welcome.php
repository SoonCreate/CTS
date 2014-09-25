<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

    function test(){
        $this->load->model('user_model','user');
        $data['username'] = 'yacole1陈';
//        $data['password'] = '111';
        $data['mobile_telephone'] = 'asjdkf';
        $this->user->insert($data);
//        $this->load->library('form_validation');
        echo validation_errors('<div class="error">', '</div>');
        echo form_error('username');
    }

    function username_check($username){
        if ($username == 'test'){
            $this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
            return FALSE;
        }else{
            return TRUE;
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */