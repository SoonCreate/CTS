<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notice extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    //发送记录查看
    function index(){
        $data['message_type'] = 'notice';
        render($data);
    }

    //发送消息：站内消息、邮件、短信
    function send(){

    }

    function data(){
        $start = 0;
        $end = 0 ;
        if(isset($_SERVER['HTTP_RANGE'])){
            $idx = stripos($_SERVER['HTTP_RANGE'],'-');
            $start = intval(substr($_SERVER['HTTP_RANGE'],6,$idx-6));
            $end = intval(substr($_SERVER['HTTP_RANGE'],$idx+1));
        }
        $message_type = v('message_type');
        switch($message_type){
            case 'email';
                $this->load->model('email_log_model');
                $elm = new Email_log_model();
                $elm->order_by('id','desc');
                $elm->limit($end+1,$start);
                $logs = $elm->find_all();

                for($i=0;$i<count($logs);$i++){
                    $logs[$i]['content'] = word_truncate(_trim($logs[$i]['content']));
                    if(is_null($logs[$i]['reason'])){
                        $logs[$i]['send_flag'] = 1;
                    }else{
                        $logs[$i]['send_flag'] = 0;
                    }
                }

                $totalCnt = $elm->count_all();

                $data["identifier"] = 'id';
                $data["label"] = 'subject';
                $data['items'] = _format($logs,true);
                $output = $data;
                break;
            case 'sms':
                $this->load->model('sms_log_model');
                $slm = new Sms_log_model();
                $slm->order_by('id','desc');
                $slm->limit($end+1,$start);
                $logs = $slm->find_all();

                for($i=0;$i<count($logs);$i++){
                    $logs[$i]['content'] = word_truncate(_trim($logs[$i]['content']));
                    if(is_null($logs[$i]['reason'])){
                        $logs[$i]['send_flag'] = 1;
                    }else{
                        $logs[$i]['send_flag'] = 0;
                    }
                }

                $totalCnt = $slm->count_all();

                $data["identifier"] = 'id';
                $data["label"] = 'subject';
                $data['items'] = _format($logs,true);
                $output = $data;
                break;
            default :
                $this->load->model('notice_model');
                $nm =  new Notice_model();
                $nm->order_by('id','desc');
                $nm->limit($end+1,$start);
                $notices = $nm->find_all();
                for($i=0;$i<count($notices);$i++){
                    $notices[$i]['notice_type'] = get_label('vl_notice_type',$notices[$i]['notice_type']);
                    $notices[$i]['read'] = $notices[$i]['read_flag'];
                    $notices[$i]['content'] = word_truncate(_trim($notices[$i]['content']));
                }
                $totalCnt = $nm->count_all();

                $data["identifier"] = 'id';
                $data["label"] = 'title';
                $data['items'] = _format($notices,true);
                $output = $data;
                break;
        }
        if(isset($_SERVER['HTTP_RANGE'])){
            header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.$totalCnt);
            $output = $data['items'];
        }
        echo json_encode($output);
    }

    function  structure(){
        $structure = array();
        $message_type = v('message_type');
        switch($message_type){
            case 'email':
                array_push($structure,_structure('send_flag',null,'40px'));
                array_push($structure,_structure('subject',null,'200px'));
                array_push($structure,_structure('content',null,'400px'));
                array_push($structure,_structure('send_to',label('to'),'200px'));
                array_push($structure,_structure('created_by',label('from'),'160px'));
                array_push($structure,_structure('creation_date',label('send_date'),'160px'));
                array_push($structure,_structure('send_cc',null,'200px'));
                array_push($structure,_structure('send_bcc',null,'200px'));
                array_push($structure,_structure('attach',null,'200px'));
                array_push($structure,_structure('reason',label('error_reason'),'200px'));
                break;
            case 'sms':
                array_push($structure,_structure('send_flag',null,'40px'));
                array_push($structure,_structure('send_to',label('to'),'100px'));
                array_push($structure,_structure('content',null,'400px'));
                array_push($structure,_structure('created_by',label('from'),'160px'));
                array_push($structure,_structure('creation_date',label('send_date'),'160px'));
                array_push($structure,_structure('reason',label('error_reason'),'200px'));
                break;
            default :
                array_push($structure,_structure('read_flag',null,'40px'));
                array_push($structure,_structure('notice_type',null,'100px'));
                array_push($structure,_structure('title',null,'200px'));
                array_push($structure,_structure('content',null,'400px'));
                array_push($structure,_structure('received_by',label('to'),'160px'));
                array_push($structure,_structure('created_by',label('from'),'160px'));
                array_push($structure,_structure('creation_date',label('send_date'),'160px'));
                break;
        }
        echo json_encode($structure);
    }

}