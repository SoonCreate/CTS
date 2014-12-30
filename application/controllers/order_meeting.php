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
            $this->load->model('meeting_file_model');
            $mfm = new Meeting_file_model();
            $omm = new Order_meeting_model();
            $objects = $omm->find_all_by_view(array('order_id'=>$order['id']));
            for($i=0;$i<count($objects);$i++){
                $objects[$i] = $this->_meeting_status($objects[$i]);
                $objects[$i]['file_count'] = $mfm->count_by(array('meeting_id'=>$objects[$i]['id']));
            }
            $data['objects'] = _format($objects);
            if(check_meeting_auth($order['order_type'],$order['category'],'create')){
                $data['can_create'] = 1;
            }
            if(check_meeting_auth($order['order_type'],$order['category'],'edit')){
                $data['can_edit'] = 1;
            }
            if(check_meeting_auth($order['order_type'],$order['category'],'inactive')){
                $data['can_cancel'] = 1;
            }
            render($data);
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
                if(!check_meeting_auth($order['order_type'],$order['category'],'create')){
                    render_no_auth_error();
                }else{
                    $data['start_date'] = date('Y-m-d');
                    $data['end_date'] = date('Y-m-d');
                    $data['anchor'] = full_name(_sess('uid'));
                    render_view('order_meeting/create',$data);
                }

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
                $meeting['start_date'] = date('Y-m-d H:i:s',$meeting['start_date']);
                $meeting['end_date'] = date('Y-m-d H:i:s',$meeting['end_date']);

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
                        go_back();
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
                    foreach($this->upload->error_msg as $msg){
                        custz_message('E',$msg);
                    }
                }
                else
                {
                    $this->load->model('file_model');
                    $fm = new File_model();
                    $omf = new Meeting_file_model();
                    $this->db->trans_start();
                    $data['file_id'] = $fm->insert($this->upload->data());
                    $data['meeting_id'] = $m['id'];
                    $data['description'] = v('description');
                    $omf->insert($data);
                    $this->db->trans_complete();
                    if($this->db->trans_status() === TRUE){
                        custz_message('I','文件上传成功');
                    }else{
                        custz_message('E','文件上传失败');
                    }
                }
                echo '<html><body><textarea>'.json_encode(_sess('output')).'</textarea></body></html>';
                unset_sess('output');
            }else{
                $this->load->view('upload_file');
            }
        }
    }

    function user_search(){
        $this->load->view('order_meeting/user_search');
    }

    //根据角色查询用户
    function user_search_data(){
        $this->load->model('role_model');
        $this->load->model('user_role_model');
        $rm = new Role_model();
        $urm = new User_role_model();
        $roles = $rm->find_all();
        $data['items'] = array();
        foreach($roles as $role){
            $row['id'] = 'role_'.$role['id'];
            $row['description'] = '角色： ' . $role['description'];
            $row['type'] = 'role';
            $users = $urm->find_all_by_view(array('role_id'=>$role['id']));
            if(!empty($users)){
                $row['children'] = array();
                foreach($users as $user){
                    $sub_row['id'] = 'user_'.$user['ur_id'];
                    $sub_row['description'] = $user['full_name'];
                    $sub_row['type'] = 'user';
                    array_push($row['children'],$sub_row);
                }
            }
            array_push($data['items'],$row);
        }
        $data["identifier"] = 'id';
        $data["label"] = 'description';
//        $data["structure"] = build_structure('full_name');
        echo json_encode($data);
    }

    //提醒参与者
    function notice_actor(){
        $mm = new Meeting_model();
        $m = $mm->find(v('id'));
        if(empty($m) || $m['inactive_flag']){
            show_404();
        }else{
            $this->load->model('user_model');
            $um = new User_model();
            $full_names = explode(',',$m['actor']);
            //通知人数统计
            $success = 0;
            $failure = 0;
            foreach($full_names as $full_name){
                $user = $um->find_by(array('full_name'=>$full_name));
                if(!empty($user)){
                    //站内短信
                    $this->load->model('notice_model');
                    $nm = new Notice_model();

                    $omm = new Order_meeting_model();
                    $omfm = new Meeting_file_model();
                    $m['orders'] = $omm->find_all_by_view(array('id'=>$m['id']));
                    $m['files'] = $omfm->find_all_by_view(array('meeting_id'=>$m['id']));
                    $m = $this->_meeting_status($m);

                    $notice['received_by'] = $user['id'];
                    $notice['title'] = '会议通知：'.$m['title'];
                    $notice['content'] = $this->load->view('order_meeting/show',_format_row($m),true);

                    $nm->insert($notice);

                    if(send_message($user['id'],$notice['title'],$notice['content'])){
                        $success = $success + 1;
                    }else{
                        $failure = $failure + 1;
                        custz_message('E','['.$full_name.'] 发送失败！');
                    }
                }else{
                    custz_message('E','['.$full_name.'] 用户不存在！');
                    $failure = $failure + 1;
                }
            }
            $type = 'I';
            if($failure > 0){
                $type = 'W';
            }
            custz_message($type,'已成功通知 ['.$success.'] 位 . 未通知 ['.$failure.'] 位');
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

        //时间允许为过去
//        if($_POST['start_date'] < strtotime(date('Y-m-d'))){
//            $p = false;
//            add_validation_error('start_date','日期不能为过去！') ;
//        }
//
//        if($_POST['end_date'] < strtotime(date('Y-m-d'))){
//            $p = false;
//            add_validation_error('end_date','日期不能为过去！') ;
//        }
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
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }

        }else{
            add_validation_error('order_id','订单号输入有误，其中单号'.$error.'不存在');
        }

    }

    function choose_orders_data(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        $order_type = null;
        if(!empty($order)){
            $order_type = $order['order_type'];
        }
        $output = $om->find_my_orders($order_type,null,'allocated');
        $data = $output['data'];
        $data['structure'] = build_structure('id');
        array_push($data['structure'],_structure('title',null,'240px'));
        $data['structure'] = array_merge($data['structure'],build_structure('content','created_by'));
        array_push($data['structure'],_structure('creation_date',null,'180px'));
//        $data['objects'] = $output['data']['items'];
//        $this->load->view('order_meeting/_choose_orders',$data);
        echo json_encode($data);
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
                $object['status'] = label('finished');
            }

            if($object['end_date'] < time() && $object['discuss']){
                $object['status'] = label('closed');
            }
        }
        return $object;
    }

}