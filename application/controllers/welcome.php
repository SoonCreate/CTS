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
		$this->load->view('welcome',$data);
        $this->session->set_flashdata('item', 'value');
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

    function my_functions(){
        $module_id = p('module_id');
        $am = new Auth_model();
        $data['functions'] = $am->can_choose_functions($module_id);
        if(count($data['functions']) > 1){
            $this->load->view('my_functions',$data);
        }elseif(count($data['functions']) == 1){
            redirect(_url($data['functions'][0]['controller'],$data['functions'][0]['action']));
        }else{
            show_404();
        }
    }

    function get_code(){
        $this->code(4,60,20);
    }

    //ajax验证码校对
    function check_code(){
        $code = v('code');
        if($code == _sess('code')){
            echo json_encode(array('ok'=>''));
        }else{
            echo json_encode(array('error'=>_text('message_wrong_code')));
        }
    }

    //验证码
    private
    function code($num,$w,$h) {
        $code = "";
        for ($i = 0; $i < $num; $i++) {
            $code .= rand(0, 9);
        }
        //4位验证码也可以用rand(1000,9999)直接生成
        //将生成的验证码写入session，备验证页面使用
        set_sess('code',$code);
        if(_sess('code') != ""){
            //创建图片，定义颜色值
            Header("Content-type: image/PNG");
            $im = imagecreate($w, $h);
            $black = imagecolorallocate($im, 0, 0, 0);
            $gray = imagecolorallocate($im, 200, 200, 200);
            $bgcolor = imagecolorallocate($im, 255, 255, 255);

            imagefill($im, 0, 0, $gray);

            //画边框
            imagerectangle($im, 0, 0, $w-1, $h-1, $black);

            //随机绘制两条虚线，起干扰作用
            $style = array (
                $black,
                $black,
                $black,
                $black,
                $black,
                $gray,
                $gray,
                $gray,
                $gray,
                $gray
            );
            imagesetstyle($im, $style);
            $y1 = rand(0, $h);
            $y2 = rand(0, $h);
            $y3 = rand(0, $h);
            $y4 = rand(0, $h);
            imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED);
            imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED);

            //在画布上随机生成大量黑点，起干扰作用;
            for ($i = 0; $i < 80; $i++) {
                imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
            }
            //将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
            $strx = rand(3, 8);
            for ($i = 0; $i < $num; $i++) {
                $strpos = rand(1, 6);
                imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black);
                $strx += rand(8, 12);
            }
            imagepng($im);
            imagedestroy($im);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */