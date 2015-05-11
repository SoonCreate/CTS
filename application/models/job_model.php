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
    function refresh_next_exec_date($job,$start_date){
        if($job['period_flag'] && $job['period_value']){
            $n = $job['first_exec_date'];
//            log_message('error',$start_date);
            $period_value = string_to_number($job['period_value']);
//            if(is_null($n) || !$n){
//                $n = $job['first_exec_date'];
//            }
            //如果手动运行，或提前运行，则不更新下次运行时间
            if($start_date >= $job['next_exec_date']){
                $os = $start_date - $n;
                switch($job['period_type']){
                    case 'minute':
                        $single = $period_value * 60;
                        //进1取整
                        $n = $n + ceil($os/$single)*$single;
                        break;
                    case 'hour' :
                        $single = $period_value * 60 * 60;
                        //进1取整
                        $n = $n + ceil($os/$single)*$single;
                        break;
                    case 'day' :
                        $single = $period_value * 60 * 60 * 24;
                        //进1取整
                        $n = $n + ceil($os/$single)*$single;
                        break;
                    case 'month' :
                        //计算月份差
                        $cy = interval_month($n,$start_date);
                        if($cy == 0){
                            $cy = 1;
                        }
                        $yc = ceil($cy/$period_value)*$period_value;
                        log_message('error',$yc);
                        //获取本应下次运行时间
                        $n = strtotime('+'.$yc.' month',$n);
                        break;
                    case 'year' :
                        $cy = date("Y",$start_date)-date("Y",$n);
                        if($cy == 0){
                            $cy = 1;
                        }
                        $nc = ceil($cy/$period_value)*$period_value;
                        $n = strtotime('+'.$nc.' year',$n);
                        break;
                }
                $data['next_exec_date'] = $n;
                log_message('error',$n);
                $this->update($job['id'],$data,true);
            }

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