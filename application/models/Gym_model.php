<?php
class Gym_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function set_gym($image = false){
        $this->load->helper('url');
        $data = array();
        if($image==false){
            $data['image'] = "";
        }
        else{
            $data['image'] = $image;
        }
        if($this->input->post('name')){
            $data['name'] = $this->input->post('name');
        }
        if($this->input->post('user_name')){
            $data['user_name'] = $this->input->post('user_name');
        }

        if($this->input->post('email')){
            $data['email'] = $this->input->post('email');
        }
        if($this->input->post('country')){
            $data['country_id'] = $this->input->post('country');
        }
        if($this->input->post('city')){
            $data['city_id'] = $this->input->post('city');
        }
        if($this->input->post('currency')){
            $data['currency_id'] = $this->input->post('currency');
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
        if($this->input->post('timezone')){
            $data['timezone'] = $this->input->post('timezone');
        }

            $data['parent_gym'] = 1;

        if($this->input->post('add_user_status') && $this->input->post('add_user_status')==1){
            $data['add_user_status'] = $this->input->post('add_user_status');
        }
        else{
            $data['add_user_status'] = 0;
        }
        $data['status'] = 1;
        $data['fees_limit']=30;
        $data['sms_limit']=5;
		return $this->db->insert('tbl_gym', $data);
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
    public function creategymmembertable($tablename=FALSE){

        $sql="CREATE TABLE ".$tablename." (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255),
    phone varchar(255),
    
    cnic varchar(255),
    address varchar(255),
    fees int,
    admission_fees int,
    fees_detail blob,
    payment_criteria int,
    package varchar(20),
    joining_date varchar(255),
    fee_date varchar(255),
    gym_id int,
    image varchar(255),
    blood_group varchar(255),
    body_weight varchar(255),
    height varchar(30),
    secondary_name varchar(100),
    secondary_phone varchar(100),
    comment text,
    gender varchar(20),
    refrence_no varchar(100),
    member_type tinyint(4) DEFAULT 0,
    commission_percentage int,
    salary int,
    training_fees int,
    trainer_id int,
    archive_status tinyint(4),
    status tinyint(4),
    sms tinyint(4) NOT NULL,
    remindersms_status tinyint(4) NOT NULL,
    created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
            return $this->db->query($sql);
    }
    public function createstaffpaymentstable($tablename=FALSE){
        $sql="CREATE TABLE ".$tablename." (
    id int NOT NULL AUTO_INCREMENT,
    date Date NOT NULL,
    member_id int,
    payments_hiostory blob,
    pending_amount int,
    created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
            return $this->db->query($sql);
    }
    public function creategymlogstable($tablename=FALSE){
        $sql="CREATE TABLE ".$tablename." (
    id int NOT NULL AUTO_INCREMENT,
    date Date NOT NULL,
    log_details blob,
    created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
            return $this->db->query($sql);
    }
	
    public function creategymattendencetable($tablename=FALSE){
        $sql="CREATE TABLE ".$tablename." (
    id int NOT NULL AUTO_INCREMENT,
    date Date NOT NULL,
    attendence blob,
    created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
            return $this->db->query($sql);
    }
		
    public function creategymbodyfitnesstable($tablename=FALSE){
        $sql="CREATE TABLE ".$tablename." (
    id int NOT NULL AUTO_INCREMENT,
    member_id int NOT NULL,
	posted_date varchar(65),
    body_fat varchar(45),
    body_water varchar(45),
    lean_body_mass varchar(45),
    bmi varchar(45),
    basal_metabolic_rate varchar(255),
    bone_density varchar(255),
    height varchar(45),
    weight varchar(45),
    neck varchar(45),
    chest varchar(45),
    abs varchar(45),
    waist varchar(45),
    arms varchar(45),
    hips varchar(45),
    thighs varchar(45),
    calf varchar(45),
    partial_curl_ups varchar(45),
    flexibility varchar(45),
    pushups varchar(45),
    weight_prospect varchar(45),
    member_category varchar(45),
    assessed_by varchar(65),
    trainer_recommendation varchar(255),
    created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";
            return $this->db->query($sql);
    }
	
	
    public function creategymexpensestables($expensestablename,$expensesdetailstablename){
        $sql="CREATE TABLE ".$expensestablename." (
    id int NOT NULL AUTO_INCREMENT,
    month_date Date NOT NULL,
    total_expence int,
    total_income int,
    PRIMARY KEY (id)
    );";
        $sqltwo="CREATE TABLE ".$expensesdetailstablename." (
    id int NOT NULL AUTO_INCREMENT,
    expense_date Date NOT NULL,
    expenses blob,
    created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
    );";
            $this->db->query($sql);
            return $this->db->query($sqltwo);
    }
    public function get_all_gyms( $id = FALSE){
        if($id === FALSE){
            $this->db->where('parent_gym',1);
            $query = $this->db->get('tbl_gym');
            return $query->result_array();
            
        }
        else{
            $query = $this->db->where('id', $id)->get('tbl_gym');
            return $query->result_array();
        }
    }
    public function update_gym($image = false)
    {
        

        $this->load->helper('url');
        $data = array();
        if($image==false){
        }
        else{
            $data['image']=$image;
        }
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

        if($this->input->post('password') && !empty($this->input->post('password'))){
            $data['password'] = md5($this->input->post('password'));
        }
        if($this->input->post('package_type')){
            $data['package_type'] = $this->input->post('package_type');
        }
        if($this->input->post('payment_criteria')){
            $data['payment_criteria'] = $this->input->post('payment_criteria');
        }

            $data['parent_gym'] = 1;

        if($this->input->post('country')){
            $data['country_id'] = $this->input->post('country');
        }
        if($this->input->post('city')){
            $data['city_id'] = $this->input->post('city');
        }
        if($this->input->post('currency')){
            $data['currency_id'] = $this->input->post('currency');
        }
        if($this->input->post('add_user_status') && $this->input->post('add_user_status')==1){
            $data['add_user_status'] = $this->input->post('add_user_status');
        }
        else{
            $data['add_user_status'] = 0;
        }
        
        if($this->input->post('status') && $this->input->post('status')==1){
            $data['status'] = $this->input->post('status');
        }
        else{
            $data['status'] = 0;
        }
        if($this->input->post('timezone')){
            $data['timezone'] = $this->input->post('timezone');
        }
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('tbl_gym', $data);
    }
    
    public function delete_gym($id = NULL)
    {
        $membertablename="tbl_member_".$id;
        $attendencetablename="tbl_attendence_".$id;
        if ($this->db->table_exists($membertablename) ){
            $this->db->query("DROP TABLE ".$membertablename.";");
        }
        if ($this->db->table_exists($attendencetablename) ){
            $this->db->query("DROP TABLE ".$attendencetablename.";");
        }
        
        $this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_gym');
    }
    
    
}
?>