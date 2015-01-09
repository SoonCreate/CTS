<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('job_model');
        $this->load->model('job_step_model');
        $this->load->model('job_history_model');
        $this->load->model('job_output_model');
    }

    function index(){
        $jm = new Job_model();
        $data['objects'] = _format($jm->find_all(),true);
        render($data);
    }

    function create(){
        if($_POST){
            $jm = new Job_model();
            $_POST['period_flag'] = v('period_flag');
            $_POST['first_exec_date'] = sc_strtotime(v('first_exec_date'));
            $_POST['inactive_date'] = sc_strtotime(v('inactive_date'));
            $job_id = $jm->insert(_data('job_name','description','output_type',
                'first_exec_date','inactive_date','period_flag','period_type','period_value'));

            if($job_id){
                redirect_to('job','steps',array('job_id'=>$job_id));
                message_db_success();
            }else{
                validation_error();
            }
        }else{
            //默认5分钟后允许
            $data['first_exec_date'] = date('Y-m-d H:i:s',time()+300);
            render($data);
        }
    }

    function edit(){
        $jm = new Job_model();
        $job = $jm->find(v('id'));
        if(empty($job)){
            show_404();
        }else{
            if($_POST){
                $_POST['period_flag'] = v('period_flag');
                $_POST['first_exec_date'] = sc_strtotime(v('first_exec_date'));
                $_POST['inactive_date'] = sc_strtotime(v('inactive_date'));

                if($jm->update($job['id'],_data('job_name','description','output_type',
                    'first_exec_date','inactive_date','period_flag','period_type','period_value'))){
                    go_back();
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }else{
                if(!is_null($job['inactive_date'])){
                    $job['inactive_date'] = date('Y-m-d H:i:s',$job['inactive_date']);
                }
                $job['first_exec_date'] = date('Y-m-d H:i:s',$job['first_exec_date']);

                render($job);
            }
        }

    }

    function destroy(){
        //没有运行记录能删除，有则只能改结束时间
        $jm = new Job_model();
        $job = $jm->find(v('id'));
        if(empty($job)){
            show_404();
        }else{
            $jhm = new Job_history_model();
            if($jhm->count_by(array('job_id'=>$job['id'])) > 0){
                custz_message('E','该作业已被运行，无法再删除，只能通过修改失效时间停止运行！');
            }else{
                $jsm = new Job_step_model();
                $this->db->trans_start();
                $jsm->delete_by(array('job_id'=>$job['id']));
                $jm->delete($job['id']);
                $this->db->trans_complete();
                if($this->db->trans_status() === FALSE){
                    message_db_failure();
                }else{
                    message_db_success();
                }
            }
        }
    }

    //步骤
    function steps(){
        $jm = new Job_model();
        $job = $jm->find(v('job_id'));
        if(empty($job)){
            show_404();
        }else{
            $jsm = new Job_step_model();
            $data['objects'] = $jsm->find_all_by_view(array('job_id'=>$job['id']));
            render($data);
        }
    }

    function step_create(){
        $jm = new Job_model();
        $job = $jm->find(v('job_id'));
        if(empty($job)){
            show_404();
        }else{
            if($_POST){
                $jsm = new Job_step_model();
                if($jsm->insert(_data('job_id','step','function_id','variant_id'))){
                    go_back();
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                render();
            }
        }
    }

    function step_edit(){
        $jsm = new Job_step_model();
        $step = $jsm->find(v('id'));
        if(empty($step)){
            show_404();
        }else{
            if($_POST){
                $jsm = new Job_step_model();
                if($jsm->update($step['id'],_data('step','function_id','variant_id'))){
                    go_back();
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }else{
                render($step);
            }
        }
    }

    function step_destroy(){

    }

    function histories(){

    }

    function history_log(){

    }

    function history_output(){

    }

    //发送报警信息
    function send_alarm_message(){

        send_mail('yacole@163.com','helper方法测试','测试');
    }

    //定期清理垃圾上传文件
    function clear_upload_files(){

    }

    public function message($to = 'World')
    {
        if($this->input->is_cli_request()){
            echo "Hello {$to}!".PHP_EOL;
        }else{
            echo '11';
        }

    }

    //由此方法开始分配任务并执行
    function run(){
        //获取有效并可以开始运行的作业
        $jm = new Job_model();
        $jsm = new Job_step_model();
        $jobs = $jm->find_all();
        foreach($jobs as $job){
            if(is_null($job['inactive_date']) || (!is_null($job['inactive_date']) && $job['inactive_date'] > time())){
                //判断第一次和后续
                if((is_null($job['next_exec_date']) && $job['first_exec_date'] <= time())||
                    (!is_null($job['next_exec_date']) && $job['first_exec_date'] <= time())){

                    //判断步骤
                    $steps = $jsm->find_all_by_view(array('job_id'=>$job['id']));
                    if(!empty($steps)){
                        foreach($steps as $step){
                            
                        }
                    }
                }
            }
        }
    }

}