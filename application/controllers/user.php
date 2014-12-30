<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('user_model');
    }

	public function index(){
        render();
	}

    function user_data(){
        $start = 0;
        $end = 0 ;
        if(isset($_SERVER['HTTP_RANGE'])){
            $idx = stripos($_SERVER['HTTP_RANGE'],'-');
            $start = intval(substr($_SERVER['HTTP_RANGE'],6,$idx-6));
            $end = intval(substr($_SERVER['HTTP_RANGE'],$idx+1));
        }

        $um = new User_model();
//        $um->order_by('inactive_flag');
        $um->order_by('username');
        $um->limit($end+1,$start);
        $users = $um->find_all();
        for($i=0;$i<count($users);$i++){
            $users[$i]["sex"] = get_label('vl_sex',$users[$i]["sex"] );
        }
        $totalCnt = $um->count_all();

        $data["identifier"] = 'id';
        $data["label"] = 'title';
        $data['items'] = $users;
        $output = $data;

        if(isset($_SERVER['HTTP_RANGE'])){
            header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.$totalCnt);
            $output = $data['items'];
        }
        echo json_encode($output);
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
                custz_message('E','验证码错误！');
            }

            if(empty($user)){
                custz_message('E','账号密码输入错误！');
            }else{
                set_sess('uid',$user['id']);
                redirect_to('welcome', 'app_index');
            }
        }else{
            $this->load->view('user/login');
        }
    }

    //第三方登录
    function third_part_login(){
        $username = v('username');
        $password = sha1(v('password'));
        $um = new User_model();
        $user = $um->find_by(array('username'=>$username,'password'=>$password,'inactive_flag'=>0));
        if(empty($user)){
            redirect('user/login');
        }else{
            set_sess('uid',$user['id']);
            redirect('welcome/app_index');
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
//        redirect(_url('user','login'));
        //演示用
        redirect(site_url());
    }

    function register(){
        if(_config('allow_register')){
            if($_POST){
                $pass = true;
                if(v('password') != v('repassword')){
                    add_validation_error('password', '');
                    add_validation_error('repassword', '两次输入密码不一致');
                    $pass = false;
                }

                $data['username'] = v('username');
                $data['password']  = v('password');
                $data['user_type'] = v('user_type');
                $data['full_name'] = v('full_name');
                $data['initial_pass_flag'] = 0;
                $um = new User_model();
                if($um->run_validation($data) && $pass){
                    $data['password']  = sha1(v('password'));
                    if($um->register_save($data)){
                        custz_message('I','用户注册成功！');
                        redirect_to('user','login');
                    }else{
                        validation_error();
                    }
                }else{
                    $pass = false;
                    validation_error();
                }
            }else{
                $this->load->view('user/register');
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
                go_back();
                message_db_success();
            }else{
                validation_error();
            }
        }else{
            render();
        }
    }

    //用户更新
    function user_edit(){
        $o = new User_model();
        if($_POST){
            if(!v('email_flag')){
                $_POST['email_flag'] = 0;
            }
            //验证唯一性
            $fn_check = $this->_full_name_check(_sess('uid'),v('full_name'));
            if($fn_check){
                if($o->update(_sess('uid'),$_POST)){
                    message_db_success();
                }else{
                    validation_error();
                }
            }
        }else{
            $data = $o->find(_sess('uid'));
            $data['to'] = 'user_edit';
            render_view('user/edit',$data);
        }
    }

    //管理员更新
    function admin_edit(){
        $um = new User_model();
        $user = $um->find(v('id'));
        if(empty($user)){
            show_404();
        }else{
            if($_POST){
                //验证唯一性
                $fn_check = $this->_full_name_check($user['id'],v('full_name'));
                if($fn_check){
                    if($um->update($user['id'],$_POST)){
                        go_back();
                        message_db_success();
                    }else{
                        validation_error();
                    }
                }
            }else{
                $data = $user;
                $data['to'] = 'admin_edit';
                render_view('user/edit',$data);
            }
        }

    }

    function change_password(){
        if($_POST){
            if(v('new_password')){
                if(v('new_password') != v('re_new_password')){
                    add_validation_error('re_new_password', '两次输入密码不一致');
                }else{
                    $data['password'] = sha1(v('new_password'));
                    $data['initial_pass_flag'] = 0;
                    $old_password = sha1(v('old_password'));
                    $um = new User_model();
                    $user = $um->find_by(array('id'=>_sess('uid'),'password'=>$old_password));
                    //验证旧密码是否有效
                    if(!empty($user)){
                        if($um->update($user['id'],$data,true)){
                            go_back();
                            message_db_success();
                        }else{
                            message_db_failure();
                        }
                    }else{
                        add_validation_error('old_password', '旧密码输入有误');
                    }
                }
            }else{
                add_validation_error('new_password', '密码不能为空');
            }


        }else{
            render();
        }
    }

    function change_status(){
        $um = new User_model();
        $user = $um->find(v('id'));
        if(empty($user)){
            show_404();
        }else{
            if($user['username'] == 'administrator'){
                custz_message('E','不允许修改超级管理员帐号的状态');
            }else{
                if($user['inactive_flag']){
                    $data['inactive_flag'] = 0;
                }else{
                    $data['inactive_flag'] = 1;
                }
                if($um->update($user['id'],$data,true)){
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }
        }
    }

    function initial_password(){
        $um = new User_model();
        $user = $um->find(v('id'));
        if(empty($user)){
            show_404();
        }else{
            $data['password'] = sha1(_config('initial_password'));
            $data['initial_pass_flag'] = 1;
            if($um->update($user['id'],$data,true)){
                message_db_success();
            }else{
                message_db_failure();
            }
        }
    }

    //选择角色
    function choose_roles(){
        $this->load->model('user_role_model');
        $ur = new User_role_model();
        $um = new User_model();
        $user = $um->find(v('id'));
        if(empty($user)){
            show_404();
        }else{
            if($_POST){
                $ids = v('roles');
                $ids = explode(',',v('lines'));
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
                    $ids = array_diff($ids,$ur->find_role_ids($data['user_id']));
                    foreach($ids as $id){
                        $data['role_id'] = $id;
                        $ur->insert($data);
                    }
                }
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    message_db_failure();
                }else{
                    go_back();
                    message_db_success();
                }
            }else{
                render();
            }
        }

    }

    //角色选择grid
    function role_data(){
        $um = new User_model();
        $user = $um->find(v('user_id'));
        if(empty($user)){
            show_404();
        }else{
            $this->load->model('role_model');
            $this->load->model('user_role_model');
            $urm = new User_role_model();
            $rm = new Role_model();
            $roles = $rm->find_all();
            $seleceds = array();
            foreach($roles as $role){
                $line = $urm->find_by(array('role_id'=>$role['id'],'user_id'=>$user['id']));
                if(!empty($line)){
                    array_push($seleceds,$role['id']);
                }
            }
            $data['items'] = $roles;
            $data['selected'] = $seleceds;
        }
        $data["identifier"] = 'id';
        $data["label"] = 'description';
        $data["structure"] = build_structure('role_name','description');
        echo json_encode($data);
    }

    function forget_password(){

    }

    //用户消息
    function notices(){
        render();
    }

    function notice_data(){
        $start = 0;
        $end = 0 ;
        if(isset($_SERVER['HTTP_RANGE'])){
            $idx = stripos($_SERVER['HTTP_RANGE'],'-');
            $start = intval(substr($_SERVER['HTTP_RANGE'],6,$idx-6));
            $end = intval(substr($_SERVER['HTTP_RANGE'],$idx+1));
        }

        $this->load->model('notice_model');
        $nm =  new Notice_model();
        $nm->order_by('id','desc');
        $nm->limit($end+1,$start);
        $notices = $nm->find_all_by(array('received_by' => _sess('uid')));
        for($i=0;$i<count($notices);$i++){
            $notices[$i]['notice_type'] = get_label('vl_notice_type',$notices[$i]['notice_type']);
            $notices[$i]['read'] = $notices[$i]['read_flag'];
        }
        $totalCnt = $nm->count_by(array('received_by' => _sess('uid')));

        $data["identifier"] = 'id';
        $data["label"] = 'title';
        $data['items'] = _format($notices,true);
        $output = $data;

        if(isset($_SERVER['HTTP_RANGE'])){
            header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.$totalCnt);
            $output = $data['items'];
        }
        echo json_encode($output);
    }

    function notice_structure(){
        $structure = array();
        array_push($structure,_blank_structure());
        array_push($structure,_structure('notice_type',null,'100px'));
        array_push($structure,_structure('title',null,'300px'));
        if(check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) {
            array_push($structure,_structure('created_by',label('from'),'160px'));
        }
        array_push($structure,_structure('creation_date',null,'160px'));
        echo json_encode($structure);
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
                render(_format_row($n,true));
            }

        }
    }

    //全部标注为已读
    function notice_read_all(){
        $this->load->model('notice_model');
        $nm = new Notice_model();
        if($nm->update_by(array('received_by'=>_sess('uid')),array('read_flag'=>1))){
            message_db_success();
        }else{
            message_db_failure();
        }
    }

    //用户配置列表
    function configs(){
        $this->load->model('user_config_model');
        $this->load->model('config_model');
        $cm = new Config_model();
        $user_configs = $cm->find_all_by(array('user_flag'=>1,'editable_flag'=>1));
        $ucm = new User_config_model();
        for($i=0;$i<count($user_configs);$i++){
            $uc = $ucm->find_by(array('user_id'=>_sess('uid'),'config_id'=>$user_configs[$i]['id']));
            if(!empty($uc)){
                $user_configs[$i]['config_value'] = $uc['config_value'];
            }
        }
        $data['objects'] = $user_configs;
        render($data);
    }

    //配置修改，如果当前没有配置则新建user config，再修改
    function config_edit(){
        $this->load->model('user_config_model');
        $this->load->model('config_model');
        $cm = new Config_model();
        $ucm = new User_config_model();
        $config_id = v('id');
        $config = $cm->find_by(array('user_flag'=>1,'id'=>$config_id,'editable_flag'=>1));
        if(empty($config)){
            show_404();
        }else{
            $uc = $ucm->find_by_view(array('config_id'=>$config_id));
            if(empty($uc)){
                $data['config_id'] = $config_id;
                $data['user_id'] = _sess('uid');
                $data['config_value'] = $config['config_value'];
                $uc = $ucm->find_by_view(array('id'=>$ucm->insert($data,true)));
            }
            if($_POST){
                if($ucm->update($uc['id'],array('config_value'=>v('config_value')))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render($uc);
            }
        }
    }

    //前端控件权限验证
    function check_auth(){
        echo check_auth($this->input->get('type'),$this->input->get('status'),$this->input->get('category'));
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

    function _full_name_check($id,$full_name){
        $um = new User_model();
        $user = $um->find($id);
        if($user['full_name'] == $full_name){
            return true;
        }else{
            $u = $um->find_by(array('full_name'=>$full_name));
            if(empty($u)){
                return true;
            }else{
                add_validation_error('full_name','已被他人使用，建议在后方加数字用于区分！');
                return false;
            }
        }
    }


}