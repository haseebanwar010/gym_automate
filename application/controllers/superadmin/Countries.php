<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Countries extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct()
        {
                parent::__construct();
                
				$this->load->library('session');
				$this->load->model('country_model');
				
		  }
	
	public function index( $msg = NULL)
	{

        $data=array();
        $data['page'] = 'country';
		$data['countries'] = $this->country_model->get_all_countries();

        if(! $this->session->userdata('userrole')){
			redirect('auth2');
		}
        else{
            $this->load->view('superadmin/templates/header', $data);
			$this->load->view('superadmin/templates/sidebar', $data);
			$this->load->view('superadmin/countries/index', $data);
			$this->load->view('superadmin/templates/footer', $data);
        }
				
	}
	
	
	public function add($id = NULL){
        $user = $this->session->get_userdata();
			$data['page'] = 'countryadd';
			//$data['config'] = $this->config_model->get_config(1);
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('superadmin/templates/header');
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/countries/add', $data);
				$this->load->view('superadmin/templates/footer');
			}
			else
			{
                    if($this->country_model->set_country()){
                        $this->session->set_flashdata('msg', 'Country Added Successfully!');
                        redirect('countries');
                    }
			}
    }
    public function createThumbnail($filename)
    {



        $config['image_library']    = "gd2";
        $config['source_image']     = "./uploads/" .$filename;
        $config['new_image']     = "./uploads/thumb/";
        $config['create_thumb']     = TRUE;
        $config['maintain_ratio']   = TRUE;
        $config['width'] = "140";
        $config['height'] = "100";
        $this->load->library('image_lib',$config);
        if(!$this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
        }
    }
    
        public function edit($id = NULL){
			$user = $this->session->get_userdata();
			$data['page'] = 'country';
        
        $data['country'] = $this->country_model->get_all_countries($id);
			
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');



			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('superadmin/templates/header');
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/countries/edit', $data);
				$this->load->view('superadmin/templates/footer');
			}
			else
			{
                    $this->country_model->update_country();
                    $this->session->set_flashdata('msg', 'Country Information is updated Successfully!');
                    redirect('countries');
			}
			
			
			
			
		}
    public function history($patientid){
        $result=$this->patient_model->getappointmentshistory($patientid);
        $data['page'] = 'patient';
        $data['history']=$result;
        $data['patientid']=$patientid;
        $this->load->view('admin/templates/header');
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/patients/history',$data);
        $this->load->view('admin/templates/footer');
        
    }
    
  
     public function delete($id = NULL){
			$user = $this->session->get_userdata();
        
        
			if($this->country_model->delete_country($id)){
               
				$this->session->set_flashdata('msg', 'Country is deleted Successfully!');
				redirect('countries');
			}
			
		}
    public function appointment($id=NULL){
       
        $data['page'] = 'patient';
        $this->load->helper('form');
			$this->load->library('form_validation');
       $this->form_validation->set_rules('appointeddoctor', 'Appointed Doctor', 'required');
           
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('admin/templates/header');
				$this->load->view('admin/templates/sidebar', $data);
				$this->load->view('admin/patients', $data);
				$this->load->view('admin/templates/footer');
			}
			else
			{
				
				$appointedpatient=$this->patient_model->get_appointed_patient($id);	
                $doctorid=$this->input->post('appointeddoctor');
                $doctordetail=getdoctorbyid($doctorid);
                $doctoremail=$doctordetail[0]['email'];
                
                $patientid=$this->input->post('appointedperson');
                $patientdetail=getpatientbyid($patientid);
                $patientemail=$patientdetail[0]['email'];
                $patientname=$patientdetail[0]['name'];
                $patientphone=$patientdetail[0]['phone'];
                
                if($appointedpatient==null){
                    $this->patient_model->set_appointment();
		 		$message = '<h3>You are appointed to the patient:</h3>';
                    $message.="<h4>Patient Detail: </h4>";
        	$message.="<p>Name : ".$patientname."</p>";
			$message.="<p>Email : ".$patientemail."</p>";
			$message.="<p>Phone : ".$patientphone."</p>";
			
            send_email_custom($doctoremail, $doctoremail, 'Form Bio Heath Check', $message);    
				$this->session->set_flashdata('msg', 'Patient Appointed Successfully!');
				redirect('admin/patient');
                }
                else{
                    
                    $aid=$appointedpatient[0]['id'];
                    
                    //echo $patientemail;
                    //echo $doctoremail;
                    //exit;
                    
                    
                    
                    
                    $this->patient_model->update_appointment($aid);
                    $this->patient_model->set_appointment();
                    
                    $message = '<h3>You are appointed to the patient:</h3>';
                    $message.="<h4>Patient Detail: </h4>";
        	$message.="<p>Name : ".$patientname."</p>";
			$message.="<p>Email : ".$patientemail."</p>";
			$message.="<p>Phone : ".$patientphone."</p>";
			
            send_email_custom($doctoremail, $doctoremail, 'Form Bio Heath Check', $message);        
                    
				$this->session->set_flashdata('msg', 'Patient Appointed Successfully!');
				redirect('admin/patient');
                }
				
				
			}
    }
    public function dropdownvalidation(){
        $selectedoctor = $_POST['appointeddoctor'];
        if($selectedoctor=="no"){
            return false;
        }
        else{
            return true;
        }
    }
    public function updateStatus($EmpId=false,$status=false)
    {
        
        if(!$EmpId || !$status)
        {
            redirect('frontend_users');
        }
        $update_data =array();

        if($status=="verified")
        {
			$update_data['status'] = 'disapproved';
		}
        else
        {
            $update_data['status'] = 'verified';
        }
		

        if($this->user_model->updateUserStatus($EmpId,$update_data))
        {
			/*
                $user = $this->User_model->GetUserDetailsById($EmpId);

                $to = $user->email;
                $from = "info@biohealthcheck";
                $subject = "Your User Account has been Verified";
				$data['name'] = $user->first_name;
				$data['link'] = base_url()."employer/login-employer";
                $message = $this->load->view('emails/account_verification',$data,TRUE);
                send_email_custom($to, $from, $subject, $message);
            */
			
            $this->session->set_flashdata('success_msg', 'User Status Updated successfully!!');

        }
        else
        {
             $this->session->set_flashdata('error_msg', 'Ops Something goes wrong!!');
        }

        redirect('frontend_users');

    }
	
	public function view($id=false)
    {
        if(!$id)
        {
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