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
        $am = new Auth_model();
        $data['order_types'] = $am->can_show_order_types();
        $data['status'] = array();
        $this->load->model('status_line_model');
        $sm = new Status_model();
        $status_codes = array();
        foreach($data['order_types']  as $t){
            array_push($status_codes,default_value('status',$t)) ;
        }

        foreach($sm->options($status_codes) as $l){
            array_push($data['status'],$l);
        }
        render($data);
	}

    function order_data(){
        $this->load->model('status_model');
        $this->load->model('order_log_model');
        $om = new Order_model();
        $sm = new Status_model();
        $olm = new Order_log_model();
        $am = new Auth_model();

        $start = 0;
        $end = 0 ;

//        print_r($where);
        if(isset($_SERVER['HTTP_RANGE'])){
            $idx = stripos($_SERVER['HTTP_RANGE'],'-');
            $start = intval(substr($_SERVER['HTTP_RANGE'],6,$idx-6));
            $end = intval(substr($_SERVER['HTTP_RANGE'],$idx+1));
        }

        if(v('order_type')){
            $types = array(v('order_type'));
        }else{
            $types = $am->can_show_order_types();
        }

        $title = $this->input->get('title');
        $status = $this->input->get('status');

        //获取数据
        if($am->check_auth('only_mine_control',array('ao_true_or_false'=>'TRUE'))){
            $om->limit($end+1,$start);
            $om->order_by('id','DESC');

            //与自己相关的用户id字段
            $this->db->where('(created_by = '._sess('uid').' OR leader_id = '._sess('uid').' OR manager_id = '._sess('uid').')');
//            $this->db->or_where('leader_id',_sess('uid'));
//            $this->db->or_where('manager_id',_sess('uid'));

            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);

            //fix ：Error in Body._buildRowContent: Row is not in cache
            if($title){
                $this->db->like('title',$title);
            }
            if($status){
                $this->db->where('status',$status) ;
            }

            $os = $om->find_all();

            //与自己相关的用户id字段
            $this->db->where('(created_by = '._sess('uid').' OR leader_id = '._sess('uid').' OR manager_id = '._sess('uid').')');

            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);

            //fix ：Error in Body._buildRowContent: Row is not in cache
            if($title){
                $this->db->like('title',$title);
            }
            if($status){
                $this->db->where('status',$status) ;
            }
            $totalCnt = $om->count_by();
        }else{
            $om->limit($end+1,$start);

            if($title){
                $this->db->like('title',$title);
            }

            if($status){
                $this->db->where('status',$status) ;
            }

            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);
            $om->order_by('id','DESC');
            $os = $om->find_all();

            if($title){
                $this->db->like('title',$title);
            }
            if($status){
                $this->db->where('status',$status) ;
            }
            //获取允许查看的订单类型
            $this->db->where_in('order_type',$types);
            $totalCnt = $om->count_by();
        }
//        print_r($os);

        $os = _format($os);
        for($i=0;$i<count($os);$i++){
            $os[$i]['category'] = get_label('vl_order_category',$os[$i]['category'],$os[$i]['order_type']);
            $os[$i]['status'] = $sm->get_label(default_value('status',$os[$i]['order_type']),$os[$i]['status']);
            $os[$i]['severity'] = get_label('vl_severity',$os[$i]['severity']);
            $os[$i]['content'] = word_truncate(t($om->first_content($os[$i]['id'])),10);
            $os[$i]['managed_by'] = $os[$i]['manager_id'];
            $os[$i]['delay_flag'] = 0;
            if(!is_null($os[$i]['plan_complete_date']) && $os[$i]['plan_complete_date'] < time()){
                $os[$i]['delay_flag'] = 1;
            }
            $os[$i]['plan_date_count'] = $olm->count_by_view(array('field_name'=>'plan_complete_date','dll_type'=>'update'));
            $os[$i]['order_type'] = get_label('vl_order_type',$os[$i]['order_type']);
        }

        $data["identifier"] = 'id';
        $data["label"] = 'title';
        $data['items'] = $os;
        $output = $data;

        if(isset($_SERVER['HTTP_RANGE'])){
//                    header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.round($totalCnt/($end+1)));
            header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.$totalCnt);
            $output = $data['items'];
        }
        echo json_encode($output);
    }

    //在创建之前做选择
    function choose_create(){
        $a = new Auth_model();
        //能够创建的订单列表
        $rows = $a->can_create_order_types();
        if(empty($rows)){
            //不能创建任何投诉订单，提示账号未被授权
            render_error('不能创建任何投诉订单，账号未被授权') ;
        }elseif(count($rows) > 1){
            $data['objects'] = $rows;
            //同时拥有几种订单的创建权限，显示选择页
            render_view('order/choose_create',$data);

        }else{
            //一种时，直接跳转
//            redirect(_url('order','create',array('type'=>$rows[0])));
            $_GET['order_type'] = $rows[0];
            $this->create();
        }

    }

    function create(){
        $order = new Order_model();
        $order_type = v('order_type');
        if($_POST){
            //非分类管理，默认分类设置时可默认
            if(!_config('category_control')){
                $c = $order->default_category($order_type);
                if(!is_null($c)){
                    $_POST['category'] = $c['value'];
                }
            }
            $_POST['status'] = $order->default_status($order_type);
            //验证提交
            //权限
            if(check_order_auth($order_type,v('status'),v('category'))){
                $data = _data('order_type','category','severity','frequency',
                    'title','contact','phone_number','mobile_telephone','address','full_name','status');
                $content = r(v('content'));
                $addfiles = tpost('addfiles');
                $order_id = $order->save($data,$content,$addfiles);
                if($order_id){
                    //如果同时拥有提交和确认权限，则自动确认
                    if(check_order_auth($order_type,'confirmed',v('category'))){
                        $order->confirm($order_id);
                    }else{
                        message_db_success();
                    }
                    redirect_to('order','show',array('id'=>$order_id));
                }else{
                    validation_error();
                }
            }else{
                message_unknow_error();
            }
        }else{
            //获取订单类型，如果没有则跳转到chose_create
            if(!$order_type){
                $this->choose_create();
            }else{
                $this->db->distinct();
                $this->db->select('contact,mobile_telephone,full_name,address,phone_number ');
                $order->order_by('creation_date','DESC');
                $os = $order->find_all_by(array('created_by'=>_sess('uid')));
                if(!empty($os)){
                    $data['contact_data'] = json_encode($os);
                }

                if(_config('category_control')){
                    $au = new Auth_model();
                    $data['categories'] = $au->can_choose_order_categories($order_type,$order->default_status($order_type));
                }
                $data['order_type'] = $order_type;
                render_view('order/create',$data);
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
            $pass = true;
            if($am->check_auth('only_mine_control',array('ao_true_or_false'=>'TRUE')) ){
                if($order['created_by'] == _sess('uid') || $order['leader_id'] == _sess('uid') || $order['manager_id'] == _sess('uid')){
                    $pass = true;
                }else{
                    $pass = false;
                }
            }
            //检验通过
            if($pass){
                $this->load->model('status_model');
                $this->load->model('order_addfile_model');
                $this->load->model('order_content_model');
                $ocm = new Order_content_model();
                $oam = new Order_addfile_model();
                $sm = new Status_model();
                $ocm->order_by('creation_date');
                $order['contents'] = _format($ocm->find_all_by(array('order_id'=>$id)));
                $oam->order_by('creation_date');
                $order['addfiles'] = $oam->find_all_by_view(array('order_id'=>$id));
                $order['status_desc'] = $sm->get_label(default_value('status',$order['order_type']),$order['status']);
                render(_format_row($order));
            }
        }else{
            show_404();
        }
    }

    function log_data(){
        $om = new Order_model();
        export_to_itemStore($om->logs(v('id')),'id','log_type',check_auth('log_display_fullname',array('ao_true_or_false'=>'TRUE'))) ;
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
                $reason = v('reason');
                if($olm->update_by(array('change_hash'=>$change_hash),array('reason'=>$reason))){
                    message_db_success();
                }else{
//                    message_db_failure();
                    validation_error();
                }
            }else{
                render();
            }
        }
    }

    function confirm(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        //默认更新下一个状态
        $data['status'] = 'confirmed';
        //id是否有效
        if(!empty($order)){;
            $om->confirm($order['id']);
        }
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

    //选择责任人（部门经理）
    function choose_leader(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        if(empty($order)){
            show_404();
        }else{
            if($_POST){
                $data['leader_id'] = v('leader_id');
                if($om->do_update($order['id'],$data)){
                    go_back();
                    message_db_success();
                }else{
                    message_db_failure();
                }
            }else{
                $am = new Auth_model();
                $ids = $am->can_choose_leaders($order);
                if(empty($ids)){
                    render_error('无对应的负责人');
                }else{
                    $order['leaders'] = array();
                    foreach($ids as $id){
                        $d['value'] = $id;
                        //可以做进一步的优化，比如根据责任人的繁忙程度排序，显示现在空闲的责任人等

                        $d['label'] = full_name($id);
                        array_push($order['leaders'],$d);
                    }
                    render($order);
                }
            }

        }
    }

    //分配任务，指定处理人
    function dispatcher(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        if(empty($order)){
            show_404();
        }else{
            if($_POST){
                $data = _data('manager_id');
                $this->_update(v('id'),$data);
            }else{
                $am = new Auth_model();
                $ids = $am->can_choose_managers($order);
                if(empty($ids)){
                    render_error('无对应的责任人');
                }else{
                    $order['managers'] = array();
                    foreach($ids as $id){
                        $d['value'] = $id;
                        //可以做进一步的优化，比如根据责任人的繁忙程度排序，显示现在空闲的责任人等

                        $d['label'] = full_name($id);
                        array_push($order['managers'],$d);
                    }
                    render($order);
                }
            }

        }


    }

    function pcd_change(){
        $om = new Order_model();
        $order = $om->find(v('id'));
        if(empty($order)){
            show_404();
        }else{
            if($order['pcd_change_times'] < _config('pcd_change_times')){
                if($_POST){

                    //格式化提交的日期
                    $_POST['plan_complete_date'] = str_replace('T',' ',$_POST['plan_complete_date'] . $_POST['plan_complete_time']);

                    $_POST['plan_complete_date'] = strtotime($_POST['plan_complete_date']);
                    if($_POST['plan_complete_date'] < time()){
                        add_validation_error('plan_complete_date','不能选择在过去的时间');
                        add_validation_error('plan_complete_time','');
                    }else{
                        $data = _data('plan_complete_date');
                        $data['pcd_change_times'] = $order['pcd_change_times'] + 1;
                        if($om->do_update($order['id'],$data,true)){
                            go_back();
                            message_db_success();
                        }else{
                            message_db_failure();
                        }
                    }

                }else{
                    if(is_null($order['plan_complete_date']) || !$order['plan_complete_date']){
                        $order['plan_complete_date'] = date('Y-m-d',time());
                    }else{
                        $order['plan_complete_date'] = date('Y-m-d H:m:s',$order['plan_complete_date']);
                        $order['plan_complete_time'] = 'T'.substr($order['plan_complete_date'],11,9);
                        $order['plan_complete_date'] = substr($order['plan_complete_date'],0,10);
                    }
                    render($order);
                }
            }else{
                render_error('无法继续修改计划完成日期，已超出允许修改次数！');
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
                $data['content'] = r(v('content'));
                $data['order_id'] = $id;
                $content_id = $ocm->insert($data);
                if($content_id){
                    message_db_success();
                    $r = _format_row($ocm->find($content_id));
                    $r['created_by'] = full_name($r['created_by']);
                    data('content',$r);
                    //回复之后发送消息到相关人员



                }else{
                    validation_error();
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
            if(_config('feedback_control')){
                $nm = new Notice_model();
                $data['order_id'] = $order['id'];
                $data['with_manager'] = 0;
                $data['received_by'] = $order['created_by'];
                $data['title'] = '关于投诉单'.$data['order_id'].'的反馈';
                $data['direct_url'] = _url('order','feedback',array('id'=>$data['order_id'] ));
                $notice_id = $nm->insert($data);
                if($notice_id){
                    $om->send_mail_by_notice($notice_id);
                }else{
                    custz_message('E','反馈消息传送失败，请您'.
                        render_link(array('order','feedback',array('id'=>$data['order_id'] )),'点击此链接').'进行本次投诉的反馈！');
                }
            }

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
            if(_config('allow_reopen') ){
                $this->_update(v('id'),array('status'=>'reopen'));
            }else{
                render_error('不允许重新打开投诉单！');
            }
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
        if(_config('feedback')){
            $om = new Order_model();
            $order = $om->find(v('id'));
            if(empty($order)){
                show_404();
            }else{
                $this->load->model('feedback_model');
                $this->load->model('feedback_star_model');
                $this->load->model('valuelist_line_model');
                $ofm = new Feedback_model();
                $fsm = new Feedback_star_model();
                $vlm = new Valuelist_line_model();
                if($order['created_by'] == _sess('uid')){
                    if(is_order_locked($order['status'])){
                        if($_POST){
                            if(v('feedback_id')){
                                //修改
                                $line = $ofm->find(v('feedback_id'));
                                if(empty($line)){
                                    message_db_failure();
                                }else{
                                    $this->db->trans_start();
                                    $feedback['content'] = v('content_plus');
                                    $stars = $fsm->find_all_by(array('feedback_id'=>$line['id']));
                                    $ofm->update($line['id'],$feedback);
                                    foreach($stars as $star){
                                        $s['stars'] = v('star_'.$star['feedback_type']);
                                        $fsm->update($star['id'],$s);
                                    }
                                    $this->db->trans_complete();
                                    if($this->db->trans_status() === TRUE){
                                        go_back();
                                        message_db_success();
                                    }else{
                                        message_db_failure();
                                    }
                                }

                            }else{
                                //判断是否存在
                                $line = $ofm->find_by(array('order_id'=>v('id')));
                                if(empty($line)){
                                    //创建
                                    $vlm->order_by('sort');
                                    $stars = $vlm->find_all_by_view(array('valuelist_name'=>'vl_feedback','inactive_flag'=>0));
                                    $this->db->trans_start();
                                    $feedback['order_id'] = v('id');
                                    $feedback['content'] = v('content_plus');
                                    $feedback_id = $ofm->insert($feedback);
                                    foreach($stars as $star){
                                        $s['feedback_id'] = $feedback_id;
                                        $s['feedback_type'] = $star['segment_value'];
                                        $s['feedback_desc'] = $star['segment_desc'];
                                        $s['stars'] = v('star_'.$star['segment_value']);
                                        $fsm->insert($s);
                                    }
                                    $this->db->trans_complete();
                                    if($this->db->trans_status() === TRUE){
                                        go_back();
                                        message_db_success();
                                    }else{
                                        message_db_failure();
                                    }
                                }else{
                                    custz_message('E','订单已反馈请勿重复提交！');
                                }


                            }
                        }else{
                            $o = $ofm->find_by(array('order_id'=>$order['id']));
                            if(empty($o)){
                                $vlm->order_by('sort');
                                $data['stars'] = $vlm->find_all_by_view(array('valuelist_name'=>'vl_feedback','inactive_flag'=>0));
                                for($i=0;$i<count($data['stars']);$i++){
                                    $data['stars'][$i]['value'] = _config('feedback_star');
                                }
                                render_view('order/feedback_create',$data);
                            }else{
                                $o['stars'] = $fsm->find_all_by(array('feedback_id'=>$o['id']));
                                $o['content_plus'] = $o['content'];
                                render_view('order/feedback_edit',$o);
                            }
                        }
                    }else{
                        show_404();
                    }
                }else{
                    $o = $ofm->find_by(array('order_id'=>$order['id']));
                    if(!empty($o)){
                        $o['stars'] = $fsm->find_all_by(array('feedback_id'=>$o['id']));
                        render_view('order/feedback_show',$o);
                    }else{
                        render_view('order/feedback_show');
                    }

                }
            }
        }else{
            render_error('必须先开启反馈功能！请联系系统管理员！') ;
        }

    }

    private function _update($id,$data = null){
        $om = new Order_model();
        $order = $om->find($id);
        //id是否有效
        if(!empty($order)){
            //先判断订单状态流是否允许更改,判断是否有权限更改次状态
            if(is_order_allow_next_status($order['order_type'],$order['status'],$data['status']) && check_order_auth($order['order_type'],$data['status'],$order['category'])){
                if($om->do_update($order['id'],$data)){
                    message_db_success();
                }else{
                    validation_error();
                }
            }else{
                custz_message('E','不允许状态流向！');
            }
        }else{
            show_404();
        }
    }

}