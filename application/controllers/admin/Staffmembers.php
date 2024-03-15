<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffmembers extends CI_Controller {
   
	protected $title = 'Gym';
	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('staffmembers_model');
        if(check_permission('staffmembers_access')){
            
        }else{
            redirect('admin/restricted');
        }
    }
	public function index( $msg = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data=array();
        $data['page'] = 'staffmembers';
        $data['staff_members']=$this->staffmembers_model->get_all_staff_members();
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/staffmembers/index', $data);
		$this->load->view('admin/templates/footer', $data);		
	}
	public function add($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $data['page'] = 'addstaffmember';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|callback_validate_phonenumber');
        $this->form_validation->set_message('validate_phonenumber', 'Please enter a valid phone number');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cnic', 'CNIC', 'required');
        $this->form_validation->set_rules('secondary_name', 'Secondary Name', 'required');
        $this->form_validation->set_rules('secondary_phone', 'Secondary Phone', 'required');
        $this->form_validation->set_rules('commission_percentage', 'Commission', 'required');
        $this->form_validation->set_rules('salary', 'Salary', 'required');
        $this->form_validation->set_rules('training_fees', 'Training Fees', 'required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/staffmembers/add', $data);
            $this->load->view('admin/templates/footer');	
        }
        else{
            $imagename='';
            if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
                $new_name = time() . $_FILES["image"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = "./uploads/";
                $config['allowed_types'] = "gif|jpg|jpeg|png";
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                    redirect('admin/staffmembers');
                }else {
                    $finfo = $this->upload->data();
                    $this->createThumbnail($finfo['file_name']);
                    $imagename=$finfo['file_name'];     
                }
            }
            $memberid=$this->staffmembers_model->set_member($imagename);
            add_pendingpayment_staffmember($memberid,$this->input->post('salary'),$this->session->userdata('userid'));
            $this->session->set_flashdata('msg', 'Staff Member Added Successfully!');
            redirect('admin/staffmembers');
        }
    }
    public function edit($id = NULL){
        $baseurl=$this->config->item('base_url');
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $data['page'] = 'editmember';
        $data['member'] = $this->staffmembers_model->get_all_staff_members($id);
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|callback_validate_phonenumber');
        $this->form_validation->set_message('validate_phonenumber', 'Please enter a valid phone number');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cnic', 'CNIC', 'required');
        $this->form_validation->set_rules('secondary_name', 'Secondary Name', 'required');
        $this->form_validation->set_rules('secondary_phone', 'Secondary Phone', 'required');
        $this->form_validation->set_rules('commission_percentage', 'Commission', 'required');
        $this->form_validation->set_rules('salary', 'Salary', 'required');
        $this->form_validation->set_rules('training_fees', 'Training Fees', 'required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/staffmembers/edit', $data);
            $this->load->view('admin/templates/footer');	
        }else{
            $imagename='';
            if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
                $new_name = time() . $_FILES["image"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = "./uploads/";
                $config['allowed_types'] = "gif|jpg|jpeg|png";
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                    redirect('admin/staffmembers');
                }else {
                    $finfo = $this->upload->data();
                    $this->createThumbnail($finfo['file_name']);
                    $imagename=$finfo['file_name'];     
                }
            }
            if($this->staffmembers_model->update_member($imagename)){
                $this->session->set_flashdata('msg', 'Member Information is updated Successfully!');
                redirect('admin/staffmembers');
            }     
        }
    }  
    public function delete($id = NULL){
        if(! $this->session->userdata('validated')){
             redirect('auth');
        }
        $memberdetail=$this->staffmembers_model->get_all_staff_members($id);
        $imagename=$memberdetail['image'];
        if($this->staffmembers_model->delete_member($id)){
            if($imagename!=''){
                @unlink("./uploads/$imagename");
                @unlink("./uploads/thumb/$imagename");
            }
            $this->session->set_flashdata('msg', 'Member is deleted Successfully!');
            redirect('admin/staffmembers');
        }
    }
    public function view($memberid=NULL){
        if(! $this->session->userdata('validated')){
             redirect('auth');
        }
        if($this->input->post() && !empty($this->input->post())){
            $paymenthistory=$this->staffmembers_model->get_trainer_paymenthistory($memberid,date("Y-m-1"));
            if(!empty($paymenthistory)){
                $previoushistory=array();
                if(!empty($paymenthistory['payments_hiostory'])){
                    $previoushistory=unserialize($paymenthistory['payments_hiostory']);
                }
                $feehistory=array();
                $feehistory[]=array('date'=>date('d-M-Y'),'amount'=>$this->input->post('amount'),'comment'=>$this->input->post('comment'),'remaining_amount'=>$this->input->post('pending_amount')-$this->input->post('amount'));
                if($previoushistory){
                    foreach($previoushistory as $prhistory){
                        $feehistory[]=$prhistory;
                    }
                }
                $datatoupdate=array();
                $datatoupdate['payments_hiostory']=serialize($feehistory);
                $datatoupdate['pending_amount']=$this->input->post('pending_amount')-$this->input->post('amount');
                if($this->staffmembers_model->update_payments_history($paymenthistory['id'],date("Y-m-1"),$datatoupdate)){
                    $this->session->set_flashdata('msg', 'Payment added Successfully!');
                    redirect('admin/staffmembers/view/'.$memberid);
                }
            }
        }
        $data=array();
        $data['page']="staffmemberdetail";
        $memberdetail=$this->staffmembers_model->get_all_staff_members($memberid);
        $assignedmembers=$this->staffmembers_model->get_assigned_members($memberid);
        $paymenthistory=$this->staffmembers_model->get_trainer_paymenthistory($memberdetail['id'],date("Y-m-1"));
        if(!empty($paymenthistory)){
            if(!empty($paymenthistory['payments_hiostory'])){
                $paymenthistory['payments_hiostory']=unserialize($paymenthistory['payments_hiostory']);
            }else{
                $paymenthistory['payments_hiostory']=array();
            }
        }
        else{
            $paymenthistory['payments_hiostory']=array();
        }
        $totalpayable_totrainer=$memberdetail['salary'];
        $assignedactivemembers=0;
        for($k=0;$k<sizeof($assignedmembers);$k++){
            if($assignedmembers[$k]['package']=='custom'){
                $assignedmembers[$k]['custom_fees']=$assignedmembers[$k]['fees'];
            }else{
                $packagedetail=$this->staffmembers_model->get_packagedetail($assignedmembers[$k]['package']);
                $assignedmembers[$k]['custom_fees']=$packagedetail['fees'];
            }
            if($assignedmembers[$k]['status']==1){
                $member_fees_percentage=($assignedmembers[$k]['training_fees']*$assignedmembers[$k]['commission_percentage'])/100;
                $totalpayable_totrainer=$totalpayable_totrainer+$member_fees_percentage;
                $assignedactivemembers++;
            }
        }
        // $totalpayable_totrainer=$totalpayable_totrainer+(($assignedactivemembers*$memberdetail['training_fees']*$memberdetail['commission_percentage'])/100);
        $data['paymenthistory']=$paymenthistory;
        $data['total_payable_trainer']=$totalpayable_totrainer;
        $data['member']=$memberdetail;
        $data['assignedmembers']=$assignedmembers;
        $this->load->view('admin/templates/header');
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/staffmembers/view', $data);
        $this->load->view('admin/templates/footer');
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
}
?>