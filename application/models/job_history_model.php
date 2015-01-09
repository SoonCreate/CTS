<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_history_model extends MY_Model{

    public $id;
    public $data;
    public $canceled = false;

    function __construct(){
        parent::__construct();
        $this->add_validate('job_id','required');
        $this->add_validate('status','required');
        $this->load->model('job_output_model');
    }

    //日志单行刷入
    function log($log){
        $jom = new Job_output_model();
        $o = $jom->find_by(array('history_id'=>$this->id));
        if(!empty($o)){
            $data['log'] = $o['log'].date('Y-m-d H:i:s').'  '.$log.'\n';
            $jom->update($o['id'],$data);
        }
    }

    //数据单行刷入
    function data($data){
        $this->data = $this->data .$data;
    }

    function starting($job){
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
        //运行
        $url = site_url($step['controller'].'/'.$step['action']);

        $this->sock_get($url);

        $this->log('Step'.$step['step'].'运行结束');
    }

    //fsocket模拟get提交
    function sock_get($url)
    {
        $info = parse_url($url);
        $fp = fsockopen($info["host"], 80, $errno, $errstr, 10);
        //参数
        if(isset($info["query"])){
            $head = "GET ".$info['path']."?".$info["query"]." HTTP/1.0rn";
        }else{
            $head = "GET ".$info['path']." HTTP/1.0rn";
        }

        $head .= "Host: ".$info['host']."rn";
        $head .= "rn";
        $write = fputs($fp, $head);
//        print_r($write);
//        while (!feof($fp))
//        {
//            $line = fread($fp,4096);
//            echo $line;
//        }
    }

    function sock_post($url, $query)
    {
        $info = parse_url($url);
        $fp = fsockopen($info["host"], 80, $errno, $errstr, 10);
        $head = "POST ".$info['path']."?".$info["query"]." HTTP/1.0rn";
        $head .= "Host: ".$info['host']."rn";
        $head .= "Referer: http://".$info['host'].$info['path']."rn";
        $head .= "Content-type: application/x-www-form-urlencodedrn";
        $head .= "Content-Length: ".strlen(trim($query))."rn";
        $head .= "rn";
        $head .= trim($query);
        $write = fputs($fp, $head);
        while (!feof($fp))
        {
            $line = fread($fp,4096);
            echo $line;
        }
    }

    //最后将数据刷新到outpu表，并统计时间
    function ending(){
        $jom = new Job_output_model();
        $data['output'] = $this->data;
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

}