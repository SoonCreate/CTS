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
        $jsm = new Job_step_model();
        $step = $jsm->find(v('id'));
        if(empty($step)){
            show_404();
        }else{
            if($jsm->delete($step['id'])){
                message_db_success();
            }else{
                message_db_failure();
            }
        }
    }

    function histories(){
        $jm = new Job_model();
        $job = $jm->find(v('job_id'));
        if(empty($job)){
            show_404();
        }else{
            render();
        }
    }

    function history_data(){

        $start = 0;
        $end = 0 ;
        if(isset($_SERVER['HTTP_RANGE'])){
            $idx = stripos($_SERVER['HTTP_RANGE'],'-');
            $start = intval(substr($_SERVER['HTTP_RANGE'],6,$idx-6));
            $end = intval(substr($_SERVER['HTTP_RANGE'],$idx+1));
        }

        $jhm = new Job_history_model();

        $totalCnt = $jhm->count_by(array('job_id'=>v('job_id')));

        $data["identifier"] = 'id';
        $data["label"] = 'subject';

        $jhm->order_by('id','desc');
        $jhm->limit($end+1,$start);
        $histories = $jhm->find_all_by(array('job_id'=>v('job_id')));
        for($i=0;$i<count($histories);$i++){
            if(!is_null($histories[$i]['end_date'])){
                $histories[$i]['experience'] = $histories[$i]['end_date'] - $histories[$i]['start_date'];
            }
            $histories[$i]['status'] = get_label('vl_job_status',$histories[$i]['status']);
            $histories[$i] = _format_row($histories[$i],true);
        }
        $data['items'] = $histories;

        if(isset($_SERVER['HTTP_RANGE'])){
            header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.$totalCnt);
            $output = $data['items'];
        }
        echo json_encode($output);


    }

    function history_structure(){
        $structure = array();
        array_push($structure,_structure('id',null,'40px'));
        array_push($structure,_structure('status',null,'100px'));
        array_push($structure,_structure('start_date',null,'200px'));
        array_push($structure,_structure('end_date',null,'200px'));
        array_push($structure,_structure('experience',null,'200px'));
        echo json_encode($structure);
    }

    function history_log(){
        $jhm = new Job_history_model();
        $h = $jhm->find(v('id'));
        if(empty($h)){
            show_404();
        }else{
            $jom = new Job_output_model();
            $o = $jom->find_by(array('history_id'=>$h['id']));
            $data['content'] =  str_replace("\r\n","<br/>",$o['log']);
            render($data);
        }
    }

    function history_output(){
        //根据类型直接下载
        //分析有多少步骤有输出
        $jhm = new Job_history_model();
        $h = $jhm->find(v('id'));
        if(empty($h)){
            show_404();
        }else{
            $jom = new Job_output_model();
            $o = $jom->find_by(array('history_id'=>$h['id']));
            //20150511 内容为空下载时不生成文件bug修复
            $content = ' ';
            $filename = date('ymd').'.'.$o['output_type'];
            //排除没有输出的bug
            if(!is_null($o['output'])){
                $d =  json_decode($o['output']);
                //判断是否每步骤都会输出
                $cnt = count($d);
                switch($o['output_type']){
                    case 'txt' :
                        if($cnt == 1){
                            $content = unicode_to_word($d[0]->data);
                        }else{
                            foreach($d as $s){
                                $content = $content . 'Step '.$s->step."\r\n";
                                $content = $content .unicode_to_word($s->data)."\r\n";
                            }
                        }

                        break;
                    case 'xlsx':
                        $this->load->library('PHPExcel');
                        $this->load->library('PHPExcel/IOFactory');
                        $objPHPExcel = new PHPExcel();
                        $objPHPExcel->getProperties()->setTitle($filename)->setDescription("none");
                        $sheet = 0;
                        foreach($d as $s){
                            if($sheet > 0){
                                $objPHPExcel->createSheet();
                            }
                            $objPHPExcel->setActiveSheetIndex($sheet);
                            $objPHPExcel->getActiveSheet()->setTitle('step '.$s->step);

                            $data = array();
                            $fields = array();
                            //判断数据
                            if(is_array($s->data)){
                                $data = $s->data;
                                foreach($data[0] as $key=>$value){
                                    array_push($fields,$key);
                                }
                            }else{
                                if(isset($s->data->items)){
                                    $data = $s->data->items;
                                    foreach($data[0] as $key=>$value){
                                        array_push($fields,$key);
                                    }
                                }else{
                                    $a['data'] = $s->data;
                                    array_push($data,$a);
                                    $fields = array('data');
                                }
                            }

                            // Field names in the first row
                            $col = 0;
                            foreach ($fields as $field)
                            {
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, label($field));
                                $col++;
                            }

                            // Fetching the table data
                            $row = 2;
                            foreach($data as $row_data){
                                $col = 0;
                                foreach ($fields as $field)
                                {
                                    //中文需转义
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, unicode_to_word($row_data[$field]));
                                    $col++;
                                }
                                $row++;
                            }

                            $sheet ++;

                        }
                        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
                        //发送标题强制用户下载文件
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="'.$filename.'"');
                        header('Cache-Control: max-age=0');
                        $objWriter->save('php://output');
                        break;
                    case 'pdf' :
                        //fpdf dompdf 中文支持 后续实现
                        break;
                    case 'doc' :
                        if($cnt == 1){
                            $content = unicode_to_word($d[0]->data);
                        }else{
                            foreach($d as $s){
                                $content = $content . '<h1>Step '.$s->step."</h1>";
                                $content = $content .unicode_to_word($s->data);
                            }
                        }

                        $data['content'] = $content;
                        $content = $this->load->view('doc_template',$data,true);
                        break;
                }
            }
            //                    $data = file_get_contents(v('path')); // 读文件内容
            force_download($filename, $content);
        }
    }

    //由此方法开始分配任务并执行
    function run(){
        //跳过权限验证
        set_sess('uid',-1);
        //获取有效并可以开始运行的作业
        $jm = new Job_model();
        $jsm = new Job_step_model();
        $jobs = $jm->find_all();
        foreach($jobs as $job){
            if(is_null($job['inactive_date']) || (!is_null($job['inactive_date']) && $job['inactive_date'] > time())){
                //判断第一次和后续
                if((is_null($job['next_exec_date']) && $job['first_exec_date'] <= time())||
                    (!is_null($job['next_exec_date']) && $job['next_exec_date'] <= time())){

                    if($jsm->count_by(array('job_id'=>$job['id'])) > 0){

                        //并发运行
                        $this->_run($job['id']);
                    }
                }
            }
        }

        //登出
//        clear_all_sess();
    }

    //单个运行
    function single_run($id){
        set_sess('uid',-1);
        //必须是job客户端访问
        if($this->input->is_cli_request()){
            $jm = new Job_model();
            $jsm = new Job_step_model();
            $job = $jm->find($id);
            if(!empty($job)){
                $jhm = new Job_history_model();
                $goon = true;

                //判断步骤
                $steps = $jsm->find_all_by_view(array('job_id'=>$job['id']));

                //程序异常处理
                try {
                    //记录
                    $jhm->starting($job);

                    //步骤开始
                    foreach($steps as $step){
                        if($goon){
                            $goon = $jhm->run_step($step);
                        }else{
                            break;
                        }
                    }

                    //保存数据
                    $jhm->ending();

                } catch (Exception $e) {
                    //提前结束
                    $jhm->log($e->getMessage());
                    $jhm->ending();
                }
            }
        }else{
            show_404();
        }

    }

    //并发运行job
    private function _run($id){
        $out = popen(_config('php_dir').' '.FCPATH.'index.php job single_run '. $id,'r');
//        $data = fread($out, 1024);
//        log_message('error',$data);
        pclose($out);
    }

}