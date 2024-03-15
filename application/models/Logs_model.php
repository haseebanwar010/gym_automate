<?php
class Logs_model extends CI_Model {
     public function __construct()
    {
        $this->load->database();
    }
   public function get_log_by_date($date){
       $user = $this->session->get_userdata();
		$gymid=$user['userid'];
		$tablename="tbl_logs_".$gymid;
        $query=$this->db->where('date',$date)->get($tablename);
        return $query->row_array();
   }
    
   
    
}
?>