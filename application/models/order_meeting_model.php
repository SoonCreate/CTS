<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_meeting_model extends MY_Model{

    function __construct(){
        parent::__construct();
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