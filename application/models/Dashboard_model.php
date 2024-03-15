<?php
class Dashboard_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }
	public function get_total_members(){
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$tablename="tbl_member_".$gymid;
		$this->db->where('gym_id', $gymid);
		$this->db->where('member_type', 0);
		$query=$this->db->get($tablename);
		return $query->num_rows();
	}
	public function get_members(){
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$tablename="tbl_member_".$gymid;
		$this->db->where('gym_id', $gymid);
        $this->db->where('member_type', 0);
		$this->db->where('status', 1);
        if($this->input->post('id')){
            $this->db->where('id', $this->input->post('id'));
        }
		$query=$this->db->get($tablename);
		$result = $query->result_array();
        return $result;
	}
	public function get_all_members(){
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$tablename="tbl_member_".$gymid;
		$this->db->where('gym_id', $gymid);
        $this->db->where('member_type', 0);
        if($this->input->post('id')){
            $this->db->where('id', $this->input->post('id'));
        }
		$query=$this->db->get($tablename);
		$result = $query->result_array();
		return $result;
	}
	public function getmemberbyid($id){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
		$this->db->where('id', $id);
		$query=$this->db->get($tablename);
		$result = $query->result_array();
		return $result;
	}
	public function getgymbyid($id){
		$this->db->where('id', $id);
		$query=$this->db->get('tbl_gym');
		$result = $query->result_array();
		return $result;
	}


    public function addattendence(){
        $dataa=array();
        $data=array();
        $datatosearlize=array();
        if($this->input->post('date')){
			$dataa['date'] = date("Y-m-d",strtotime($this->input->post('date')));
		}
        if($this->input->post('member_id')){
			$dataa['member_id'] = $this->input->post('member_id');
		}
        
        if($this->input->post('timein')){
			$dataa['time_in'] = $this->input->post('timein');
		}
        if($this->input->post('timeout')){
			$dataa['time_out'] = $this->input->post('timeout');
		}
        $currentdate=date("Y-m-d",strtotime($this->input->post('date')));
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_attendence_".$gymid;
		$this->db->where('date', $currentdate);
		$query=$this->db->get($tablename);
		$checkdate = $query->result_array();
        if(empty($checkdate)){
            $datatosearlize[]=$dataa;
            $data['attendence']=serialize($datatosearlize);
            $data['date']=$currentdate;
            return $this->db->insert($tablename, $data);
        }
        else{
            $checkdateattendence=$checkdate[0]['attendence'];
            $checkdateattendence=unserialize($checkdateattendence);
            for($i=0;$i<sizeof($checkdateattendence);$i++){
                $datatosearlize[]=$checkdateattendence[$i];
            }
            $datatosearlize[]=$dataa;
            $data['attendence']=serialize($datatosearlize);
            $this->db->where('id', $checkdate[0]['id']);
		    return $this->db->update($tablename, $data);
        }
    }
    
    public function addcurrentattendence(){
        $dataa=array();
        $data=array();
        $datatosearlize=array();
        $currenttime=date('h:i:s');
        $currentdate=date("Y-m-d");
        $dataa['date'] = $currentdate;
        $dataa['member_id'] = $_POST['memberid'];
        $dataa['time_out']="00:00";
        $dataa['time_in']=$currenttime;
		$tablename=$_POST['tablename'];
		$this->db->where('date', $currentdate);
		$query=$this->db->get($tablename);
		$checkdate = $query->result_array();
        if(empty($checkdate)){
            $datatosearlize[]=$dataa;
            $data['attendence']=serialize($datatosearlize);
            $data['date']=$currentdate;
            return $this->db->insert($tablename, $data);
        }
        else{
            $checkdateattendence=$checkdate[0]['attendence'];
            $checkdateattendence=unserialize($checkdateattendence);
            for($i=0;$i<sizeof($checkdateattendence);$i++){
                $datatosearlize[]=$checkdateattendence[$i];
            }
            $datatosearlize[]=$dataa;
            $data['attendence']=serialize($datatosearlize);
            $this->db->where('id', $checkdate[0]['id']);
		    return $this->db->update($tablename, $data);
        }
    }
	public function payfee(){
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
		}
		else{
			if(isset($getdata[0]['package']) && $getdata[0]['package']!="custom"){
				$query = $this->db->where('id', $getdata[0]['package'])->get('tbl_packages');
				$package=$query->result_array();
				$updateddate = strtotime("+".$package[0]['duration'] ." months", $getdata[0]['fee_date']);
				$data['fee_date']=$updateddate;
			}else{
				$updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", $getdata[0]['fee_date']);
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
            $expensedata['total_income']=$dataa['fees']+$checkdatetwo[0]['total_income'];
            $this->db->where('month_date', $comparisondatetwo);
            $this->db->update($tablenametwo, $expensedata);
        }
       /*add fees in income end*/ 
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update($tablename, $data);
	}
	public function deactivate_member($memberid){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
		$data['status']=0;
		$this->db->where('id', $memberid);
		return $this->db->update($tablename, $data);
	}
	public function get_active_members(){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$this->db->where('gym_id', $gymid);
        if($this->input->post('id')){
            $this->db->where('id', $this->input->post('id'));
        }
		$this->db->where('status', 1);
        $this->db->where('member_type', 0);
		$query=$this->db->get($tablename);
		$result = $query->result_array();
		return $result;
	}
	public function get_inactive_members(){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$this->db->where('gym_id', $gymid);
        if($this->input->post('id')){
            $this->db->where('id', $this->input->post('id'));
        }
		$this->db->where('status', 0);
        $this->db->where('member_type', 0);
		$query=$this->db->get($tablename);
		$result = $query->result_array();
		return $result;
	}

	public function get_total_active_members(){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$this->db->where('gym_id', $gymid);
		$this->db->where('status', 1);
        $this->db->where('member_type', 0);
		$query=$this->db->get($tablename);
		return $query->num_rows();
	}
    public function total_todays_entrances(){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_attendence_".$gymid;
        $currentdate=date('Y-m-d');
        $this->db->where('date', $currentdate);
		$query=$this->db->get($tablename);
        return $query->row_array();
    }
	public function get_total_inactive_members(){
		$gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
		$user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$this->db->where('gym_id', $gymid);
        $this->db->where('member_type', 0);
		$this->db->where('status', 0);
		$query=$this->db->get($tablename);
		return $query->num_rows();
	}
}