<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    //提供给客户，优化后的界面，并非高级配置

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    //状态统计
    function status_statistics(){
        render();
    }

    function status_statistics_data(){
        $this->load->model('order_model');
        $this->load->model('status_model');
        $om = new Order_model();
        $sm = new Status_model();
        $order_type = v('order_type');
        if(!$order_type){
            $ts = get_options('vl_order_type');
            $order_type = $ts[0]['value'];
        }
        $this->db->select('status,count(id) as status_count');
        $this->db->group_by('status');
        $rs = $om->find_all_by(array('order_type'=>$order_type));
        $all_count = $om->count_by(array('order_type'=>$order_type));
        for($i=0;$i<count($rs);$i++){
            $rs[$i]['percent'] = round($rs[$i]['status_count'] * 100 / $all_count,2) . '%' ;
            $rs[$i]['text'] = $sm->get_label(default_value('status',$order_type),$rs[$i]['status']);
        }
        $data["items"] = $rs;
        $data["identifier"] = 'status';
        $data["label"] = 'text';
        $data["structure"] = build_structure('text','status_count','percent');
        $data["detail_structure"] = $om->grid_structure();
        echo json_encode($data);
    }

    //处理时间统计
    function time_statistics(){
        $data['time_span'] = 1;
        render($data);
    }

    //耗时分析
    function time_statistics_data(){
        //默认为结构和空数据
        $data["structure"] = build_structure('id','title','leader','manager','release_to_confirm','confirm_to_allocate','allocate_to_close','total_time');
        $data["items"] = array();
        $data["identifier"] = 'id';
        if($_POST){

        }else{

        }
        echo json_encode($data);
    }

    //效率分析
    function efficiency_statistics(){
        //评为效率差的订单，规定各个阶段的报警时长
    }

}