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
        $this->load->model('status_model');
        $this->load->model('order_log_model');
        $om = new Order_model();
        $sm = new Status_model();
        $olm = new Order_log_model();
        $os = $om->find_all();
        for($i=0;$i<count($os);$i++){
            $os[$i]['order_type'] = get_label('vl_order_type',$os[$i]['order_type']);
            $os[$i]['category'] = get_label('vl_order_category',$os[$i]['category']);
            $os[$i]['status'] = $sm->get_label($os[$i]['status']);
            $os[$i]['severity'] = get_label('vl_severity',$os[$i]['severity']);
            $os[$i]['content'] = $om->first_content($os[$i]['id']);
            $os[$i]['managed_by'] = $os[$i]['manager_id'];
            $os[$i]['delay_flag'] = 0;
            if(!is_null($os[$i]['plan_complete_date']) && $os[$i]['plan_complete_date'] < time()){
                $os[$i]['delay_flag'] = 1;
            }
            $os[$i]['plan_date_count'] = $olm->count_by_view(array('field_name'=>'plan_complete_date','dll_type'=>'update'));
        }
        $data['objects'] = _format($os);
		render($data);
	}

    //在创建之前做选择
    function choose_create(){
        $a = new Auth_model();
        //能够创建的订单列表
        $rows = $a->can_create_order_types();
        if(empty($rows)){
            //不能创建任何投诉订单，提示账号未被授权
            echo '不能创建任何投诉订单，账号未被授权';
        }elseif(count($rows) > 1){
            $data['objects'] = $rows;
            //同时拥有几种订单的创建权限，显示选择页
            render_view('order/choose_create',$data);

        }else{
            //一种时，直接跳转
//            redirect(_url('order','create',array('type'=>$rows[0])));
            $_GET['type'] = $rows[0];
            $this->create();
        }

    }

    function create(){
        $order = new Order_model();
        if($_POST){
            //非分类管理，默认分类设置时可默认
            if(!_config('category_control')){
                $c = $order->default_category(v('order_type'));
                if(!is_null($c)){
                    $_POST['category'] = $c['value'];
                }
            }
            $_POST['status'] = $order->default_status();
            //验证提交
            //权限
            if(check_order_auth(v('order_type'),v('status'),v('category'))){
                $data = _data('order_type','category','severity','frequency',
                    'title','contact','phone_number','mobile_telephone','address','full_name','status');
                $content = r(v('content'));
                $addfiles = tpost('addfiles');
                $order_id = $order->save($data,$content,$addfiles);
                if($order_id){
                    message_db_success();
                    redirect_to('order','show',array('id'=>$order_id));
                }else{
                    validation_error();
                }
            }else{
                message_unknow_error();
            }
        }else{
            //获取订单类型，如果没有则跳转到chose_create
            $order_type = tget('type');
            $data['order_type'] = $order_type;
            if(_config('category_control')){
                $au = new Auth_model();
                $data['categories'] = $au->can_choose_order_categories($order_type,$order->default_status());
            }

            if(is_null($order_type)){
                $this->choose_create();
            }else{
                render($data);
            }
        }

    }

    function show(){
        $id = p('id');
        $om = new Order_model();
        $order = $om->find($id);
        //id是否有效
        if(!empty($order)){
            //是否只能看到自己的订单
            $am = new Auth_model();
            if($am->check_auth('only_mine_control',array('ao_true_or_false'=>'TRUE')) && $order['created_by'] != _sess('uid')){
                show_404();
            }else{
                $this->load->model('status_model');
                $this->load->model('order_addfile_model');
                $this->load->model('order_content_model');
                $ocm = new Order_content_model();
                $oam = new Order_addfile_model();
                $sm = new Status_model();
                $ocm->order_by('creation_date');
                $order['contents'] = $ocm->find_all_by(array('order_id'=>$id));
                $oam->order_by('creation_date');
                $order['addfiles'] = $oam->find_all_by_view(array('order_id'=>$id));
                $order['status_desc'] = $sm->get_label($order['status']);
                $order['logs'] = _format($om->logs($id));
                render(_format_row($order));
            }
        }else{
            show_404();
        }
    }

    //如果日志类型需要原因，此页面用于补充
    function change_reason(){
        $this->load->model('order_log_model');
        $olm = new Order_log_model();
        $change_hash = v('change_hash');
        $l = $olm->find_by(array('change_hash'=>$change_hash));
        if(empty($l)){
            show_404();
        }else{
            if($_POST){
                $reason = tpost('reason');
                if($olm->update_by(array('change_hash'=>$change_hash),array('reason'=>$reason))){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                render();
            }
        }
    }

    function confirm(){
        //默认更新下一个状态
        $this->_update(v('id'),array('status'=>'confirmed'));
    }

    function upload_file(){
        if($_FILES){
            $this->load->library('upload', load_upload_config());
            print_r(load_upload_config());
            if ( ! $this->upload->do_upload())
            {
                echo $this->upload->display_errors();
            }
            else
            {
                $this->load->model('file_model');
                $fm = new File_model();
                if($fm->insert($this->upload->data())){
                    print_r($this->upload->data());
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }
        }else{
            render();
        }
    }

    //分配任务，制定负责人，计划完成时间
    function dispatcher(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        if(empty($order)){
            show_404();
        }else{
            if($_POST){
                $_POST['plan_complete_date'] = strtotime($_POST['plan_complete_date']);
                $data = _data('manager_id','plan_complete_date');
                $data['status'] = 'allocated';
                $this->_update(v('id'),$data);
            }else{
                $am = new Auth_model();
                $order['ids'] = $am->can_choose_managers($order);
                if(empty($order['ids'])){
                    echo '无对应的责任人';
                }else{
                    render(_format_row($order));
                }
            }

        }


    }

    //已解决
    function done(){
        $this->_update(v('id'),array('status'=>'done'));
    }

    function reply(){
        $om = new Order_model();
        $id = v('id');
        $order = $om->find($id);
        if(empty($order)){
            show_404();
        }else{
            if($_POST){
                $this->load->model('order_content_model');
                $ocm = new Order_content_model();
                $data['content'] = tpost('content');
                $data['order_id'] = $id;
                if($ocm->insert($data)){
                    redirect(_url('order','show',array('id'=>$id)));
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                shoe_404();
            }

        }
    }

    //关闭
    function close(){
        $this->load->model('notice_model');
        $om = new Order_model();
        $id = v('id');
        $order = $om->find($id);
        if(empty($order)){
            show_404();
        }else{
            $this->_update($order['id'],array('status'=>'closed'));
            //关闭之后发送反馈信息给创建人填写
            $nm = new Notice_model();
            $data['order_id'] = $order['id'];
            $data['with_manager'] = 0;
            $data['received_by'] = $order['created_by'];
            $data['title'] = '关于投诉单'.$data['order_id'].'的反馈';
            $data['direct_url'] = _url('order','feedback',array('id'=>$data['order_id'] ));
            $nm->insert($data);

        }
    }

    //问题重新开启
    function reopen(){
        $om = new Order_model();
        $id = v('id');
        $order = $om->find($id);
        if(empty($order)){
            show_404();
        }else{
            $this->_update(v('id'),array('status'=>'reopen'));
        }
    }

    //责任人资料
    function manager_info(){
        //符合当前订单处理权限的责任人列表
        //责任人姓名、联系方式、当前待处理订单数量
    }

    function change_content(){
        //提交后5分钟内可以修改自己刚提交的内容，提高用户体验
    }

    //用户反馈
    function feedback(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        if(empty($order)){
            show_404();
        }else{
            if($_POST){

            }else{
                $data['stars'] = get_options('vl_feedback');
                render($data);
            }
        }
    }

    function feedback_show(){
        $this->load->model('feedback_model');
        $fm = new Feedback_model();
        $f = $fm->find(v('id'));
        if(empty($f)){
            show_404();
        }else{
            $this->load->model('feedback_star_model');
            $fsm = new Feedback_star_model();
            $f['stars'] = $fsm->find_all_by(array('feedback_id'=>$f['id']));
            render($f);
        }
    }

    private function _update($id,$data = null){
        $om = new Order_model();
        $order = $om->find($id);
        //id是否有效
        if(!empty($order)){
            //先判断订单状态流是否允许更改,判断是否有权限更改次状态
            if(is_order_allow_next_status($order['status'],$data['status']) && check_order_auth($order['order_type'],$data['status'],$order['category'])){
                if($om->do_update($order['id'],$data)){
                    echo 'done';
                }else{
                    echo validation_errors('<div class="error">', '</div>');
                }
            }else{
                echo '不允许状态流向！';
            }
        }else{
            show_404();
        }
    }

}