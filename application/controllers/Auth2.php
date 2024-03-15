<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth2 extends CI_Controller {

	public function __construct()
        {
                parent::__construct();
				$this->load->model('user_model');
                $this->load->helper('url_helper');
				$this->load->library('session');
				//$this->check_isvalidated();
        }
		
	
	public function index( $msg = NULL)
	{
      
		$this->load->view('superadmin/login');
	}	
	
	public function login($flag = false)
	{
        
		$username=$this->input->post('username');
		$password=$this->input->post('password');
       
        if($username=="abaska" && $password=="Th75McY!23456"){
            $data = array(
						'username' => $username,
						'userrole' => "superadmin"
						);
				$this->session->set_userdata($data);
            redirect('superadmin/dashboard');
        }
        else{
            $data['msg'] = 'Invalid username and/or password.';
						$this->load->view('superadmin/login', $data);
        }
			
	}
	
	public function forgot_password(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if ($this->form_validation->run() === FALSE)
		{
			//$data['msg'] = 'Invalid Email!';
			$this->load->view('administrator/forgot_password');
		}
		else
		{
			if(!$this->user_model->validate_email()){
				$data['msg'] = 'Email Does not Match!';
				$this->load->view('administrator/forgot_password', $data);
			}else{
				
				$pass = $this->user_model->randomPassword();
				$this->user_model->update_admin_password_by_email($pass);
				$email = $this->input->post('email');
				
				$user_info = $this->user_model->get_user_by_email($email);
				
				$master_email = $this->config->item('master_email');
				$master_name = $this->config->item('master_name');
				
				$message = "Your password has been reset!<br /><br />
				User Name: ".$user_info['name']."
				<br />Your New password is: ".$pass;
				
				$this->load->library('email');
					
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['mailtype'] = 'html';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);

					$this->email->from($master_email, $master_name);
					$this->email->to($email); 
					
					$this->email->subject('Password Reset for Lead 2 Need Cargo');
					
					$this->email->message($message);	
					$this->email->send();
					redirect('auth/login/reset');
			}
			
		}
	}
	public function change_password($customer_id = NULL){
			if(! $this->session->userdata('validated')){
				redirect('auth');
			}else{
				
				$data['page'] = 'password';
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				
				$this->form_validation->set_rules('old_password', 'Old Password', 'required');
				$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[6]|matches[new_password]');
				
				
			
				if ($this->form_validation->run() === FALSE)
				{
						$this->load->view('administrator/templates/header', $data);
						$this->load->view('administrator/templates/sidebar', $data);
						$this->load->view('administrator/change_password', $data);
						$this->load->view('administrator/templates/footer', $data);
					
			
				}
				else
				{
					
					if($this->user_model->validate_admin_pass()){
						
						$this->user_model->update_admin_password();	
						//var_dump($_POST);
					//exit;				
						redirect('auth/change_password');
					}elseif($this->user_model->validate_password()){
						
						$this->user_model->update_password();
					
						redirect('auth/change_password');
						
					}else{
						$data['msg'] = 'Incorrect password given';
						$this->load->view('administrator/templates/header', $data);
						$this->load->view('administrator/templates/sidebar', $data);
						$this->load->view('administrator/change_password', $data);
						$this->load->view('administrator/templates/footer', $data);
						
					}
					
				}
			}
			
			
			
		}
	public function logout(){
			 $role = $this->session->userdata('user_role');
			$this->session->unset_userdata('user');
			$this->session->sess_destroy();
			if($role!='AGENT'){
				redirect('auth2','refresh');
			}else{
				redirect('agentPanel','refresh');
				}
		}
}
