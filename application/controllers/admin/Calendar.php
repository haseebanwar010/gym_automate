<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('dashboard_model');
        $this->load->model('charts_model');
        $this->load->model('members_model');
        $this->load->model('packages_model');
        if(check_permission('calendar_access')){
            
        }else{
            redirect('admin/restricted');
        }
    }
	
	public function calendar(){
        $data=array();
        $data['page']="calendar";
        $date="";
        $comparisonstartdate="";
        $comparisonenddate="";
        if(isset($_POST['date']) && isset($_POST['date'])){
            $date=date("Y-m-d",strtotime($_POST['date']));
            $comparisonstartdate=date('Y-m-1',strtotime($_POST['date']));
            $comparisonenddate=date("Y-m-t",strtotime($_POST['date']));
        }
        else{
            $date=date("Y-m-d");
            $comparisonstartdate=date('Y-m-1');
            $comparisonenddate=date("Y-m-t");
        }
        $data['date']=$date;
        $members=$this->charts_model->get_all_members();
        $baseUrl = $this->config->item('base_url');
        $fees_details=array();
        for($i=0;$i<sizeof($members);$i++){
            $members[$i]['fees_detail']=unserialize($members[$i]['fees_detail']);
        }
        foreach($members as $member){
            foreach($member['fees_detail'] as $fees){
                if($fees['payment_date']>=strtotime($comparisonstartdate) && $fees['payment_date']<=strtotime($comparisonenddate)){
                    $fees_details[]=array(
                        'title' => $member['name'],
                        'start' => date('Y-m-d',$fees['payment_date']),
                        'title' => $member['name'],
                        'url'   => $baseUrl."admin/members/view/".$member['id'],
                        'backgroundColor'=> '#00a65a', //Success (green)
                        'borderColor'    => '#00a65a'
                    );
                }
                
            }
        }
        $data['fees_detail']=$fees_details;
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/charts/calendar', $data);
		$this->load->view('admin/templates/footer', $data);
    }
}
