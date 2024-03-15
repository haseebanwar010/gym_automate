<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currencies extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct()
        {
                parent::__construct();
                
				$this->load->library('session');
				$this->load->model('currency_model');
				
		  }
	
	public function index( $msg = NULL)
	{

        $data=array();
        $data['page'] = 'currency';
		$data['currencies'] = $this->currency_model->get_all_currencies();

        if(! $this->session->userdata('userrole')){
			redirect('auth2');
		}
        else{
            $this->load->view('superadmin/templates/header', $data);
			$this->load->view('superadmin/templates/sidebar', $data);
			$this->load->view('superadmin/currencies/index', $data);
			$this->load->view('superadmin/templates/footer', $data);
        }
				
	}
	
	
	public function add($id = NULL){
        $user = $this->session->get_userdata();
			$data['page'] = 'currencyadd';
			//$data['config'] = $this->config_model->get_config(1);
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->form_validation->set_rules('currency_name', 'Currency Name', 'required|min_length[3]');
            $this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'required');
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('superadmin/templates/header');
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/currencies/add', $data);
				$this->load->view('superadmin/templates/footer');
			}
			else
			{
                    if($this->currency_model->set_currency()){
                        $this->session->set_flashdata('msg', 'Currency Added Successfully!');
                        redirect('currencies');
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
			$data['page'] = 'currency';
        
        $data['currency'] = $this->currency_model->get_all_currencies($id);
			
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->form_validation->set_rules('currency_name', 'Currency Name', 'required|min_length[3]');
            $this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'required');



			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('superadmin/templates/header');
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/currencies/edit', $data);
				$this->load->view('superadmin/templates/footer');
			}
			else
			{
                    $this->currency_model->update_currency();
                    $this->session->set_flashdata('msg', 'Currency Information is updated Successfully!');
                    redirect('currencies');
			}
			
			
			
			
		}
 
    
  
     public function delete($id = NULL){
			$user = $this->session->get_userdata();
        
        
			if($this->currency_model->delete_currency($id)){
               
				$this->session->set_flashdata('msg', 'Currency is deleted Successfully!');
				redirect('currencies');
			}
			
		}
  
    
}
?>