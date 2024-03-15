<?php
class Charts_model extends CI_Model {
     public function __construct()
    {
        $this->load->database();
    }
    public function total_entrances_filter(){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_attendence_".$gymid;
        $currentdate=date('Y-m-d',strtotime($this->input->post('date')));
        $this->db->where('date', $currentdate);
		$query=$this->db->get($tablename);
        return $query->row_array();
    }
    public function last_somedays_attendences(){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_attendence_".$gymid;
        
        
        if($this->input->post('startdate') && $this->input->post('enddate')){
            $comparisonenddate=date('Y-m-d', strtotime($this->input->post('enddate')));
            $comparisonstartdate=date('Y-m-d', strtotime($this->input->post('startdate')));
        }
        else{
            $comparisonenddate=date('Y-m-d');
            $comparisonstartdate=date('Y-m-d', strtotime('-20 days', strtotime($comparisonenddate)));
        }
        $query=$this->db->where('`date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        return $query->result_array();
    }
    public function getprofitlossdata_bydate($date){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_expenses_".$gymid;
        $this->db->where('month_date', $date);
        $query=$this->db->get($tablename);
        return $query->row_array();
    }
    public function last_somedays_registrations(){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
        
        
        if($this->input->post('startdate') && $this->input->post('enddate')){
            $comparisonenddate=date('Y-m-d', strtotime($this->input->post('enddate')));
            $comparisonstartdate=date('Y-m-d', strtotime($this->input->post('startdate')));
        }
        else{
            $comparisonenddate=date('Y-m-d');
            $comparisonstartdate=date('Y-m-d', strtotime('-20 days', strtotime($comparisonenddate)));
        }
        $this->db->where('member_type', 0);
        $query=$this->db->where('`created_date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        return $query->result_array();
    }
    public function get_numberof_registration_bydate($date){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
        $this->db->where('member_type', 0);
        $query=$this->db->where('joining_date', strtotime($date))->get($tablename);
        return $query->result_array();
//        return $query->num_rows();
    }
    public function get_all_members(){
        $gymid=$this->session->userdata('userid');
		$tablename="tbl_member_".$gymid;
        $this->db->where('member_type', 0);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }
}
?>