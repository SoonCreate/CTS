<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends CI_Controller {

    function create(){

    }

    function edit(){

    }

    function show(){

    }

    function destroy(){

    }

    function history(){

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

    }

}