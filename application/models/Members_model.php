<?php
class Members_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function set_member($image = false){
        $this->load->helper('url');
        $data = array();
        $data['image']=$image;
        if($this->input->post('blood_group')){
            $data['blood_group'] = $this->input->post('blood_group');
        }
        if($this->input->post('body_weight')){
            $data['body_weight'] = $this->input->post('body_weight');
        }
        if($this->input->post('height')){
            $data['height'] = $this->input->post('height');
        }

        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('email')){
            $data['email'] = $this->input->post('email');
        }
        if($this->input->post('phone')){
            $phone=$this->input->post('phone');
            $firstone=substr($phone, 0, 1);
            $firsttwo=substr($phone, 0, 2);
            if($firstone==0){
                $remaining=substr($phone,1);
                $remaining="92".$remaining;
                $data['phone'] = $remaining;
            }
            elseif ($firsttwo==92){
                $remaining=substr($phone,2);
                $data['phone'] = $remaining;
            }
        }
        if($this->input->post('cnic')){
            $data['cnic'] = $this->input->post('cnic');
        }
        if($this->input->post('address')){
            $data['address'] = $this->input->post('address');
        }
        if($this->input->post('fees')){
            $data['fees'] = $this->input->post('fees');
        }
        if($this->input->post('admission_fees')){
            $data['admission_fees'] = $this->input->post('admission_fees');
        }
        if($this->input->post('payment_radio') && $this->input->post('payment_radio')!=""){
            $data['payment_criteria'] = $this->input->post('payment_radio');
        }
        elseif ($this->input->post('payment_select') && $this->input->post('payment_select')!=""){
            $data['payment_criteria'] = $this->input->post('payment_select');
        }
        else{
            $data['payment_criteria']=1;
        }
        if($this->input->post('joining_date')){
            $data['joining_date'] = strtotime($this->input->post('joining_date'));
        }
        if($this->input->post('package')){
            $data['package']=$this->input->post('package');
        }
         if($this->input->post('gender')){
            $data['gender']=$this->input->post('gender');
        }
        if($this->input->post('refrence_no')){
            $data['refrence_no']=$this->input->post('refrence_no');
        }
        $gymid=$this->session->userdata('userid');
        if(isset($gymid)){
            $data['gym_id'] = $gymid;
        }
        if($this->input->post('status') && $this->input->post('status')==1){
            $data['status'] = $this->input->post('status');
        }
        else{
            $data['status']=0;
        }
        if($this->input->post('secondary_name')){
            $data['secondary_name'] = $this->input->post('secondary_name');
        }
        if($this->input->post('secondary_phone')){
            $data['secondary_phone'] = $this->input->post('secondary_phone');
        }
        if($this->input->post('comment')){
            $data['comment'] = $this->input->post('comment');
        }
        if($this->input->post('trainer_id') && $this->input->post('trainer_id')!=0){
            $data['trainer_id'] = $this->input->post('trainer_id');
            $data['commission_percentage']=$this->input->post('commission_percentage');
            $data['training_fees']=$this->input->post('training_fees');
        }
        if($data['package']=="custom"){
            $data['fee_date'] = strtotime($this->input->post('joining_date'));
            $data['fee_date'] = strtotime("+".$data['payment_criteria']." month", $data['fee_date']);
            $dataa=array();
            $dataa['payment_date'] = $data['joining_date'];
            $dataa['fees'] = $data['fees']+$data['admission_fees'];
            $dataa['comment']="";
        }
        else{
            $query = $this->db->get_where('tbl_packages', array('id' => $data['package']));
            $package=$query->result_array();
            $data['fee_date'] = strtotime($this->input->post('joining_date'));
            $data['fee_date'] = strtotime("+".$package[0]['duration']." month", $data['fee_date']);
            $dataa=array();
            $dataa['payment_date'] = $data['joining_date'];
            $dataa['fees'] = $package[0]['admission_fees']+$package[0]['fees'];
            $dataa['comment']="";
        }
        if(!empty($this->input->post('fee_date'))){
            $data['fee_date'] = strtotime($this->input->post('fee_date'));
        }
        $datatosearlize[]=$dataa;
        $searilizeddetail=serialize($datatosearlize);
        $data['fees_detail']=$searilizeddetail;
        $tablename="tbl_member_".$gymid;
		$this->db->insert($tablename, $data);
        $insert_id = $this->db->insert_id();
        //$lastid=$lastone->row;
        if(isset($insert_id) && $insert_id!=0){
            $insertedrecord=$this->get_all_members($insert_id);
            if(!empty($insertedrecord)){
                if($insertedrecord[0]['package']!="custom"){
                    $insertedrecord[0]['packagedetail']=$this->get_packages($insertedrecord[0]['package']);
                }
            }
            return $insertedrecord;
        }
    }
    public function get_trainers($id = FALSE){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        if($id === FALSE){  
            $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'member_type' => 1 , 'status' => 1));
            return $query->result_array();
        }
        else{
            $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'id' => $id));
            return $query->row_array();
        }
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
    }
    public function updatereminderstatus($data){
        $dataa['remindersms_status']=1;
        $this->db->where('id', $data['memberid']);
        return $this->db->update($data['tablename'], $dataa);
    }
    public function payinactivefee(){
        $dataa=array();
        if($this->input->post('payment_date')){
            $dataa['payment_date'] = strtotime($this->input->post('payment_date'));
        }
        if($this->input->post('fees')){
            $dataa['fees'] = $this->input->post('fees');
        }
        if($this->input->post('comment') && $this->input->post('comment')!=""){
            $dataa['comment'] = $this->input->post('comment');
        }
        else{

            $dataa['comment']="";
        }
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('id',$this->input->post('id'));
        $query=$this->db->get($tablename);
        $getdata=$query->result_array();
        if($getdata[0]['package']==""){
            $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", strtotime($this->input->post('payment_date')));
            $data['fee_date']=$updateddate;
            $data['status']=1;
        }
        else{
            if(isset($getdata[0]['package']) && $getdata[0]['package']!="custom"){
                $query = $this->db->where('id', $getdata[0]['package'])->get('tbl_packages');
                $package=$query->result_array();
                $updateddate = strtotime("+".$package[0]['duration'] ." months", strtotime($this->input->post('payment_date')));
                $data['fee_date']=$updateddate;
                $data['status']=1;
            }else{
                $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", strtotime($this->input->post('payment_date')));
                $data['fee_date']=$updateddate;
                $data['status']=1;
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
        /*add fees in income start*/
        $comparisondatetwo=date('Y-m-1',strtotime($this->input->post('payment_date')));
        $tablenametwo="tbl_expenses_".$gymid;
        $query = $this->db->get_where($tablenametwo, array('month_date' => $comparisondatetwo ));
        $checkdatetwo=$query->result_array();
        if(empty($checkdatetwo)){
            $expensedata['month_date']=$comparisondatetwo;
            $expensedata['total_income']=$dataa['fees'];
            $this->db->insert($tablenametwo, $expensedata);
        }
        else{
            $expensedata['month_date']=$comparisondatetwo;
            $expensedata['total_income']=$dataa['fees']+$checkdatetwo[0]['total_income'];
            $this->db->where('month_date', $comparisondatetwo);
            $this->db->update($tablenametwo, $expensedata);
        }
       /*add fees in income end*/ 
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($tablename, $data);
    }   
    public function get_gym_detail($gymid){
        $query = $this->db->get_where('tbl_gym', array('id' => $gymid));
        return $query->row_array();
    }
    public function get_packagedetail_ajax(){
        $query = $this->db->get_where('tbl_packages', array('id' => $this->input->post('packageid')));
        return $query->row_array();
    }
    public function get_searched_members(){
        $serachedkey=$this->input->post('searchkey');
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        if($this->input->post('searchtype') && $this->input->post('searchtype')=='id'){
            $this->db->like('id', $serachedkey);
        }
        else if($this->input->post('searchtype') && $this->input->post('searchtype')=='name'){
            $this->db->like('name', $serachedkey);
        }
        else if($this->input->post('searchtype') && $this->input->post('searchtype')=='phone'){
            $this->db->like('phone', $serachedkey);
        }
        else if($this->input->post('searchtype') && $this->input->post('searchtype')=='refrenceno'){
            $this->db->like('refrence_no', $serachedkey);
        }
        $this->db->where('member_type', 0);
        $query = $this->db->get($tablename);
        return $query->result_array();
    }
    public function payrejoinfee(){
        $dataa=array();
        if($this->input->post('payment_date')){
            $dataa['payment_date'] = strtotime($this->input->post('payment_date'));
        }
        if($this->input->post('fees')){
            $dataa['fees'] = $this->input->post('fees');
        }
        if($this->input->post('comment') && $this->input->post('comment')!=""){
            $dataa['comment'] = $this->input->post('comment');
        }
        else{
            $dataa['comment']="";
        }
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('id',$this->input->post('id'));
        $query=$this->db->get($tablename);
        $getdata=$query->result_array();
        if($getdata[0]['package']==""){
            $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", $getdata[0]['fee_date']);
            $data['fee_date']=$updateddate;
            $data['status']=1;
        }
        else{
            if(isset($getdata[0]['package']) && $getdata[0]['package']!="custom"){
                $query = $this->db->where('id', $getdata[0]['package'])->get('tbl_packages');
                $package=$query->result_array();
                $updateddate = strtotime("+".$package[0]['duration'] ." months", $getdata[0]['fee_date']);
                $data['fee_date']=$updateddate;
                $data['status']=1;
            }else{
                $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", $getdata[0]['fee_date']);
                $data['fee_date']=$updateddate;
                $data['status']=1;
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
        /*add fees in income start*/
        $comparisondatetwo=date('Y-m-1',strtotime($this->input->post('payment_date')));
        $tablenametwo="tbl_expenses_".$gymid;
        $query = $this->db->get_where($tablenametwo, array('month_date' => $comparisondatetwo ));
        $checkdatetwo=$query->result_array();
        if(empty($checkdatetwo)){
            $expensedata['month_date']=$comparisondatetwo;
            $expensedata['total_income']=$dataa['fees'];
            $this->db->insert($tablenametwo, $expensedata);
        }
        else{
            $expensedata['month_date']=$comparisondatetwo;
            $expensedata['total_income']=$dataa['fees']+$checkdatetwo[0]['total_income'];
            $this->db->where('month_date', $comparisondatetwo);
            $this->db->update($tablenametwo, $expensedata);
        }
       /*add fees in income end*/ 
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($tablename, $data);
    }
    public function get_all_member(){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $query = $this->db->get_where($tablename, array('gym_id' => $gymid, 'member_type' => 0 ));
        return $query->result_array();
    }
    public function get_all_members( $id = FALSE){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        if($id === FALSE){  
            $query = $this->db->get_where($tablename, array('gym_id' => $gymid, 'member_type' => 0 ));
            return $query->result_array();
        }
        else{
            $query = $this->db->where('id', $id)->get($tablename);
            $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'id' => $id));
            return $query->result_array();
        }
    }
    public function get_packages( $id = FALSE){
        $gymid=$this->session->userdata('userid');
        if($id === FALSE){
            $query = $this->db->get_where('tbl_packages', array('gym_id' => $gymid ));
            return $query->result_array();

        }
        else{
            $query = $this->db->where('id', $id)->get('tbl_packages');
            $query = $this->db->get_where('tbl_packages', array('gym_id' => $gymid , 'id' => $id));
            return $query->result_array();
        }
    }
    public function uservalidate(){
        $gymid=$this->session->userdata('userid');

        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $cnic = $this->input->post('cnic');
        $tablename="tbl_member_".$gymid;
        if(isset($cnic) && $cnic!="" ) {
            $sql = "select * from ".$tablename." where gym_id='" . $gymid . "' AND (
        email='" . $email . "' OR phone='" . $phone . "' OR cnic='" . $cnic . "')";
        }
        else{
            $sql = "select * from ".$tablename." where gym_id='" . $gymid . "' AND(
        email='" . $email . "' OR phone='" . $phone . "')";
        }
        return $this->db->query($sql)->result_array();
    }
    public function get_attendences_bydate($date){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_attendence_".$gymid;
        $comparisondate=date('Y-m-d',strtotime($date));
        $query=$this->db->where('date',$comparisondate)->get($tablename);
        $result=$query->result_array();
        return $result;
    }
    public function get_todayslog(){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_logs_".$gymid;
        $comparisondate=date('Y-m-d');
        $query=$this->db->where('date',$comparisondate)->get($tablename);
        return $query->row_array();
    }
    public function add_log($date,$logdetail){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_logs_".$gymid;
        $data=array();
        $data['date']=$date;
        $data['log_details']=$logdetail;
        return $this->db->insert($tablename, $data);
    }
    public function update_log($logdetail, $logid){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_logs_".$gymid;
        $data=array();
        $data['log_details']=$logdetail;
        $this->db->where('id', $logid);
        return $this->db->update($tablename, $data);
    }
    public function get_member_attendence($filterdate=false){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_attendence_".$gymid;
        if($filterdate==false){
            $comparisonyear=date("Y");
            $comparisonmonth=date("M"); 
            $startdate=$this->input->post('start_date');
            $enddate=$this->input->post('end_date');
            $comparisonstartday=date('d',strtotime($startdate));
            $comparisonstartmonth=date('m',strtotime($startdate));
            $comparisonstartyear=date('Y',strtotime($startdate));
         
            $comparisonendday=date('d',strtotime($enddate));
            $comparisonendmonth=date('m',strtotime($enddate));
            $comparisonendyear=date('Y',strtotime($enddate));
            
            
            $comparisonstartdate=$comparisonstartyear."-".$comparisonstartmonth."-".$comparisonstartday;
            $comparisonenddate=$comparisonendyear."-".$comparisonendmonth."-".$comparisonendday;
           
            $comparisonquerystartdate="1-Jan-".$comparisonstartyear;
            $comparisonqueryenddate="31-Dec-".$comparisonstartyear;
            $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
            $result=$query->result_array();
            return $result;
        }
    }
    public function get_member_attendence_by_date($dayslimit=false){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_attendence_".$gymid;
        $daystocompare=$dayslimit-1;
		
		$day=01;
		$month=date("m",strtotime($this->input->post('enddate')));	
		$year=date("Y",strtotime($this->input->post('enddate')));
		
$comparisonenddate=$year.'-'.$month.'-'.$dayslimit;
$comparisonstartdate=$year.'-'.$month.'-'.$day;

//echo 'start date '.	$comparisonstartdate .' and end date is' .$comparisonenddate;
//		exit;
		
        //$comparisonenddate=date("Y-m-d");

        //$comparisonstartdate=date('Y-m-d', strtotime('-'.$daystocompare.' days', strtotime($comparisonenddate)));
        $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        $result=$query->result_array();

        return $result;
    }
	
//	    public function get_member_attendence_by_date($dayslimit=false){
//        $gymid=$this->session->userdata('userid');
//        $tablename="tbl_attendence_".$gymid;
//        $daystocompare=$dayslimit-1;
//        $comparisonenddate=date("Y-m-d");
//        $comparisonstartdate=date('Y-m-d', strtotime('-'.$daystocompare.' days', strtotime($comparisonenddate)));
//        $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
//        $result=$query->result_array();
//        return $result;
//    }
//	
//	
    public function update_member($image = false){
        $this->load->helper('url');
        $data = array();
        if($image!=''){
            $data['image']=$image;
        }
        if($this->input->post('blood_group')){
            $data['blood_group'] = $this->input->post('blood_group');
        }
        if($this->input->post('package')){
            $data['package'] = $this->input->post('package');
        }
        if($this->input->post('body_weight')){
            $data['body_weight'] = $this->input->post('body_weight');
        }
        if($this->input->post('height')){
            $data['height'] = $this->input->post('height');
        }
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('email')){
            $data['email'] = $this->input->post('email');
        }
        if($this->input->post('phone')){
            $phone = $this->input->post('phone');
            $firstone=substr($phone, 0, 1);
            $firsttwo=substr($phone, 0, 2);
            if($firstone==0){
                $remaining=substr($phone,1);
                $remaining="92".$remaining;
                $data['phone'] = $remaining;
            }
            else{
                $data['phone'] = $this->input->post('phone');
            }
        }
        if($this->input->post('cnic')){
            $data['cnic'] = $this->input->post('cnic');
        }
        if($this->input->post('address')){
            $data['address'] = $this->input->post('address');
        }
        if($this->input->post('fees')){
            $data['fees'] = $this->input->post('fees');
        }
        if($this->input->post('gender')){
            $data['gender'] = $this->input->post('gender');
        }
        if($this->input->post('refrence_no')){
            $data['refrence_no']=$this->input->post('refrence_no');
        }
        if($this->input->post('joining_date')){
            $data['joining_date'] = strtotime($this->input->post('joining_date'));
        }
        $gymid=$this->session->userdata('userid');
        if(isset($gymid)){
            $data['gym_id'] = $gymid;
        }
        if($this->input->post('status') && $this->input->post('status')==1){
            $data['status'] = $this->input->post('status');
        }
        else{
            $data['status']=0;
        }

        if ($this->input->post('payment_select') && $this->input->post('payment_select')!=""){
            $data['payment_criteria'] = $this->input->post('payment_select');
        }
        elseif($this->input->post('payment_radio') && $this->input->post('payment_radio')!=""){
            $data['payment_criteria'] = $this->input->post('payment_radio');
        }

        if(!empty($this->input->post('fee_date'))){
            $data['fee_date'] = strtotime($this->input->post('fee_date'));
        }

        if($this->input->post('secondary_name')){
            $data['secondary_name'] = $this->input->post('secondary_name');
        }
        if($this->input->post('secondary_phone')){
            $data['secondary_phone'] = $this->input->post('secondary_phone');
        }
        if($this->input->post('comment')){
            $data['comment'] = $this->input->post('comment');
        }
        if($this->input->post('trainer_id') && $this->input->post('trainer_id')!=0){
            $data['trainer_id'] = $this->input->post('trainer_id');
            $data['commission_percentage']=$this->input->post('commission_percentage');
            $data['training_fees']=$this->input->post('training_fees');
        }
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update($tablename, $data);
    }
    public function delete_member($id = NULL){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete($tablename);
    }
    public function GetMemberDetailById($id=NULL){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('id', $id);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }
    public function decryment_gym_sms($data){
        $gymid=$data['gymid'];
        $this->db->set('sms_counter_limit', 'sms_counter_limit - ' . (int)1, FALSE);
        $this->db->where('id', $gymid);
        return $this->db->update('tbl_gym'); 
    }
	
	public function get_memberdetails($id){
		$gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->select('id,name,refrence_no,phone,gender');
		$this->db->where('id', $id);
        $query=$this->db->get($tablename);
        return $query->row_array();
	}
	public function insert_member_bodycomposition($data){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_body_composition_fitness_".$gymid;
		$result=$this->db->insert($tablename, $data);
		return $result;
		
	}
	public function get_memberbodydetails($mid){
		$gymid=$this->session->userdata('userid');
        $tablename="tbl_body_composition_fitness_".$gymid;
        $this->db->select('*');
		$this->db->where('member_id', $mid);
        $query=$this->db->get($tablename);
        return $query->result_array();
	}
	
	public function get_trainermembername($trainer_id){
		$gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->select('name');
		$this->db->where('id', $trainer_id);
        $query=$this->db->get($tablename);
        return $query->row_array();
	}
    
}
?>