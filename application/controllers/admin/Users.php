<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
   
	protected $title = 'GYM'; 

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('user_model');
        if(check_permission('users_access')){
            
        }else{
            redirect('admin/restricted');
        }
    }
	
	public function index( $msg = NULL){
        $data=array();
        $data['page'] = 'users';
		$data['frontend_users'] = $this->user_model->get_frontend_users();
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/frontend_users/index', $data);
			$this->load->view('admin/templates/footer', $data);
        }
	}
    public function adminusers( $msg = NULL){
        $data=array();
        $data['page'] = 'users';
		$data['admin_users'] = $this->user_model->get_admin_users();
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/admin_users/index', $data);
			$this->load->view('admin/templates/footer', $data);
        }
	}
    public function addadminusers($url = NULL){
        $user = $this->session->get_userdata();
        $data['page'] = 'users';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('user_name', 'User Name', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $VideoData= array();
        if ($this->form_validation->run() === FALSE){
            if($url == NULL){
                $this->load->view('admin/templates/header');
                $this->load->view('admin/templates/sidebar', $data);
                $this->load->view('admin/admin_users/add', $data);
                $this->load->view('admin/templates/footer');
            }else{
                echo validation_errors();
            }
        }
        else{
            $checkadminuser_withusername=$this->user_model->checkadminuser_withusername();
            if(empty($checkadminuser_withusername)){
                $this->user_model->set_adminuser();
                $this->session->set_flashdata('msg', 'User Added Successfully!');
                redirect('users');
            }
            else{
                $this->session->set_flashdata('usernameerrormsg', 'User name already exists!');
                redirect('users');
            }
        }
    }
    public function deleteadminuser($id=NULL){
        if($this->user_model->delete_adminuser($id)){
            $this->session->set_flashdata('msg', 'User is deleted Successfully!');
            redirect('users');
        }
    }
    public function editadminusers($id = NULL){
        $user = $this->session->get_userdata();
        $data['page'] = 'users';
        $data['user']=$this->user_model->get_admin_users($id);
        $data['user'][0]['authorization']=unserialize($data['user'][0]['authorization']);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');

        $VideoData= array();
        if ($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/admin_users/edit', $data);
            $this->load->view('admin/templates/footer');
        }
        else{
            $checkadminuser_withusername=$this->user_model->checkadminuser_withusername();
            if(empty($checkadminuser_withusername)){
                $this->user_model->update_adminuser();
                $this->session->set_flashdata('msg', 'User Updated Successfully!');
                redirect('users');
            }
            else{
                $this->session->set_flashdata('usernameerrormsg', 'User name already exists!');
                redirect('users');
            }
        }
    }
    public function updateStatus($EmpId=false,$status=false){
        if(!$EmpId || !$status){
            redirect('frontend_users');
        }
        $update_data =array();
        if($status=="verified"){
			$update_data['status'] = 'disapproved';
		}
        else{
            $update_data['status'] = 'verified';
        }
        if($this->user_model->updateUserStatus($EmpId,$update_data))
        {
			$this->session->set_flashdata('success_msg', 'User Status Updated successfully!!');
        }
        else{
            $this->session->set_flashdata('error_msg', 'Ops Something goes wrong!!');
        }
        redirect('frontend_users');
    }
    public function delete($id = NULL){
        $user = $this->session->get_userdata();
        $thumb=$this->videos_model->getbannername($id);
        $thumbname=$thumb[0]['thumb'];
        if($this->videos_model->delete_video($id)){
            @unlink("./uploads/$thumbname");
            @unlink("./uploads/thumb/$thumbname");
            $this->session->set_flashdata('msg', 'Video is deleted Successfully!');
            redirect('videos');
        }
    }
    public function delete_frontuser($id){
        if($this->user_model->delete_frontuser($id)){
            $this->session->set_flashdata('msg', 'User is deleted Successfully!');
            redirect('frontend_users');
        }
    }
	public function view($id=false){
        if(!$id){
            redirect("frontend_users");
        }
		$data=array();
        $data['page'] = 'users';
        $EmpData = $this->user_model->GetUserDetailsById($id);
		$data['users'] = $EmpData; 
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/frontend_users/view', $data);
		$this->load->view('admin/templates/footer', $data);
    }
}
?>