<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_role_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    function find_user_ids($role_id){
        $return = array();
        $rows = $this->find_all_by(array('role_id'=>$role_id));
        if(!empty($rows)){
            foreach($rows as $row){
                array_push($return,$row['user_id']);
            }
        }
        return $return;
    }

    function find_role_ids($user_id){
        $return = array();
        $rows = $this->find_all_by(array('user_id'=>$user_id));
        if(!empty($rows)){
            foreach($rows as $row){
                array_push($return,$row['role_id']);
            }
        }
        return $return;
    }

}