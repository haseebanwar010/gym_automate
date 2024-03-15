<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gym extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct()
        {
                parent::__construct();
                
				$this->load->library('session');
				$this->load->model('gym_model');
				$this->load->model('country_model');
				$this->load->model('cities_model');
				$this->load->model('currency_model');

		  }
	
	public function index( $msg = NULL)
	{
        $data=array();
        $data['page'] = 'gyms';
		$data['gyms'] = $this->gym_model->get_all_gyms();

        if(! $this->session->userdata('userrole')){
			redirect('auth2');
		}
        else{
            $this->load->view('superadmin/templates/header', $data);
			$this->load->view('superadmin/templates/sidebar', $data);
			$this->load->view('superadmin/gym/index', $data);
			$this->load->view('superadmin/templates/footer', $data);
        }
				
	}
	
	
	public function add($id = NULL){
        $user = $this->session->get_userdata();
			$data['page'] = 'gymsadd';
        $data['countries'] = $this->country_model->get_all_countries();
        $data['cities'] = $this->cities_model->get_all_cities();
        $data['currencies'] = $this->currency_model->get_all_currencies();
			//$data['config'] = $this->config_model->get_config(1);
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
            $this->form_validation->set_rules('user_name', 'User name', 'required|alpha_numeric_spaces');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('city', 'city', 'required');
            $this->form_validation->set_rules('currency', 'Currency', 'required');
            $this->form_validation->set_rules('timezone', 'TimeZone', 'required');

            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('package_type', 'Package Type', 'required');
            $this->form_validation->set_rules('payment_criteria', 'Payment Criteria', 'required');

			
			if ($this->form_validation->run() === FALSE)
			{
              
				$this->load->view('superadmin/templates/header');
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/gym/add', $data);
				$this->load->view('superadmin/templates/footer');
				
					
			}
			else
			{


                if (empty($_FILES['image']['name'])) {
                    $this->gym_model->set_gym();
                    $gymdata=$this->gym_model->getGymid();
                    if(isset($gymdata) && !empty($gymdata)){
                        $tablename="tbl_member_".$gymdata[0]['id'];
                        $tablelogs="tbl_logs_".$gymdata[0]['id'];
                        $attendencetablename="tbl_attendence_".$gymdata[0]['id'];
                        $expensestablename="tbl_expenses_".$gymdata[0]['id'];
                        $expensesdetailstablename="tbl_expenses_details_".$gymdata[0]['id'];
                        $staffpaymentstablename="tbl_staffmembers_payments_".$gymdata[0]['id'];
                        $bodycompositionfitnesstablename="tbl_body_composition_fitness_".$gymdata[0]['id'];
                        $this->gym_model->creategymmembertable($tablename);
                        $this->gym_model->creategymlogstable($tablelogs);
                        $this->gym_model->creategymattendencetable($attendencetablename);
                        $this->gym_model->creategymbodyfitnesstable($bodycompositionfitnesstablename);
                        $this->gym_model->creategymexpensestables($expensestablename,$expensesdetailstablename);
                        $this->gym_model->updategymtablename($gymdata[0]['id'],$tablename);
                        $this->gym_model->createstaffpaymentstable($staffpaymentstablename);
                    }
                    $this->session->set_flashdata('msg', 'Gym Added Successfully!');
                    redirect('gyms');
                } else {

                    $new_name = time() . $_FILES["image"]['name'];
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = "./uploads/";
                    $config['allowed_types'] = "gif|jpg|jpeg|png";
                    // $config['max_size'] = "5000";
                    // $config['max_width'] = "2000";
                    // $config['max_height'] = "1280";
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        echo
                        $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                        redirect('gyms');
                    } else {


                        $finfo = $this->upload->data();

                        $this->createThumbnail($finfo['file_name']);
                        $this->gym_model->set_gym($finfo['file_name']);
                        $gymdata=$this->gym_model->getGymid();
                        if(isset($gymdata) && !empty($gymdata)){
                            $tablename="tbl_member_".$gymdata[0]['id'];
                            $logstablename="tbl_logs_".$gymdata[0]['id'];
                            $attendencetablename="tbl_attendence_".$gymdata[0]['id'];
                            $expensestablename="tbl_expenses_".$gymdata[0]['id'];
                            $expensesdetailstablename="tbl_expenses_details_".$gymdata[0]['id'];
                            $staffpaymentstablename="tbl_staffmembers_payments_".$gymdata[0]['id'];
							$bodycompositionfitnesstablename="tbl_body_composition_fitness_".$gymdata[0]['id'];
                            $this->gym_model->creategymmembertable($tablename);
                            $this->gym_model->creategymlogstable($logstablename);
                            $this->gym_model->creategymattendencetable($attendencetablename);
							$this->gym_model->creategymbodyfitnesstable($bodycompositionfitnesstablename);
                            $this->gym_model->creategymexpensestables($expensestablename,$expensesdetailstablename);
                            $this->gym_model->updategymtablename($gymdata[0]['id'],$tablename);
                            $this->gym_model->createstaffpaymentstable($staffpaymentstablename);
                        }
                        $this->session->set_flashdata('msg', 'Gym Added Successfully!');
                        redirect('gyms');
                    }
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
			$data['page'] = 'gyms';
        
        $data['gym'] = $this->gym_model->get_all_gyms($id);
            $data['countries'] = $this->country_model->get_all_countries();
            $data['cities'] = $this->cities_model->get_all_cities();
            $data['currencies'] = $this->currency_model->get_all_currencies();
            
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
            $this->form_validation->set_rules('user_name', 'User name', 'required');
            //$this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('city', 'city', 'required');
            $this->form_validation->set_rules('currency', 'Currency', 'required');
            $this->form_validation->set_rules('timezone', 'TimeZone', 'required');
          //  $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('package_type', 'Package Type', 'required');
            $this->form_validation->set_rules('payment_criteria', 'Payment Criteria', 'required');


			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('superadmin/templates/header');
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/gym/edit', $data);
				$this->load->view('superadmin/templates/footer');
			}
			else
			{


                if (empty($_FILES['image']['name'])) {

                    $this->gym_model->update_gym();
                    $this->session->set_flashdata('msg', 'Gym Information is updated Successfully!');
                    redirect('gyms');
                } else {

                    $new_name = time() . $_FILES["image"]['name'];
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = "./uploads/";
                    $config['allowed_types'] = "gif|jpg|jpeg|png";
                    // $config['max_size'] = "5000";
                    // $config['max_width'] = "2000";
                    // $config['max_height'] = "1280";
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        echo
                        $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                        redirect('gyms');
                    } else {


                        $finfo = $this->upload->data();

                        $this->createThumbnail($finfo['file_name']);

                        $this->gym_model->update_gym($finfo['file_name']);
                        $this->session->set_flashdata('msg', 'Gym Information is updated Successfully!');
                        redirect('gyms');
                    }
                }

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
        
        
			if($this->gym_model->delete_gym($id)){
               
				$this->session->set_flashdata('msg', 'Gym is deleted Successfully!');
				redirect('gyms');
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