<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('sms_model');
        if(check_permission('sms_access')){
        }else{
            redirect('admin/restricted');
        }
    }
	
	public function index( $msg = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data=array();
        $data['page'] = 'sms';
        $data['totalsms_available']=$this->sms_model->get_gym_totalsms_available();
        $data['totalsms_available']=$data['totalsms_available']['sms_counter_limit'];
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/sms/index', $data);
        $this->load->view('admin/templates/footer', $data);
	}
    public function get_members_bygroup(){
        $response=array();
        if($this->input->post('membergroup') && $this->input->post('membergroup')=="all"){
            $response['members']=$this->sms_model->get_all_members();
        }
        else if($this->input->post('membergroup') && $this->input->post('membergroup')=="active"){
            $response['members']=$this->sms_model->get_all_active_members();
        }
        else if($this->input->post('membergroup') && $this->input->post('membergroup')=="inactive"){
            $response['members']=$this->sms_model->get_all_inactive_members();
        }
        $response['totalsms_available']=$this->sms_model->get_gym_totalsms_available();
        echo json_encode($response);
    }
    public function decrease_sms_numbers(){
        $this->sms_model->decrease_sms_numbers($this->input->post('total_messages_send'));
        $response['response']="success";
        echo json_encode($response);
    }
    
}
?>