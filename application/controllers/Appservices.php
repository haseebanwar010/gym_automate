<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appservices extends CI_Controller {
   // public $baseUrl="http://localhost/calarepair2";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('appservices_model');
        $this->load->helper('url_helper');
        $this->load->library('session');
        date_default_timezone_set('Asia/Karachi');
        //$this->check_isvalidated();
    }
    public function index( $msg = NULL)
    {

      //echo "there";
        //exit;
        $data=0; 
        $admins = $this->appservices_model->get_admins();
      //$this->load->view('front/appservicesview', $data);
      
    }
    
    
    /*History services start*/
    public function get_memberregistrations_history(){
        $data=array();
        $currentdate=date('Y-m-d');
        $datesarray=array();
        $output=array();
        $found=false;
        $gymid=$this->input->post('gymid');
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
            $registrationsdata=$this->appservices_model->get_numberof_registration_bydate($compare_date,$gymid);
            
            $registrationscount=sizeof($registrationsdata);
            $data['labels'][]=$compare_date;
            $data['number_of_registrations'][]=$registrationscount;
            for($i=0;$i<sizeof($registrationsdata);$i++){
             $registrationsdata[$i]['fee_date']=date('d-M-Y',$registrationsdata[$i]['fee_date']);   
                if($registrationsdata[$i]['package']!="" && $registrationsdata[$i]['package']!="custom"){
                    $package=$this->appservices_model->GetpackageById($registrationsdata[$i]['package']);
                    
                    if(!empty($package[0])){
                        $registrationsdata[$i]['fees']=$package[0]['fees'];
                        $registrationsdata[$i]['packagedetail']=$package[0];
                    }
                    else{
                        $registrationsdata[$i]['packagedetail']="";
                    }
                }
                $data['members'][]=$registrationsdata[$i];
            }
            
        }
        echo json_encode($data);
    }
    public function get_feespaid_history(){
        $gymid=$this->input->post('gymid');
        $data=array();
        if($this->input->post('startdate') && $this->input->post('enddate')){

            $desireuesers=array();
            $allmembers=$this->appservices_model->get_all_members($gymid);
            for($k=0;$k<sizeof($allmembers);$k++){
                $allmembers[$k]['fee_date']=date('d-M-Y',$allmembers[$k]['fee_date']);
                if($allmembers[$k]['package']!="" && $allmembers[$k]['package']!="custom"){
                    $package=$this->appservices_model->GetpackageById($allmembers[$k]['package']);
                    
                    if(!empty($package[0])){
                        $allmembers[$k]['fees']=$package[0]['fees'];
                        $allmembers[$k]['packagedetail']=$package[0];
                    }
                    else{
                        $allmembers[$k]['packagedetail']="";
                    }
                }
           
                
                
                if(!empty($allmembers[$k]['fees_detail'])){
                    $feesdetail=unserialize($allmembers[$k]['fees_detail']);
                    for($j=0;$j<sizeof($feesdetail);$j++){
                        $feesdetail[$j]['payment_date']=date('d-M-Y',$feesdetail[$j]['payment_date']);
                    }
                    $allmembers[$k]['fees_detail']=$feesdetail;

                }
$indexnumberr=sizeof($allmembers[$k]['fees_detail'])-1;
                $lastfeesdate=$allmembers[$k]['fees_detail'][$indexnumberr]['payment_date'];

                $lastindex=sizeof($allmembers[$k]['fees_detail'])-1;
                if(strtotime($allmembers[$k]['fees_detail'][$lastindex]['payment_date'])>=strtotime($this->input->post('startdate')) && strtotime($allmembers[$k]['fees_detail'][$lastindex]['payment_date'])<=strtotime($this->input->post('enddate'))){

                    //$allmembers[$k]['payment_date']=date("d-M-Y",$allmembers[$k]['fees_detail'][$lastindex]['payment_date']);
                    $allmembers[$k]['lastfeesdate']=$lastfeesdate;
$desireuesers[]=$allmembers[$k];


                }
            }


             echo json_encode($desireuesers);
        }
        
    }
    public function get_all_logs(){
        $data=array();
        $gymid=$this->input->post('gymid');
        if($this->input->post('date') && !empty($this->input->post('date'))){
            $date=date('Y-m-d',strtotime($this->input->post('date')));
        }
        else{
            $date=date('Y-m-d');
        }
        
        $logs=$this->appservices_model->get_log_by_date($date,$gymid);
        
        $data['logs']=array();
        if(!empty($logs)){
            $logsdetails=unserialize($logs['log_details']);
            
            foreach($logsdetails as $log){
                $customarray=array();
                
                $logtext=$this->get_logtext($log);
                $customarray['text']=$logtext;
                if($log['log_type']=='delete_member'){
                    $customarray['member_id']='';
                }else{
                    $customarray['member_id']=$log['member_id'];
                }
                $data['logs'][]=$customarray;
            }
        }
        echo json_encode($data);
    }
    public function get_logtext($log){
        $baseurl=$this->config->item('base_url');
        if(!empty($log)){
            if($log['log_type']=='delete_member'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has deleted ".$log['member_name'];
            }
            else if($log['log_type']=='payfee_active'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has paid fee (".$log['currency_symbol'].$log['feee_amount'].") and activated ".$log['member_name'];
            }
            else if($log['log_type']=='payfee_rejoin'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has paid fee (".$log['currency_symbol'].$log['feee_amount'].") and rejoined ".$log['member_name'];
            }
            else if($log['log_type']=='payfee'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has paid fee (".$log['currency_symbol'].$log['feee_amount'].") of  ".$log['member_name'];
            }
            else if($log['log_type']=='edit_member'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has updated a member ".$log['member_name'];
            }
            else if($log['log_type']=='add_member'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has added a new member ".$log['member_name'];
            }
            return $text;
        }
        
    }
    /*History services end*/
    
    
    
    
    public function login(){

        //$data = json_decode(file_get_contents("php://input"));


        $email=$this->input->post('username');
        $password=$this->input->post('password');
        $result = $this->appservices_model->authenticate($email,$password);
if($result=="error"){
    echo $result;
}
        else{
            echo json_encode($result);
        }

    }

    public function dashboarddata(){

       // $data = json_decode(file_get_contents("php://input"));

        $gymid=$this->input->post('gymid');
        $gymsettings=getSystemsettings($gymid);
        $totalmembers=$this->appservices_model->get_total_members($gymid);
        $activemembers = $this->appservices_model->get_total_active_members($gymid);
        $inactivemembers = $this->appservices_model->get_total_inactive_members($gymid);
        
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);

        $total_todays_entrances=$this->appservices_model->total_todays_entrances($gymid);

        $totalincome = $this->appservices_model->get_total_income2($gymid);








            //$data["total_todays_entrances"]
            $temparray=array();
        $unserializeformdata=array();
        $counter=0;
        $finalincome=0;
        $totalusersincome=0;
        $currentdate=date('d-m-y');
$memberslist=array();


        
if(!empty($totalincome)){
  
    for($i=0;$i<sizeof($totalincome);$i++){
  
    
//    foreach($totalincome as $member){
        if(!empty($totalincome[$i]['fees_detail'])){
            $feedate=unserialize($totalincome[$i]['fees_detail']);
        }else{
            $feedate=array();
        }
                foreach($feedate as $fee){
                    
                    if(date('d-m-y',$fee['payment_date'])==$currentdate){
                        $totalusersincome=$totalusersincome+$fee['fees'];
                        
                        
                    }
                     
                }
       
    }
    
}



    
        
            if(!empty($total_todays_entrances)){
                $attendence=unserialize($total_todays_entrances['attendence']);
                foreach($attendence as $att){
                if (!in_array($att['member_id'], $temparray)){
                    $counter++;
                    $temparray[]=$att['member_id'];
                }
                }
            }
        

        $pastfees=array();
        $pendingfeesthismonth=0;
        $upcomingfee=array();
        
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            
            $feedate=$upcomingfeedata[$i]['fee_date'];
            
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+".$gymsettings[0]['fees_limit']." days", $feedate);

            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-".$gymsettings[0]['sms_limit']." days", $feedate);
            $feetime=date('Y-M-d',$feedate);
            
            $cmonth=date('M');
            $fmonth=date('M',$feedate);
            $cmonthday=date('d');
            $fmonthday=date('d',$feedate);

            if($feedate<$cdate){
                    $pendingfeesthismonth++;
                }

                if($cdate>=$feedateplus2mont){

                    if($upcomingfeedata[$i]['payment_criteria']==1){
                        //this is the condition for more than 2 months w8
//                      $this->appservices_model->deactivate_member($upcomingfeedata[$i]['id']);
                    }

                }
                elseif ($cdate>=$feedateminus5days && $cdate<=$feedate){
                    if(isset($upcomingfeedata[$i]['package']) && $upcomingfeedata[$i]['package']!="custom" && $upcomingfeedata[$i]['package']!=""){
                        $packagedetail=$this->appservices_model->GetpackageById($upcomingfeedata[$i]['package']);
                        $upcomingfeedata[$i]['packagedetail']=$packagedetail[0];
                    }
                   
                    $upcomingfee[]=$upcomingfeedata[$i];
                }
                elseif ($cdate>$feedate){


                    $pastfees[]=$upcomingfeedata[$i];
                }

        }

        $resultedarr=$activemembers-$pendingfeesthismonth;


        $data=array();
        $data['paidfees']=$activemembers-$pendingfeesthismonth;
        $data['pendingfeesthismonth']=$pendingfeesthismonth;
        $data['totalmembers']=$totalmembers;
        $data['activemembers']=$activemembers;
        $data['inactivemembers']=$inactivemembers;
        $data['pastfees']=sizeof($pastfees);
        $data["total_todays_entrances"]=$counter;
        //$data['todays_income']=$totalusersincome;
        $data['todays_income']=$totalusersincome;
        $data['upcoming_fee']=sizeof($upcomingfee);
//        $data['todays_income_members']=$memberslist;

        echo json_encode($data);
    }
    
public function incomelistusers($gymid=NULL){
$totalincome = $this->appservices_model->get_total_income2($gymid);
            
        $totalusersincome=0;
        $currentdate=date('d-m-y');
$memberslist=array();
if(!empty($totalincome)){
    
    for($i=0;$i<sizeof($totalincome);$i++){
  
    
//    foreach($totalincome as $member){
    $feedate=unserialize($totalincome[$i]['fees_detail']);

                foreach($feedate as $fee){
                    
                    if(date('d-m-y',$fee['payment_date'])==$currentdate){
                        $totalusersincome=$totalusersincome+$fee['fees'];
                        $totalincome[$i]['fee_date']=date('d-M-Y',$totalincome[$i]['fee_date']);
                        $memberslist[]=$totalincome[$i];
                        
                        
                    }
                     
                }
        
              
    }
        
//    }
    
    
//    $feedate=$totalincome['payment'];    
}
    
        $data=array();
        $data['todays_income']=$totalusersincome;
        $data['todays_income_members']=$memberslist;
        $data['cdate']=$currentdate;
    

        echo json_encode($data);  
}
    

public function searchfordate(){
       
    $data = json_decode(file_get_contents("php://input"));
    $gymid=$data->gymid;
    $posteddtae=date('d-m-y',strtotime($data->searchdate));
    
    $totalincome = $this->appservices_model->get_total_income2($gymid);
            
        $totalusersincome=0;
        
$memberslist=array();
if(!empty($totalincome)){
    for($i=0;$i<sizeof($totalincome);$i++){
  
    
//    foreach($totalincome as $member){
    $feedate=unserialize($totalincome[$i]['fees_detail']);

                foreach($feedate as $fee){
                    
                    if(date('d-m-y',$fee['payment_date'])==$posteddtae){
                        $totalusersincome=$totalusersincome+$fee['fees'];
                        $totalincome[$i]['fee_date']=date('d-M-Y',$totalincome[$i]['fee_date']);
                        $memberslist[]=$totalincome[$i];
                        
                        
                    }
                     
                }      
    }  
}
    
        $data=array();
        $data['todays_income']=$totalusersincome;
        $data['todays_income_members']=$memberslist;
    

        echo json_encode($data);  

    
    
}


    public function totalpresenttoday($gymid=NULL){
        $total_todays_entrances=$this->appservices_model->total_todays_entrances($gymid);

        
        $members=array();
        $temparray=array();
            $counter=0;
            if(!empty($total_todays_entrances)){
                $attendence=unserialize($total_todays_entrances['attendence']);
                for($i=0;$i<sizeof($attendence);$i++){
          
                    $attendence[$i]['member_detail']=$this->appservices_model->GetMemberDetailById1($attendence[$i]['member_id'],$gymid);
                    
                    $attendence[$i]['member_detail']['fee_date']=date('d-M-Y',$attendence[$i]['member_detail']['fee_date']);
                    
                    
//            
                }
            }
            
        $data['members']=$attendence;
        
        echo json_encode($attendence);
    }

    public function pastfeesmembers($gymid=NULL){
        $data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;
$gymid=$gymid;
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);
        $pastfees=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);

            if ($cdate>$feedate){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);

                $pastfees[]=$upcomingfeedata[$i];
            }

        }

        echo json_encode($pastfees);
    }


    public function paidfeesmembers($gymid=NULL){


        //$data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;
//$gymid=$gymid;
        $gymid=$this->input->post('gymid');
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);
        $pastfees=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            if($upcomingfeedata[$i]['package']!="" && $upcomingfeedata[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($upcomingfeedata[$i]['package']);
                $upcomingfeedata[$i]['fees']=$packagedetail[0]['fees'];
            }
            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);
            $cmonth=date('M');
            $fmonth=date('M',$feedate);
            if(isset($upcomingfeedata[$i]['fee_date']) && !empty($upcomingfeedata[$i]['fee_date'])){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);
            }
            if($cmonth==$fmonth){

                $pendingfeesthismonth[]=$upcomingfeedata[$i];
            }
            else{
                $paidfeesthismonth[]=$upcomingfeedata[$i];
            }


        }

        echo json_encode($paidfeesthismonth);
    }

    public function pendingfeesmembers($gymid=NULL){
        //$data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;
//$gymid=$gymid;
        $gymid=$this->input->post('gymid');
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);
        $pastfees=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){

            if($upcomingfeedata[$i]['package']!="" && $upcomingfeedata[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($upcomingfeedata[$i]['package']);
                $upcomingfeedata[$i]['fees']=$packagedetail[0]['fees'];
            }

            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);
            $cmonth=date('M');
            $fmonth=date('M',$feedate);
            if(isset($upcomingfeedata[$i]['fee_date']) && !empty($upcomingfeedata[$i]['fee_date'])){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);
            }
            $cmonthday=date('d');
            $fmonthday=date('d',$feedate);
            if($feedate<$cdate){
                    $pendingfeesthismonth[]=$upcomingfeedata[$i];
                }
            
            else{
                $paidfeesthismonth[]=$upcomingfeedata[$i];
            }

        }

        echo json_encode($pendingfeesthismonth);
    }

    public function upcomingfee($gymid=NULL){
$gymid=$gymid;
        $data = json_decode(file_get_contents("php://input"));

        //$gymid=$data->gymid;
        
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);


        $upcomingfee=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);


            if($cdate>=$feedateplus2mont){
                /*comment the auto deactivate code of 2 month older meber without fee*/
                /*if($upcomingfeedata[$i]['payment_criteria']==1){
                    $this->dashboard_model->deactivate_member($upcomingfeedata[$i]['id']);
                }*/

            }
            elseif ($cdate>=$feedateminus5days && $cdate<=$feedate){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);
                
                $upcomingfee[]=$upcomingfeedata[$i];
            }

        }
        $dataa=array();
        $dataa['upcomingfee']=$upcomingfee;
        $dataa['upcomingfeecount']=sizeof($upcomingfee);

        echo json_encode($dataa);
    }
    
    public function upcomingfeee(){
$gymid=$this->input->post('gymid');
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);

$gymsettings=getSystemsettings($gymid);

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
                if($upcomingfeedata[$i]['package']!="" && $upcomingfeedata[$i]['package']!="custom"){
                    $packagedetail=$this->appservices_model->GetpackageById($upcomingfeedata[$i]['package']);
                    $upcomingfeedata[$i]['fees']=$packagedetail[0]['fees'];
                }
                //$upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);
                $upcomingfee[]=$upcomingfeedata[$i];
            }

        }

        //$data['members']=$upcomingfee;
        //$data['upcomingfeecount']=sizeof($upcomingfee);
        echo json_encode($upcomingfee);

    }

    public function updateexpense(){
      if($this->appservices_model->update_expenses()){
          echo json_encode('true');
      }
    }

     public function edit_expenses(){
         
            $id=$this->input->post('id');
$gymid=$this->input->post('gymid');
        
        $data['expenses'] = $this->appservices_model->get_all_expenses($id,$gymid);

         if(!empty($data['expenses']['expenses'])){

             $data['expenses']['expenses']=unserialize($data['expenses']['expenses']);
for($i=0;$i<sizeof($data['expenses']['expenses']);$i++){
$fr=$i+1;
$data['expenses']['expenses'][$i]['indexid']=$i+1;
$data['expenses']['expenses'][$i]['titleid']="expensetitle$fr";
$data['expenses']['expenses'][$i]['amountid']="expenseamount$fr";
}

$data['expenses']['sizeofexpenses']=sizeof($data['expenses']['expenses']);

             echo json_encode($data);
         }
         

       
//          if (!$this->input->post())
//          {
//                
//                $this->load->view('admin/templates/header');
//                $this->load->view('admin/templates/sidebar', $data);
//                $this->load->view('admin/expenses/edit', $data);
//                $this->load->view('admin/templates/footer');
//          }
//          else
//          {
//                
//                    $this->expenses_model->update_expenses();
//                    $this->session->set_flashdata('msg', 'Expenses Information is updated Successfully!');
//                    redirect('expenses');
//
//            }
            
            
            
            
        }


    public function expenses()
    {
        $gymid=$this->input->post('gymid');
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $filterdata=array();
        $jsonexpenses=array();
        if($this->input->post('startdate') && !empty($this->input->post('startdate')) && $this->input->post('enddate') && !empty($this->input->post('enddate'))){
            
            $filterdata['start_date']=date('Y-m-1',strtotime($this->input->post('startdate')));
            $filterdata['end_date']=date('Y-m-30',strtotime($this->input->post('enddate')));
            $filterdata['gymid']=$this->input->post('gymid');
            $expenses = $this->appservices_model->get_expenses($filterdata);
            for($j=0; $j<sizeof($expenses);$j++){
                $expenses[$j]['expenses']=unserialize($expenses[$j]['expenses']);
                foreach($expenses[$j]['expenses'] as $expense){
                    $datatoassign=array();
                    $datatoassign['parent_id']=$expenses[$j]['id'];
                    $datatoassign['parent_expense_date']=$expenses[$j]['expense_date'];
                    $datatoassign['expense_title']=$expense['expense_title'];
                    $datatoassign['expense_amount']=$expense['expense_amount'];
                    $jsonexpenses[]=$datatoassign;
                }
            }
        }
        else{
            $data['expenses'] = $this->appservices_model->get_expenses();
        }
echo json_encode($jsonexpenses);

    }

public function addexpenses(){


        if($this->appservices_model->addexpenses()){
            echo json_encode('true');
        }
        
    }

    public function deleteexpenses(){
        
            $gymid=$this->input->post('gymid');
            $id=$this->input->post('id');
            $expensetitle=$this->input->post('title');
            $expenseamount=$this->input->post('amount');
            $date=strtotime($this->input->post('date'));
        
   
            if($this->appservices_model->delete_expense($gymid,$id,$expensetitle,$expenseamount,$date)){
               
echo json_encode('true');
            }
else{
 echo json_encode('false');
}
            
        }
    
    public function validateuser(){
        //$data = json_decode(file_get_contents("php://input"));
        $gymid=$this->input->post('gymid');
        $email=$this->input->post('email');
        $phone=$this->input->post('phone');
        $cnic=$this->input->post('cnic');

        $validate=$this->appservices_model->uservalidate($gymid,$email,$phone,$cnic);

        if(empty($validate)){

           echo "true";
        }
        else{
            echo "false";
        }
    }
    public function memberregistration(){
        $data = json_decode(file_get_contents("php://input"));

        $data=$_POST;

       // $validate=$this->appservices_model->uservalidate($data);


     /*   if(empty($validate)) {*/
           
            //echo "success";
            //exit;
            if(!empty($_FILES["file"]['name'])) {
                $new_name = time() . $_FILES["file"]['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = "./uploads/";
                $config['allowed_types'] = "gif|jpg|jpeg|png";
                //$config['max_size'] = "5000";
                //$config['max_width'] = "2000";
                //$config['max_height'] = "1280";
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    //echo $this->upload->display_errors();
                    echo "notallowed";
                    exit;
                } else {


                    $finfo = $this->upload->data();

                    $this->createThumbnail($finfo['file_name']);

                    $imagename = $finfo['file_name'];
                    @unlink("./uploads/$imagename");
                    $data['image'] = $imagename;


                    $output=$this->appservices_model->registeredmember($data);
                    if ($output) {

                        echo json_encode($output);
                        exit;
                        //echo "success";
                    } else {
                        echo "error";
                    }


                }

            }
            else{
                $data['image']="";
                $output=$this->appservices_model->registeredmember($data);
               
                if ($output) {


                    echo json_encode($output);
                    exit;
                } else {
                    echo "error";
                }
            }
            
            
            
            
      /*  }
        else{
            echo "alreadyuser";
        }*/
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
    public function packages(){
$gymid=$this->input->post('gymid');
        //$data = json_decode(file_get_contents("php://input"));
        $packages=$this->appservices_model->getpackages($gymid);
        echo json_encode($packages);
    }

    public function memberlist($gymid=NULL){
//        $data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;
$gymid=$this->input->post('gymid');

        $memberslist=$this->appservices_model->get_members($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            $memberslist[$i]['fee_date']=date("d-M-Y",$memberslist[$i]['fee_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        
        echo json_encode($memberslist);
    }
    
    
    
    public function staffmemberlist($gymid=NULL){

//        $data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;
        $gymid=$this->input->post('gymid');

        $staffmemberslist=$this->appservices_model->get_all_staff_members($gymid);
        for($i=0;$i<sizeof($staffmemberslist);$i++){
            $staffmemberslist[$i]['joining_date']=date("d-M-Y",$staffmemberslist[$i]['joining_date']);
        }
     
        echo json_encode($staffmemberslist);
    }
    



public function viewattendence(){

    
        $gymid=$this->input->post('gymid');
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $memberid=$this->input->post('memberid');
        $filterdata=array();        


        $data=array();

        if(!empty($this->input->post('startdate')) && !empty($this->input->post('enddate'))){

            
            $filterdata['start_date']=date('Y-m-1',strtotime($this->input->post('startdate')));
            $filterdata['end_date']=date('Y-m-30',strtotime($this->input->post('enddate')));
            $filterdata['gymid']=$this->input->post('gymid');

            $attendences=$this->appservices_model->get_staffmember_attendence($filterdata);
        


            if(!empty($attendences)){

                for($i=0;$i<sizeof($attendences);$i++){

                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);

                    $unsetindexes=array();

                    for($j=0;$j<sizeof($attendences[$i]['attendence']);$j++){

                        if($memberid!=$attendences[$i]['attendence'][$j]['member_id']){

                            $unsetindexes[]=$j;

                        }

                    }

                    for($k=0;$k<sizeof($unsetindexes);$k++){

                        unset($attendences[$i]['attendence'][$unsetindexes[$k]]);

                    }

                }


            }
            
            
                    

            $startdate=date('Y-m-d',strtotime($this->input->post('startdate')));
            $enddate=date('Y-m-d',strtotime($this->input->post('enddate'). ' +1 day'));
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

                if($status==false){
                    $pusharray=array();
                    $pusharray['date']=$range[$i];
                    $pusharray['attendence'][0]['date']=$range[$i];
                    $pusharray['attendence'][0]['time_in']="00:00";
                    $pusharray['attendence'][0]['time_out']="00:00";
                    $pusharray['attendence'][0]['member_id']=$memberid;
                    $pusharray['attendence'][0]['status']="Absent";
                    $notfounddates[]=$pusharray;
                }
        
            }
            $attendences=$notfounddates;
$data['attendences']=$attendences;



            
           // $data['attendences']=$attendences;
            echo json_encode($data);
        }
//        else if(!empty($this->input->post('dayslimit')) && !empty($this->input->post('dayslimit'))){
//            $attendences=$this->members_model->get_member_attendence_by_date($this->input->post('dayslimit'));
//            if(!empty($attendences)){
//                for($i=0;$i<sizeof($attendences);$i++){
//                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
//                    $unsetindexes=array();
//                    for($j=0;$j<sizeof($attendences[$i]['attendence']);$j++){
//                        if($memberid!=$attendences[$i]['attendence'][$j]['member_id']){
//                            $unsetindexes[]=$j;
//                        }
//                    }
//                    for($k=0;$k<sizeof($unsetindexes);$k++){
//                        unset($attendences[$i]['attendence'][$unsetindexes[$k]]);
//                    }
//                }
//            }
//            $enddate=strtotime(date('Y-m-d'));
//            $enddate=date('Y-m-d', strtotime('+1 days', $enddate));
//            $daystocompare=$this->input->post('dayslimit');
//            $startdate=date('Y-m-d', strtotime('-'.$daystocompare.' days', strtotime($enddate)));
//            $range=$this->createDateRange($startdate, $enddate);
//            $notfounddates=array();
//            for($i=0;$i<sizeof($range);$i++){
//                $status=false;
//                for($j=0;$j<sizeof($attendences);$j++){
//                    if($range[$i]==$attendences[$j]['date']){
//                        $status=true;
//                        $notfounddates[]=$attendences[$j];
//                    }
//                }
//                if($status==false){
//                    $pusharray=array();
//                    $pusharray['date']=$range[$i];
//                    $pusharray['attendence'][0]['date']=$range[$i];
//                    $pusharray['attendence'][0]['time_in']="00:00";
//                    $pusharray['attendence'][0]['time_out']="00:00";
//                    $pusharray['attendence'][0]['member_id']=$memberid;
//                    $pusharray['attendence'][0]['status']="Absent";
//                    $notfounddates[]=$pusharray;
//                }
//            }
//            $attendences=$notfounddates;
//            $data['attendences']=$attendences;
//        }
//        else{
//            $data['attendences']=array();
//        }
//        $data['filtermemberid']=$memberid;
//        $this->load->view('admin/templates/header', $data);
//        $this->load->view('admin/templates/sidebar', $data);
//        $this->load->view('admin/members/viewattendences', $data);
//        $this->load->view('admin/templates/footer', $data);
    }


public function viewtilltodayattendence(){
    
        $gymid=$this->input->post('gymid');
        $memberid=$this->input->post('memberid');
        $filterdata=array();        


        $data=array();

        if(!empty($this->input->post('gymid')) && !empty($this->input->post('memberid'))){

            $filterdata['gymid']=$this->input->post('gymid');

            $attendences=$this->appservices_model->get_till_today_staffmember_attendence($filterdata);
        


            if(!empty($attendences)){

                for($i=0;$i<sizeof($attendences);$i++){

                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);

                    $unsetindexes=array();

                    for($j=0;$j<sizeof($attendences[$i]['attendence']);$j++){

                        if($memberid!=$attendences[$i]['attendence'][$j]['member_id']){

                            $unsetindexes[]=$j;

                        }

                    }

                    for($k=0;$k<sizeof($unsetindexes);$k++){

                        unset($attendences[$i]['attendence'][$unsetindexes[$k]]);

                    }

                }


            }
            
            
        

           // $startdate=date('Y-m-d',strtotime($this->input->post('startdate')));
           // $enddate=date('Y-m-d',strtotime($this->input->post('enddate'). ' +1 day'));
            $startdate=date('Y-m-01');
            $enddate=date('Y-m-d',strtotime(" +1 day"));

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

                if($status==false){
                    $pusharray=array();
                    $pusharray['date']=$range[$i];
                    $pusharray['attendence'][0]['date']=$range[$i];
                    $pusharray['attendence'][0]['time_in']="00:00";
                    $pusharray['attendence'][0]['time_out']="00:00";
                    $pusharray['attendence'][0]['member_id']=$memberid;
                    $pusharray['attendence'][0]['status']="Absent";
                    $notfounddates[]=$pusharray;
                }
        
            }
            $attendences=$notfounddates;
$data['attendences']=$attendences;



            
           // $data['attendences']=$attendences;
            echo json_encode($data);
        }
//        else if(!empty($this->input->post('dayslimit')) && !empty($this->input->post('dayslimit'))){
//            $attendences=$this->members_model->get_member_attendence_by_date($this->input->post('dayslimit'));
//            if(!empty($attendences)){
//                for($i=0;$i<sizeof($attendences);$i++){
//                    $attendences[$i]['attendence']=unserialize($attendences[$i]['attendence']);
//                    $unsetindexes=array();
//                    for($j=0;$j<sizeof($attendences[$i]['attendence']);$j++){
//                        if($memberid!=$attendences[$i]['attendence'][$j]['member_id']){
//                            $unsetindexes[]=$j;
//                        }
//                    }
//                    for($k=0;$k<sizeof($unsetindexes);$k++){
//                        unset($attendences[$i]['attendence'][$unsetindexes[$k]]);
//                    }
//                }
//            }
//            $enddate=strtotime(date('Y-m-d'));
//            $enddate=date('Y-m-d', strtotime('+1 days', $enddate));
//            $daystocompare=$this->input->post('dayslimit');
//            $startdate=date('Y-m-d', strtotime('-'.$daystocompare.' days', strtotime($enddate)));
//            $range=$this->createDateRange($startdate, $enddate);
//            $notfounddates=array();
//            for($i=0;$i<sizeof($range);$i++){
//                $status=false;
//                for($j=0;$j<sizeof($attendences);$j++){
//                    if($range[$i]==$attendences[$j]['date']){
//                        $status=true;
//                        $notfounddates[]=$attendences[$j];
//                    }
//                }
//                if($status==false){
//                    $pusharray=array();
//                    $pusharray['date']=$range[$i];
//                    $pusharray['attendence'][0]['date']=$range[$i];
//                    $pusharray['attendence'][0]['time_in']="00:00";
//                    $pusharray['attendence'][0]['time_out']="00:00";
//                    $pusharray['attendence'][0]['member_id']=$memberid;
//                    $pusharray['attendence'][0]['status']="Absent";
//                    $notfounddates[]=$pusharray;
//                }
//            }
//            $attendences=$notfounddates;
//            $data['attendences']=$attendences;
//        }
//        else{
//            $data['attendences']=array();
//        }
//        $data['filtermemberid']=$memberid;
//        $this->load->view('admin/templates/header', $data);
//        $this->load->view('admin/templates/sidebar', $data);
//        $this->load->view('admin/members/viewattendences', $data);
//        $this->load->view('admin/templates/footer', $data);
    }


    public function createDateRange($startDate, $endDate, $format = "Y-m-d"){
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D'); // 1 Day
        $dateRange = new DatePeriod($begin, $interval, $end);
        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }
        return $range;
    }   
    
    
    public function incomelist($gymid=NULL){
        //$gymid=$data->gymid;
$gymid=$gymid;

        $memberslist=$this->appservices_model->get_feepaidmembers($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        echo json_encode($memberslist);
    }
    public function activemembers($gymid=NULL){
        //$data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;
//$gymid=$gymid;
        $gymid=$this->input->post('gymid');

        $memberslist=$this->appservices_model->get_activemembers($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            $memberslist[$i]['fee_date']=date("d-M-Y",$memberslist[$i]['fee_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        echo json_encode($memberslist);
    }
    public function inactivemembers($gymid=NULL){
        //$data = json_decode(file_get_contents("php://input"));
        //$gymid=$data->gymid;

//$gymid=$gymid;
$gymid=$this->input->post('gymid');

        $memberslist=$this->appservices_model->get_inactivemembers($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            $memberslist[$i]['fee_date']=date("d-M-Y",$memberslist[$i]['fee_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        echo json_encode($memberslist);
    }
    public function memberprofile(){
$gymid=$this->input->post('gymid');
$memberid=$this->input->post('memberid');
        $data=array();

        $EmpData = $this->appservices_model->GetMemberDetailById($memberid,$gymid);
        $data['member'] = $EmpData[0];


        $record=array();
        $record['memberdetail']['id']=$data['member']['id'];
        $record['memberdetail']['name']=$data['member']['name'];
        $record['memberdetail']['email']=$data['member']['email'];
        $record['memberdetail']['phone']=$data['member']['phone'];
        
        $record['memberdetail']['gender']=$data['member']['gender'];
        $record['memberdetail']['blood_group']=$data['member']['blood_group'];
        $record['memberdetail']['body_weight']=$data['member']['body_weight'];
        $record['memberdetail']['height']=$data['member']['height'];
        $record['memberdetail']['secondary_name']=$data['member']['secondary_name'];
        $record['memberdetail']['secondary_phone']=$data['member']['secondary_phone'];
        $record['memberdetail']['comment']=$data['member']['comment'];
        $record['memberdetail']['refrence_no']=$data['member']['refrence_no'];
        $record['memberdetail']['cnic']=$data['member']['cnic'];
        if(isset($data['member']['sms'])){
            $record['memberdetail']['sms']=$data['member']['sms'];
        }else{
            $record['memberdetail']['sms']=0;
        }

        $record['memberdetail']['address']=$data['member']['address'];
        $record['memberdetail']['package']=$data['member']['package'];

        $record['memberdetail']['image']=$data['member']['image'];

        if($record['memberdetail']['package']=="" || $record['memberdetail']['package']=="custom"){
            $record['memberdetail']['fees']=$data['member']['fees'];
            $record['memberdetail']['packagename']="";
            $record['memberdetail']['duration']=$data['member']['payment_criteria']." Month";
        }
        else{

            $packagedetail = $this->appservices_model->GetpackageById($record['memberdetail']['package']);

            $record['memberdetail']['fees']=$packagedetail[0]['fees'];
            $record['memberdetail']['packagename']=$packagedetail[0]['name'];
            $record['memberdetail']['duration']=$packagedetail[0]['duration']." Month";
        }

        $record['memberdetail']['joining_date']=date("d-M-Y",$data['member']['joining_date']);
        $record['memberdetail']['fee_date']=date("d-M-Y",$data['member']['fee_date']);

        if($data['member']['status']==1){$record['memberdetail']['status']="Active";}
        else{$record['memberdetail']['status']="Inctive";}

        $datatosearlize=array();
            if($data['member']['fees_detail']!=null){
                $fees_detail=$data['member']['fees_detail'];
                $unserdata=unserialize($fees_detail);

                for($j=0;$j<sizeof($unserdata);$j++){
                    $datatosearlize[]=$unserdata[$j];
                }

            }
        $record['fees_record']=$datatosearlize;
        for($i=0;$i<sizeof($record['fees_record']);$i++){
            $record['fees_record'][$i]['payment_date']=date("d-M-Y",$record['fees_record'][$i]['payment_date']);
        }
//        echo "<pre>";
//        var_dump($record);
//        exit;
        echo json_encode($record);

    }

    public function searchmember($gymid=NULL,$phone=NULL,$name=NULL){
        $data=json_decode(file_get_contents("php://input"));
$gymid=$gymid;
$phone=$phone;
$name=$name; 
        $members=$this->appservices_model->searchmembers($gymid,$phone,$name);
        if(!empty($members)){
            for ($i=0;$i<sizeof($members);$i++){
                if($members[$i]['package']!="custom" && $members[$i]['package']!=""){
                    $packagedetail=$this->appservices_model->GetpackageById($members[$i]['package']);
                    $members[$i]['fees']=$packagedetail[0]['fees'];
                }
            }
        }

        echo json_encode($members);
    }

    public function forgotpassword(){
        $data = json_decode(file_get_contents("php://input"));



        $this->load->helper('email');
        $this->load->library('email');



        if(isset($data)){
            $email=$data->email;

            $check=$this->appservices_model->Checkemail($email);

            if($check){


                $new_password= $this->appservices_model->Random_Code();


                $master_email = "danish.khan@abaskatech.com";
                $master_name = "Abaska";
                $customer_name=$check[0]['name'];

                $message = 'Dear '.$customer_name.'<br /><br />
                <br />Your password has been changed successfully.<br>
                New Password: '.$new_password;

                    $config['protocol'] = "smtp";
                    $config['smtp_host'] = "ssl://smtp.gmail.com";
                    $config['smtp_port'] = "465";
                    $config['smtp_user'] = "mike.smith92333@gmail.com";
                    $config['smtp_pass'] = "admin123asdf123";

                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->email->initialize($config);
                $this->email->from($master_email, $master_name);
                $this->email->to($email);
                $this->email->subject('New Password');
                $this->email->message($message);
                $this->email->send();
                echo $this->email->print_debugger();
                //$update=$this->appservices_model->customer_new_password($check[0]['id'],$new_password);
                /*if($update)
                {
                    echo 1;
                }*/
            }
            else{
                echo 0;
                exit;
            }


        }
    }
    public function checksms(){
        $data=json_decode(file_get_contents("php://input"));

        $dataa=array();
        $dataa['tablename']=$data->tablename;
        $dataa['memberid']=$data->memberid;
        $result=$this->appservices_model->updatesms($dataa);
        echo $result;
    }

    public function payfee(){
        $data=json_decode(file_get_contents("php://input"));
/*echo "<pre>";
        var_dump($data);
        exit;
*/
        if($this->appservices_model->payfee($data)){
            echo 1;
        }
        else{
            echo 0;
        }
    }

public function getchartsdata(){
    $postdata=json_decode(file_get_contents("php://input"));

    $postgymid=$postdata->gymid;

    $data=array();
    $members=$this->appservices_model->get_all_members($postgymid);
    $upcomingfeedata=$this->appservices_model->get_active_members($postgymid);
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
                //$this->dashboard_model->deactivate_member($upcomingfeedata[$i]['id']);
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


    $data['monthlyrevenue']=$monthlyrevenue;

   echo json_encode($data);
}
    
    public function removefees_entry($memberid){
        
        $gymid=$this->session->userdata('userid');
        $memberdetail=$this->appservices_model->GetMemberDetailById($memberid,$gymid);
        if(!empty($memberdetail)){
            $feeshistory=unserialize($memberdetail[0]['fees_detail']);
            $newfeeshistory=array();
            for($i=0;$i<sizeof($feeshistory);$i++){
                if($i+1==sizeof($feeshistory)){
//                    echo date('d-M-Y',$feeshistory[$i]['payment_date'])." ";
                }
                else{
                    $newfeeshistory[]=$feeshistory[$i];
                }
                
            }
            $datatoupdate=array();
            $datatoupdate['fees_detail']=serialize($newfeeshistory);
            $this->appservices_model->update_member_feeshistory($gymid,$memberid,$datatoupdate);
            echo "<pre>";
            var_dump($newfeeshistory);
            exit;
        }
        
    }
    
    
    public function saveudid(){
        $gymid=$this->input->post('gymid');
        $udid=$this->input->post('udid');
        $response=array();
        $previds=array();
        $oldudids=$this->appservices_model->getoldudids($gymid);
        if(!empty($oldudids)){
            $previds=unserialize($oldudids['mobile_udid']);
        }
//        echo "<pre>";
//        var_dump($previds);
//        exit;
        $newids=array();
        $found=false;
        foreach($previds as $id){
            if($id==$udid){
                $found=true;
            }
            $newids[]=$id;
        }
        if($found==false){
            $newids[]=$udid;
            $newids=serialize($newids);
            if($this->appservices_model->update_udid($gymid,$newids)){
                $response['response']='success';
            }else{
                $response['response']='error';
            }
        }
        else{
            $response['response']='success';
        }
        
        echo json_encode($response);
    }
    
    public function create_table_for_gyms_script(){
        $gyms=$this->appservices_model->get_all_gyms();
        foreach($gyms as $gym){
            $staffpaymentstablename="tbl_staffmembers_payments_".$gym['id'];
            $this->appservices_model->createstaffpaymentstable($staffpaymentstablename);
        }
    }
    
    
    
    public function exporttoexcel(){
        $inventory=$this->appservices_model->getinventory();
        $mrow=array();
        $mrow['productId']='productId';
        $mrow['disabled']='disabled';
        $mrow['productCode']='productCode';
        $mrow['quantity']='quantity';
        $mrow['testing_note']='testing_note';
        $mrow['description']='description';
        $mrow['image']='image';
        $mrow['noImages']='noImages';
        $mrow['price']='price';
        $mrow['name']='name';
        $mrow['cat_id']='cat_id';
        $mrow['popularity']='popularity';
        $mrow['sale_price']='sale_price';
        $mrow['stock_level']='stock_level';
        $mrow['cost']='cost';
        $mrow['stockWarn']='stockWarn';
        $mrow['useStockLevel']='useStockLevel';
        $mrow['digital']='digital';
        $mrow['digitalDir']='digitalDir';
        $mrow['prodWeight']='prodWeight';
        $mrow['taxType']='taxType';
        $mrow['tax_inclusive']='tax_inclusive';
        $mrow['showFeatured']='showFeatured';
        $mrow['showHome']='showHome';
        $mrow['prod_metatitle']='prod_metatitle';
        $mrow['prod_metadesc']='prod_metadesc';
        $mrow['prod_metakeywords']='prod_metakeywords';
        $mrow['eanupcCode']='eanupcCode';
        $mrow['date_added']='date_added';
        $mrow['seo_custom_url']='seo_custom_url';
        $mrow['freeshipping']='freeshipping';



        $filename = 'webdata_' . date('Ymd') . '.csv';
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/octet-stream");
        $out = fopen("php://output", 'w');  // write directly to php output, not to a file
        fputcsv($out, $mrow);
        foreach($inventory as $row)
        {
            fputcsv($out, $row);
        }
        fclose($out);
        exit;

        echo "<pre>";
        var_dump($inventory);
        exit;
    }

public function addhundredmembers(){
    exit;
    $name=array("iqbal gym","samnabad gym","valencia gym","rana gym","johar town gym","DHA gym","builder night","wapda town gym","builders house","Shadman gym",
                "iqbal gym12","samnabad gym12","valencia gym12","rana gym12","johar town gym12","DHA gym12","builder night12","wapda town gym12","builders house12","Shadman gym12",
                "iqbal gym34","samnabad gym34","valencia gym34","rana gym34","johar town gym34","DHA gym34","builder night34","wapda town gym34","builders house34","Shadman gym34",
                "iqbal gym45","samnabad gym45","valencia gym45","rana gym45","johar town gym45","DHA gym45","builder night45","wapda town gym45","builders house45","Shadman gym45",
                "iqbal gym65","samnabad gym65","valencia gym65","rana gym65","johar town gym65","DHA gym65","builder night65","wapda town gym65","builders house65","Shadman gym65",
                "iqbal gym76","samnabad gym76","valencia gym76","rana gym76","johar town gym76","DHA gym76","builder night76","wapda town gym76","builders house76","Shadman gym76",
                "iqbal gym88","samnabad gym88","valencia gym88","rana gym88","johar town gym88","DHA gym88","builder night88","wapda town gym88","builders house88","Shadman gym88",
                "iqbal gym99","samnabad gym99","valencia gym99","rana gym99","johar town gym99","DHA gym99","builder night99","wapda town gym99","builders house99","Shadman gym99",
                "iqbal gym44","samnabad gym44","valencia gym44","rana gym44","johar town gym44","DHA gym44","builder night44","wapda town gym44","builders house44","Shadman gym44",
                "iqbal gym11","samnabad gym11","valencia gym11","rana gym11","johar town gym11","DHA gym11","builder night11","wapda town gym11","builders house11","Shadman gym11"
               );
    $email=array('dansih@gmail.com','dawood@gmail.com','usman@gmail.com','umair@gmail.com','ahsan@gmail.com','sheri@gmail.com','ali@gmail.com','mahad@gmail.com','naqash@gmail.com','hussain@gmail.com',
                 'dansih@gmail12.com','dawood@gmail12.com','usman@gmail12.com','umair@gmail12.com','ahsan@gmail12.com','sheri@gmail12.com','ali@gmail12.com','mahad@gmail12.com','naqash@gmail12.com','hussain@gmail12.com',
                 'dansih@gmail33.com','dawood@gmail33.com','usman@gmail33.com','umair@gmail33.com','ahsan@gmail33.com','sheri@gmail33.com','ali@gmail33.com','mahad@gmail33.com','naqash@gmail33.com','hussain@gmail33.com',
                 'dansih@gmail55.com','dawood@gmail55.com','usman@gmail55.com','umair@gmail55.com','ahsan@gmail55.com','sheri@gmail55.com','ali@gmail55.com','mahad@gmail55.com','naqash@gmail55.com','hussain@gmail55.com',
                 'dansih@gmail76.com','dawood@gmail76.com','usman@gmail76.com','umair@gmail76.com','ahsan@gmail76.com','sheri@gmail76.com','ali@gmail76.com','mahad@gmail76.com','naqash@gmail76.com','hussain@gmail76.com',
                 'dansih@gmail88.com','dawood@gmail88.com','usman@gmail88.com','umair@gmail88.com','ahsan@gmail88.com','sheri@gmail88.com','ali@gmail88.com','mahad@gmail88.com','naqash@gmail88.com','hussain@gmail88.com',
                 'dansih@gmail98.com','dawood@gmail98.com','usman@gmail98.com','umair@gmail98.com','ahsan@gmail98.com','sheri@gmail98.com','ali@gmail98.com','mahad@gmail98.com','naqash@gmail98.com','hussain@gmail98.com',
                 'dansih@gmail14.com','dawood@gmail14.com','usman@gmail14.com','umair@gmail14.com','ahsan@gmail14.com','sheri@gmail14.com','ali@gmail14.com','mahad@gmail14.com','naqash@gmail14.com','hussain@gmail14.com',
                 'dansih@gmail87.com','dawood@gmail87.com','usman@gmail87.com','umair@gmail87.com','ahsan@gmail87.com','sheri@gmail87.com','ali@gmail87.com','mahad@gmail87.com','naqash@gmail87.com','hussain@gmail87.com',
                 'dansih@gmail54.com','dawood@gmail54.com','usman@gmail54.com','umair@gmail54.com','ahsan@gmail54.com','sheri@gmail54.com','ali@gmail54.com','mahad@gmail54.com','naqash@gmail54.com','hussain@gmail54.com'
                );
    $phone=array('0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757');
   
    
    $pcriteria=array(1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1);
    
    for($i=0;$i<100;$i++){
        $record=array();
        $record['name']=$name[$i];
        $record['user_name']="admin".$i;
        $record['email']=$email[$i];
        $record['phone']=$phone[$i];
        $record['address']="sample address".$i;
        $record['password']="40be4e59b9a2a2b5dffb918c0e86b3d7";
        $record['parent_gym']=0;
        $record['package_type']=$pcriteria[$i];
        $record['payment_criteria']=$pcriteria[$i];
        $record['status']=1;
        $this->appservices_model->registeredgym100($record);
    }
    
    
}



public function addspecifichundredmembers(){
exit;


$name=array('danish','usman','dawood','umair','ahmad','naqash','mahad','hussain','hassan','waqas',
    'danish 11','usman 11','dawood 11','umair 11','ahmad 11','naqash 11','mahad 11','hussain 11','hassan 11','waqas 11',
    'danish 22','usman 22','dawood 22','umair 22','ahmad 22','naqash 22','mahad 22','hussain 22','hassan 22','waqas 22',
    'danish 33','usman 33','dawood 33','umair 33','ahmad 33','naqash 33','mahad 33','hussain 33','hassan 33','waqas 33',
    'danish 44','usman 44','dawood 44','umair 44','ahmad 44','naqash 44','mahad 44','hussain 44','hassan 44','waqas 44',
    'danish 55','usman 55','dawood 55','umair 55','ahmad 55','naqash 55','mahad 55','hussain 55','hassan 55','waqas 55',
    'danish 66','usman 66','dawood 66','umair 66','ahmad 66','naqash 66','mahad 66','hussain 66','hassan 66','waqas 66',
    'danish 99','usman 99','dawood 99','umair 99','ahmad 99','naqash 99','mahad 99','hussain 99','hassan 99','waqas 99',
    'danish 77','usman 77','dawood 77','umair 77','ahmad 77','naqash 77','mahad 77','hussain 77','hassan 77','waqas 77',
    'danish 88','usman 88','dawood 88','umair 88','ahmad 88','naqash 88','mahad 88','hussain 88','hassan 88','waqas 88',);
    $email=array('danish@gmail.com','usman@gmail.com','dawood@gmail.com','umair@gmail.com','ahmad@gmail.com','naqash@gmail.com','mahad@gmail.com','hussain@gmail.com','hassan@gmail.com','waqas@gmail.com',
        'danish11@gmail.com','usman11@gmail.com','dawood11@gmail.com','umair11@gmail.com','ahmad11@gmail.com','naqash11@gmail.com','mahad11@gmail.com','hussain11@gmail.com','hassan11@gmail.com','waqas11@gmail.com',
        'danish22@gmail.com','usman22@gmail.com','dawood22@gmail.com','umair22@gmail.com','ahmad22@gmail.com','naqash22@gmail.com','mahad22@gmail.com','hussain22@gmail.com','hassan22@gmail.com','waqas22@gmail.com',
        'danish33@gmail.com','usman33@gmail.com','dawood33@gmail.com','umair33@gmail.com','ahmad33@gmail.com','naqash33@gmail.com','mahad33@gmail.com','hussain33@gmail.com','hassan33@gmail.com','waqas33@gmail.com',
        'danish44@gmail.com','usman44@gmail.com','dawood44@gmail.com','umair44@gmail.com','ahmad44@gmail.com','naqash44@gmail.com','mahad44@gmail.com','hussain44@gmail.com','hassan44@gmail.com','waqas44@gmail.com',
        'danish55@gmail.com','usman55@gmail.com','dawood55@gmail.com','umair55@gmail.com','ahmad55@gmail.com','naqash55@gmail.com','mahad55@gmail.com','hussain55@gmail.com','hassan55@gmail.com','waqas55@gmail.com',
        'danish66@gmail.com','usman66@gmail.com','dawood66@gmail.com','umair66@gmail.com','ahmad66@gmail.com','naqash66@gmail.com','mahad66@gmail.com','hussain66@gmail.com','hassan66@gmail.com','waqas66@gmail.com',
        'danish77@gmail.com','usman77@gmail.com','dawood77@gmail.com','umair77@gmail.com','ahmad77@gmail.com','naqash77@gmail.com','mahad77@gmail.com','hussain77@gmail.com','hassan77@gmail.com','waqas77@gmail.com',
        'danish88@gmail.com','usman88@gmail.com','dawood88@gmail.com','umair88@gmail.com','ahmad88@gmail.com','naqash88@gmail.com','mahad88@gmail.com','hussain88@gmail.com','hassan88@gmail.com','waqas88@gmail.com',
        'danish99@gmail.com','usman99@gmail.com','dawood99@gmail.com','umair99@gmail.com','ahmad99@gmail.com','naqash99@gmail.com','mahad99@gmail.com','hussain99@gmail.com','hassan99@gmail.com','waqas99@gmail.com',);
    $phone=array('0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757');
    $cnic=array('03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87669863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09887686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03497687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757');
    $fees=array(800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,
        1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,
        2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500);
    $pcriteria=array(1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6);
    $jdate=array(strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),);
    $fdate=array(strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),);

    for($i=6;$i<106;$i++){
        for($j=0;$j<100;$j++){
            $record=array();
            $record['name']=$name[$j]." admin".$i;
            $record['email']=$email[$j];
            $record['phone']=$phone[$j];
            $record['cnic']=$cnic[$j];
            $record['address']="sample address ".$j;
            $record['fees']=$fees[$j];
            $record['payment_criteria']=$pcriteria[$j];
            $record['joining_date']=$jdate[$j];
            $record['fee_date']=$fdate[$j];
            $record['gym_id']=$i;
            $record['status']=1;

            $this->appservices_model->addspecifichundredmembers($record);
        }
    }
}

    
}


?>
