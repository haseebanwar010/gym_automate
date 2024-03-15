<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('packages_model');
        if(check_permission('packages_access')){
        }else{
            redirect('admin/restricted');
        }
    }
	public function index( $msg = NULL)
	{
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data=array();
        $data['page'] = 'packages';
		$data['packages'] = $this->packages_model->get_all_packages();
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/packages/index', $data);
			$this->load->view('admin/templates/footer', $data);
        }		
	}

    public function printpackages( $msg = NULL)
	{
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data = array();
        ini_set('memory_limit', '256M');

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $data=array();
        $data['page'] = 'packages';
		$data['packages'] = $this->packages_model->get_all_packages();
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $html=  $this->load->view('admin/packages/printpackages', $data, true);
            $pdf->WriteHTML($html);
            $output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
            $pdf->Output("$output", 'I');
        }
	}
	
	
	public function add($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
		$data['page'] = 'addpackage';
		$this->load->helper('form');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('admission_fees', 'Admission fees', 'required|numeric');
        $this->form_validation->set_rules('fees', 'Fees', 'required|numeric');
        $this->form_validation->set_rules('members', 'Members', 'required|numeric');
        $this->form_validation->set_rules('duration', 'Duration', 'required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/packages/add', $data);
            $this->load->view('admin/templates/footer');
        }
        else{
            $this->packages_model->set_package();
            $this->session->set_flashdata('msg', 'Package Added Successfully!');
            redirect('packages');
        }
    }
    public function edit($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $data['page'] = 'editpackage';
        $data['package'] = $this->packages_model->get_all_packages($id);
		$this->load->helper('form');
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
        $this->form_validation->set_rules('admission_fees', 'Admission fees', 'required|numeric');
        $this->form_validation->set_rules('fees', 'Fees', 'required|numeric');
        $this->form_validation->set_rules('members', 'Members', 'required|numeric');
        $this->form_validation->set_rules('duration', 'Duration', 'required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/packages/edit', $data);
            $this->load->view('admin/templates/footer');
        }
        else{
            $this->packages_model->update_package();
            $this->session->set_flashdata('msg', 'package Information is updated Successfully!');
            redirect('packages');
        }
    }
    public function delete($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        if($this->packages_model->delete_package($id)){
            $this->session->set_flashdata('msg', 'Package is deleted Successfully!');
            redirect('packages');
        }
    }
}
?>