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
        $this->load->model('user_model');
        $um = new User_model();
        $data['users'] = $um->find_all_by(array('inactive_flag'=>0));
        $this->load->view('demo',$data);
	}

    function demo_env(){
        unset_sess('uid');
        set_sess('uid',string_to_number(v('id')));
        redirect('welcome/app_index');
    }

    function app_index(){
        $am = new Auth_model();
        $modules = $am->can_choose_modules();
        if(empty($modules)){
            show_404();
        }else{
            //初始打开的URL运算
            for($i = 0;$i < count($modules);$i++){
                $fns = $am->can_choose_functions($modules[$i]['module_id']);
                $url = "";
                if(count($fns) > 1){
                    $url = _url('welcome','my_functions',array('module_id'=>$modules[$i]['module_id']));
                }elseif(count($fns) == 1){
                    $url = _url($fns[0]['controller'],$fns[0]['action'],array('cm'=>$fns[0]['id']));
                }else{
                    $url = _url('welcome','show_404');
                }
                $modules[$i]['url'] = $url;
            }
            $this->load->model('notice_model');
            $nm = new Notice_model();
            $data['notice_need_to_read'] = $nm->count_by(array('received_by'=>_sess('uid'),'read_flag'=>0));
            $data['modules'] = $modules;

            $this->load->model('user_model');
            $um = new User_model();
            $user = $um->find(_sess('uid'));
//            $data['initial_pass_flag'] = $user['initial_pass_flag'];
            //demo用，不验证密码初始化
            $data['initial_pass_flag'] = 0;
            $this->load->view('welcome',$data);
        }

    }

    function on_module(){
        set_sess('mid',v('mid'));
        echo 1;
    }

    function notice_need_to_read(){
        $this->load->model('notice_model');
        $nm = new Notice_model();
        echo $nm->count_by(array('received_by'=>_sess('uid'),'read_flag'=>0));
    }

    function show_404(){
        show_404();
    }

    function welcome_message(){
        $this->load->view('welcome_message');
    }

    function username_check($username){
        if ($username == 'test'){
            $this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    //当有多个功能时
    function my_functions(){
        $module_id = v('module_id');
        if($module_id){
            set_sess('mid',$module_id);
        }
        $am = new Auth_model();
        $data['functions'] = $am->can_choose_functions(_sess('mid'));
        render_view('my_functions',$data);
    }

    //用户功能页跳转，并记录唯一性ID
    function go(){
        $this->load->model('module_line_model');
        $mlm = new Module_line_model();
        $ml = $mlm->find_by_view(array('id'=>v('cm')));
        if(!empty($ml)){
            $params = $this->input->get_post();
            unset($params['cm']);
            //当前的功能模块id，即module_line_id
            set_sess('cm',$ml['id']);
            set_sess('mid',$ml['module_id']);
            set_sess('fid',$ml['function_id']);
            redirect(_url($ml['controller'],$ml['action'],$params));
        }else{
            show_404();
        }
    }

    function file_download(){
        $data = file_get_contents(v('path')); // 读文件内容
        force_download(v('name'), $data);
    }

    //字段列表
    function field_list(){
        echo json_encode(field_list(v('table')));
    }

    function options(){
        $pv = null;
        if(v('pv')){
            $pv = v('pv');
        }
        $all = false;
        if(v('all')){
            $all = string_to_boolean(v('all'));
        }
        $data['items'] = get_options(v('n'),$pv,$all);
        $data["identifier"] = 'value';
        $data["label"] = 'label';
        echo json_encode($data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */