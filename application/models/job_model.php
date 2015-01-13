<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends MY_Model{

    function __construct(){
        parent::__construct();
        $this->_validate();
        $this->add_validate('job_name','required|min_length[5]|max_length[45]|is_unique[jobs.job_name]|alpha_dash');
        //设置钩子
        array_unshift($this->before_update,'before_update');
    }

    function before_update($data){
        $this->_validate();
        return $data;
    }

    //job运行开始时计算
    function refresh_next_exec_date($job){
        if($job['period_flag'] && $job['period_value']){
            $n = $job['next_exec_date'];
            $period_value = string_to_number($job['period_value']);
            if(is_null($n) || !$n){
                $n = $job['first_exec_date'];
            }
            switch($job['period_type']){
                case 'minute':
                    $n = $n + $period_value * 60;
                    break;
                case 'hour' :
                    $n = $n + $period_value * 60 * 60;
                    break;
                case 'day' :
                    $n = $n+ $period_value * 60 * 60 * 24;
                    break;
                case 'month' :
                    $n = strtotime('+'.$period_value.' month',$n);
                    break;
                case 'year' :
                    $n = strtotime('+'.$period_value.' year',$n);
                    break;
            }
            $data['next_exec_date'] = $n;
            log_message('error',$n);
            $this->update($job['id'],$data,true);
        }
    }

    private function _validate(){
        $this->clear_validate();
        $this->add_validate('description','required|max_length[255]');
        $this->add_validate('output_type','required');
        $this->add_validate('first_exec_date','required');
        $this->add_validate('period_value','is_numeric');
    }

}