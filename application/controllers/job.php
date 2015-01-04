<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends CI_Controller {

    //发送报警信息
    function send_alarm_message(){

        send_mail('yacole@163.com','helper方法测试','测试');
    }

    //定期清理垃圾上传文件
    function clear_upload_files(){

    }

    //自动反馈
    function auto_feedback(){
        //只为后台运行
        if($this->input->is_cli_request()){
            //判断是否开启反馈功能
            $feedback_control = _config('feedback_control');
            $auto_feedback = _config('auto_feedback');
            $feedback_star = _config('feedback_star');
            if($feedback_control && $auto_feedback && $feedback_star){
                $this->load->model('feedback_model');
                $this->load->model('feedback_star_model');
                $this->load->model('valuelist_line_model');
                $this->load->model('order_log_model');
                $ofm = new Feedback_model();
                $fsm = new Feedback_star_model();
                $vlm = new Valuelist_line_model();
                $olm = new Order_log_model();
                $this->db->trans_start();
                //确定范围
                $this->db->where('feedback_id is null');
                $orders = $this->db->get_where('feedback_orders_v',array('status'=>'closed'))->result_array();
                //创建
                $vlm->order_by('sort');
                $stars = $vlm->find_all_by_view(array('valuelist_name'=>'vl_feedback','inactive_flag'=>0));
                foreach($orders as $order){
                    //获取最后关闭时间
                    $olm->order_by('last_update_date','desc');
                    $log = $olm->find_by(array('order_id'=>$order['id'],'log_type'=>'order_status','new_value'=>'closed'));
                    if(!empty($log)){
                        $period = (time() - $log['last_update_date'])/3600;
                        //超出时间则运行
                        if($period >= $auto_feedback){
                            $feedback['order_id'] = $order['id'];
                            $feedback_id = $ofm->insert($feedback);

                            foreach($stars as $star){
                                $s['feedback_id'] = $feedback_id;
                                $s['feedback_type'] = $star['segment_value'];
                                $s['feedback_desc'] = $star['segment_desc'];
                                $s['stars'] = $feedback_star;
                                $s['total_stars'] = $feedback_star;
                                $fsm->insert($s);
                            }
                        }
                    }
                }
                $this->db->trans_complete();
                if($this->db->trans_status() === TRUE){
                    echo 'god';
                }else{
                    echo 'shit';
                }

            }
        }else{
            show_404();
        }
    }

    public function message($to = 'World')
    {
        if($this->input->is_cli_request()){
            echo "Hello {$to}!".PHP_EOL;
        }else{
            echo '11';
        }

    }

}