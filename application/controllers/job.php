<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends CI_Controller {

    //发送报警信息
    function send_alarm_message(){

        send_mail('yacole@qq.com','helper方法测试','测试<hr/>');
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