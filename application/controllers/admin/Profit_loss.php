<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_loss extends CI_Controller {
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('expenses_model');
        $this->load->model('charts_model');
        $this->load->model('members_model');
        $this->load->model('packages_model');
        if(check_permission('profitloss_access')){
            
        }else{
            redirect('admin/restricted');
        }
    }
	
	public function balancesheet(){
        $data=array();
        $data['page'] = 'balancesheet';
        $filterdata=array();
        $filterdatatwo=array();
        if($this->input->post('date') && !empty($this->input->post('date'))){
            $filterdata['start_date']=date('Y-m-1',strtotime($this->input->post('date')));
            $filterdata['end_date']=date('Y-m-30',strtotime($this->input->post('date')));
            $filterdatatwo['date']=date('Y-m-1',strtotime($this->input->post('date')));
            $data['expenses'] = $this->expenses_model->get_balancesheet_expenses($filterdata);
            $data['totals'] = $this->expenses_model->get_balancesheet_totals($filterdatatwo);
        }
        else{
            $data['expenses'] = $this->expenses_model->get_balancesheet_expenses();
            $data['totals'] = $this->expenses_model->get_balancesheet_totals();
        }
        $expenses=array();
        if(!empty($data['expenses'])){
            for($i=0;$i<sizeof($data['expenses']);$i++){
                $data['expenses'][$i]['expenses']=unserialize($data['expenses'][$i]['expenses']);
            }
        }
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            $this->load->view('admin/templates/header', $data);
			$this->load->view('admin/templates/sidebar', $data);
			$this->load->view('admin/expenses/view', $data);
			$this->load->view('admin/templates/footer', $data);
        }
    }
}
