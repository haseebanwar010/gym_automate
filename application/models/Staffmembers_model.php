<?php
class Staffmembers_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function get_all_staff_members( $id = FALSE){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        if($id === FALSE){  
            $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'member_type' => 1));
            return $query->result_array();
        }
        else{
            $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'id' => $id));
            return $query->row_array();
        }
    }
    public function set_member($image = false){
        $this->load->helper('url');
        $data = array();
        $data['image']=$image;
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
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
                $data['phone'] = $phone;
            }
        }
        if($this->input->post('cnic')){
            $data['cnic'] = $this->input->post('cnic');
        }
        if($this->input->post('address')){
            $data['address'] = $this->input->post('address');
        }
        if($this->input->post('gender')){
            $data['gender']=$this->input->post('gender');
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
        if($this->input->post('commission_percentage')){
            $data['commission_percentage'] = $this->input->post('commission_percentage');
        }
        if($this->input->post('salary')){
            $data['salary'] = $this->input->post('salary');
        }
        if($this->input->post('training_fees')){
            $data['training_fees'] = $this->input->post('training_fees');
        }
        $data['joining_date'] = strtotime(date('d-m-y'));
        $data['member_type']=1;
        $tablename="tbl_member_".$gymid;
		$this->db->insert($tablename, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function update_member($image = false){
        $this->load->helper('url');
        $data = array();
        if($image!=''){
            $data['image']=$image;
        }
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
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
                $data['phone'] = $phone;
            }
        }
        if($this->input->post('cnic')){
            $data['cnic'] = $this->input->post('cnic');
        }
        if($this->input->post('address')){
            $data['address'] = $this->input->post('address');
        }
        if($this->input->post('gender')){
            $data['gender']=$this->input->post('gender');
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
        if($this->input->post('commission_percentage')){
            $data['commission_percentage'] = $this->input->post('commission_percentage');
        }
        if($this->input->post('salary')){
            $data['salary'] = $this->input->post('salary');
        }
        if($this->input->post('training_fees')){
            $data['training_fees'] = $this->input->post('training_fees');
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
    public function get_assigned_members($trainerid){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'trainer_id' => $trainerid));
        return $query->result_array();
    }
    public function get_packagedetail($packageid){
        $gymid=$this->session->userdata('userid');
        $tablename='tbl_packages';
        $query = $this->db->get_where($tablename, array('gym_id' => $gymid , 'id' => $packageid));
        return $query->row_array();
    }
    public function get_trainer_paymenthistory($memberid,$date){
        $gymid=$this->session->userdata('userid');
        $tablename='tbl_staffmembers_payments_'.$gymid;
        $query = $this->db->get_where($tablename, array('member_id' => $memberid , 'date' => $date));
        return $query->row_array();
    }
    public function update_payments_history($paymentid,$date,$datatoupdate){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_staffmembers_payments_".$gymid;
        $this->db->where('id', $paymentid);
        $this->db->where('date', $date);
        return $this->db->update($tablename, $datatoupdate);
    }
}
?>