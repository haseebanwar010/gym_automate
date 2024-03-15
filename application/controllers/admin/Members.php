<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('members_model');
        $this->load->model('dashboard_model');
        if(check_permission('members_access')){
        }else{
            redirect('admin/restricted');
        }
    }
	public function index( $msg = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $gymsettings=getSystemsettings($_SESSION['userid']);
        $data=array();
        $data['page'] = 'members';
        $data['gym_detail']=$this->members_model->get_gym_detail($this->session->userdata('userid'));
        if($this->input->post('id')){
            $data['members'] = $this->members_model->get_all_members($this->input->post('id'));
        }
        else if(isset($_GET['status']) && $_GET['status']!="all"){
            $data['members'] = $this->dashboard_model->get_members();
        }
		else{
            $data['members'] = $this->members_model->get_all_members();
        }
        if(isset($_GET['status']) && $_GET['status']!=""){$filtertype=$_GET['status'];} else{$filtertype="all";}
        $memberstosend=array();
        for($i=0;$i<sizeof($data['members']);$i++){
            $memberfeesdetail=unserialize($data['members'][$i]['fees_detail']);
            $feedate=date("m-d-Y",$data['members'][$i]['fee_date']);
            $feemonth=date("M",$data['members'][$i]['fee_date']);
            $last_day_this_month  = date('m-t-Y');
            $feedate=$data['members'][$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+".$gymsettings[0]['fees_limit']." days", $feedate); //adding days that is set in gym settings table 
            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-".$gymsettings[0]['sms_limit']." days", $feedate);  // adding upcoming fees days limit set in settings table
            $feetime=date('Y-M-d',$feedate);
			$cmonth=date('M');
            $fmonth=date('M',$feedate);
            $cmonthday=date('d');
            $fmonthday=date('d',$feedate);
				if($cmonth==$fmonth){
                    if($fmonthday<$cmonthday){
						$data['members'][$i]['currentmonthstatus']="pending";
                    }
                    else{
                        $data['members'][$i]['currentmonthstatus']="paid";
                    }
				}
            else{
                if($data['members'][$i]['status']==1){
                    $data['members'][$i]['currentmonthstatus']="paid";
                }
            }
            if($data['members'][$i]['package']!="" && $data['members'][$i]['package']!="custom"){
                $package=$this->members_model->get_packages($data['members'][$i]['package']);
                if(!empty($package[0])){
                    $data['members'][$i]['packagedetail']=$package[0];
                }
                else{
                    $data['members'][$i]['packagedetail']="";
                }
            }
            if($filtertype=="paid" && (isset($data['members'][$i]['currentmonthstatus']) && $data['members'][$i]['currentmonthstatus']=="paid")){
                $memberstosend[]=$data['members'][$i];
            }
            elseif($filtertype=="pending" && (isset($data['members'][$i]['currentmonthstatus']) && $data['members'][$i]['currentmonthstatus']=="pending")){
                $memberstosend[]=$data['members'][$i];
            }
            elseif($filtertype=="all"){
                $memberstosend[]=$data['members'][$i];
            }
        }
        $data['members']=$memberstosend;
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/members/index', $data);
			$this->load->view('admin/templates/footer', $data);
        }
	}
    
	public function add($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $data['page'] = 'addmember';
        $data['gym_detail']=$this->members_model->get_gym_detail($this->session->userdata('userid'));
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|callback_validate_phonenumber');
        $this->form_validation->set_message('validate_phonenumber', 'Please enter a valid phone number');
        $this->form_validation->set_rules('body_weight', 'Body Weight', 'numeric');
        $this->form_validation->set_rules('height', 'Height', 'numeric');
        if(isset($_POST['package']) && $_POST['package']=="custom"){
            $this->form_validation->set_rules('fees', 'Fees', 'required|numeric');
            $this->form_validation->set_rules('admission_fees', 'Admission Fees', 'required|numeric');
        }
        $this->form_validation->set_rules('package', 'Package', 'required');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
        $packages=$this->members_model->get_packages();
        $trainers=$this->members_model->get_trainers();
        $data['packages']=$packages;
        $data['trainers']=$trainers;
        if ($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/members/add', $data);
            $this->load->view('admin/templates/footer');
        }
        else{
            $validate=$this->members_model->uservalidate();
            $phone = $this->input->post('phone');
            $firstone=substr($phone, 0, 1);
            $firsttwo=substr($phone, 0, 2);
            if($firstone==0){
                $remaining=substr($phone,1);                
                $remaining="92".$remaining;
            }
            elseif ($firsttwo==92){
                $remaining=$phone;
            }
            if(empty($validate)) {
                $imagename='';
                if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
                    $new_name = time() . $_FILES["image"]['name'];
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = "./uploads/";
                    $config['allowed_types'] = "gif|jpg|jpeg|png";
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image')) {
                        $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                        redirect('members');
                    } else{
                        $finfo = $this->upload->data();
                        $this->createThumbnail($finfo['file_name']);
                        $imagename=$finfo['file_name'];  
                    }
                }
                $feesneedtoadd=0;
                $dateneedtoadd="";
                if($_POST['package']>0){
                    $packagedetail=$this->members_model->get_packages($_POST['package']);
                    if(!empty($packagedetail)){
                        $feesneedtoadd=$packagedetail[0]['fees']+$packagedetail[0]['admission_fees'];
                    }
                }
                else{
                    $feesneedtoadd=$_POST['fees']+$_POST['admission_fees'];
                }
                $dateneedtoadd=date('Y-m-1',strtotime($this->input->post('joining_date')));
                setincometomonth($dateneedtoadd,$feesneedtoadd);
                $insertedrecord=$this->members_model->set_member($imagename);
                if(!empty($insertedrecord)){
                    $title="New Member Registered";
                    $msg="New member (".$insertedrecord[0]['name'].") has been registered successfully to ". $_SESSION['username'].". ".date('d-M-Y')." ".date('h:i A');
                    sendpushnotification($title,$msg);
                    $todayslog=$this->members_model->get_todayslog();
                    $logdetails=array();
                    $logdetails['member_id']=$insertedrecord[0]['id'];
                    $logdetails['admin_name']=$this->session->userdata('username');
                    $logdetails['member_name']=$this->input->post('name');
                    $logdetails['log_type']='add_member';
                    $logdetails['date']=date('d-M-Y');
                    $logdetails['time']=date("H:i:s");
                    $logdate=date('Y-m-d');
                    if(empty($todayslog)){
                        $serialized_log=array();
                        $serialized_log[0]=$logdetails;
                        $serialized_log=serialize($serialized_log);
                        $this->members_model->add_log($logdate,$serialized_log);
                    }
                    else{
                        $prev_logs=unserialize($todayslog['log_details']);
                        $serialized_log=array();
                        $serialized_log[0]=$logdetails;
                        foreach($prev_logs as $log){
                            $serialized_log[]=$log;
                        }
                        $serialized_log=serialize($serialized_log);
                        $this->members_model->update_log($serialized_log,$todayslog['id']);
                    }
                }
                $this->session->set_flashdata('msg', 'Member Added Successfully!');
                $this->session->set_flashdata('insertedrecord', $insertedrecord);
                $data['insertedrecord']=$insertedrecord;
                redirect('members');
            }
            else{
                for($i=0;$i<sizeof($validate);$i++){
                    if($validate[$i]['package']!="" && $validate[$i]['package']!="custom"){
                        $package=$this->members_model->get_packages($validate[$i]['package']);
                        $validate[$i]['packagedetail']=$package[0];
                    }
                }
                $data['validateduser']=$validate;
                $data['alreadyerror']="Sorry the person already exists with same email,phone or cnic.";
                $this->load->view('admin/templates/header');
                $this->load->view('admin/templates/sidebar', $data);
                $this->load->view('admin/members/add', $data);
                $this->load->view('admin/templates/footer');
            }
        }
    }
    public function payfee(){
        $baseurl=$this->config->item('base_url');
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        if($this->dashboard_model->payfee()){
            $title="Fees Paid";
            $msg=$this->input->post('name')." has paid his/her fees ".$this->session->userdata('currency_symbol').$this->input->post('fees')." to ".$this->session->userdata('username')." on ".date('d-M-Y')." ".date('h:i A');
            sendpushnotification($title,$msg);
            $memberdetail=$this->members_model->get_all_members($this->input->post('id'));
            if(!empty($memberdetail)){
                if($memberdetail[0]['trainer_id']!=0 || $memberdetail[0]['trainer_id']!=null){
                    $trainerdetail=get_trainer_byid($memberdetail[0]['trainer_id']);
                    if(!empty($trainerdetail)){
                        $pendingamount_toadd=($memberdetail[0]['training_fees']*$memberdetail[0]['commission_percentage'])/100;
                        add_pendingpayment_staffmember($memberdetail[0]['trainer_id'],$pendingamount_toadd,$this->session->userdata('userid'));
                    }
                }
            }
            $todayslog=$this->members_model->get_todayslog();
            $logdetails=array();
            $logdetails['member_id']=$this->input->post('id');
            $logdetails['admin_name']=$this->session->userdata('username');
            $logdetails['member_name']=$this->input->post('name');
            $logdetails['currency_symbol']=$this->session->userdata('currency_symbol');
            $logdetails['feee_amount']=$this->input->post('fees');
            $logdetails['log_type']='payfee';
            $logdetails['date']=date('d-M-Y');
            $logdetails['time']=date("H:i:s");
            $logdate=date('Y-m-d');
            if(empty($todayslog)){
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                $serialized_log=serialize($serialized_log);
                $this->members_model->add_log($logdate,$serialized_log);
            }
            else{
                $prev_logs=unserialize($todayslog['log_details']);
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                foreach($prev_logs as $log){
                    $serialized_log[]=$log;
                }
                $serialized_log=serialize($serialized_log);
                $this->members_model->update_log($serialized_log,$todayslog['id']);     
            }
            redirect('admin/members/view/'.$this->input->post('id').'/print');
            $data=array();
            $data['memberdetail']=$this->dashboard_model->getmemberbyid($this->input->post('id'));
            $data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']);
            $data['feepostdata']['fees']=$this->input->post('fees');
            $data['feepostdata']['comment']=$this->input->post('comment');
            $data['feepostdata']['payment_date']=$this->input->post('payment_date');
            ini_set('memory_limit', '256M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $a = '';
            for ($i = 0; $i<8; $i++){
                $a .= mt_rand(0,9);
            }
            $data['invoice_number'] = $a."-".time();
            $html=  $this->load->view('admin/feeinvoice', $data, true);
            $pdf->WriteHTML($html);

            $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
        }
    }
    
    public function edit($id = NULL){
        $baseurl=$this->config->item('base_url');
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $data['page'] = 'editmember';
        $data['member'] = $this->members_model->get_all_members($id);
		$this->load->helper('form');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
        $this->form_validation->set_rules('body_weight', 'Body Weight', 'numeric');
        $this->form_validation->set_rules('height', 'Height', 'numeric');
        if(isset($_POST['package']) && $_POST['package']=="custom"){
            $this->form_validation->set_rules('fees', 'Fees', 'required|numeric');
        }
        $packages=$this->members_model->get_packages();
        $trainers=$this->members_model->get_trainers();
        $data['packages']=$packages;
        $data['trainers']=$trainers;
		if($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/members/edit', $data);
            $this->load->view('admin/templates/footer');
        }
        else{
            $phone = $this->input->post('phone');
            $firstone=substr($phone, 0, 1);
            $firsttwo=substr($phone, 0, 2);
            if($firstone==0){
                $remaining=substr($phone,1);
                $remaining="92".$remaining;
            }
            elseif ($firsttwo==92){
                $remaining=substr($phone,2);
            }
            else{
                $this->session->set_flashdata('phoneerror', 'Please enter a proper phone number!');
                redirect('admin/members/edit/'.$id);
            }
            $image="";
            if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
                $new_name = time().$_FILES["image"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path']   =   "./uploads/";
                $config['allowed_types'] =   "gif|jpg|jpeg|png";
                $this->load->library('upload',$config);
                if(!$this->upload->do_upload('image')){
                    $this->session->set_flashdata('error_msg',$this->upload->display_errors());
                    redirect('members');
                }
                else{
                    $finfo=$this->upload->data();
                    $this->createThumbnail($finfo['file_name']);
                    $image=$finfo['file_name'];
                }
            }
            if($this->members_model->update_member($image)){
                $todayslog=$this->members_model->get_todayslog();
                $logdetails=array();
                $logdetails['member_id']=$this->input->post('id');
                $logdetails['admin_name']=$this->session->userdata('username');
                $logdetails['member_name']=$this->input->post('name');
                $logdetails['log_type']='edit_member';
                $logdetails['date']=date('d-M-Y');
                $logdetails['time']=date("H:i:s");
                $logdate=date('Y-m-d');
                if(empty($todayslog)){
                    $serialized_log=array();
                    $serialized_log[0]=$logdetails;
                    $serialized_log=serialize($serialized_log);
                    $this->members_model->add_log($logdate,$serialized_log);
                }
                else{
                    $prev_logs=unserialize($todayslog['log_details']);
                    $serialized_log=array();
                    $serialized_log[0]=$logdetails;
                    foreach($prev_logs as $log){
                        $serialized_log[]=$log;
                    }
                    $serialized_log=serialize($serialized_log);
                    $this->members_model->update_log($serialized_log,$todayslog['id']);    
                }
            }
            $this->session->set_flashdata('msg', 'Member Information is updated Successfully!');
            redirect('members');
        }
    }
    public function delete($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $memberdetail=$this->members_model->get_all_members($id);
        if($this->members_model->delete_member($id)){
            $todayslog=$this->members_model->get_todayslog();
            $logdetails=array();
            $logdetails['admin_name']=$this->session->userdata('username');
            $logdetails['member_name']=$memberdetail[0]['name'];
            $logdetails['log_type']='delete_member';
            $logdetails['date']=date('d-M-Y');
            $logdetails['time']=date("H:i:s");
            $logdate=date('Y-m-d');
            if(empty($todayslog)){
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                $serialized_log=serialize($serialized_log);
                $this->members_model->add_log($logdate,$serialized_log);
            }
            else{
                $prev_logs=unserialize($todayslog['log_details']);
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                foreach($prev_logs as $log){
                    $serialized_log[]=$log;
                }
                $serialized_log=serialize($serialized_log);
                $this->members_model->update_log($serialized_log,$todayslog['id']); 
            }
            $this->session->set_flashdata('msg', 'Member is deleted Successfully!');
            redirect('members');
        }
    }
    public function payinactivefee($id=NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        if($this->members_model->payinactivefee()){
            $title="Member Rejoined";
            $msg=$this->input->post('name')." has paid his/her fees ".$this->session->userdata('currency_symbol').$this->input->post('fees')." & rejoin to ".$this->session->userdata('username')." on ".date('d-M-Y')." ".date('h:i A');
            sendpushnotification($title,$msg);
            $memberdetail=$this->members_model->get_all_members($this->input->post('id'));
            if(!empty($memberdetail)){
                if($memberdetail[0]['trainer_id']!=0 || $memberdetail[0]['trainer_id']!=null){
                    $trainerdetail=get_trainer_byid($memberdetail[0]['trainer_id']);
                    if(!empty($trainerdetail)){
                        $pendingamount_toadd=($trainerdetail['training_fees']*$trainerdetail['commission_percentage'])/100;
                        add_pendingpayment_staffmember($memberdetail[0]['trainer_id'],$pendingamount_toadd,$this->session->userdata('userid'));
                    }
                }
            }
            $todayslog=$this->members_model->get_todayslog();
            $logdetails=array();
            $logdetails['member_id']=$this->input->post('id');
            $logdetails['admin_name']=$this->session->userdata('username');
            $logdetails['member_name']=$this->input->post('name');
            $logdetails['currency_symbol']=$this->session->userdata('currency_symbol');
            $logdetails['feee_amount']=$this->input->post('fees');
            $logdetails['log_type']='payfee_rejoin';
            $logdetails['date']=date('d-M-Y');
            $logdetails['time']=date("H:i:s");
            $logdate=date('Y-m-d');
            if(empty($todayslog)){
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                $serialized_log=serialize($serialized_log);
                $this->members_model->add_log($logdate,$serialized_log);
            }
            else{
                $prev_logs=unserialize($todayslog['log_details']);
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                foreach($prev_logs as $log){
                    $serialized_log[]=$log;
                }
                $serialized_log=serialize($serialized_log);
                $this->members_model->update_log($serialized_log,$todayslog['id']);      
            }
            redirect('admin/members/view/'.$this->input->post('id').'/print');
            $data=array();
            $data['memberdetail']=$this->dashboard_model->getmemberbyid($this->input->post('id'));
            $data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']);
            $data['feepostdata']['fees']=$this->input->post('fees');
            $data['feepostdata']['comment']=$this->input->post('comment');
            $data['feepostdata']['payment_date']=$this->input->post('payment_date');
            $dateneedtoadd=date('Y-m-1',strtotime($this->input->post('payment_date')));
            $feesneedtoadd=$this->input->post('fees');
            setincometomonth($dateneedtoadd,$feesneedtoadd);
            
            ini_set('memory_limit', '256M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $a = '';
            for ($i = 0; $i<8; $i++){
                $a .= mt_rand(0,9);
            }
            $data['invoice_number'] = $a."-".time();
            $html=  $this->load->view('admin/feeinvoice', $data, true);
            $pdf->WriteHTML($html);
            $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
        }
    }
    public function payrejoinfee($id=NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        if($this->members_model->payrejoinfee()){
            $title="Fees Paid";
            $msg=$this->input->post('name')." has paid his/her fees ".$this->session->userdata('currency_symbol').$this->input->post('fees')." to ".$this->session->userdata('username')." on ".date('d-M-Y')." ".date('h:i A');
            sendpushnotification($title,$msg);
            $memberdetail=$this->members_model->get_all_members($this->input->post('id'));
            if(!empty($memberdetail)){
                if($memberdetail[0]['trainer_id']!=0 || $memberdetail[0]['trainer_id']!=null){
                    $trainerdetail=get_trainer_byid($memberdetail[0]['trainer_id']);
                    if(!empty($trainerdetail)){
                        $pendingamount_toadd=($trainerdetail['training_fees']*$trainerdetail['commission_percentage'])/100;
                        add_pendingpayment_staffmember($memberdetail[0]['trainer_id'],$pendingamount_toadd,$this->session->userdata('userid'));
                    }
                }
            }
            $todayslog=$this->members_model->get_todayslog();
            $logdetails=array();
            $logdetails['member_id']=$this->input->post('id');
            $logdetails['admin_name']=$this->session->userdata('username');
            $logdetails['member_name']=$this->input->post('name');
            $logdetails['currency_symbol']=$this->session->userdata('currency_symbol');
            $logdetails['feee_amount']=$this->input->post('fees');
            $logdetails['log_type']='payfee_active';
            $logdetails['date']=date('d-M-Y');
            $logdetails['time']=date("H:i:s");
            $logdate=date('Y-m-d');
            if(empty($todayslog)){
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                $serialized_log=serialize($serialized_log);
                $this->members_model->add_log($logdate,$serialized_log);
            }
            else{
                $prev_logs=unserialize($todayslog['log_details']);
                $serialized_log=array();
                $serialized_log[0]=$logdetails;
                foreach($prev_logs as $log){
                    $serialized_log[]=$log;
                }
                $serialized_log=serialize($serialized_log);
                $this->members_model->update_log($serialized_log,$todayslog['id']);   
            }
            redirect('admin/members/view/'.$this->input->post('id').'/print');
            $data=array();
            $data['memberdetail']=$this->dashboard_model->getmemberbyid($this->input->post('id'));
            $data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']);
            $data['feepostdata']['fees']=$this->input->post('fees');
            $data['feepostdata']['comment']=$this->input->post('comment');
            $data['feepostdata']['payment_date']=$this->input->post('payment_date');
            $dateneedtoadd=date('Y-m-1',strtotime($this->input->post('payment_date')));
            $feesneedtoadd=$this->input->post('fees');
            setincometomonth($dateneedtoadd,$feesneedtoadd);
            
            ini_set('memory_limit', '256M');
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $a = '';
            for ($i = 0; $i<8; $i++){
                $a .= mt_rand(0,9);
            }
            $data['invoice_number'] = $a."-".time();
            $html=  $this->load->view('admin/feeinvoice', $data, true);
            $pdf->WriteHTML($html);

            $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
        }
    }
    
    public function search(){
        $baseurl=$this->config->item('base_url');
        $data=array();
        if($this->input->post('searchkey') && !empty($this->input->post('searchkey'))){
            $data['members']=$this->members_model->get_searched_members();
        }
        else{
            $data['members']=array();
        }
        $htmltoreturn='';
        for($i=0;$i<sizeof($data['members']);$i++){
            $memberid=$data['members'][$i]['id'];
            $membername=$data['members'][$i]['name'];
            $memberphone=$data['members'][$i]['phone'];
            if($data['members'][$i]['gender']!=''){
                $membergender=$data['members'][$i]['gender'];
            }else{
                $membergender="N/A";
            }
            $memberfeedate=date('d-M-Y',$data['members'][$i]['fee_date']);
            $feedate=date("m-d-Y",$data['members'][$i]['fee_date']);
            $feemonth=date("M",$data['members'][$i]['fee_date']);
            $feedate=$data['members'][$i]['fee_date'];
            $memberfees=0;
            if($data['members'][$i]['package']!="" && $data['members'][$i]['package']!="custom"){
                $package=$this->members_model->get_packages($data['members'][$i]['package']);
                if(!empty($package[0])){
                    $memberfees=$package[0]['fees'];
                }
                else{
                }
            }else{
                $memberfees=$data['members'][$i]['fees'];
            }
            $actionhtml="";
            $actionhtml.='<div class="margin"><div class="btn-group"><button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="'.$baseurl.'admin/members/edit/'.$memberid.'">Edit</a></li>
                   <li><a href="javascript:;" class="myinactivedeleteClicker" data-memberid="'.$memberid.'">Delete</a></li>
                   <li><a href="'.$baseurl.'admin/members/view/'.$memberid.'" >Detail</a></li>';
          
            if($data['members'][$i]['status']==1){
                $statusdiv='<div class="activespan"></div>';
            }else{
                $statusdiv='<div class="activespan deactivespan"></div>';
                $cdate = date('m/d/Y');
                $actionhtml.='<li><a data-cdate="'.$cdate.'" data-fees="'.$memberfees.'" data-memberid="'.$memberid.'" data-membername="'.$membername.'" class="myinactivefeeModalclicker" href="javascript:;" onclick="myinactivefeeModalclicker()">Pay-Fee+Rejoin</a></li>';
                $actionhtml.='<li><a data-cdate="'.$cdate.'" data-fees="'.$memberfees.'" data-memberid="'.$memberid.'" data-membername="'.$membername.'" class="myrejoinclicker" href="javascript:;">Pay-Fee+Active</a></li>';
            }
            $actionhtml.='<li><a href="'.$baseurl.'admin/members/viewattendence/'.$memberid.'" >View Attendence</a></li>
			<li><a href="'.$baseurl.'admin/members/bodycomposition/'.$memberid.'" >Body Composition & Fitness</a></li>
			</ul></div></div>';
            $htmltoreturn.='<tr><td>'.$memberid.'</td><td class="activedivname">'.$statusdiv.'<a href="'.$baseurl.'admin/members/view/'.$memberid.'">'.$membername.'</a></td><td>'.$memberphone.'</td><td>'.$membergender.'</td><td>'.$this->session->userdata['currency_symbol'].''.$memberfees.'</td><td>'.$memberfeedate.'</td><td>'.$actionhtml.'</td></tr>';
        }
        echo $htmltoreturn;
    }
	public function printinvoice($id=false){
        $data['memberdetail']=$this->dashboard_model->getmemberbyid($id);
        $data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']);
        $memberfeesdetails=$data['memberdetail'][0]['fees_detail'];
        $memberfeesdetails=unserialize($memberfeesdetails);
        $memberfeesdetailslength=sizeof($memberfeesdetails);
        $memberlastfeesdetails=$memberfeesdetails[$memberfeesdetailslength-1];
        $data['feepostdata']['fees']=$memberlastfeesdetails['fees'];
        $data['feepostdata']['comment']=$memberlastfeesdetails['comment'];
        $data['feepostdata']['payment_date']=date('d-M-Y',$memberlastfeesdetails['payment_date']);

        ini_set('memory_limit', '256M');
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $a = '';
        for ($i = 0; $i<8; $i++){
            $a .= mt_rand(0,9);
        }
        $data['invoice_number'] = $a."-".time();
        if($this->session->userdata['printer_option']==2){
            $html=  $this->load->view('admin/feeinvoice_small', $data, true);
        }else{
            $html=  $this->load->view('admin/feeinvoice', $data, true);
        }
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }
    public function secondprintinvoice($id=false,$feeindexid=false){
        $data['memberdetail']=$this->dashboard_model->getmemberbyid($id);
        $data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']); 
        $memberfeesdetails=$data['memberdetail'][0]['fees_detail'];
        $memberfeesdetails=unserialize($memberfeesdetails);
        $memberlastfeesdetails=$memberfeesdetails[$feeindexid];
        $data['feepostdata']['fees']=$memberlastfeesdetails['fees'];
        $data['feepostdata']['comment']=$memberlastfeesdetails['comment'];
        $data['feepostdata']['payment_date']=date('d-M-Y',$memberlastfeesdetails['payment_date']);

        ini_set('memory_limit', '256M');
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $a = '';
        for($i = 0; $i<8; $i++){
            $a .= mt_rand(0,9);
        }
        $data['invoice_number'] = $a."-".time();
        $html=  $this->load->view('admin/feeinvoice_small', $data, true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }
    public function test80mm(){
        $data['memberdetail']=$this->dashboard_model->getmemberbyid(3);
        $data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']);
        $memberfeesdetails=$data['memberdetail'][0]['fees_detail'];
        $memberfeesdetails=unserialize($memberfeesdetails);
        $memberlastfeesdetails=$memberfeesdetails[0];
        $data['feepostdata']['fees']=$memberlastfeesdetails['fees'];
        $data['feepostdata']['comment']=$memberlastfeesdetails['comment'];
        $data['feepostdata']['payment_date']=date('d-M-Y',$memberlastfeesdetails['payment_date']);
        ini_set('memory_limit', '256M');
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $a = '';
        for($i = 0; $i<8; $i++){
            $a .= mt_rand(0,9);
        }
        $data['invoice_number'] = $a."-".time();
        $html=  $this->load->view('admin/feeinvoice_small', $data, true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }
	public function view($id=false,$print=false){
        if(!$id){
            redirect("frontend_users");
        }
		$data=array();
        $data['gym_detail']=$this->members_model->get_gym_detail($this->session->userdata('userid'));
        if($print=="print"){
            $data['printstatus'] = 'ok';
        }
        $data['page'] = 'members';
        $EmpData = $this->members_model->GetMemberDetailById($id);
        if(isset($EmpData[0]['package']) && $EmpData[0]['package']!='custom' && $EmpData[0]['package']!=''){
            $packageData = $this->members_model->get_packages($EmpData[0]['package']);
            $EmpData[0]['packagename']=$packageData[0]['name'];
        }
		$data['member'] = $EmpData[0];
        if($data['member']['package']!="" && $data['member']['package']!="custom"){
            $packagedetail=$this->members_model->get_packages($data['member']['package']);
            $data['member']['packagedetail']=$packagedetail[0];
        }
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/view', $data);
		$this->load->view('admin/templates/footer', $data);
    }
    public function createDateRange($startDate, $endDate, $format = "Y-m-d"){
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);
        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }
        return $range;
    }
    public function viewattendence($memberid=false){
        $data=array();
        $data['page']="members";
        if(!empty($this->input->post('start_date')) && !empty($this->input->post('end_date'))){
            $attendences=$this->members_model->get_member_attendence();
    
            if(!empty($attendences)){
                for($i=0;$i<sizeof($attendences);$i++){
                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
                    $unsetindexes=array();
                    for($j=0;$j<sizeof($attendences[$i]['attendence']);$j++){
                        if($memberid!=$attendences[$i]['attendence'][$j]['member_id']){
                            $unsetindexes[]=$j;
                        }
                    }
                    for($k=0;$k<sizeof($unsetindexes);$k++){
                        unset($attendences[$i]['attendence'][$unsetindexes[$k]]);
                    }
                }
            }
            $startdate=date('Y-m-d',strtotime($this->input->post('start_date')));
            $enddate=date('Y-m-d',strtotime($this->input->post('end_date'). ' +1 day'));
            $range=$this->createDateRange($startdate, $enddate);
            $notfounddates=array();
            for($i=0;$i<sizeof($range);$i++){
                $status=false;
                for($j=0;$j<sizeof($attendences);$j++){
                    if($range[$i]==$attendences[$j]['date']){
                        $status=true;
                        $notfounddates[]=$attendences[$j];
                    }
                }
                if($status==false){
                    $pusharray=array();
                    $pusharray['date']=$range[$i];
                    $pusharray['attendence'][0]['date']=$range[$i];
                    $pusharray['attendence'][0]['time_in']="00:00";
                    $pusharray['attendence'][0]['time_out']="00:00";
                    $pusharray['attendence'][0]['member_id']=$memberid;
                    $pusharray['attendence'][0]['status']="Absent";
                    $notfounddates[]=$pusharray;
                }
        
            }
            $attendences=$notfounddates;
            $data['attendences']=$attendences;
        }
        else if(!empty($this->input->post('dayslimit')) && !empty($this->input->post('dayslimit'))){
            $attendences=$this->members_model->get_member_attendence_by_date($this->input->post('dayslimit'));
            if(!empty($attendences)){
                for($i=0;$i<sizeof($attendences);$i++){
                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
                    
                    
                    $unsetindexes=array();
                    $newarray=array();
                    for($j=0;$j<sizeof($attendences[$i]['attendence']);$j++){
                        if($memberid==$attendences[$i]['attendence'][$j]['member_id']){
                            $newarray[]=$attendences[$i]['attendence'][$j];
//                            $unsetindexes[]=$j;
                        }
                    }
                    $attendences[$i]['attendence']=$newarray;
                    
//                    for($k=0;$k<sizeof($unsetindexes);$k++){
//                        unset($attendences[$i]['attendence'][$unsetindexes[$k]]);
//                    }
                }
            }
            $enddate=strtotime(date('Y-m-d'));
            $enddate=date('Y-m-d', strtotime('+1 days', $enddate));
            $daystocompare=$this->input->post('dayslimit');
            $startdate=date('Y-m-d', strtotime('-'.$daystocompare.' days', strtotime($enddate)));
            $range=$this->createDateRange($startdate, $enddate);
            $notfounddates=array();
            for($i=0;$i<sizeof($range);$i++){
                $status=false;
                for($j=0;$j<sizeof($attendences);$j++){
                    if($range[$i]==$attendences[$j]['date']){
                        $status=true;
                        $notfounddates[]=$attendences[$j];
                    }
                }
                if($status==false){
                    $pusharray=array();
                    $pusharray['date']=$range[$i];
                    $pusharray['attendence'][0]['date']=$range[$i];
                    $pusharray['attendence'][0]['time_in']="00:00";
                    $pusharray['attendence'][0]['time_out']="00:00";
                    $pusharray['attendence'][0]['member_id']=$memberid;
                    $pusharray['attendence'][0]['status']="Absent";
                    $notfounddates[]=$pusharray;
                }
            }
            $attendences=$notfounddates;
            
            $data['attendences']=$attendences;
            
        }
        else{
            $data['attendences']=array();
        }
        $data['filtermemberid']=$memberid;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/viewattendences', $data);
        $this->load->view('admin/templates/footer', $data);
    }
    
    
    public function profileprint($id=0){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data = array();
        ini_set('memory_limit', '256M');
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $EmpData = $this->members_model->GetMemberDetailById($id);
        if(isset($EmpData[0]['package']) && $EmpData[0]['package']!='custom' && $EmpData[0]['package']!=''){
            $packageData = $this->members_model->get_packages($EmpData[0]['package']);
            $EmpData[0]['packagename']=$packageData[0]['name'];
        }
        $data['member'] = $EmpData[0];
        $data['today'] = date("Y-m-d H:i:s");
        $a = '';
        for ($i = 0; $i<8; $i++){
            $a .= mt_rand(0,9);
        }
        $data['invoice_number'] = $a."-".time();
        $html =  $this->load->view('admin/members/printprofile', $data, true);
        $pdf->WriteHTML($html);
        $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
    }
    public function createThumbnail($filename){
        $config['image_library']    = "gd2";
        $config['source_image']     = "./uploads/" .$filename;
        $config['new_image']     = "./uploads/thumb/";
        $config['create_thumb']     = TRUE;
        $config['maintain_ratio']   = TRUE;
        $config['width'] = "140";
        $config['height'] = "100";
        $this->load->library('image_lib',$config);
        if(!$this->image_lib->resize()){
            echo $this->image_lib->display_errors();
        }
    }
    public function checksms(){
        $data=$_POST;
        $this->members_model->updatesms($data);
    }
    public function updatereminderstatus(){
        $data=$_POST;
        $this->members_model->updatereminderstatus($data);
    }
    public function decryment_gym_sms(){
        $data=$_POST;
        if($this->members_model->decryment_gym_sms($data)){
            echo "success";
        }
    }
    public function get_packagedetail_ajax(){
        $packagedetail=$this->members_model->get_packagedetail_ajax();
        echo json_encode($packagedetail);
    }
    public function validate_phonenumber($phone){
        $firstone=substr($phone, 0, 1);
        $firsttwo=substr($phone, 0, 2);
        if($firstone==0 || $firsttwo==92){
            return true;
        }
        else{
            return false;
        }
    }
	
	
	
	public function addbodycomposition($id=false){
$mem_id;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('posted_date', 'Date', 'required');
        $this->form_validation->set_rules('height', 'Height', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required');
		
		if($this->form_validation->run() === FALSE){
			$data['memberid']=$id;
			$data['page']="body composition";
		$this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/add_body_composition', $data);
        $this->load->view('admin/templates/footer', $data);	
		}
		else{
		
		if($this->input->post('member_id') && !empty($this->input->post('member_id'))){
            $data['member_id']=$this->input->post('member_id');
			$mem_id= $data['member_id'];
        }
        else{
            $data['member_id']='';
        }
							
		if($this->input->post('posted_date') && !empty($this->input->post('posted_date'))){
            $data['posted_date']=$this->input->post('posted_date');
        }
        else{
            $data['posted_date']='';
        }
					
		if($this->input->post('posted_date') && !empty($this->input->post('body_fat'))){
            $data['body_fat']=$this->input->post('body_fat');
        }
        else{
            $data['body_fat']='';
        }
					
		if($this->input->post('body_water') && !empty($this->input->post('body_water'))){
            $data['body_water']=$this->input->post('body_water');
        }
        else{
            $data['body_water']='';
        }
					
		if($this->input->post('lean_body_mass') && !empty($this->input->post('lean_body_mass'))){
            $data['lean_body_mass']=$this->input->post('lean_body_mass');
        }
        else{
            $data['lean_body_mass']='';
        }
					
		if($this->input->post('bmi') && !empty($this->input->post('bmi'))){
            $data['bmi']=$this->input->post('bmi');
        }
        else{
            $data['bmi']='';
        }
					
		if($this->input->post('basal_metabolic_rate') && !empty($this->input->post('basal_metabolic_rate'))){
            $data['basal_metabolic_rate']=$this->input->post('basal_metabolic_rate');
        }
        else{
            $data['basal_metabolic_rate']='';
        }
					
		if($this->input->post('bone_density') && !empty($this->input->post('bone_density'))){
            $data['bone_density']=$this->input->post('bone_density');
        }
        else{
            $data['bone_density']='';
        }
					
		if($this->input->post('height') && !empty($this->input->post('height'))){
            $data['height']=$this->input->post('height');
        }
        else{
            $data['height']='';
        }
					
		if($this->input->post('weight') && !empty($this->input->post('weight'))){
            $data['weight']=$this->input->post('weight');
        }
        else{
            $data['weight']='';
        }
					
		if($this->input->post('neck') && !empty($this->input->post('neck'))){
            $data['neck']=$this->input->post('neck');
        }
        else{
            $data['neck']='';
        }
							
		if($this->input->post('chest') && !empty($this->input->post('chest'))){
            $data['chest']=$this->input->post('chest');
        }
        else{
            $data['chest']='';
        }
							
		if($this->input->post('abs') && !empty($this->input->post('abs'))){
            $data['abs']=$this->input->post('abs');
        }
        else{
            $data['abs']='';
        }
							
		if($this->input->post('waist') && !empty($this->input->post('waist'))){
            $data['waist']=$this->input->post('waist');
        }
        else{
            $data['waist']='';
        }
							
		if($this->input->post('arms') && !empty($this->input->post('arms'))){
            $data['arms']=$this->input->post('arms');
        }
        else{
            $data['arms']='';
        }
							
		if($this->input->post('hips') && !empty($this->input->post('hips'))){
            $data['hips']=$this->input->post('hips');
        }
        else{
            $data['hips']='';
        }
							
		if($this->input->post('thighs') && !empty($this->input->post('thighs'))){
            $data['thighs']=$this->input->post('thighs');
        }
        else{
            $data['thighs']='';
        }
							
		if($this->input->post('calf') && !empty($this->input->post('calf'))){
            $data['calf']=$this->input->post('calf');
        }
        else{
            $data['calf']='';
        }
							
		if($this->input->post('partial_curl_ups') && !empty($this->input->post('partial_curl_ups'))){
            $data['partial_curl_ups']=$this->input->post('partial_curl_ups');
        }
        else{
            $data['partial_curl_ups']='';
        }
							
		if($this->input->post('flexibility') && !empty($this->input->post('flexibility'))){
            $data['flexibility']=$this->input->post('flexibility');
        }
        else{
            $data['flexibility']='';
        }
							
		if($this->input->post('pushups') && !empty($this->input->post('pushups'))){
            $data['pushups']=$this->input->post('pushups');
        }
        else{
            $data['pushups']='';
        }
									
		if($this->input->post('weight_prospect') && !empty($this->input->post('weight_prospect'))){
            $data['weight_prospect']=$this->input->post('weight_prospect');
        }
        else{
            $data['weight_prospect']='';
        }
											
		if($this->input->post('member_category') && !empty($this->input->post('member_category'))){
            $data['member_category']=$this->input->post('member_category');
        }
        else{
            $data['member_category']='';
        }
											
		if($this->input->post('assessed_by') && !empty($this->input->post('assessed_by'))){
            $data['assessed_by']=$this->input->post('assessed_by');
        }
        else{
            $data['assessed_by']='';
        }
											
		if($this->input->post('trainer_recommendation') && !empty($this->input->post('trainer_recommendation'))){
            $data['trainer_recommendation']=$this->input->post('trainer_recommendation');
        }
        else{
            $data['trainer_recommendation']='';
        }
			
			
			
			
			$result=$this->members_model->insert_member_bodycomposition($data);
			if($result==1){
				$this->session->set_flashdata('succ_msg', 'Member Body Detail Added Successfully!');
			}
			else{
				$this->session->set_flashdata('error_msg', 'Member Body Detail Does Not Added Successfully!');
			}
			
			
		redirect('admin/members/bodycomposition/'.$mem_id);	
		}
		
		
	}
	public function bodycomposition($id=false){
		$member=$this->members_model->get_memberdetails($id);
		$memberbody=$this->members_model->get_memberbodydetails($id);
//		echo '<pre>';
//		var_dump($memberbody);
//		exit;
		$data['members']=$member;
		$data['membersbody']=$memberbody;
		$data['page']="Body Composition";
		
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/body_composition', $data);
        $this->load->view('admin/templates/footer', $data);	
		
		

	}
	
}
?>