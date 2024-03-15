<?php
class Appservices_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    /*History services start*/
    
    public function get_numberof_registration_bydate($date,$gymid){
        
		$tablename="tbl_member_".$gymid;
        $this->db->where('member_type', 0);
        $query=$this->db->where('joining_date', strtotime($date))->get($tablename);
        return $query->result_array();
    }
    public function get_log_by_date($date,$gymid){
		$tablename="tbl_logs_".$gymid;
        $query=$this->db->where('date',$date)->get($tablename);
        return $query->row_array();
   }
    /*History services end*/
    public function authenticate($email,$password){

        $this->db->where('user_name', $email);
        $this->db->where('password', md5($password));

        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();



        if(!empty($res))
        {
            $res['authorization']=unserialize($res['authorization']);
            $res['dashboard_access']=$res['authorization']['dashboard_access'];
            $res['members_access']=$res['authorization']['members_access'];
            $res['stats_access']=$res['authorization']['stats_access'];

            if($res['parent_gym']==0 && $res['super_gym_id']>0){
                $res['id']=$res['super_gym_id'];
                $superadmindata=$this->getsuperadmindata($res['super_gym_id']);
                if(!empty($superadmindata)){
                    $res['name']=$superadmindata['name'];
                }
            }
            if(isset($res['currency_id']) && $res['currency_id']!=0){
                $this->db->where('id', $res['currency_id']);
			     $query = $this->db->get('tbl_currencies');
			     $currencydata = $query->row_array();
                $res['currency_name']=$currencydata['currency_name'];
                $res['currency_symbol']=$currencydata['currency_symbol'];
            }
            else{
                $res['currency_name']="Ruppes";
                $res['currency_symbol']="Rs";
            }

            return $res;
        }
        return "error";


    }

    public function update_expenses()
    {


        $data = array();
$gymid=$this->input->post('gymid');
        $tablename="tbl_expenses_details_".$gymid;
$expenses=array();

        for($i=1;$i<=$this->input->post('counter');$i++){
             $expenses[]=array('expense_title' => $this->input->post('extitle'.$i) ,
                         'expense_amount' => $this->input->post('amount'.$i)
                         );
        }
       
        $data['expenses']=serialize($expenses);
        
        

        $this->db->where('id', $this->input->post('id'));
        $this->db->update($tablename, $data);
        if($this->updateexpensetotal(strtotime($this->input->post('myDate')),$gymid)){
            return true;
        }
    }

    public function get_all_expenses($id,$gymid){
        $tablename="tbl_expenses_details_".$gymid;
        $this->db->where('id', $id);
        $query=$this->db->get($tablename);

        return $query->row_array();
    }


public function addexpenses()
    {
       

        $expensedata = array();
        $expensedetaildata = array();

if($this->input->post('myDate')){
    $licount=$this->input->post('counter');
    $gymid=$this->input->post('gymid');
    $expenses=array();
    $totlaexpenseinput=0;
    for($i=1;$i<=$licount;$i++){
        $expenses[]=array('expense_title' => $this->input->post('extitle'.$i) ,
                         'expense_amount' => $this->input->post('amount'.$i)
                         );
        $totlaexpenseinput=$totlaexpenseinput+$this->input->post('amount'.$i);
    }

    /*comparison of date for tbl_expenses_details_ start*/
    $comparisondate=date('Y-m-d',strtotime($this->input->post('myDate')));
    
    $tablename="tbl_expenses_details_".$gymid;
    $query = $this->db->get_where($tablename, array('expense_date' => $comparisondate ));
    $checkdate=$query->result_array();
    
    if(empty($checkdate)){
        $expensedetaildata['expense_date']=$comparisondate;
        $expensedetaildata['expenses']=serialize($expenses);
        $this->db->insert($tablename, $expensedetaildata);
    }
    else{
        $unserializeddata=unserialize($checkdate[0]['expenses']);
       
        for($j=0;$j<sizeof($unserializeddata);$j++){
        $expenses[]=$unserializeddata[$j];
        }
        
        //$expenses[]=unserialize($checkdate[0]['expenses']);
        $expensedetaildata['expense_date']=$comparisondate;
        $expensedetaildata['expenses']=serialize($expenses);
       
        $this->db->where('id', $checkdate[0]['id']);
        $this->db->update($tablename, $expensedetaildata);
    }
    /*comparison of date for tbl_expenses_details_ end*/
    
    /*comparison of date for tbl_expenses_ start*/
    
    $comparisondatetwo=date('Y-m-1',strtotime($this->input->post('expense_date')));
    $tablenametwo="tbl_expenses_".$gymid;
    $query = $this->db->get_where($tablenametwo, array('month_date' => $comparisondatetwo ));
    $checkdatetwo=$query->result_array();
    if(empty($checkdatetwo)){
        $expensedata['month_date']=$comparisondatetwo;
        $expensedata['total_expence']=$totlaexpenseinput;
        return $this->db->insert($tablenametwo, $expensedata);
    }
    else{
//        $expensedata['month_date']=$comparisondatetwo;
        $expensedata['total_expence']=$totlaexpenseinput+$checkdatetwo[0]['total_expence'];
        $this->db->where('month_date', $comparisondatetwo);
        return $this->db->update($tablenametwo, $expensedata);
    }
    /*comparison of date for tbl_expenses_ end*/
    
    
}

        
    }


    public function get_expenses($filterdata=NULL)
    {
        $gymid=$filterdata['gymid'];
        $tablename="tbl_expenses_details_".$gymid;
        if($filterdata==NULL){
            $comparisonstartdate=date('Y-m-1');
            $comparisonenddate=date('Y-m-30');
        }
        else{
            $comparisonstartdate=$filterdata['start_date'];
            $comparisonenddate=$filterdata['end_date'];
        }
        

        $query=$this->db->where('`expense_date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        $result=$query->result_array();
        return $result;
    }

    public function delete_expense($gymid,$id,$expensetitle,$expenseamount,$date)
    {
       
        $tablename="tbl_expenses_details_".$gymid;
        
        $this->db->where('expense_date', date('Y-m-d',$date));
        $query=$this->db->get($tablename);
        $result=$query->result_array();
        $expenseupdate=array();
        $data=array();
        if(!empty($result)){
            $expenses=unserialize($result[0]['expenses']);
            foreach($expenses as $expense){
                if($expense['expense_title']!=$expensetitle && $expense['expense_amount']!=$expenseamount){
                    $expenseupdate[]=$expense;
                }
            }
        }
        $data['expenses']=serialize($expenseupdate);
        $this->db->where('id', $id);
        $this->db->update($tablename, $data);
        
        if($this->updateexpensetotal($date,$gymid)){
            return true;
        }
    }
    
    public function updateexpensetotal($date=NULL,$gymid=NULL){
       //$gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        $comparisonstartdate=date('Y-m-1',$date);
        $comparisonenddate=date('Y-m-30',$date);
        
        $query=$this->db->where('`expense_date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        $result=$query->result_array();
        $totalexpense=0;
        if(!empty($result)){
            $expenses=unserialize($result[0]['expenses']);
            for($i=0;$i<sizeof($expenses);$i++){
                $totalexpense=$totalexpense+$expenses[$i]['expense_amount'];
            }
            $data['total_expence']=$totalexpense;
            $tablenametwo="tbl_expenses_".$gymid;
            $this->db->where('month_date', $comparisonstartdate);
        return $this->db->update($tablenametwo, $data);
        }
        
    }

    public function getsuperadmindata($id){

        $this->db->where('id', $id);

        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();
        return $res;
    }
    
    public function get_total_members($gymid){
        $tablename="tbl_member_$gymid";
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        return $query->num_rows();
    }
public function get_total_income1($gymid){
        $gymid=$gymid;
    
        $tablename="tbl_member_".$gymid;
        $this->db->select('id,name,phone,fees_detail');
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
    $this->db->where('member_type', 0);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    
    
      //  $currentdate=date('Y-m-d');
        //$this->db->select('total_income');
 //$tablename="tbl_expenses_".$gymid; 
 //       $this->db->where('month_date', $currentdate);       
 //       $query=$this->db->get($tablename);
   
 //       $result = $query->row_array();
 //   if($result!=NULL){
      
 //       return $query->row_array();
 //   }
 //   else
 //   {
 //       return false;
 //   }
        
}  
    
public function get_total_income2($gymid){
        $gymid=$gymid;
    
        $tablename="tbl_member_".$gymid;
        $this->db->select('id,name,phone,fees_detail,fees,fee_date');
        $this->db->where('gym_id', $gymid);
//        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;   
}
    
public function get_feepaidmembers($gymid)
{
        $gymid=$gymid;
        $currentdate=date('Y-m-d');
        $this->db->where('month_date', $currentdate);       
        $tablename="tbl_expenses_".$gymid;  
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    
}

  
    public function get_total_active_members($gymid){

        $gymid=$gymid;
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        //$result = $query->result_array();

        return $query->num_rows();
    }
	public function total_todays_entrances($gymid){
        
		$tablename="tbl_attendence_".$gymid;
		//$tablename="tbl_attendence_136";
        $currentdate=date('Y-m-d');
//        $currentdate='2017-12-05';
        $this->db->where('date', $currentdate);
		$query=$this->db->get($tablename);

        return $query->row_array();
    }

    public function get_total_inactive_members($gymid){

        $gymid=$gymid;
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 0);
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        //$result = $query->result_array();

        return $query->num_rows();
    }
    public function get_members($gymid){
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->select('id, name, fees, package, fee_date, joining_date, image');
        $this->db->where('gym_id', $gymid);
        //$this->db->where('status', 1);
        $this->db->where('member_type', 0);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    }
	
    public function get_all_staff_members($gymid){
		
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->select('*');
        $this->db->where('gym_id', $gymid);
        //$this->db->where('status', 1);
        $this->db->where('member_type', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    }
	

	
    public function get_staffmember_attendence($filterdata){

        $gymid=$filterdata['gymid'];
        $tablename="tbl_attendence_".$gymid;


        if($filterdata==NULL){
            $comparisonstartdate=date('Y-m-1');
            $comparisonenddate=date('Y-m-30');
        }
        else{

            $startdate=$filterdata['start_date'];
            $enddate=$filterdata['end_date'];
			
			
            $comparisonstartday=date('d',strtotime($startdate));

            $comparisonstartmonth=date('m',strtotime($startdate));

            $comparisonstartyear=date('Y',strtotime($startdate));

         

            $comparisonendday=date('d',strtotime($enddate));

            $comparisonendmonth=date('m',strtotime($enddate));

            $comparisonendyear=date('Y',strtotime($enddate));

            

            

            $comparisonstartdate=$comparisonstartyear."-".$comparisonstartmonth."-".$comparisonstartday;

            $comparisonenddate=$comparisonendyear."-".$comparisonendmonth."-".$comparisonendday;

			

            $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);

//            $result=$query->result_array();


            return $query->result_array();
			
        }
		
//        if($filterdate==false){
//
//            $comparisonyear=date("Y");
//
//            $comparisonmonth=date("M"); 
//
//            $startdate=$this->input->post('start_date');
//
//            $enddate=$this->input->post('end_date');
//
//            $comparisonstartday=date('d',strtotime($startdate));
//
//            $comparisonstartmonth=date('m',strtotime($startdate));
//
//            $comparisonstartyear=date('Y',strtotime($startdate));
//
//         
//
//            $comparisonendday=date('d',strtotime($enddate));
//
//            $comparisonendmonth=date('m',strtotime($enddate));
//
//            $comparisonendyear=date('Y',strtotime($enddate));
//
//            
//
//            
//
//            $comparisonstartdate=$comparisonstartyear."-".$comparisonstartmonth."-".$comparisonstartday;
//
//            $comparisonenddate=$comparisonendyear."-".$comparisonendmonth."-".$comparisonendday;
//
//           
//
//            $comparisonquerystartdate="1-Jan-".$comparisonstartyear;
//
//            $comparisonqueryenddate="31-Dec-".$comparisonstartyear;
//
//            $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
//
//            $result=$query->result_array();
//
//            return $result;
//
//        }

    }	

	
    public function get_till_today_staffmember_attendence($filterdata){

        $gymid=$filterdata['gymid'];
        $tablename="tbl_attendence_".$gymid;


        if($filterdata==NULL){
            $comparisonstartdate=date('Y-m-1');
            $comparisonenddate=date('Y-m-30');
        }
        else{

            //$startdate=$filterdata['start_date'];
           // $enddate=$filterdata['end_date'];
			$startdate=date('Y-m-01');
			$enddate=date('Y-m-d');
			

            $comparisonstartday=date('d',strtotime($startdate));;

            $comparisonstartmonth=date('m',strtotime($startdate));

            $comparisonstartyear=date('Y',strtotime($startdate));

         

            $comparisonendday=date('d',strtotime($enddate));

            $comparisonendmonth=date('m',strtotime($enddate));

            $comparisonendyear=date('Y',strtotime($enddate));

            

            

            $comparisonstartdate=$comparisonstartyear."-".$comparisonstartmonth."-".$comparisonstartday;

            $comparisonenddate=$comparisonendyear."-".$comparisonendmonth."-".$comparisonendday;


            $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);

//            $result=$query->result_array();

//echo 'pre';
//var_dump($query->result_array());
//exit;

            return $query->result_array();
			
        }
		
//        if($filterdate==false){
//
//            $comparisonyear=date("Y");
//
//            $comparisonmonth=date("M"); 
//
//            $startdate=$this->input->post('start_date');
//
//            $enddate=$this->input->post('end_date');
//
//            $comparisonstartday=date('d',strtotime($startdate));
//
//            $comparisonstartmonth=date('m',strtotime($startdate));
//
//            $comparisonstartyear=date('Y',strtotime($startdate));
//
//         
//
//            $comparisonendday=date('d',strtotime($enddate));
//
//            $comparisonendmonth=date('m',strtotime($enddate));
//
//            $comparisonendyear=date('Y',strtotime($enddate));
//
//            
//
//            
//
//            $comparisonstartdate=$comparisonstartyear."-".$comparisonstartmonth."-".$comparisonstartday;
//
//            $comparisonenddate=$comparisonendyear."-".$comparisonendmonth."-".$comparisonendday;
//
//           
//
//            $comparisonquerystartdate="1-Jan-".$comparisonstartyear;
//
//            $comparisonqueryenddate="31-Dec-".$comparisonstartyear;
//
//            $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
//
//            $result=$query->result_array();
//
//            return $result;
//
//        }

    }	


    
    public function get_activemembers($gymid){
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
        $this->db->where('member_type', 0);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();

        return $result;
    }
    public function get_inactivemembers($gymid){
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 0);
        $this->db->where('member_type', 0);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    }

    public function GetpackageById($id){
        $this->db->where('id', $id);

        $query=$this->db->get('tbl_packages');
        $result = $query->result_array();

        return $result;
    }
    
    public function uservalidate($gymid,$email,$phone,$cnic){


        //$gymid=$data->gym_id;
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        //$email = $data->email;
        //$phone = $data->phone;
        //$cnic = $data->cnic;
        if(isset($scnic) && $cnic!="" ) {
            $sql = "select * from ".$tablename." where gym_id='" . $gymid . "' AND (
        email='" . $email . "' OR phone='" . $phone . "' OR cnic='" . $cnic . "')";
        }
        else{
            $sql = "select * from ".$tablename." where gym_id='" . $gymid . "' AND(
        email='" . $email . "' OR phone='" . $phone . "')";
        }

        $output=$this->db->query($sql)->result_array();
        echo json_encode($output);
        exit;
        return $output;
    }


    public function registeredmember($data){


        $record=array();
        $record['name']=$data['name'];
        $record['email']=$data['email'];
        $record['phone']=$data['phone'];
        $record['gender']=$data['gender'];
        $record['cnic']=$data['cnic'];
        $record['address']=$data['address'];
        $record['image']=$data['image'];
        $record['blood_group']=$data['blood_group'];
        $record['body_weight']=$data['body_weight'];

        $record['payment_criteria']=$data['payment_criteria'];
        $record['package']=$data['package_type'];
        $record['gym_id']=$data['gymid'];
        $record['status']=1;

        $datetime=$data['joining_date'];
        $jdate=substr($data['joining_date'],0,15);
        $record['joining_date']=strtotime($jdate);
        $today=date("Y/m/d");



        $record['fee_date'] = strtotime($jdate);
        if($record['package']=="" || $record['package']=="custom"){
            $record['fees']=$data['fees'];
            $record['fee_date'] = strtotime("+".$record['payment_criteria']." month", $record['fee_date']);

            $dataa=array();
            $dataa['payment_date'] = $record['joining_date'];
            $dataa['fees'] = $record['fees'];
            $dataa['comment']="";
        }
        else{




            $packagedetail=$this->GetpackageById($record['package']);
            $record['fee_date'] = strtotime("+".$packagedetail[0]['duration']." month", $record['fee_date']);
            $record['fees']=$packagedetail[0]['fees'];
            $dataa=array();
            $dataa['payment_date'] = $record['joining_date'];
            $dataa['fees'] = $packagedetail[0]['admission_fees']+$packagedetail[0]['fees'];
            $dataa['comment']="";
        }

        $datatosearlize[]=$dataa;
        $searilizeddetail=serialize($datatosearlize);
        $record['fees_detail']=$searilizeddetail;
        $tablename="tbl_member_".$record['gym_id'];

        $this->db->insert($tablename, $record);
        $insert_id = $this->db->insert_id();
        //$lastid=$lastone->row;

        if(isset($insert_id) && $insert_id!=0){
            $insertedrecord=$this->GetMemberDetailById($insert_id,$record['gym_id']);
            if(!empty($insertedrecord)){
                if($insertedrecord[0]['package']!="custom"){
                    $insertedrecord[0]['packagedetail']=$this->get_packages($insertedrecord[0]['package']);
                }
            }
            return $insertedrecord[0];
        }

    }
    public function getpackages($gymid){
        //$gymid=$data->gymid;
        //$this->db->select('name');
        $this->db->where('gym_id', $gymid);
        $query=$this->db->get('tbl_packages'); 
        return $query->result_array();
    }
    public function GetMemberDetailById1($id=NULL,$gymid=null){
            $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->where('id', $id);
        $query=$this->db->get($tablename);
        return $query->row_array();
    }
    public function GetMemberDetailById($id=NULL,$gymid=null){
        
        $tablename="tbl_member_".$gymid;
        //$tablename="tbl_member_136";
        $this->db->where('id', $id);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }

    public function Checkemail($email=NULL){

        $this->db->where('email', $email);
        $query=$this->db->get('tbl_gym');
        return $query->result_array();
    }

    public function Random_Code($length=10)
    {
        $chars = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N",
            "O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3",
            "4","5","6","7","8","9","0");
        $max_chars = count($chars) - 1;
        srand((double)microtime()*1000000);
        $randChars='';
        for ($i = 0; $i < $length; $i++) {
            $randChars .= ($i == 0) ? $chars[rand(0, $max_chars)] :$chars[rand(0, $max_chars)];
        }
        return $randChars;
    }

    public function customer_new_password($customer_id='',$password='')
    {
        $this->load->helper('url');
        $data = array();
        if($customer_id!='' && $password!='')
        {
            $data['password']= md5($password);
            return $this->db->where('id',$customer_id)->set($data)->update_all('tbl_gym');
        }
        return false;
    }



    public function updatesms($data){

        $query = $this->db->get_where($data['tablename'], array('id' => $data['memberid']));
        $result=$query->result_array();

        if(isset($result[0]['sms'])){

            if($result[0]['sms']<2){
                $dataa['sms']=$result[0]['sms']+1;

                $this->db->where('id', $data['memberid']);
                return $this->db->update($data['tablename'], $dataa);
            }
        }
        else{
echo "error";
        }
    }
public function update_member_feeshistory($gymid,$memberid,$datatoupdate){
    $tablename="tbl_member_".$gymid;
    $this->db->where('id', $memberid);
    return $this->db->update($tablename, $datatoupdate);
}
    public function searchmembers($gymid=NULL,$phone=NULL,$name=NULL){




$phone=$phone;
            $name=$name;
            $gymid=$gymid;
            $tablename="tbl_member_".$gymid;
            //$tablename="tbl_member_136";
if($name!=NULL  && $name!=undefined){

$this->db->where('name', $name);
}
if($phone!=NULL && $phone!=undefined){
$this->db->like('phone', $phone);
}
            $this->db->where('member_type', 0);
            
            //$this->db->where('gym_id', $gymid);
            $query = $this->db->get($tablename);
            $res= $query->result_array();





   /*     if(!empty($phone) && !empty($name)){



            

        }
        else if(!empty($name)){
echo $name;
exit;
            $name=$name;
            $gymid=$gymid;
            $tablename="tbl_member_".$gymid;
            $this->db->like('name', $name);
            $this->db->where('gym_id', $gymid);
            $query = $this->db->get($tablename);
            $res= $query->result_array();
        }
        else if(!empty($phone)){
echo $phone;
exit;
            $phone=$phone;
            $gymid=$gymid;
            $tablename="tbl_member_".$gymid;
            //$tablename="tbl_member_136";
            $this->db->like('phone', $phone);
            $this->db->where('gym_id', $gymid);
            $query = $this->db->get($tablename);
            $res= $query->result_array();
        }
*/
        for ($i=0;$i<sizeof($res);$i++){
            $res[$i]['joining_date']=date("Y-M-d",$res[$i]['joining_date']);
            $res[$i]['fee_date']=date("Y-M-d",$res[$i]['fee_date']);
        }
return $res;


    }


    public function payfee($record){

        /*echo "<pre>";
        var_dump($record);
        exit;*/
        $gymid=$record->gymid;
        $tablename="tbl_member_".$gymid;
        $tablename="tbl_member_136";
        $dataa=array();

        if(isset($record->payment_date) && $record->payment_date!=""){
            $dataa['payment_date'] = strtotime($record->payment_date);
        }
        else{
            $dataa['payment_date'] = strtotime(date("d-M-y"));
        }

            $dataa['fees'] = $record->fees;
        if(isset($record->comment) && $record->comment!=""){
            $dataa['comment'] = $record->comment;
        }
        else{
            $dataa['comment'] = "";
        }




        $this->db->where('id',$record->memberid);
        $query=$this->db->get($tablename);
        $getdata=$query->result_array();

/*echo "<pre>";
        var_dump($getdata);
        exit;*/

        if($getdata[0]['package']=="" || $getdata[0]['package']=="custom"){
            $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", $getdata[0]['fee_date']);
            $data['fee_date']=$updateddate;
        }
        else{

            $packagedetail=$this->GetpackageById($getdata[0]['package']);

            $updateddate = strtotime("+".$packagedetail[0]['duration'] ." months", $getdata[0]['fee_date']);
            $data['fee_date']=$updateddate;
        }

        if($getdata[0]['status']==0){

            $data['status']=1;
            if($getdata[0]['package']=="" || $getdata[0]['package']=="custom"){
                $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", $dataa['payment_date']);
                $data['fee_date']=$updateddate;
            }
            else{
                $packagedetail=$this->GetpackageById($getdata[0]['package']);
                $updateddate = strtotime("+".$packagedetail[0]['duration'] ." months", $dataa['payment_date']);
                $data['fee_date']=$updateddate;
            }

        }

        $datatosearlize=array();
        for($i=0;$i<sizeof($getdata);$i++){
            if($getdata[$i]['fees_detail']!=null){
  $fees_detail=$getdata[$i]['fees_detail'];
                $unserdata=unserialize($fees_detail);
                for($j=0;$j<sizeof($unserdata);$j++){
                    $datatosearlize[]=$unserdata[$j];
                }

            }
        }
  $datatosearlize[]=$dataa;


        $searilizeddetail=serialize($datatosearlize);
        
        $data['fees_detail']=$searilizeddetail;
        $data['sms']=0;
        $data['remindersms_status']=0;
        $this->db->where('id', $record->memberid);
        return $this->db->update($tablename, $data);


    }

    public function get_all_members($postgymid=0){

        $gymid=$postgymid;
        $tablename="tbl_member_".$gymid;
        $this->db->where('gym_id', $gymid);
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        $result = $query->result_array();

        return $result;
    }
    public function get_active_members($postgymid=0){
        $gymid=$postgymid;
        $tablename="tbl_member_".$gymid;
        $tablename="tbl_member_136";
        $user = $this->session->get_userdata();
        $gymid=$postgymid;
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        $result = $query->result_array();

        return $result;
    }

public function getoldudids($gymid){
    $tablename='tbl_gym';
    $this->db->select('mobile_udid');
    $this->db->where('id', $gymid);
    $query=$this->db->get($tablename);
    return $query->row_array();
}
public function update_udid($gymid,$udid){
        $data=array();
        $tablename='tbl_gym';
        $data['mobile_udid']=$udid;
        $this->db->where('id', $gymid);
        return $this->db->update($tablename, $data);
    }
    
    /*Tables script start*/
    
    public function get_all_gyms(){
        $tablename="tbl_gym";
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    }
    public function createstaffpaymentstable($tablename=FALSE){
        $sql="CREATE TABLE ".$tablename." (
            id int NOT NULL AUTO_INCREMENT,
            date Date NOT NULL,
            member_id int,
            payments_hiostory blob,
            pending_amount int,
            created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            );";
        return $this->db->query($sql);
    }

    /*Tables script end*/






}