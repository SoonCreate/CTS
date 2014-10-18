<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meeting_model extends MY_Model{

    function __construct(){
        parent::__construct();

        //服务端插入数据库之前验证
        $this->add_validate('title','required|max_length[100]');
        $this->add_validate('start_date','required');
        $this->add_validate('end_date','required');
        $this->add_validate('site','required|max_length[100]');
        $this->add_validate('anchor','required|max_length[45]');
        $this->add_validate('recorder','max_length[45]');
        $this->add_validate('actor','required|max_length[255]');

        $this->load->model('order_meeting_model');
    }

    function save($data,$ids){
        if(!is_array($ids)){
            $ids = array($ids);
        }
        $omm = new Order_meeting_model();
        $this->db->trans_begin();
        if(!isset($data['id'])){
            $l['meeting_id'] = $this->insert($data);
            if(!$l['meeting_id']){
                $this->db->trans_rollback();
                return false;
            }
        }else{
            $l['meeting_id'] = $data['id'];
            if(!$this->update($data['id'],$data)){
                $this->db->trans_rollback();
                return false;
            }
        }

        $this->db->where_not_in('order_id',$ids);
        if($omm->delete_by(array('meeting_id' => $l['meeting_id']))){
            $ids = array_diff($ids,$omm->find_order_ids($l['meeting_id']));
            foreach($ids as $id){
                $l['order_id'] = $id;
                if(!$omm->insert($l)){
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }else{
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }
}