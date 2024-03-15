<?php
class Packages_model extends CI_Model {
     public function __construct()
    {
        $this->load->database();
    }
    public function set_package($image = false){
        $this->load->helper('url');
        $data = array();
        $gymid=$this->session->userdata('userid');
        $data['gym_id'] = $gymid;
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('admission_fees')){
            $data['admission_fees'] = $this->input->post('admission_fees');
        }
        if($this->input->post('fees')){
            $data['fees'] = $this->input->post('fees');
        }
        if($this->input->post('members')){
            $data['members'] = $this->input->post('members');
        }
        if($this->input->post('duration')){
            $data['duration'] = $this->input->post('duration');
        }
		return $this->db->insert('tbl_packages', $data);
    }
    public function get_all_packages( $id = FALSE){
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
    public function update_package($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('admission_fees')){
            $data['admission_fees'] = $this->input->post('admission_fees');
        }
        if($this->input->post('fees')){
            $data['fees'] = $this->input->post('fees');
        }
        if($this->input->post('members')){
            $data['members'] = $this->input->post('members');
        }
        if($this->input->post('duration')){
            $data['duration'] = $this->input->post('duration');
        }
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('tbl_packages', $data);
    }
    public function delete_package($id = NULL)
    {
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_packages');
    }
    public function GetMemberDetailById($id=NULL){
        $this->db->where('id', $id);
        $query=$this->db->get('members');
        return $query->result_array();
    }
    
    
}
?>