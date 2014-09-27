<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('order_model');
        $this->load->model('auth_model');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

    //在创建之前做选择
    function choose_create(){
        $a = new Auth_model();
        //能够创建的订单列表
        $rows = $a->can_create_order_types();
        if(empty($rows)){
            //不能创建任何投诉订单，提示账号未被授权

        }elseif(count($rows) > 1){
            //同时拥有几种订单的创建权限，显示选择页
            render('choose_create');

        }else{
            //一种时，直接跳转
            redirect_to('order','create',array('type'=>$rows[0]));
        }

    }

    function create(){
        if($_POST){
            $data['order_type'] = tpost('type');
            $data['category'] = tpost('category');
            $data['status'] = $this->order->default_status();

            //验证提交
            //权限
            if(check_auth($data['order_type'],$data['status'],$data['category'])){

                $data['severity'] = tpost('severity');
                $data['priority'] = tpost('frequency');
                $data['title'] = tpost('title');
                $content = r(v('content'));
                $addfiles = tpost('addfiles');
                $order = new Order_model();
                if($order->save($data,$content,$addfiles)){

                }else{

                }


            }else{

            }
        }else{
            //获取订单类型，如果没有则跳转到chose_create
            $order_type = tget('type');
            if(is_null($order_type)){
                redirect_to('order','choose_create');
            }else{
                render();
            }
        }

    }

    function change_status(){
        //先判断订单状态流是否允许更改
        //判断是否有权限更改次状态
    }

    function upload_file(){

    }

    //分配任务，制定负责人，计划完成时间
    function dispatcher(){

    }

    function change_plan_complete_date(){
        //需要填写原因
    }

}