<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_history_model extends MY_Model{

    public $id;
    public $job_id;
    public $data = array();
    public $canceled = false;

    function __construct(){
        parent::__construct();
        $this->add_validate('status','required');
        $this->load->model('job_output_model');
        $this->load->model('job_model');
    }

    //日志单行刷入
    function log($log){
        $jom = new Job_output_model();
        $o = $jom->find_by(array('history_id'=>$this->id));
        if(!empty($o)){
            $data['log'] = $o['log'].date('Y-m-d H:i:s').'  '.$log."\r\n";
            $jom->update($o['id'],$data);
        }
    }

    //数据单行刷入
    function data($data){
        array_push($this->data,$data);
    }

    function starting($job){
        $this->job_id = $job['id'];

        //更新job的下次运行时间
        $jm = new Job_model();
        $jm->refresh_next_exec_date($job);

        //开始运行，日志
        $data['job_id'] = $job['id'];
        $data['status'] = 'running';
        $data['start_date'] = time();
        $this->id = $this->insert($data);

        //output
        $jom = new Job_output_model();
        $o['history_id'] = $this->id;
        $o['log'] = '';
        $o['output_type'] = $job['output_type'];
        $jom->insert($o);

        //log
        $this->log('Job start...');
    }

    function run_step($step){
        $this->log('Step'.$step['step'].'开始运行...');
        $this->log('Step info :'.json_encode($step));
        //构建url和参数
        $url = _url($step['controller'],$step['action']);
        $this->load->model('variant_line_model');
        $vlm = new Variant_line_model();
        $ps = $vlm->find_all_by(array('variant_id'=>$step['variant_id']));
        $params = array();
        foreach($ps as $p){
            //时间值处理

            $d[$p['segment_name']] =  $p['segment_value'];
            array_push($params,$d);
        }
        $result = cevin_http_open($url);

        //如果有返回数据
        if($result){
            //具体步骤的数据
            $data['step'] = $step['step'];
            $data['data'] = $result;
            $this->data($data);
        }

        $this->log('Step'.$step['step'].'运行结束');
        return $this->_analyze_response($result);
    }

    //最后将数据刷新到outpu表，并统计时间
    function ending(){
        $jom = new Job_output_model();
        $data['output'] = json_encode($this->data);
        $jom->update_by(array('history_id'=>$this->id),$data);
        //结束时间
        $h['end_date'] = time();
        if($this->canceled){
            $h['status'] = 'canceled';
        }else{
            $h['status'] = 'finished';
        }
        $this->update($this->id,$h);
    }

    //返回结果判断是否有错误
    private function _analyze_response($data_string){
        $data = json_decode($data_string);
        if(is_null($data)){
            return true;
        }else{
            $pass = true;
            //解析json
            if(isset($data->message)){
                foreach($data->message as $m){
                    if($m->type == 'E'){
                        $this->canceled = true;
                        $pass = false;
                        break;
                    }
                }
            }
            return $pass;
        }
    }

}