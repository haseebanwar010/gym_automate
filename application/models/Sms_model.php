<?php
class Sms_model extends CI_Model {
     public function __construct()
    {
        $this->load->database();
    }
    public function get_all_members(){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }
    public function get_all_active_members(){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('status', 1);
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }
    public function get_all_inactive_members(){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_member_".$gymid;
        $this->db->where('status', 0);
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }
    public function get_gym_totalsms_available(){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_gym";
        $this->db->select('sms_counter_limit'); 
        $this->db->where('id', $gymid);
        $query=$this->db->get($tablename);
        return $query->row_array();
    }
    public function decrease_sms_numbers($decreasesms){
        $gymid=$this->session->userdata('userid');
        $this->db->set('sms_counter_limit', 'sms_counter_limit - ' . (int)$decreasesms, FALSE);
        $this->db->where('id', $gymid);
        return $this->db->update('tbl_gym'); 
    }
}
?>