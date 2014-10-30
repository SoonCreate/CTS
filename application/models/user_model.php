<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('valuelist_model','vl');
        $this->load->model('role_model','role');
        $this->load->model('user_role_model','user_role');

        $this->_validate_for_insert();

        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function config($name,$user_id = null){
        if(is_null($user_id)){
            $user_id = _sess('uid');
        }
        $uc = $this->find_by_view(array('config_name'=>$name,'user_id'=>$user_id));
        if(empty($uc)){
            $this->load->model('config_model');
            $cm = new Config_model();
            return $cm->find_by(array('config_name'=>$name));
        }else{
            return $uc;
        }
    }

    function default_roles($order_type){
        $vm = new Valuelist_model();
        return $vm->find_active_children_options('default_role',$order_type);
    }

    function before_update($data){
        $this->clear_validate();
        $this->_validate();
        return $data;
    }

    function register_save($data){
        $rm = new Role_model();
        $urm = new User_role_model();
        $return = false;
        $this->db->trans_begin();
        $user_id = $this->insert(elements(array('username','password','full_name','initial_pass_flag'),$data,NULL));
        if($user_id){
            $this->load->model('valuelist_line_model');
            //内容
            $vlm = new Valuelist_line_model();
            //查找对应的订单类型
            $line = $vlm->find_by_view(array('valuelist_name'=>'vl_register_select','segment_value'=>$data['user_type']));
            if(!empty($line)){
                $row['user_id'] = $user_id;
                $roles = $this->default_roles($line['parent_segment']);
                if(!empty($roles)){
                    //多个默认角色
                    foreach($roles as $role){
                        $r = $rm->find_by(array('role_name'=>$role['value']));
                        if(!empty($r)){
                            $row['role_id'] = $r['id'];
                            $urm->insert($row);
                        }
                    }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    }else{
                        $this->db->trans_commit();
                        $return = true;
                    }
                }else{
                    $this->db->trans_rollback();
                }
            }else{
                $this->db->trans_rollback();
            }
        }else{
            $this->db->trans_rollback();
        }
        return $return;
    }

    private  function _validate_for_insert(){
        $this->clear_validate();
        //服务端插入数据库之前验证
        $this->add_validate('username','required|min_length[5]|max_length[200]|is_unique[users.username]|alpha_dash');
        $this->add_validate('password','required');
        $this->_validate();
    }

    //公用验证
    function _validate(){
        $this->add_validate('full_name','required|max_length[255]');
        $this->add_validate('email','valid_email');
        $this->add_validate('mobile_telephone','numeric');
        $this->add_validate_255('phone_number','address','contact');
    }
    function is_username_exists($username){
        if(count($this->db->get_where('users',array('username' => $username))->result_array()) > 0){
            return true;
        }else{
            return false;
        }
    }
}