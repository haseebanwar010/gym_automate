<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('expenses_model');
        if(check_permission('expenses_access')){
        }else{
            redirect('admin/restricted');
        }
    }
	public function index( $msg = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data=array();
        $data['page'] = 'expenses';
        $filterdata=array();
        if($this->input->post('start_date') && !empty($this->input->post('start_date')) && $this->input->post('end_date') && !empty($this->input->post('end_date'))){
            $filterdata['start_date']=date('Y-m-1',strtotime($this->input->post('start_date')));
            $filterdata['end_date']=date('Y-m-30',strtotime($this->input->post('end_date')));
            $data['expenses'] = $this->expenses_model->get_expenses($filterdata);
        }
        else{
            $data['expenses'] = $this->expenses_model->get_expenses();
        }
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/expenses/index', $data);
			$this->load->view('admin/templates/footer', $data);
        }	
	}
    public function addexpenses(){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $data=array();
        $data['page'] = 'expenses';
        if($this->expenses_model->addexpenses()){
            $this->session->set_flashdata('msg', 'Expenses Added Successfully!');
            redirect('expenses');
        }
    }
    public function edit($id = NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        $user = $this->session->get_userdata();
        $data['page'] = 'expenses';
        $data['expenses'] = $this->expenses_model->get_all_expenses($id);
        if(!empty($data['expenses'][0]['expenses'])){
            $data['expenses'][0]['expenses']=unserialize($data['expenses'][0]['expenses']);
        }
		$this->load->helper('form');
        $this->load->library('form_validation');
        if (!$this->input->post()){
            $this->load->view('admin/templates/header');
            $this->load->view('admin/templates/sidebar', $data);
            $this->load->view('admin/expenses/edit', $data);
            $this->load->view('admin/templates/footer');
        }
        else{
            $this->expenses_model->update_expenses();
            $this->session->set_flashdata('msg', 'Expenses Information is updated Successfully!');
                redirect('expenses');
        }
    }
    
    public function delete($id = NULL,$expensetitle=NULL,$expenseamount=NULL,$date=NULL){
        if(! $this->session->userdata('validated')){
            redirect('auth');
        }
        if($this->expenses_model->delete_expense($id,$expensetitle,$expenseamount,$date)){
            $this->session->set_flashdata('msg', 'Expense is deleted Successfully!');
				redirect('expenses');
        }
    }
}
?>