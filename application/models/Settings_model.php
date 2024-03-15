<?php
class Settings_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function get_gym_settings(){
        $query = $this->db->get_where('tbl_gym', array('id' => $_SESSION['userid']));
        return $query->result_array();
    }
    public function updategymsettings(){
        $data['fees_limit']=$_POST['fees_limit'];
        $data['sms_limit']=$_POST['sms_limit'];
        if($this->input->post('printer_option')){
            $data['printer_option']=$this->input->post('printer_option');
        }
        if($this->input->post('show_fees')){
            $data['show_fees']=1;
            $this->session->userdata['show_fees']=1;
        }
        else{
            $data['show_fees']=0;
            $this->session->userdata['show_fees']=0;
        }
        if($this->input->post('show_phone')){
            $data['show_phone']=1;
            $this->session->userdata['show_phone']=1;
        }
        else{
            $data['show_phone']=0;
            $this->session->userdata['show_phone']=0;
        }
        $this->db->where('id', $_SESSION['userid']);
        return $this->db->update('tbl_gym', $data);
    }
}
?>