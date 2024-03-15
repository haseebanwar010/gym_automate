<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getSettings'))
{
    function getSettings($var = '')
    {
		$result = mysql_query("SELECT * FROM site_settings ");
		$row = mysql_fetch_array($result);
		return $row;
	}   
}
if ( ! function_exists('is_user_logged_in'))
{
   function is_user_logged_in()
	{
		$CI =& get_instance();
		if($CI->session->userdata('logged_in'))
          {      
            return true;

           }else{
               return false;

            }
	}
}
if ( ! function_exists('setincometomonth'))
{
   function setincometomonth($incomedate="",$amount=0){
        $CI =& get_instance();
        $gymid=$CI->session->userdata('userid');
        $comparisondatetwo=$incomedate;
        $tablenametwo="tbl_expenses_".$gymid;
        $query = $CI->db->get_where($tablenametwo, array('month_date' => $comparisondatetwo ));
        $checkdatetwo=$query->result_array();
        if(empty($checkdatetwo)){
            $expensedata['month_date']=$comparisondatetwo;
            $expensedata['total_income']=$amount;
            $CI->db->insert($tablenametwo, $expensedata);
        }
        else{
            $CI->db->where('month_date', $comparisondatetwo);
            $expensedata['total_income']=$amount+$checkdatetwo[0]['total_income'];
            $CI->db->update($tablenametwo, $expensedata);
        }
   }
}
if ( ! function_exists('getUserByID'))
{
   function getUserByID($var ='')
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('frontend_users');
		$CI->db->where('id',$var);
		$query = $CI->db->get();
		return $query->result_array();
	}
}
if ( ! function_exists('getCountryByID'))
{
   function getCountryByID($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('tbl_countries');
		$CI->db->where('id',$id);
		$query = $CI->db->get();
		return $query->result_array();
	}
}
if ( ! function_exists('getSystemsettings'))
{
   function getSystemsettings($var ='')
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('tbl_gym');
		$CI->db->where('id',$var);
		$query = $CI->db->get();
		return $query->result_array();
	}
}
if ( ! function_exists('add_staffmember_ssalary_month'))
{
   function add_staffmember_ssalary_month(){
       $CI =& get_instance();
       $gymid=$CI->session->userdata('userid');
       $tablename="tbl_member_".$gymid;
       $CI->db->select('id,name,email,phone,cnic,address,commission_percentage,salary,training_fees');
       $CI->db->from($tablename);
       $CI->db->where('status',1);
       $CI->db->where('member_type',1);
       $query = $CI->db->get();
       $trainers=$query->result_array();
       foreach($trainers as $trainer){
           $paymenttable='tbl_staffmembers_payments_'.$gymid;
           $CI->db->select('id');
           $CI->db->from($paymenttable);
           $CI->db->where('member_id',$trainer['id']);
           $CI->db->where('date',date('Y-m-1'));
           $query = $CI->db->get();
           $check_already_added=$query->row_array();
           if(empty($check_already_added)){
               $pendingamount=0;
               $prevdate = date("Y-m-d", strtotime("first day of previous month"));
               $CI->db->select('pending_amount');
               $CI->db->from($paymenttable);
               $CI->db->where('member_id',$trainer['id']);
               $CI->db->where('date',$prevdate);
               $query = $CI->db->get();
               $previousmonthpending=$query->row_array();
               if(!empty($previousmonthpending)){
                   $pendingamount=$pendingamount+$previousmonthpending['pending_amount'];
               }
               $pendingamount=$pendingamount+$trainer['salary'];
               add_pendingpayment_staffmember($trainer['id'],$pendingamount,$gymid);
           }else{
               
           }
       }
       return true;
   }
}
if ( ! function_exists('add_pendingpayment_staffmember'))
{
   function add_pendingpayment_staffmember($memberid,$amount,$gymid){
       $paymenttablename='tbl_staffmembers_payments_'.$gymid;
       $currentmonthdate=date('Y-m-1');
       $CI =& get_instance();
       $CI->db->select('id,pending_amount');
       $CI->db->from($paymenttablename);
       $CI->db->where('member_id',$memberid);
       $CI->db->where('date',$currentmonthdate);
       $query = $CI->db->get();
       $checkpreviousrecordthismonth=$query->row_array();
       
       if(empty($checkpreviousrecordthismonth)){
           $data=array();
           $data['date']=$currentmonthdate;
           $data['member_id']=$memberid;
           $data['pending_amount']=$amount;
           return $CI->db->insert($paymenttablename, $data);
       }else{
           $data=array();
           $data['pending_amount']=$amount+$checkpreviousrecordthismonth['pending_amount'];
           
           $CI->db->where('date', $currentmonthdate);
           $CI->db->where('member_id', $memberid);
           return $CI->db->update($paymenttablename, $data);
       }
       
   }
}

if ( ! function_exists('sendpushnotification')){
   function sendpushnotification($title,$msg){
       $udid=get_mobile_udid();
       $url='https://android.googleapis.com/gcm/send';
       $server_key = 'AIzaSyCLqa1c6GBXEqVmZgx8ZWL4PDU3tRZG9HI';
       $data=array(
            'message' 	=> $msg,
	       'title'		=> $title,
       );
       $mobile_ids=array();
       if(!empty($udid)){
           $mobile_ids=unserialize($udid['mobile_udid']);
       }
//       $to=array($mobile_ids);
       $to=$mobile_ids;
       $fields = array();
       $fields['data'] = $data;
       if(is_array($to)){
	       $fields['registration_ids'] = $to;
       }else{
	       $fields['to'] = $to;
       }

       $headers = array(
	       'Content-Type:application/json',
            'Authorization:key='.$server_key
       );
			
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);
       if ($result === FALSE) {
           die('FCM Send Error: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
   }
}

if ( ! function_exists('get_trainer_byid'))
{
   function get_trainer_byid($trainerid){
       $CI =& get_instance();
       $gymid=$CI->session->userdata('userid');
       $tablename="tbl_member_".$gymid;
       $CI->db->select('id,name,phone,cnic,address,salary,training_fees,commission_percentage');
       $CI->db->where('id',$trainerid);
       $CI->db->where('member_type',1);
       $query = $CI->db->get($tablename);
       return $query->row_array();
   }
}

// if ( ! function_exists('calculatefees'))
// {
//    function calculatefees($core_fees,$trainerid){
//        if($trainerid==0 || $trainerid==null){
//            return $core_fees;
//        }else{
//            $CI =& get_instance();
//            $trainerdetail=get_trainer_byid($trainerid);
//            if(!empty($trainerdetail)){
//                $totalfees=$core_fees+$trainerdetail['training_fees'];
//            }else{
//                $totalfees=$core_fees;
//            }
//            return $totalfees;
//        }
//    }
// }

if ( ! function_exists('arhive_members')){
   function arhive_members(){
       $CI =& get_instance();
       $gymid=$CI->session->userdata('userid');
       $tablename="tbl_member_".$gymid;
       $CI->db->select('id,fee_date');
       $CI->db->where('gym_id',$gymid);
       $CI->db->where('status',0);
       $CI->db->where('archive_status',0);
       $query = $CI->db->get($tablename);
       $inactivemembers=$query->result_array();
       foreach($inactivemembers as $member){
           $feedateplus2month=strtotime("+2 month", $member['fee_date']);
           $cdate = strtotime(date('Y-m-d'));
           if($feedateplus2month<=$cdate){
               $updatedata=array();
               $updatedata['archive_status']=1;
               $CI->db->where('id', $member['id']);
               $CI->db->update($tablename, $updatedata);
           }
       }
   }
}
if ( ! function_exists('calculatefees')){
   function calculatefees($core_fees,$trainerid,$trainingfees,$commision_percentage){
       if($trainerid==0 || $trainerid==null){
           return $core_fees;
       }else{
           $percentval=($trainingfees*$commision_percentage)/100;
           return $core_fees+$trainingfees;
       }
   }
}


if ( ! function_exists('get_mobile_udid'))
{
   function get_mobile_udid(){
       $CI =& get_instance();
       $gymid=$CI->session->userdata('userid');
       $CI->db->select('mobile_udid');
       $CI->db->where('id',$gymid);
       $query = $CI->db->get('tbl_gym');
       return $query->row_array();
   }
}
if ( ! function_exists('check_permission'))
{
   function check_permission($permission_name=''){
       $CI =& get_instance();
       $authorization=$CI->session->userdata('authorization');
       
       if($CI->session->userdata('parent_gym')==1){
           return true;
       }else if(isset($authorization[$permission_name]) && $authorization[$permission_name]==1 && $CI->session->userdata('parent_gym')==0){
           return true;
       }else{
           return false;
       }
       
   }
}


