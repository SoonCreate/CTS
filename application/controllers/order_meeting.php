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
                $_GET['order_id'] = $order['id'];
                $this->create();
            }else{
                for($i=0;$i<count($objects);$i++){
                    $objects[$i] = $this->_meeting_status($objects[$i]);
                }
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
            $meeting = $this->_meeting_status($meeting);
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
                $data['start_date'] = date('Y-m-d');
                $data['end_date'] = date('Y-m-d');
                render_view('order_meeting/create',$data);
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
                $meeting['start_date'] = date('Y-m-d H:m:s',$meeting['start_date']);
                $meeting['end_date'] = date('Y-m-d H:m:s',$meeting['end_date']);
                $meeting['start_time'] = 'T'.substr($meeting['start_date'],11,9);
                $meeting['start_date'] = substr($meeting['start_date'],0,10);
                $meeting['end_time'] = 'T'.substr($meeting['end_date'],11,9);
                $meeting['end_date'] = substr($meeting['end_date'],0,10);

                render($meeting);
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
                        message_db_success();
                    }else{
                        message_db_failure();
                    }
                }else{
                    render();
                }
            }else{
                custz_message('E','会议已有决议，不能再取消！');
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
                    custz_message('E',$this->upload->display_errors()) ;
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
                            go_back();
                            message_db_success();
                        }else{
                            $this->db->trans_rollback();
                            validation_error();
                        }
                    }else{
                        $this->db->trans_rollback();
                        validation_error();
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

        //格式化提交的日期
        $_POST['start_date'] = str_replace('T',' ',$_POST['start_date'] . $_POST['start_time']);
        $_POST['end_date'] = str_replace('T',' ',$_POST['end_date'] . $_POST['end_time']);

        $_POST['start_date'] = strtotime(v('start_date'));
        $_POST['end_date'] = strtotime(v('end_date'));
        $ids = array_unique(explode(',',v('order_id')));
        $p = true;
        if(empty($ids)){
            $p = false;
            add_validation_error('order_id','请至少填写一个投诉单号') ;
        }

        if($_POST['start_date'] >= $_POST['end_date'] ){
            add_validation_error('start_date','开始日期大于结束日期！') ;
        }

        if($_POST['start_date'] < strtotime(date('Y-m-d'))){
            $p = false;
            add_validation_error('start_date','日期不能为过去！') ;
        }

        if($_POST['end_date'] < strtotime(date('Y-m-d'))){
            $p = false;
            add_validation_error('end_date','日期不能为过去！') ;
        }
        $error = '';
        foreach($ids as $id){
            $o = $om->find($id);
            if(empty($o)){
                $error = $error.' '.$id.' ';
                break;
            }
        }
        if($error == ''){
            if($p){
                $data = _data('title','start_date','end_date','site','anchor','recorder','actor','discuss');
                if(v('id')){
                    $data['id'] = v('id');
                }
                if($mm->save($data,$ids)){
                    message_db_success();
                }else{
                    validation_error();
                }
            }

        }else{
            add_validation_error('order_id','订单号输入有误，其中单号'.$error.'不存在');
        }

    }

    private function _meeting_status($object){
        if($object['inactive_flag']){
            $object['status'] = label('canceled');
        }else{

            if($object['start_date'] > time()){
                $object['status'] = label('ready');
            }

            if($object['start_date'] <= time() && $object['end_date'] >= time()){
                $object['status'] = label('running');
            }

            if($object['end_date'] < time()){
                $object['status'] = label('done');
            }

            if($object['end_date'] < time() && $object['discuss']){
                $object['status'] = label('closed');
            }
        }
        return $object;
    }

}