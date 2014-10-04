<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('valuelist_model','vl');
        $this->load->model('role_model','role');
        $this->load->model('user_role_model','user_role');

        $this->_validate_for_insert();

        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }

    function default_roles($order_type){
        $vm = new Valuelist_model();
        return $vm->find_active_children_options('default_role',$order_type);
    }

    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        $this->clear_validate();
        $this->_validate();
        return set_last_update($data);
    }

    function register_save($data){
        $return = false;
        $this->db->trans_begin();
        $user_id = $this->insert(elements(array('username','password','full_name','initial_pass_flag'),$data,NULL));
        if($user_id){
            //内容
            $row['user_id'] = $user_id;
            $roles = $this->default_roles($data['order_type']);
            if(!empty($roles)){
                //多个默认角色
                foreach($roles as $role){
                    $r = $this->role->find_by(array('role_name'=>$role['value']));
                    if(!empty($r)){
                        $row['role_id'] = $r['id'];
                        $this->user_role->insert($row);
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
        return $return;
    }

    private  function _validate_for_insert(){
        $this->clear_validate();
        //服务端插入数据库之前验证
        $this->add_validate('username','required|min_length[5]|max_length[12]|is_unique[users.username]|alpha_dash');
        $this->add_validate('password','required');
        $this->add_validate('full_name','required|max_length[255]');
        $this->_validate();
    }

    //公用验证
    function _validate(){
        $this->add_validate('email','valid_email');
        $this->add_validate('mobile_telephone','numeric');
        $this->add_validate_255('phone_number','address','contact');
    }
}