<?php
class Gym_model extends CI_Model {
     public function __construct()
    {
        $this->load->database();
    }
    public function set_gym($image = false)
    {
       
        $this->load->helper('url');
        $data = array();

        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('user_name')){
            $data['user_name'] = $this->input->post('user_name');
        }

        if($this->input->post('email')){
            $data['email'] = $this->input->post('email');
        }


        if($this->input->post('phone')){
            $data['phone'] = $this->input->post('phone');
        }
        if($this->input->post('address')){
            $data['address'] = $this->input->post('address');
        }

        if($this->input->post('password')){
            $data['password'] = md5($this->input->post('password'));
        }
        if($this->input->post('package_type')){
            $data['package_type'] = $this->input->post('package_type');
        }
        if($this->input->post('payment_criteria')){
            $data['payment_criteria'] = $this->input->post('payment_criteria');
        }
        if($this->input->post('parent_gym') && $this->input->post('parent_gym')==0){
            $data['parent_gym'] = $this->input->post('parent_gym');
        }
       

		
		return $this->db->insert('tbl_gym', $data);
    }
    public function getappointmentshistory($patientid=FALSE){
        $query = $this->db->get_where('appointments', array('patient_id' => $patientid));
                return $query->result_array();
    }
   public function get_appointmentbyid($id = FALSE){
      $query = $this->db->get_where('appointments', array('patient_id' => $id,'appointment_status' => 1));
                return $query->result_array();
   }
    public function get_all_gyms( $id = FALSE)
    {
       
        if($id === FALSE){  
            $query = $this->db->get('tbl_gym');
        return $query->result_array();
            
		  }
        else{
        $query = $this->db->where('id', $id)->get('tbl_gym');
            return $query->result_array();
    }
        }
    public function get_frontusers(){
        $query = $this->db->where('status', "verified")->get('frontend_users');
            return $query->result_array();
    }
    public function update_gym($image = false)
    {
        
    
        $this->load->helper('url');
        $data = array();

        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('user_name')){
            $data['user_name'] = $this->input->post('user_name');
        }
        if($this->input->post('email')){
            $data['email'] = $this->input->post('email');
        }
        if($this->input->post('phone')){
            $data['phone'] = $this->input->post('phone');
        }
        if($this->input->post('address')){
            $data['address'] = $this->input->post('address');
        }

        if($this->input->post('password')){
            $data['password'] = md5($this->input->post('password'));
        }
        if($this->input->post('package_type')){
            $data['package_type'] = $this->input->post('package_type');
        }
        if($this->input->post('payment_criteria')){
            $data['payment_criteria'] = $this->input->post('payment_criteria');
        }
        if($this->input->post('parent_gym') && $this->input->post('parent_gym')==0){
            $data['parent_gym'] = $this->input->post('parent_gym');
        }
        else{
            $data['parent_gym'] = "";
        }

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('tbl_gym', $data);
    }
    public function get_appointed_patient($id = NULL){
        $query = $this->db->get_where('appointments', array('patient_id' => $id,'appointment_status' => 1));
                return $query->result_array();

    }
    public function set_appointment(){
        $this->load->helper('url');
        $data = array();

        if($this->input->post('appointeddoctor')){
            $data['doctor_id'] = $this->input->post('appointeddoctor');
        }
        if($this->input->post('appointedperson')){
            $data['patient_id'] = $this->input->post('appointedperson');
        }
        $data['appointment_status'] = 1;
        //var_dump($data);
        //exit;
        return $this->db->insert('appointments', $data);
    }
    public function update_appointment($id=NULL){
        
        $data=array();
        $data['appointment_status']=0;
            $this->db->where('id',$id);
            return $this->db->update('appointments', $data); 
       
    }
    public function getbannername($id = NULL){
        //echo $id;
        //exit;
        $this->load->helper('url');
		$service=$this->db->where('id', $id)->get('patients');
        
        return $service->result_array();
    }
    public function delete_gym($id = NULL)
    {
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_gym');
    }
    
    
}
?>