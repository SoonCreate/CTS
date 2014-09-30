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
        $this->load->model('auth_model');
    }

	public function index()
	{
        set_sess('uid',44);
        $am = new Auth_model();
        $data['modules'] = $am->can_choose_modules();
		$this->load->view('welcome_message',$data);
	}

    function username_check($username){
        if ($username == 'test'){
            $this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function my_functions(){
        $module_id = p('module_id');
        $am = new Auth_model();
        $data['functions'] = $am->can_choose_functions($module_id);
        if(!empty($data['functions'])){
            $this->load->view('my_functions',$data);
        }else{
            show_404();
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */