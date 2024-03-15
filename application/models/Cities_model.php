<?php
class Cities_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function set_city($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('country')){
            $data['country_id'] = $this->input->post('country');
        }
		return $this->db->insert('tbl_cities', $data);
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
    public function get_all_cities( $id = FALSE){
        if($id === FALSE){
            $query = $this->db->get('tbl_cities');
            $result=$query->result_array();
            return $result;
        }
        else{
            $query = $this->db->where('id', $id)->get('tbl_cities');
            return $query->result_array();
        }
    }
    public function update_city($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('country')){
            $data['country_id'] = $this->input->post('country');
        }
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('tbl_cities', $data);
    }
    public function delete_city($id = NULL){
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_cities');
    }
}
?>