<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_meeting_model extends MY_Model{

    function __construct(){
        parent::__construct();
        //设置钩子
        $this->before_create = array('before_insert');
        $this->before_update = array('before_update');
    }
    
    function before_insert($data){
        return set_creation_date($data);
    }

    function before_update($data){
        return set_last_update($data);
    }

    function find_all_by_view($where){
        return $this->db->get_where($this->_table.'_v',$where)->result_array();
    }

    function find_order_ids($meeting_id){
        $rows = $this->find_all_by(array('meeting_id'=>$meeting_id));
        $ids = array();
        foreach($rows as $r){
            array_push($ids,$r['order_id']);
        }
        return $ids;
    }
}