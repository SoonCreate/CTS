<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends CI_Controller {

    //提供给客户，优化后的界面，并非高级配置

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('system_session_model');
    }

    function index(){
        render();
    }

    function data(){
        $this->load->model('user_model');
        $this->load->model('module_line_model');
        $this->load->model('module_model');
        //user-agent
        $this->load->library('user_agent');
        $um = new User_model();
        $ssm = new System_session_model();
        $mlm = new Module_line_model();
        $mm = new Module_model();
        $sessions = $ssm->find_all();
        $d = array();
//        foreach($sessions as $s){
//            print_r($this->session->_unserialize($s['user_data']));
//        }
        for($i=0;$i<count($sessions);$i++){
            $user_data = $this->session->_unserialize($sessions[$i]['user_data']);
            if(isset($user_data['uid']) && $user_data['uid']){
                $user = $um->find($user_data['uid']);
                if(!empty($user)){
                    $sessions[$i]['user_id'] = $user['id'];
                    $sessions[$i]['username'] = $user['username'];
                    $sessions[$i]['full_name'] = $user['full_name'];
                }
                if(isset($user_data['cm'])){
                    $function = $mlm->find_by_view(array('id'=>$user_data['cm']));
                    if(!empty($function)){
                        $sessions[$i]['module_desc'] = $function['module_desc'];
                        $sessions[$i]['function_desc'] = $function['function_desc'];
                    }else{
                        $sessions[$i]['module_desc'] = '';
                        $sessions[$i]['function_desc'] = '';
                    }
                }else{
                    if(isset($user_data['mid'])){
                        $module = $mm->find($user_data['mid']);
                        $sessions[$i]['module_desc'] = $module['description'];
                        $sessions[$i]['function_desc'] = '';
                    }else{
                        $sessions[$i]['module_desc'] = '';
                        $sessions[$i]['function_desc'] = '';
                    }
                }
                //初始化user-agent
                $sessions[$i]['browser'] = label('unknown');
                $sessions[$i]['mobile'] = label('unknown');
                $sessions[$i]['platform'] = label('unknown');

                //user-agent:浏览器
                if (is_array($this->agent->browsers) AND count($this->agent->browsers) > 0)
                {
                    foreach ($this->agent->browsers as $key => $val)
                    {
                        if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $sessions[$i]['user_agent'], $match))
                        {
                            $sessions[$i]['browser'] = $val.$match[1];
                            break;
                        }
                    }
                }
                //手机型号
                if (is_array($this->agent->mobiles) AND count($this->agent->mobiles) > 0)
                {
                    foreach ($this->agent->mobiles as $key => $val)
                    {
                        if (FALSE !== (strpos(strtolower($sessions[$i]['user_agent']), $key)))
                        {
                            $sessions[$i]['mobile'] = $val;
                            break;
                        }
                    }
                }
                //操作系统
                if (is_array($this->agent->platforms) AND count($this->agent->platforms) > 0)
                {
                    foreach ($this->agent->platforms as $key => $val)
                    {
                        if (preg_match("|".preg_quote($key)."|i", $sessions[$i]['user_agent']))
                        {
                            $sessions[$i]['platform'] = $val;
                            break;
                        }
                    }
                }
                $sessions[$i]['last_activity'] = date('Y-m-d H:i:s',$sessions[$i]['last_activity']);
                array_push($d,$sessions[$i]);

            }//if
        }
        $data["structure"] = build_structure('username','full_name','platform','browser','mobile','ip_address','module_desc','function_desc','last_activity');
        $data["identifier"] = 'session_id';
        $data["label"] = 'username';
        $data['items'] = $d;
        echo json_encode($data);
    }

    function kill(){
        $this->load->model('system_session_model');
        $ssm = new System_session_model();
        $session = $ssm->find_by(array('session_id'=>v('id')));
        if(!empty($session)){
            $my_data = $this->session->userdata;
            //
            if($session['session_id'] == $my_data['session_id']){
                //注销当前
                location_url(_url('user','logout'));
            }else{
                if($ssm->delete_by(array('session_id'=>v('id')))){
                    custz_message('I','会话注销成功！');
                }else{
                    custz_message('E','会话注销失败！');
                }
            }

        }else{
            custz_message('E','会话不存在，可能已注销！');
        }
    }

    function kill_all(){
        if($this->db->truncate('ct_system_sessions')){
            location_url(site_url());
        }else{
            message_unknown_error();
        }
    }

}