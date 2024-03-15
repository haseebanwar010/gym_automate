<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	protected $title = 'Gym';

	public function __construct()
        {
                parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
			$this->load->library('session');
				$this->load->model('dashboard_model');
			$this->load->model('members_model');


		  }
	
	public function index( $msg = NULL)
	{
        $data=array();
        $data['gym_detail']=$this->members_model->get_gym_detail($this->session->userdata('userid'));
       
        $data['page'] = 'dashboard';
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        else{
            
            add_staffmember_ssalary_month();   // Add pending amount script of staff members it will add the staff member salary of every month
            arhive_members();                  // This will change the archive members status if there fees date passed two months
            
            $gymsettings=getSystemsettings($_SESSION['userid']);
			//$allactivemembers=$this->dashboard_model->get_members();
			$data["totalmembers"]=$this->dashboard_model->get_total_members();
			$data["totalactivemembers"]=$this->dashboard_model->get_total_active_members();
			$data["activemembers"]=$this->dashboard_model->get_active_members();
			$data["totalinactivemembers"]=$this->dashboard_model->get_total_inactive_members();
			$total_todays_entrances=$this->dashboard_model->total_todays_entrances();
            
            //$data["total_todays_entrances"]
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
            
			$upcomingfeedata=$this->dashboard_model->get_members();
			/*echo "<pre>";
			var_dump($upcomingfeedata);
			exit;*/
			$upcomingfee=array();
			$pastfees=array();
			$pendingfeesthismonth=0;
			
			for($i=0;$i<sizeof($upcomingfeedata);$i++){
				$feedate=$upcomingfeedata[$i]['fee_date'];
				
				$cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
				$feedateplus2mont = strtotime("+".$gymsettings[0]['fees_limit']." days", $feedate); //adding days that is set in gym settings table 


				$cdate = strtotime(date('Y-m-d'));
				$feedateminus5days = strtotime("-".$gymsettings[0]['sms_limit']." days", $feedate);  // adding upcoming fees days limit set in settings table
				$feetime=date('Y-M-d',$feedate);
				/*echo $cdateplus2mont . "<br>";
				echo date("Y-M-d",$feedateminus5days);
				exit;*/
				$cmonth=date('M');
				$fmonth=date('M',$feedate);
                $cmonthday=date('d');
                $fmonthday=date('d',$feedate);
                
//				if($cmonth==$fmonth){
//                    if($fmonthday<$cmonthday){
//						
//                        $pendingfeesthismonth++;
//                    }
//				}
                if($feedate<$cdate){
                    $pendingfeesthismonth++;
                }

				if($cdate>=$feedateplus2mont){

					if($upcomingfeedata[$i]['payment_criteria']==1){
						//this is the condition for more than 2 months w8
						$this->dashboard_model->deactivate_member($upcomingfeedata[$i]['id']);
					}

				}
				elseif ($cdate>=$feedateminus5days && $cdate<=$feedate){
					if(isset($upcomingfeedata[$i]['package']) && $upcomingfeedata[$i]['package']!="custom" && $upcomingfeedata[$i]['package']!=""){
						$packagedetail=$this->members_model->get_packages($upcomingfeedata[$i]['package']);
						$upcomingfeedata[$i]['packagedetail']=$packagedetail[0];
					}
					$upcomingfee[]=$upcomingfeedata[$i];
				}
				elseif ($cdate>$feedate){


					$pastfees[]=$upcomingfeedata[$i];
				}


				//echo date('Y-M-d',$cdateplus2mont);
				//exit;
				/*if($upcomingfeedata[$i]['fees_detail']==""){
					$cdate = date('Y-m-d');
					//$time=$comments["result"][$i]['time'];
					$feedate=$upcomingfeedata[$i]['joining_date'];
					$feetime=date('Y-m-d',$feedate);
$minlimit=strtotime($feetime .' +25 day');

					$cdatestr=strtotime($cdate);

					if($cdatestr>$minlimit){
						$upcomingfeedata[$i]['upcomingdate']=strtotime($feetime .' +30 day');

						$upcomingfee[]=$upcomingfeedata[$i];
					}


				}
				*/

			}

$data['pendingfeesthismonth']=$pendingfeesthismonth;
			$data['upcomingfee']=$upcomingfee;
			$data['pastfeescount']=sizeof($pastfees);
			$data['upcomingfeecount']=sizeof($upcomingfee);
			$data['pastfees']=$pastfees;
			/*$cdate = date('Y-m-d');

			$prev_date1 = date('Y-m-d', strtotime($cdate .' -1 day'));
			$prev_date2 = date('Y-m-d', strtotime($cdate .' -2 day'));
			$prev_date3 = date('Y-m-d', strtotime($cdate .' -3 day'));
			$prev_date4 = date('Y-m-d', strtotime($cdate .' -4 day'));
			$prev_date5 = date('Y-m-d', strtotime($cdate .' -5 day'));
			echo $prev_date1." ".$prev_date2." ".$prev_date3." ".$prev_date4." ".$prev_date5." ";
			exit;
			echo "<pre>";
			var_dump($upcomingfeedata);
			exit;*/

            $this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar', $data);
				$this->load->view('admin/dashboard', $data);
				$this->load->view('admin/templates/footer', $data);
        }
				
		}
    public function present_today(){
        $data=array();
        $attendence=array();
        $total_todays_entrances=$this->dashboard_model->total_todays_entrances();
        
        $members=array();
        $temparray=array();
            $counter=0;
            if(!empty($total_todays_entrances)){
                $attendence=unserialize($total_todays_entrances['attendence']);
                for($i=0;$i<sizeof($attendence);$i++){
                
                    $attendence[$i]['member_detail']=$this->members_model->GetMemberDetailById($attendence[$i]['member_id']);
//                if (!in_array($att['member_id'], $temparray)){
//                    $counter++;
//                    $temparray[]=$att['member_id'];
//                }
                }
            }
            
//            foreach($temparray as $id){
//                $memberdata=$this->members_model->GetMemberDetailById($id);
//                if(!empty($memberdata)){
//                    $memberdata=$memberdata[0];
//                    $members[]=$memberdata;
//                }
//            }
        
        $data['page'] = '';
		$data['title']="Total Present Today";
		$data['members']=$attendence;
        
//        for($i=0;$i<sizeof($data['members']);$i++){
//            $memberfeesdetail=unserialize($data['members'][$i]['fees_detail']);
//            $feedate=date("m-d-Y",$data['members'][$i]['fee_date']);
//            $feemonth=date("M",$data['members'][$i]['fee_date']);
//            $last_day_this_month  = date('m-t-Y');
//            if($last_day_this_month>=$feedate){
//                $data['members'][$i]['currentmonthstatus']="unpaid";
//            }
//            else{
//                $data['members'][$i]['currentmonthstatus']="paid";
//            }
//            if($data['members'][$i]['package']!="" && $data['members'][$i]['package']!="custom"){
//                $package=$this->members_model->get_packages($data['members'][$i]['package']);
//                if(!empty($package[0])){
//                    $data['members'][$i]['packagedetail']=$package[0];
//                }
//                else{
//                    $data['members'][$i]['packagedetail']="";
//                }
//            }
//        }
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/present_today', $data);
		$this->load->view('admin/templates/footer', $data);
    }
	public function paidfees(){
		$upcomingfeedata=$this->dashboard_model->get_members();
		$data=array();
		$upcomingfee=array();
		$pastfees=array();
		$pendingfeesthismonth=array();
		$paidfeesthismonth=array();
		for($i=0;$i<sizeof($upcomingfeedata);$i++){


			if(isset($upcomingfeedata[$i]['package']) && $upcomingfeedata[$i]['package']!="custom"){

				if($upcomingfeedata[$i]['package']==null){}
				else{
					$packagedetail=$this->members_model->get_packages($upcomingfeedata[$i]['package']);
					if(!empty($packagedetail)){
						$upcomingfeedata[$i]['packagedetail']=$packagedetail[0];
					}
					else{
						$upcomingfeedata[$i]['packagedetail']="";
					}


				}

			}

			$feedate=$upcomingfeedata[$i]['fee_date'];
			$cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
			$feedateplus2mont = strtotime("+2 month", $feedate);
			$cdate = strtotime(date('Y-m-d'));
			$feedateminus5days = strtotime("-5 days", $feedate);
			$feetime=date('Y-M-d',$feedate);
			$cmonth=date('M');
			$fmonth=date('M',$feedate);
                $cmonthday=date('d');
                $fmonthday=date('d',$feedate);
            
           
            
            
			if($cmonth==$fmonth){
                if($fmonthday<$cmonthday){
				    $pendingfeesthismonth[]=$upcomingfeedata[$i];
                }
                else{
                    $paidfeesthismonth[]=$upcomingfeedata[$i];
                }
			}
			else{
                if($upcomingfeedata[$i]['status']==1){
				$paidfeesthismonth[]=$upcomingfeedata[$i];
                }
			}



		}
		$data['page'] = '';
		$data['title']="Paid Members";
		$data['members']=$paidfeesthismonth;
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/paidfees', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function pendingfees(){
		$upcomingfeedata=$this->dashboard_model->get_members();
		$data=array();
		$upcomingfee=array();
		$pastfees=array();
		$pendingfeesthismonth=array();
		$paidfeesthismonth=array();
		for($i=0;$i<sizeof($upcomingfeedata);$i++){

			if(isset($upcomingfeedata[$i]['package']) && $upcomingfeedata[$i]['package']!="custom"){

				if($upcomingfeedata[$i]['package']==null){}
				else{
					$packagedetail=$this->members_model->get_packages($upcomingfeedata[$i]['package']);
					if(!empty($packagedetail)){
						$upcomingfeedata[$i]['packagedetail']=$packagedetail[0];
					}
					else{
						$upcomingfeedata[$i]['packagedetail']="";
					}


				}

			}

			$feedate=$upcomingfeedata[$i]['fee_date'];
			$cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
			$feedateplus2mont = strtotime("+2 month", $feedate);
			$cdate = strtotime(date('Y-m-d'));
			$feedateminus5days = strtotime("-5 days", $feedate);
			$feetime=date('Y-M-d',$feedate);
			$cmonth=date('M');
			$fmonth=date('M',$feedate);
			
                $cmonthday=date('d');
                $fmonthday=date('d',$feedate);
            if($feedate<$cdate){
                    $pendingfeesthismonth[]=$upcomingfeedata[$i];
                }
//			if($cmonth==$fmonth){
//				    if($fmonthday<$cmonthday){
//						$pendingfeesthismonth[]=$upcomingfeedata[$i];
//                    }
//				
//			}
			else{
				$paidfeesthismonth[]=$upcomingfeedata[$i];
			}



		}
		$data['page'] = '';
		$data['title']="Pending Fees Members";
		$data['members']=$pendingfeesthismonth;
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/pendingfees', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function registeredmembers(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data['page'] = 'registeredcustom';
		$data['title']="Registered Members";
		$data['members']=$this->dashboard_model->get_all_members();
		for ($i=0;$i<sizeof($data['members']);$i++){
			if(isset($data['members'][$i]['package']) && $data['members'][$i]['package']!="custom"){

				if($data['members'][$i]['package']==null){}
				else{
					$packagedetail=$this->members_model->get_packages($data['members'][$i]['package']);
if(!empty($packagedetail)){
                $data['members'][$i]['packagedetail']=$packagedetail[0];
            }
else{
$data['members'][$i]['packagedetail']="";
}

					
				}

			}
		}


		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/registeredmembers', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function activemembers(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data['page'] = 'activemembers';
		$data['title']="Active Members";
		$data['members']=$this->dashboard_model->get_active_members();
		for ($i=0;$i<sizeof($data['members']);$i++){
			if(isset($data['members'][$i]['package']) && $data['members'][$i]['package']!="custom"){

				if($data['members'][$i]['package']==null){}
				else{
					$packagedetail=$this->members_model->get_packages($data['members'][$i]['package']);
if(!empty($packagedetail)){
                $data['members'][$i]['packagedetail']=$packagedetail[0];
            }
else{
$data['members'][$i]['packagedetail']="";
}
					
				}

			}
		}

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/registeredmembers', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function inactivemembers(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data['page'] = '';
		$data['title']="Inactive Members";
		$data['members']=$this->dashboard_model->get_inactive_members();

		for ($i=0;$i<sizeof($data['members']);$i++){
			if(isset($data['members'][$i]['package']) && $data['members'][$i]['package']!="custom"){

				if($data['members'][$i]['package']==null){}
				else{
					$packagedetail=$this->members_model->get_packages($data['members'][$i]['package']);
					if(!empty($packagedetail)){
                $data['members'][$i]['packagedetail']=$packagedetail[0];
            }
else{
$data['members'][$i]['packagedetail']="";
}
				}

			}
		}

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/registeredmembers', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function upcomingfeee(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data['page'] = '';
		$data['title']="Upcoming Fee";
		$upcomingfeedata=$this->dashboard_model->get_active_members();

$gymsettings=getSystemsettings($_SESSION['userid']);

		$upcomingfee=array();
		for($i=0;$i<sizeof($upcomingfeedata);$i++){
			$feedate=$upcomingfeedata[$i]['fee_date'];
			$cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
			$feedateplus2mont = strtotime("+2 month", $feedate);


			$cdate = strtotime(date('Y-m-d'));
			$feedateminus5days = strtotime("-".$gymsettings[0]['sms_limit']." days", $feedate);    // adding upcoming fees days limit set in settings table


			if($cdate>=$feedateplus2mont){
				/*comment the auto deactivate code of 2 month older meber without fee*/
				/*if($upcomingfeedata[$i]['payment_criteria']==1){
                    $this->dashboard_model->deactivate_member($upcomingfeedata[$i]['id']);
                }*/

			}
			elseif ($cdate>=$feedateminus5days && $cdate<=$feedate){
				//$upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);
				

				$upcomingfee[]=$upcomingfeedata[$i];
			}

		}

		$data['members']=$upcomingfee;
		$data['upcomingfeecount']=sizeof($upcomingfee);


		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/registeredmembers', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function pastfees(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data['page'] = '';
		$data['title']="Upcoming Fee";
		$upcomingfeedata=$this->dashboard_model->get_active_members();
		$pastfees=array();
		for($i=0;$i<sizeof($upcomingfeedata);$i++){
			$feedate=$upcomingfeedata[$i]['fee_date'];
			$cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
			$feedateplus2mont = strtotime("+2 month", $feedate);


			$cdate = strtotime(date('Y-m-d'));
			$feedateminus5days = strtotime("-5 days", $feedate);

			if ($cdate>$feedate){
				//$upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);

				$pastfees[]=$upcomingfeedata[$i];
			}

		}
		$data['members']=$pastfees;

		for ($i=0;$i<sizeof($data['members']);$i++){
			if(isset($data['members'][$i]['package']) && $data['members'][$i]['package']!="custom"){

				if($data['members'][$i]['package']==null){}
				else{
					$packagedetail=$this->members_model->get_packages($data['members'][$i]['package']);
					if(!empty($packagedetail)){
                $data['members'][$i]['packagedetail']=$packagedetail[0];
            }
else{
$data['members'][$i]['packagedetail']="";
}
				}

			}
		}

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/members/registeredmembers', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	public function chart(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		$data=array();
		$members=$this->dashboard_model->get_all_members();
		$upcomingfeedata=$this->dashboard_model->get_active_members();
		/*echo "<pre>";
		var_dump($members);
		exit;*/

		$pendingfeesthismonth=0;

		for($i=0;$i<sizeof($upcomingfeedata);$i++){
			$feedate=$upcomingfeedata[$i]['fee_date'];
			$cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
			$feedateplus2mont = strtotime("+2 month", $feedate);


			$cdate = strtotime(date('Y-m-d'));
			$feedateminus5days = strtotime("-5 days", $feedate);
			$feetime=date('Y-M-d',$feedate);
			/*echo $cdateplus2mont . "<br>";
            echo date("Y-M-d",$feedateminus5days);
            exit;*/
			$cmonth=date('M');
			$fmonth=date('M',$feedate);

			if($cmonth==$fmonth){

				$pendingfeesthismonth++;
			}

			if($cdate>=$feedateplus2mont){

				if($upcomingfeedata[$i]['payment_criteria']==1){
					//this is the condition for more than 2 months w8
					$this->dashboard_model->deactivate_member($upcomingfeedata[$i]['id']);
				}

			}
			elseif ($cdate>=$feedateminus5days && $cdate<=$feedate){
				$upcomingfee[]=$upcomingfeedata[$i];
			}
			elseif ($cdate>$feedate){


				$pastfees[]=$upcomingfeedata[$i];
			}


		}

		$data['pendingfeesthismonth']=$pendingfeesthismonth;
		$data['totalactivemembers']=sizeof($upcomingfeedata);



		$monthlyrevenue=array();
		$monthlyrevenue['January']['monthname']='January';
		$monthlyrevenue['January']['totalrevenue']=0;
		$monthlyrevenue['February']['monthname']='February';
		$monthlyrevenue['February']['totalrevenue']=0;
		$monthlyrevenue['March']['monthname']='March';
		$monthlyrevenue['March']['totalrevenue']=0;
		$monthlyrevenue['April']['monthname']='April';
		$monthlyrevenue['April']['totalrevenue']=0;
		$monthlyrevenue['May']['monthname']='May';
		$monthlyrevenue['May']['totalrevenue']=0;
		$monthlyrevenue['June']['monthname']='June';
		$monthlyrevenue['June']['totalrevenue']=0;
		$monthlyrevenue['July']['monthname']='July';
		$monthlyrevenue['July']['totalrevenue']=0;
		$monthlyrevenue['August']['monthname']='August';
		$monthlyrevenue['August']['totalrevenue']=0;
		$monthlyrevenue['September']['monthname']='September';
		$monthlyrevenue['September']['totalrevenue']=0;
		$monthlyrevenue['October']['monthname']='October';
		$monthlyrevenue['October']['totalrevenue']=0;
		$monthlyrevenue['November']['monthname']='November';
		$monthlyrevenue['November']['totalrevenue']=0;
		$monthlyrevenue['December']['monthname']='December';
		$monthlyrevenue['December']['totalrevenue']=0;

		for($i=0;$i<sizeof($members);$i++){

			if($members[$i]['fees_detail']!=""){

				$paymenthistory=unserialize($members[$i]['fees_detail']);


				for($j=0;$j<sizeof($paymenthistory);$j++){



					$cmonth=date('F');
					$cyear=date('Y');


					if(isset($paymenthistory[$j]['payment_date'])){
						$month=date('F',$paymenthistory[$j]['payment_date']);
						$year=date('Y',$paymenthistory[$j]['payment_date']);
						if($cyear==$year){
							if(isset($monthlyrevenue[$month]) && $monthlyrevenue[$month]!=""){
								$monthlyrevenue[$month]['monthname']=$month;
								$monthlyrevenue[$month]['totalrevenue']=$monthlyrevenue[$month]['totalrevenue']+$paymenthistory[$j]['fees'];
							}
							else{
								$monthlyrevenue[$month]['monthname']=$month;
								$monthlyrevenue[$month]['totalrevenue']=$paymenthistory[$j]['fees'];
							}
						}
					}
					elseif (isset($paymenthistory[$j]['payment_date'])){
						$month=date('F',$paymenthistory[$j]['payment_date']);
						$year=date('Y',$paymenthistory[$j]['payment_date']);
						if($cyear==$year){
							if(isset($monthlyrevenue[$month]) && $monthlyrevenue[$month]!=""){
								$monthlyrevenue[$month]['monthname']=$month;
								$monthlyrevenue[$month]['totalrevenue']=$monthlyrevenue[$month]['totalrevenue']+$paymenthistory[$j]['fees'];
							}
							else{
								$monthlyrevenue[$month]['monthname']=$month;
								$monthlyrevenue[$month]['totalrevenue']=$paymenthistory[$j]['fees'];
							}
						}
					}


					/*for($k=0;$k<sizeof($paymenthistory[$j]);$k++){

						$cmonth=date('F');
						$cyear=date('Y');


						if(isset($paymenthistory[$j][$k]['payment_date'])){
						$month=date('F',$paymenthistory[$j][$k]['payment_date']);
						$year=date('Y',$paymenthistory[$j][$k]['payment_date']);
							if($cyear==$year){
								if(isset($monthlyrevenue[$month]) && $monthlyrevenue[$month]!=""){
									$monthlyrevenue[$month]['monthname']=$month;
									$monthlyrevenue[$month]['totalrevenue']=$monthlyrevenue[$month]['totalrevenue']+$paymenthistory[$j][$k]['fees'];
								}
								else{
									$monthlyrevenue[$month]['monthname']=$month;
									$monthlyrevenue[$month]['totalrevenue']=$paymenthistory[$j][$k]['fees'];
								}
							}
						}
						elseif (isset($paymenthistory[$j]['payment_date'])){
							$month=date('F',$paymenthistory[$j]['payment_date']);
							$year=date('Y',$paymenthistory[$j]['payment_date']);
							if($cyear==$year){
								if(isset($monthlyrevenue[$month]) && $monthlyrevenue[$month]!=""){
									$monthlyrevenue[$month]['monthname']=$month;
									$monthlyrevenue[$month]['totalrevenue']=$monthlyrevenue[$month]['totalrevenue']+$paymenthistory[$j]['fees'];
								}
								else{
									$monthlyrevenue[$month]['monthname']=$month;
									$monthlyrevenue[$month]['totalrevenue']=$paymenthistory[$j]['fees'];
								}
							}
						}



					}*/

				}
			}

		}



		$data['page'] = 'chart';
		$data['monthlyrevenue']=$monthlyrevenue;
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/sidebar', $data);
		$this->load->view('admin/chart', $data);
		$this->load->view('admin/templates/footer', $data);
	}

	public function payfee(){
		if(! $this->session->userdata('validated')){
			redirect('auth');
		}

		if($this->dashboard_model->payfee()){
            $todayslog=$this->members_model->get_todayslog();
                    $logdetails=array();
                    $logdetails['member_id']=$this->input->post('id');
                    $logdetails['admin_name']=$this->session->userdata('username');
                    $logdetails['member_name']=$this->input->post('name');
                    $logdetails['currency_symbol']=$this->session->userdata('currency_symbol');
                    $logdetails['feee_amount']=$this->input->post('fees');
                    $logdetails['log_type']='payfee';
                    $logdetails['date']=date('d-M-Y');
                    $logdetails['time']=date("H:i:s");
                    $logdate=date('Y-m-d');
                    if(empty($todayslog)){
                        $serialized_log=array();
                        $serialized_log[0]=$logdetails;
                        $serialized_log=serialize($serialized_log);
                        $this->members_model->add_log($logdate,$serialized_log);
                    }
                    else{
                        $prev_logs=unserialize($todayslog['log_details']);
                        $serialized_log=array();
                        $serialized_log[0]=$logdetails;
                        foreach($prev_logs as $log){
                            $serialized_log[]=$log;
                        }
                        $serialized_log=serialize($serialized_log);
                        $this->members_model->update_log($serialized_log,$todayslog['id']);
                        
                    }
            
            
            
            
redirect('admin/members/view/'.$this->input->post('id').'/print');
			$data=array();
			$data['memberdetail']=$this->dashboard_model->getmemberbyid($this->input->post('id'));
			$data['gymdetail']=$this->dashboard_model->getgymbyid($data['memberdetail'][0]['gym_id']);
			$data['feepostdata']['fees']=$this->input->post('fees');
			$data['feepostdata']['comment']=$this->input->post('comment');
			$data['feepostdata']['payment_date']=$this->input->post('payment_date');

			ini_set('memory_limit', '256M');

			$this->load->library('pdf');
			$pdf = $this->pdf->load();



			$a = '';
			for ($i = 0; $i<8; $i++)
			{
				$a .= mt_rand(0,9);

			}
			$data['invoice_number'] = $a."-".time();
			$html=  $this->load->view('admin/feeinvoice', $data, true);

			$pdf->WriteHTML($html);

			$output = 'itemreport' . date('Y_m_d_H_i_s') . '_.pdf';
			$pdf->Output("$output", 'I');
			//echo "<pre>";
			//var_dump($data);



			//$html=$this->load->view('admin/templates/header', $data, true);




			/*$this->session->set_flashdata('msg', 'Fees Submitted Successfully!');
			redirect('admin');*/
		}
	}
    public function addattendence(){
      
        if(! $this->session->userdata('validated')){
			redirect('auth');
		}
        if($this->dashboard_model->addattendence()){
            $this->session->set_flashdata('msg', 'Attendence Added Successfully!');
            if($this->input->post('redirect')){
                redirect($this->input->post('redirect'));
            }else{
                redirect('admin/dashboard');
            }
            
        }
    }
    public function addcurrentattendence(){
        if($this->dashboard_model->addcurrentattendence()){
            echo "success";
        }
        else{
            echo "fails";
        }
    }
		public function edit($id = NULL)
		{
			if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		if($this->session->userdata('user_role')=='AGENT'){
				redirect('walkCustomer');
			}
			$user = $this->session->get_userdata();
			$data['page'] = 'dashboard';
			$image ='';
			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['shipments'] = $this->dashboard_model->get_shipments($id);
			$data['agents'] = $this->dashboard_model->get_agents();
			$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|alpha_numeric_spaces');
			$this->form_validation->set_rules('pick_address', 'Pick Address', 'required');
			$this->form_validation->set_rules('drop_address', 'Drop Address', 'required');
			$this->form_validation->set_rules('item_price', 'Item Price', 'required|numeric');
			$this->form_validation->set_rules('shipment_cost', 'Shipment Cost', 'required|numeric');
			//$this->form_validation->set_rules('payment_type', 'Item Price', 'required');
			$this->form_validation->set_rules('weight', 'Weight', 'required');
			//$this->form_validation->set_rules('agent_id', 'Agent Name', 'required');	
			$this->form_validation->set_rules('shipment_status', 'Shipment Status', 'required');	
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('administrator/templates/header', $data);
				$this->load->view('administrator/templates/sidebar', $data);
				$this->load->view('administrator/dashboard/edit', $data);
				$this->load->view('administrator/templates/footer', $data);
			}
			else
			{
				$weight = ($this->input->post('weight')*1000);
				
				
				/* Updated Code */
				$this->db->select('*');
            	$query = $this->db->get_where('shipment_rates', array('id' => $this->input->post('rate_id')));
            	$dataRates = $query->result_array();
				$city_from = $dataRates[0]['city_from'];
				$city_to = $dataRates[0]['city_to'];
				$type = $dataRates[0]['type'];
				if($type==1)
				{
					
					//echo "123";
					//exit;
					/*Cash On delivery  */
					$this->db->select('*');
					$query = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																		  'weight_to>=' => $weight,
																		  'city_from' => $city_from,
																		  'city_to' => $city_to,
																		  'type' => 1		
																					));
					$dataW = $query->result_array();
					if(empty($dataW)){
					/*Cash On delivery Weights Greater */
			
					$this->db->select('*');
				//$this->db->from('shipment_rates');
					$this->db->order_by("weight_to", "Desc");
					$this->db->limit('1');
					$QrySelect = $this->db->get_where('shipment_rates',array ( 'city_from' => $city_from,
										 'city_to' => $city_to,
											'type' => 1	)); 
				
					//$QrySelect = $this->db->get(); 
					$priceData = $QrySelect->result_array();
					
					if(empty($priceData))
					{
						
					//$dataResult['error']='true';
					//$dataResult['error_msg']="Shipments rates are not available.";
				
					}else{
				
					$weight_to = $priceData[0]['weight_to'];
					$extraW = ($weight-$weight_to); 
					$priceToHW = $priceData[0]['price'];
					
					
					$this->db->select('*');
					$query = $this->db->get_where('shipment_type', array('id' => 1));
					$shipmentTypeData =  $query->result_array();
					
					//$shipmentTypeData = $this->calculater_model->getShipmentType(1);
					
					$extraWInKG =ceil(($extraW/1000));
				
					/*Extra Price */
					$this->db->select('*');
					//$this->db->from('shipment_rates');
					$QrySelectExtra = $this->db->get_where('shipment_rates',array ( 'city_from' => $city_from,
										 'city_to' => $city_to,
										 'title'=>'extra',
											'type' => 1	)); 
					//$QrySelectExtra = $this->db->get(); 
					$priceDataExt = $QrySelectExtra->result_array();
					
					if(empty($priceDataExt))
					{
						//$dataResult['error']='true';
						//$dataResult['error_msg']="Shipments rates are not available ";
					
					}else{
						
						$extraPrice = ($extraWInKG*$priceDataExt[0]['price']);
						$price = ceil(($extraPrice+ $priceToHW));
						//$dataUP['fuel_charges'] = ceil(($price/100)*$shipmentTypeData[0]['fuel_charges']);
						//$dataUP['tax'] =  ceil(($price/100)*$shipmentTypeData[0]['tax']);
						//$dataUP['flyer_cost'] = ceil($shipmentTypeData[0]['flyer_cost']);
						$dataUP['shipment_cost'] = $price;//+$dataUP['fuel_charges']+$dataUP['tax'];//+$dataUP['flyer_cost'];
						//$dataResult['total_cost'] = $price+$fualCharges+$tax+$flyer;
						$dataResult['rate_id'] = $priceDataExt[0]['id'];
						$dataResult['total_cost'] = $price;
						$dataResult['total_cost'] = ceil($dataResult['total_cost']);
						$dataUP['rate_id'] = $priceDataExt[0]['id'];
						$dataUP['shipping'] = $dataResult['total_cost'];
						$dataUP['type'] = 1;
					}
				}
			
			}else{
				/*Cash On delivery Weights Less */
			
				$this->db->select('*');
				$QrySelect = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																  'weight_to>=' => $weight,
																  'city_from' => $city_from,
																  'city_to' => $city_to,
																  'type' => 1		
																			));
				$priceData = $QrySelect->result_array();
			
				if(empty($priceData))
				{
					//$dataResult['error']='true';
					//$dataResult['error_msg']="Shipments rates are not available ";
				}else{
					$price = $priceData[0]['price'];
			
					 
					$this->db->select('*');
					$query = $this->db->get_where('shipment_type', array('id' => 1));
					$shipmentTypeData =  $query->result_array();
			
					//$dataUP['fuel_charges'] = ceil(($price/100)*$shipmentTypeData[0]['fuel_charges']);
					//$dataUP['tax'] =  ceil(($price/100)*$shipmentTypeData[0]['tax']);
					//$dataUP['flyer_cost'] = ceil($shipmentTypeData[0]['flyer_cost']);
					$dataUP['shipment_cost'] = $price;//+$dataUP['fuel_charges']+$dataUP['tax'];//+$dataUP['flyer_cost'];
					//$data['shipment_cost'] = $price+$data['fual_charges']+$data['tax']+$data['flyer_cost'];
					
					//$fualCharges = ($price/100)*$shipmentTypeData[0]['fuel_charges'];
					//$tax =  ($price/100)*$shipmentTypeData[0]['tax'];
					//$flyer = $shipmentTypeData[0]['flyer_cost'];
					//$dataResult['total_cost'] = $price+$fualCharges+$tax+$flyer;
					$dataResult['rate_id'] = $priceData[0]['id'];
					$dataResult['total_cost'] = $price;
					$dataResult['total_cost'] = ceil($dataResult['total_cost']);
					$dataUP['rate_id'] = $priceData[0]['id'];
					$dataUP['shipping'] = $dataResult['total_cost'];
					$dataUP['type'] = 1;
				}
			}
				
		}else{
			
			/*Advance Payment */
		
			$this->db->select('*');
            $query = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																  'weight_to>=' => $weight,
																  'city_from' => $city_from,
																  'city_to' => $city_to,
																  'type' => 2		
																			));
            $dataW = $query->result_array();
			//var_dump($dataW);
			//exit;
			
			if(empty($dataW)){
				/*Advance Payment Weights Greater */
				
				$this->db->select('*');
				$this->db->order_by("weight_to", "Desc");
				$this->db->limit('1');//$this->db->from('shipment_rates');
				$QrySelect = $this->db->get_where('shipment_rates' , array ( 'city_from' => $city_from,
										 'city_to' => $city_to,
											'type' => 2	)); 
				
				//$QrySelect = $this->db->get(); 
				$priceData = $QrySelect->result_array();
				//var_dump($_POST);
					//exit;
				
				if(empty($priceData))
				{
					//$dataResult['error']='true';
					//$dataResult['error_msg']="Shipments rates are not available ";
				}else
				{
				    $weight_to = $priceData[0]['weight_to'];
					$extraW = ($weight-$weight_to); 
					$priceToHW = $priceData[0]['price'];
				
					$this->db->select('*');
					$query = $this->db->get_where('shipment_type', array('id' => 2));
					$shipmentTypeData =  $query->result_array();
					
					
					
					//$shipmentTypeData = $this->calculater_model->getShipmentType(2);
					
					
					
					
					$extraWInKG =ceil(($extraW/1000));
					/*Extra Price */
					
					$this->db->select('*');
					//$this->db->from('shipment_rates');
					$QrySelectExtra = $this->db->get_where('shipment_rates' , array ( 'city_from' => $city_from,
											 'city_to' => $city_to,
											 'title'=>'extra',
												'type' => 2	)); 
					//$QrySelectExtra = $this->db->get(); 
					$priceDataExt = $QrySelectExtra->result_array();
					
					
					if(empty($priceDataExt))
					{
						//$dataResult['error']='true';
						//$dataResult['error_msg']="Shipments rates are not available ";
					}else{
						$extraPrice = ($extraWInKG*$priceDataExt[0]['price']);
						$price = ceil(($extraPrice+ $priceToHW));
						//$dataUP['flyer_cost'] = $shipmentTypeData[0]['flyer_cost'];
						
						$dataUP['shipment_cost'] = $price; //+$dataUP['flyer_cost'];
						
						$dataResult['rate_id'] = $priceDataExt[0]['id'];//+$flyer;
						$dataResult['total_cost'] = $price;//+$flyer;
						$dataResult['total_cost'] = ceil($dataResult['total_cost']);
						$dataUP['rate_id'] = $priceDataExt[0]['id'];
						$dataUP['shipping'] = $dataResult['total_cost'];
						$dataUP['type'] = 2;
						
					}
				}
							
			}else{
				/*Advance Payment Weights Less */
				
				$this->db->select('*');
				$QrySelect = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																  'weight_to>=' => $weight,
																  'city_from' => $city_from,
																  'city_to' => $city_to,
																  'type' => 2		
																			));
				$priceData = $QrySelect->result_array();
				
				//var_dump($priceData);
				//exit;
				if(empty($priceData))
					{
						//$dataResult['error']='true';
						//$dataResult['error_msg']="Shipments rates are not available ";
					}else{
						$price = $priceData[0]['price'];
						
						$this->db->select('*');
						$query = $this->db->get_where('shipment_type', array('id' => 2));
						$shipmentTypeData =  $query->result_array();
					
						
						//$shipmentTypeData = $this->calculater_model->getShipmentType(2);
						
						
						//$dataUP['flyer_cost'] = $shipmentTypeData[0]['flyer_cost'];
						$dataUP['shipment_cost'] = $price;//+$dataUP['flyer_cost'];
						$dataResult['rate_id'] = $priceData[0]['id'];
						$dataResult['total_cost'] = $price;//+$flyer;
						$dataResult['total_cost'] = ceil($dataResult['total_cost']);
						$dataUP['rate_id'] = $priceData[0]['id'];
						$dataUP['shipping'] = $dataResult['total_cost'];
						$dataUP['type'] = 2;
						
					}
				
        	}
		
		}
		 //$dataResult['total_cost'] = ceil($dataResult['total_cost']);
		//echo json_encode($dataResult);
	
				
			
			/*end*/
			
			//exit;
				
					//var_dump($dataUP);
				//exit;
				
				
				$this->dashboard_model->update_shipments($dataUP);
				//exit;
				
				if($this->input->post('shipment_status')!='Pending')
				{
						
					$userData	= $this->users_model->get_users($this->input->post('user_id'));
					
					//var_dump($userData);
					//exit;
					$to = $userData[0]['email'];
					$from= "info@lead2need.com";
					$subject= "Information About Change status of your Shipment";
					$text = "Congrats! Your Shipment is under processing <br/>";
					//echo "123";
					//var_dump($_POST);
					//exit;
					send_email_custom($to, $from, $subject, $text);
						
				}
				$this->session->set_flashdata('msg', 'Shipments Information is updated successfully!');
				redirect('cargodash');
			}
		}
		public function view($id = NULL)
        {
			if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		if($this->session->userdata('user_role')=='AGENTS'){
				redirect('walkCustomer');
			}
			$data['page'] = 'dashboard';
            $data['shipments'] = $this->dashboard_model->get_shipments($id);
			$this->load->view('administrator/templates/header', $data);
			$this->load->view('administrator/templates/sidebar', $data);
			$this->load->view('administrator/dashboard/view', $data);
			$this->load->view('administrator/templates/footer', $data);
		}
	/*public function view($page = 'dashboard')
	{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}
	
			$data['title'] = ucfirst($page); // Capitalize the first letter
	
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view($page, $data);
			$this->load->view('templates/footer', $data);
	}*/
	
	public function delete($id = NULL){
		if($this->session->userdata('user_role')=='AGENT'){
				redirect('walkCustomer');
			}
			if($this->session->userdata('user_role')=='ADMIN'){
				redirect('cargodash');
			}
			$user = $this->session->get_userdata();
			if($this->dashboard_model->delete_shipments($id)){
				$this->session->set_flashdata('msg', 'Shipment is deleted successfully!');
				redirect('cargodash');
			}
			
		}
    public function joinscheck(){
        $this->dashboard_model->joinscheck();
    }
}
