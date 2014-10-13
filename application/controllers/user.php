<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('user_model');
    }

	public function index(){
        $o = new User_model();
        $o->order_by('inactive_flag');
        $o->order_by('username');
        $data['users'] = _format($o->find_all());
        render($data);
	}

    function login(){
        if($_POST){
            $username = tpost('username');
            $password = sha1(v('password'));
            $code= tpost('code');
            //echo $username."&code:".$code."&code:"._sess('code');
            $um = new User_model();
            $user = $um->find_by(array('username'=>$username,'password'=>$password,'inactive_flag'=>0));
            if($code != _sess('code')){
                echo '1';
            }else{
                if(empty($user)){
                    echo '2';
                    //redirect(_url('welcome','index'));
                    //render();
                }else{
                    //set_sess('uid',$user['id']);
                    //if($user['initial_pass_flag']){
                     //   redirect(_url('user','change_password'));
                   // }else{
                        redirect(_url('welcome','index'));

                }
            }

        }else{
            $this->load->view('user/login');
        }
    }
/*by GS*/
    function validate_username(){
        $username = $_GET['username'];
        $user = new User_model();
        if($user->is_username_exists($username)){
            echo '1';
        }else{
            echo '0';
        }
    }



    function logout(){
        clear_all_sess();
        redirect(_url('user','login'));
    }

    function register(){
        if(string_to_boolean(_config('allow_register'))){
            if($_POST){
                $data['username'] = tpost('username');
                $data['password']  = sha1(v('password'));
                $data['order_type'] = v('order_type');
                $data['full_name'] = v('full_name');
                $data['initial_pass_flag'] = 0;
                $user = new User_model();
                if($user->register_save($data)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render();
            }
        }else{
            show_404();
        }
    }

    function create(){
        if($_POST){
            $data['username'] = tpost('username');
            //初始化密码
            $data['password'] = sha1(_config('initial_password'));
            $data['initial_pass_flag'] = 1;
            $data['contact'] = tpost('contact');
            $data['email'] = tpost('email');
            $data['phone_number'] = tpost('phone_number');
            $data['mobile_telephone'] = tpost('mobile_telephone');
            $data['address'] = tpost('address');
            $data['full_name'] = tpost('full_name');
            $data['sex'] = tpost('sex');
            $user = new User_model();
            if($user->insert($data)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            render();
        }
    }

    //用户更新
    function user_edit(){
        $o = new User_model();
        if($_POST){
            $_POST['id'] = _sess('uid');
            if($o->update(_sess('uid'),$_POST)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            $data = $o->find(_sess('uid'));
            $data['to'] = 'user_edit';
            $this->load->view('user/edit',$data);
        }
    }

    //管理员更新
    function admin_edit(){
        $o = new User_model();
        if($_POST){
            if($o->update(v('id'),$_POST)){
                echo 'done';
            }else{
                echo validation_errors('<div class="error">', '</div>');
            }
        }else{
            $data = $o->find(p('user_id'));
            $data['to'] = 'admin_edit';
            $this->load->view('user/edit',$data);
        }
    }

    function change_password(){
        if($_POST){
            $data['password'] = sha1(v('new_password'));
            $data['initial_pass_flag'] = 0;
            $old_password = sha1(v('old_password'));
            $o = new User_model();
            $user = $o->find_by(array('id'=>_sess('uid'),'password'=>$old_password));
            //验证旧密码是否有效
            if(!empty($user)){
                $this->_update(_sess('uid'),$data);
            }else{
                echo '旧密码输入有误';
            }

        }else{
            render();
        }
    }

    function change_status(){
        $user_id = p('user_id');
        $data['inactive_flag']= p('inactive_flag');
        $this->_update($user_id,$data);
    }

    function initial_password(){
        $data['password'] = sha1(_config('initial_password'));
        $data['initial_pass_flag'] = 1;
        $user_id = p('user_id');
        $this->_update($user_id,$data);
    }

    //选择角色
    function choose_roles(){
        $this->load->model('user_role_model');
        $ur = new User_role_model();
        $um = new User_model();
        $user = $um->find(v('user_id'));
        if(empty($user)){
            show_404();
        }else{
            if($_POST){
                $ids = v('roles');
                $data['user_id'] = $user['id'];
                $this->db->trans_start();
                if($ids === FALSE){
                    //删除所有
                    $ur->delete_by(array('user_id' => $data['user_id']));
                }else{
                    //先删除已取消勾选的
                    $this->db->where_not_in('role_id',$ids);
                    $ur->delete_by(array('user_id' => $data['user_id']));
                    //新增的部分
                    $ids = array_diff($ids,$ur->find_user_ids($data['user_id']));
                    foreach($ids as $id){
                        $data['role_id'] = $id;
                        $ur->insert($data);
                    }
                }
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    echo '数据库插入错误';
                }else{
                    echo 'done';
                }
            }else{
                $user_id = $user['id'];
                $this->load->model('role_model');
                $r = new Role_model();
                $roles = $r->find_all();
                for($i=0;$i<count($roles) ;$i++){
                    $user_role = $ur->find_by(array('user_id'=>$user_id,'role_id'=>$roles[$i]['id']));
                    if(!empty($user_role)){
                        $roles[$i]['checked'] = 'checked';
                    }else{
                        $roles[$i]['checked'] = '';
                    }
                }
                $data['roles'] = $roles;
                $data['user_id'] = $user_id;
                render($data);
            }
        }

    }

    function forget_password(){

    }

    //用户消息
    function notices(){
        $this->load->model('notice_model');
        $nm =  new Notice_model();
        $nm->order_by('id','desc');
        $notices = $nm->find_all_by(array('received_by' => _sess('uid')));
        $data['notices'] = _format($notices);
        render($data);
    }

    function notice_show(){
        $this->load->model('notice_model');
        $nm = new Notice_model();
        $n = $nm->find_by(array('id'=>v('id'),'received_by'=>_sess('uid')));
        if(empty($n)){
            show_404();
        }else{
            //更新成已读
            if(!$n['read_flag']){
                $nm->update($n['id'],array('read_flag'=>1));
            }
            if($n['direct_url']){
                redirect($n['direct_url']);
            }else{
                render($n);
            }

        }
    }

    //全部标注为已读
    function notice_read_all(){
        $this->load->model('notice_model');
        $nm = new Notice_model();
        if($nm->update_by(array('received_by'=>_sess('uid')),array('read_flag'=>1))){
            echo 'done';
        }else{
            redirect(_url('user','notices'));
        }
    }

    //前端控件权限验证
    function check_auth(){
        echo check_auth($this->input->get('type'),$this->input->get('status'),$this->input->get('category'));
    }

    private function  _update($id,$data){
        if($this->user->update($id,$data)){
            redirect(_url('user','index'));
        }else{
            echo validation_errors('<div class="error">', '</div>');
        }
    }
    //获取验证码
    function get_code(){
        $this->code(4,60,29);
    }

    //验证码校检
    function check_code(){
        $code = trim($_GET['code']);
        if($code == _sess('code')){
            echo '1';
        }else{
            echo '0';
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