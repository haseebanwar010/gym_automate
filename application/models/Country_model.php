<?php
class Country_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function set_country($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
		return $this->db->insert('tbl_countries', $data);
    }
    public function getGymid(){
        $query = $this->db->get_where('tbl_gym', array('name' => $this->input->post('name'),'email' => $this->input->post('email'), 'password' => md5($this->input->post('password'))));
                return $query->result_array();
    }
    public function updategymtablename($id=0,$tablename=FALSE){
        $data['tablename']=$tablename;
        $this->db->where('id', $id);
        return $this->db->update('tbl_gym', $data);
    }
    public function get_all_countries( $id = FALSE){
        if($id === FALSE){  
            $query = $this->db->get('tbl_countries');
            return $query->result_array();
        }
        else{
            $query = $this->db->where('id', $id)->get('tbl_countries');
            return $query->result_array();
        }
    }
    public function update_country($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('tbl_countries', $data);
    }
    public function delete_country($id = NULL){
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_countries');
    }
}
?>