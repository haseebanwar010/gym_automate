<?php
class Currency_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function set_currency($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('currency_name')){
            $data['currency_name'] = $this->input->post('currency_name');
        }
        if($this->input->post('currency_symbol')){
            $data['currency_symbol'] = $this->input->post('currency_symbol');
        }
		return $this->db->insert('tbl_currencies', $data);
    }
    public function get_all_currencies( $id = FALSE){
        if($id === FALSE){  
            $query = $this->db->get('tbl_currencies');
            return $query->result_array();
        }
        else{
            $query = $this->db->where('id', $id)->get('tbl_currencies');
            return $query->result_array();
        }
    }
    public function update_currency($image = false){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('currency_name')){
            $data['currency_name'] = $this->input->post('currency_name');
        }
        if($this->input->post('currency_symbol')){
            $data['currency_symbol'] = $this->input->post('currency_symbol');
        }
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('tbl_currencies', $data);
    }
    public function delete_currency($id = NULL){
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_currencies');
    }
    
    
}
?>