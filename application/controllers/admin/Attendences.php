<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendences extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('members_model');
        $this->load->model('dashboard_model');
        if(check_permission('attendences_access')){
        }else{
            redirect('admin/restricted');
        }
    }
    public function attendences(){
        $data=array();
        $data['page']="attendences";
        
        if(!empty($this->input->post('start_date'))){
            $attendences=$this->members_model->get_attendences_bydate($this->input->post('start_date'));
            if(!empty($attendences)){
                for($i=0;$i<sizeof($attendences);$i++){
                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
                    for($k=0;$k<sizeof($attendences[$i]['attendence']);$k++){
                        $attendences[$i]['attendence'][$k]['member_detail']=$this->members_model->GetMemberDetailById($attendences[$i]['attendence'][$k]['member_id']);
                        if(!empty($attendences[$i]['attendence'][$k]['member_detail'])){
                            $attendences[$i]['attendence'][$k]['member_detail']=$attendences[$i]['attendence'][$k]['member_detail'][0];
                        }
                    }
           
                }
            }   
            $startdate=date('Y-m-d',strtotime($this->input->post('start_date')));
            $enddate=date('Y-m-d',strtotime($this->input->post('end_date'). ' +1 day'));
            $range=$this->createDateRange($startdate, $enddate);
            $notfounddates=array();
            for($i=0;$i<sizeof($range);$i++){
                $status=false;
                for($j=0;$j<sizeof($attendences);$j++){
                    if($range[$i]==$attendences[$j]['date']){
                        $status=true;
                        $notfounddates[]=$attendences[$j];
                    }
                }
            }
            $attendences=$notfounddates;
            $data['attendences']=$attendences;
        }
        else{
            $data['attendences']=array();
        }
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/attendences', $data);
        $this->load->view('admin/templates/footer', $data);
    }
    public function attendencelist(){

		if($this->input->post('enddate')){
        $data=array();
        $activemembers=$this->members_model->get_all_member();
			
		$day=01;	
		$month=date("m",strtotime($this->input->post('enddate')));	
		$year=date("Y",strtotime($this->input->post('enddate')));	


		$totaldays=cal_days_in_month(CAL_GREGORIAN,$month,$year);
//		echo $month. ' and '.$year.' and days '. $totaldays;
//		exit;	
        $dayslimit=$totaldays;
        $attendences=$this->members_model->get_member_attendence_by_date($dayslimit);

$enddate=$year.'-'.$month.'-'.$dayslimit;
$startdate=$year.'-'.$month.'-'.$day;
			
//        $enddate=date('Y-m-d', strtotime(date('Y-m-d')));
//
//        $startdate=date('Y-m-d', strtotime('-'.$dayslimit.' days', strtotime($enddate)));
        $range=$this->createDateRange($startdate, $enddate);
			$totaldaysrange=sizeof($range);

        for($i=0;$i<sizeof($attendences);$i++){
            $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
        }
        for($m=0;$m<sizeof($activemembers);$m++){
            if($activemembers[$m]['package']!="" && $activemembers[$m]['package']!="custom"){
                $package=$this->members_model->get_packages($activemembers[$m]['package']);
                if(!empty($package[0])){
                    $activemembers[$m]['packagedetail']=$package[0];
                }
                else{
                    $activemembers[$m]['packagedetail']="";
                }
            }
            $memberattendence=array();
			$trainermemid;
			$tr_name;
            for($i=0;$i<sizeof($range);$i++){
                $status=false;
                for($j=0;$j<sizeof($attendences);$j++){
                    if($attendences[$j]['member_id']=$activemembers[$m]['id']){
						$trainermemid=$activemembers[$m]['trainer_id'];
						$trainermemname=$this->members_model->get_trainermembername($trainermemid);
						$tr_name=$trainermemname['name'];
						$activemembers[$m]['trainername']=$tr_name;
                        if($range[$i]==$attendences[$j]['date']){
                            $status=true;
                            $attendences[$j]['attendence'][0]['status']='present';
                            $memberattendence[]=$attendences[$j];
                        }
                    }
                }
                if($status==false){
                    $pusharray=array();
                    $pusharray['date']=$range[$i];
                    $pusharray['attendence'][0]['date']=$range[$i];
                    $pusharray['attendence'][0]['time_in']="00:00";
                    $pusharray['attendence'][0]['time_out']="00:00";
                    $pusharray['attendence'][0]['member_id']=$activemembers[$m]['id'];
                    $pusharray['attendence'][0]['status']="Absent";
                    $memberattendence[]=$pusharray;
                }
            }
            $activemembers[$m]['range_attendences']=$memberattendence;
        }

        $data['page']='';
        $data['members']=$activemembers;
        $data['daysrange']=$totaldaysrange;
//		echo '<pre>';
//		var_dump($data['members']);
//		exit;
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/attendencelist', $data);
        $this->load->view('admin/templates/footer', $data);
			
			
		}// If Brackets
		else{
			$data['page']="attendencelist";		
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/attendencelist', $data);
        $this->load->view('admin/templates/footer', $data);
		}
		
//        $data=array();
//        $activemembers=$this->members_model->get_all_member();
//        $dayslimit=10;
//        $attendences=$this->members_model->get_member_attendence_by_date($dayslimit);
//        
//        $enddate=date('Y-m-d', strtotime(date('Y-m-d')));
//
//        $startdate=date('Y-m-d', strtotime('-'.$dayslimit.' days', strtotime($enddate)));
//        $range=$this->createDateRange($startdate, $enddate);
//        for($i=0;$i<sizeof($attendences);$i++){
//            $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
//        }
//        for($m=0;$m<sizeof($activemembers);$m++){
//            if($activemembers[$m]['package']!="" && $activemembers[$m]['package']!="custom"){
//                $package=$this->members_model->get_packages($activemembers[$m]['package']);
//                if(!empty($package[0])){
//                    $activemembers[$m]['packagedetail']=$package[0];
//                }
//                else{
//                    $activemembers[$m]['packagedetail']="";
//                }
//            }
//            $memberattendence=array();
//            for($i=0;$i<sizeof($range);$i++){
//                $status=false;
//                for($j=0;$j<sizeof($attendences);$j++){
//                    if($attendences[$j]['member_id']=$activemembers[$m]['id']){
//                        if($range[$i]==$attendences[$j]['date']){
//                            $status=true;
//                            $attendences[$j]['attendence'][0]['status']='present';
//                            $memberattendence[]=$attendences[$j];
//                        }
//                    }
//                }
//                if($status==false){
//                    $pusharray=array();
//                    $pusharray['date']=$range[$i];
//                    $pusharray['attendence'][0]['date']=$range[$i];
//                    $pusharray['attendence'][0]['time_in']="00:00";
//                    $pusharray['attendence'][0]['time_out']="00:00";
//                    $pusharray['attendence'][0]['member_id']=$activemembers[$m]['id'];
//                    $pusharray['attendence'][0]['status']="Absent";
//                    $memberattendence[]=$pusharray;
//                }
//            }
//            $activemembers[$m]['range_attendences']=$memberattendence;
//        }
//
//        $data['page']='';
//        $data['members']=$activemembers;
//        $this->load->view('admin/templates/header', $data);
//        $this->load->view('admin/templates/sidebar', $data);
//        $this->load->view('admin/members/attendencelist', $data);
//        $this->load->view('admin/templates/footer', $data);
    }
    public function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        
        
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);

        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }
		$range[]=date('Y-m-d', strtotime('+1 days', strtotime($range[sizeof($range)-1])));

        return $range;
    }
    public function manual_attendednce(){
        $data=array();
        $activemembers=$this->dashboard_model->get_active_members();
        $data['members']=$activemembers;
        $data['page']="manualattendence";
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/members/manualattendence', $data);
        $this->load->view('admin/templates/footer', $data);
    } 
}
?>