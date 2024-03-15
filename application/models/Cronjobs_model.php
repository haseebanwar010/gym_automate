<?php
class Cronjobs_model extends CI_Model {
     public function __construct()
    {
        $this->load->database();
    }
    public function getallgyms(){
        $this->db->where('parent_gym',1);
        $query = $this->db->get('tbl_gym');
        return $query->result_array();
    }
    public function getactivemembers($gymid){
        $tablename="tbl_member_".$gymid;
        $this->db->where('member_type', 0);
        $this->db->where('status',1);
        $query=$this->db->get($tablename);
        return $query->num_rows();
    }
    public function getcurrencydetails($currencyid){
        $tablename="tbl_currencies";
        $this->db->where('id',$currencyid);
        $query=$this->db->get($tablename);
        return $query->row_array();
    }
    public function get_todaysregistrations($gymid){
        $tablename="tbl_member_".$gymid;
        $currentdate=date('Y-m-d');
        $sql="SELECT id FROM ".$tablename." WHERE DATE(created_date) = '".$currentdate."'";
        $sql="SELECT id FROM ".$tablename." WHERE created_date BETWEEN '".$currentdate." 00:00:00' AND '".$currentdate." 23:59:59'";
        
        return $this->db->query($sql)->result();
    }
    
    public function get_total_income2($gymid){
        $gymid=$gymid;
    
        $tablename="tbl_member_".$gymid;
        $this->db->select('id,name,phone,fees_detail,fees,fee_date');
        $this->db->where('gym_id', $gymid);
        $this->db->where('member_type', 0);
//        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;   
}
}
?>