<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
   
	protected $title = 'Settings'; 

	public function __construct()
        {
                parent::__construct();
                
				$this->load->library('session');
				$this->load->model('settings_model');
				if(check_permission('settings_access')){
            
        }else{
            redirect('admin/restricted');
        }
		  }
	
	public function index( $msg = NULL)
	{
        $data=array();
        $data['page'] = 'settings';
		$data['settings_data'] = $this->settings_model->get_gym_settings();
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/settings/edit', $data);
			$this->load->view('admin/templates/footer', $data);
        }	
	}
	public function update(){
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data=array();
        $data['page'] = 'settings';
        if($this->settings_model->updategymsettings()){
            $this->session->set_flashdata('msg', 'GYM Settings Updated Successfully!');
            redirect('settings');
        }
    }
    
    
    
}
?>