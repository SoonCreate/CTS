<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_meeting extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_meeting_model');
        $this->load->model('meeting_file_model');
        $this->load->model('order_model');
        $this->load->model('meeting_model');
    }

    function index(){
        $om = new Order_model();
        $order = $om->find(v('order_id'));
        if(empty($order)){
            show_404();
        }else{
            $omm = new Order_meeting_model();
            $objects = $omm->find_all_by_view(array('order_id'=>$order['id']));
            if(empty($objects)){
                //没有记录时新建
                redirect(_url('order_meeting','create',array('order_id'=>$order['id'])));
            }else{
                $data['objects'] = _format($objects);
                render($data);
            }

        }
    }

    function show(){
        $mm = new Meeting_model();
        $meeting = $mm->find(v('id'));
        if(empty($meeting)){
            show_404();
        }else{
            $omm = new Order_meeting_model();
            $omfm = new Meeting_file_model();
            $meeting['orders'] = $omm->find_all_by_view(array('id'=>$meeting['id']));
            $meeting['files'] = $omfm->find_all_by_view(array('meeting_id'=>$meeting['id']));
            render(_format_row($meeting));
        }
    }

    function create(){
        $om = new Order_model();
        if($_POST){
            $this->_save();
        }else{
            $order = $om->find(v('order_id'));
            if(v('order_id') && empty($order)){
                show_404();
            }else{
                render();
            }
        }
    }

    function edit(){
        $mm = new Meeting_model();
        $meeting = $mm->find(v('id'));
        if(empty($meeting) || $meeting['inactive_flag'] ){
            show_404();
        }else{
            if($_POST){
                $this->_save();
            }else{
                $omm = new Order_meeting_model();
                $ids = $omm->find_order_ids($meeting['id']);
                $meeting['order_id'] = join(',',$ids);
                render(_format_row($meeting));
            }
        }
    }

    function cancel(){
        //会议有了决议之后就无法取消
        $mm = new Meeting_model();
        $m = $mm->find(v('id'));
        if(empty($m) || $m['inactive_flag']){
            show_404();
        }else{
            if(is_null($m['discuss']) || $m['discuss'] == ''){
                if($_POST){
                    $_POST['inactive_flag'] = 1;
                    $data = _data('inactive_flag','cancel_reason','cancel_remark');
                    if($mm->update($m['id'],$data,true)){
                        echo 'done';
                    }else{
                        echo '更新失败';
                    }
                }else{
                    render();
                }
            }else{
                echo '会议已有决议，不能再取消！';
            }
        }
    }

    function upload_file(){
        $mm = new Meeting_model();
        $m = $mm->find(v('id'));
        if(empty($m) || $m['inactive_flag']){
            show_404();
        }else{
            if($_FILES && $_POST){

                $this->load->library('upload', load_upload_config());
                if ( ! $this->upload->do_upload())
                {
                    echo $this->upload->display_errors();
                }
                else
                {
                    $this->load->model('file_model');
                    $fm = new File_model();
                    $omf = new Meeting_file_model();
                    $this->db->trans_begin();
                    $id = $fm->insert($this->upload->data());
                    if($id){
                        $data['file_id'] = $id;
                        $data['meeting_id'] = $m['id'];
                        $data['description'] = v('description');
                        if($omf->insert($data)){
                            $this->db->trans_commit();
                            echo 'done';
                        }else{
                            $this->db->trans_rollback();
                            echo validation_errors('<div class="error">', '</div>');
                        }
                    }else{
                        $this->db->trans_rollback();
                        echo validation_errors('<div class="error">', '</div>');
                    }
                }
            }else{
                render();
            }
        }
    }

    private function _save(){
        $om = new Order_model();
        $mm = new Meeting_model();
        $_POST['discuss'] = tpost('discuss');
        $_POST['start_date'] = strtotime(v('start_date'));
        $_POST['end_date'] = strtotime(v('end_date'));
        $ids = array_unique(explode(',',v('order_id')));
        print_r($ids);
        if(empty($ids)){
            echo '请至少填写一个投诉单号';
        }else{
            $error = '';
            foreach($ids as $id){
                $o = $om->find($id);
                if(empty($o)){
                    $error = $error.' '.$id.' ';
                    break;
                }
            }
            if($error == ''){
                $data = _data('title','start_date','end_date','site','anchor','recorder','actor','discuss');
                if(v('id')){
                    $data['id'] = v('id');
                }
                if($mm->save($data,$ids)){

                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '订单号输入有误，其中单号'.$error.'不存在';
            }
        }
    }

}