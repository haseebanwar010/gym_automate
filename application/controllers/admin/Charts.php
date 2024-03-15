<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends CI_Controller {
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('dashboard_model');
        $this->load->model('charts_model');
        $this->load->model('members_model');
        $this->load->model('packages_model');
        if(check_permission('charts_access')){
            
        }else{
            redirect('admin/restricted');
        }
    }
	
	public function index( $msg = NULL){
        
    }
    public function attendencecharts(){
        $data=array();
        $data['page']="attendencecharts";
        $total_todays_entrances=$this->dashboard_model->total_todays_entrances();
        $temparray=array();
        $counter=0;
        if(!empty($total_todays_entrances)){
            $attendence=unserialize($total_todays_entrances['attendence']);
            foreach($attendence as $att){
                if (!in_array($att['member_id'], $temparray)){
                    $counter++;
                    $temparray[]=$att['member_id'];
                }
            }
        }
        $data["total_todays_entrances"]=$counter;
        $data["totalactivemembers"]=$this->dashboard_model->get_total_active_members();
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/charts/attendencecharts', $data);
		$this->load->view('admin/templates/footer', $data);
    }
    public function attendencechart1filter1(){
        $data=array();
        $data["totalactivemembers"]=$this->dashboard_model->get_total_active_members();
        $total_todays_entrances=$this->charts_model->total_entrances_filter();
        $temparray=array();
        $counter=0;
        if(!empty($total_todays_entrances)){
            $attendence=unserialize($total_todays_entrances['attendence']);
            foreach($attendence as $att){
                if (!in_array($att['member_id'], $temparray)){
                    $counter++;
                    $temparray[]=$att['member_id'];
                }
            }
        }
        $data["total_todays_entrances"]=$counter;
        echo json_encode($data);
    }
    
    public function attendencechart1filter2(){
        $output=array();
        $last_somedays_attendences=$this->charts_model->last_somedays_attendences();
        foreach($last_somedays_attendences as $attendencevar){
            $temparray=array();
            $counter=0;
            if(!empty($attendencevar)){
                $attendence=unserialize($attendencevar['attendence']);
                foreach($attendence as $att){
                    if (!in_array($att['member_id'], $temparray)){
                        $counter++;
                        $temparray[]=$att['member_id'];
                    }
                }
                $output['labeldata'][]=date('d-M-Y',strtotime($attendencevar['date']));
                $output['valuedata'][]=$counter;
            }
        }
        echo json_encode($output);
    }
    public function profitlosscharts(){
        $data=array();
        $data['page']="profitlosscharts";
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/charts/profitlosscharts', $data);
		$this->load->view('admin/templates/footer', $data);
    }
    public function profitlosscharts2(){
        $data=array();
        $data['page']="profitlosscharts2";
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/charts/profitlosscharts2', $data);
		$this->load->view('admin/templates/footer', $data);
    }
    public function reportscharts(){
        $data=array();
        $data['page']="reportscharts";
        $currentdate=date('Y-m-d');
        $datesarray=array();
        $output=array();
        $found=false;
        if($this->input->post('startdate') && $this->input->post('enddate')){
            $enddate=date('Y-m-d',strtotime($this->input->post('enddate')));
            $startdate=date('Y-m-d',strtotime($this->input->post('startdate')));
            $flag=0;
            while($found!=true){
                $datesarray[]=date('Y-m-d', strtotime('-'.$flag.' days', strtotime($enddate)));
                if($startdate==date('Y-m-d', strtotime('-'.$flag.' days', strtotime($enddate)))){
                    $found=true;
                }
                $flag++;
            }
        }
        else{
            for($i=0;$i<30;$i++){
                $datesarray[]=date('Y-m-d', strtotime('-'.$i.' days', strtotime($currentdate)));
            }
        }
        $data['members']=array();
        $data['feesmembers']=array();
        foreach($datesarray as $compare_date){
            $registrationscount=0;
            $registrationsdata=$this->charts_model->get_numberof_registration_bydate($compare_date);
            $registrationscount=sizeof($registrationsdata);
            $data['labels'][]=$compare_date;
            $data['number_of_registrations'][]=$registrationscount;
            for($i=0;$i<sizeof($registrationsdata);$i++){
                if($registrationsdata[$i]['package']!="" && $registrationsdata[$i]['package']!="custom"){
                    $package=$this->members_model->get_packages($registrationsdata[$i]['package']);
                    if(!empty($package[0])){
                        $registrationsdata[$i]['packagedetail']=$package[0];
                    }
                    else{
                        $registrationsdata[$i]['packagedetail']="";
                    }
                }
                $data['members'][]=$registrationsdata[$i];
            }
        }
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/charts/reportscharts', $data);
		$this->load->view('admin/templates/footer', $data);
    }
    public function feesreport(){
        $data=array();
        $data['page']="feesreport";
        $data['feesmembers']=array();
        if($this->input->post('startdate2') && $this->input->post('enddate2')){
            $allmembers=$this->charts_model->get_all_members();
            for($k=0;$k<sizeof($allmembers);$k++){
                if(!empty($allmembers[$k]['fees_detail'])){
                    $feesdetail=unserialize($allmembers[$k]['fees_detail']);
                    
                    $allmembers[$k]['fees_detail']=$feesdetail;
                }
                $lastindex=sizeof($allmembers[$k]['fees_detail'])-1;
                if($allmembers[$k]['fees_detail'][$lastindex]['payment_date']>=strtotime($this->input->post('startdate2')) && $allmembers[$k]['fees_detail'][$lastindex]['payment_date']<=strtotime($this->input->post('enddate2'))){
                    $data['feesmembers'][]=$allmembers[$k];
                }
            }
        }
        $this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/charts/feesreport', $data);
		$this->load->view('admin/templates/footer', $data);
    }
    public function getprofitlossdata(){
        $output=array();
        $currentdate=date('Y-m-1');
        $dates=array();
        if($this->input->post('startdate') && $this->input->post('enddate')){
            $enddate=date('Y-m-1',strtotime($this->input->post('enddate')));
            $startdate=date('Y-m-1',strtotime($this->input->post('startdate')));
            
            $dates[]=$enddate;
            $same=false;
            while($same != true) {
                $createdate=date("Y-m-1", strtotime("-1 month", strtotime($enddate)));
                $enddate=$createdate;
                $dates[]=$createdate;
                if($createdate==$startdate){
                    $same=true;
                }
            }
        }
        else{
            $dates[]=$currentdate;
            for($i=0;$i<6;$i++){
                $createdate=date("Y-m-1", strtotime("-1 month", strtotime($currentdate)));
                $currentdate=$createdate;
                $dates[]=$createdate;
            }
        }
        $tabledata=array();
        foreach($dates as $date){
            $profitlossdata=$this->charts_model->getprofitlossdata_bydate($date);
            if(empty($profitlossdata)){
                $output['label_data'][]=date('d-M-Y',strtotime($date));
                $output['total_expence'][]=0;
                $output['total_income'][]=0;
                $output['revenue'][]=0;
                $tabledata[]=array(
                    'date' => date('d-M-Y',strtotime($date)),
                    'total_expence' => $this->session->userdata['currency_symbol']."0",
                    'total_income' => $this->session->userdata['currency_symbol']."0",
                    'revenue' => $this->session->userdata['currency_symbol']."0"
                );
            }
            else{
                $output['label_data'][]=date('d-M-Y',strtotime($date));
                $output['total_expence'][]=$profitlossdata['total_expence'];
                $output['total_income'][]=$profitlossdata['total_income'];
                $output['revenue'][]=$profitlossdata['total_income']-$profitlossdata['total_expence'];
                $revenue=$profitlossdata['total_income']-$profitlossdata['total_expence'];
                if($revenue<0){
                    $revenue="(".$this->session->userdata['currency_symbol'].number_format(abs($revenue)).")";
                }
                else{
                    $revenue=$this->session->userdata['currency_symbol'].$revenue;
                }
                $tabledata[]=array(
                    'date' => date('d-M-Y',strtotime($date)),
                    'total_expence' => $this->session->userdata['currency_symbol'].number_format($profitlossdata['total_expence']),
                    'total_income' => $this->session->userdata['currency_symbol'].number_format($profitlossdata['total_income']),
                    'revenue' => $revenue
                );
            }
        }
        $output['tabledata']=$tabledata;
        echo json_encode($output);
    }
    public function registartionreportsdata(){
        $data=array();
        $currentdate=date('Y-m-d');
        $datesarray=array();
        $output=array();
        $found=false;
        if($this->input->post('startdate') && $this->input->post('enddate')){
            $enddate=date('Y-m-d',strtotime($this->input->post('enddate')));
            $startdate=date('Y-m-d',strtotime($this->input->post('startdate')));
            $flag=0;
            while($found!=true){
                $datesarray[]=date('Y-m-d', strtotime('-'.$flag.' days', strtotime($enddate)));
                if($startdate==date('Y-m-d', strtotime('-'.$flag.' days', strtotime($enddate)))){
                    $found=true;
                }
                $flag++;
            }
        }
        else{
            for($i=0;$i<30;$i++){
                $datesarray[]=date('Y-m-d', strtotime('-'.$i.' days', strtotime($currentdate)));
            }
        }
        foreach($datesarray as $compare_date){
            $registrationscount=$this->charts_model->get_numberof_registration_bydate($compare_date);
            $output['labels'][]=$compare_date;
            $output['number_of_registrations'][]=$registrationscount;
        }
        echo json_encode($output);
    }
	
}
