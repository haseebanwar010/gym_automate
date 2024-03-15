<?php
class User_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        $this->load->library('session');
    }
    public function get_users($user_id = FALSE){
        if ($user_id === FALSE){
            $this->db->select('*');
            $this->db->from('users');
            $query = $this->db->get();
            return $query->result_array();
        }
        $this->db->select('*');
        $query = $this->db->get_where('users', array('users.id' => $user_id));					
		return $query->row_array();
	}

	public function get_admin_users($user_id = FALSE){
		if($user_id==FALSE) {
			$this->db->select('*');
			$this->db->from('tbl_gym');
			$this->db->where('parent_gym', 0);
			$this->db->where('super_gym_id', $this->session->userdata('userid'));
			$query = $this->db->get();
			return $query->result_array();
		}
		else{
			$this->db->select('*');
			$this->db->from('tbl_gym');
			$this->db->where('id',$user_id);
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function set_adminuser(){
		$this->load->helper('url');
		$data = array();
		if($this->input->post('name')){
			$data['name'] = $this->input->post('name');
		}
		if($this->input->post('email')){
			$data['email'] = $this->input->post('email');
		}
		if($this->input->post('phone')){
			$data['phone'] = $this->input->post('phone');
		}
		if($this->input->post('password')){
			$data['password'] = md5($this->input->post('password'));
		}
		if($this->input->post('user_name')){
			$data['user_name'] = $this->input->post('user_name')."_".$this->session->userdata('userid');
		}
		$authorization=array();
		if($this->input->post('dashboard_access') && $this->input->post('dashboard_access')==1){
			$authorization['dashboard_access'] = 1;
		}
		else{
			$authorization['dashboard_access'] = 0;
		}

		if($this->input->post('members_access') && $this->input->post('members_access')==1){
			$authorization['members_access'] = 1;
		}
		else{
			$authorization['members_access'] = 0;
		}
		if($this->input->post('packages_access') && $this->input->post('packages_access')==1){
			$authorization['packages_access'] = 1;
		}
		else{
			$authorization['packages_access'] = 0;
		}
        if($this->input->post('users_access') && $this->input->post('users_access')==1){
			$authorization['users_access'] = 1;
		}
		else{
			$authorization['users_access'] = 0;
		}
        if($this->input->post('staffmembers_access') && $this->input->post('staffmembers_access')==1){
			$authorization['staffmembers_access'] = 1;
		}
		else{
			$authorization['staffmembers_access'] = 0;
		}
        if($this->input->post('expenses_access') && $this->input->post('expenses_access')==1){
			$authorization['expenses_access'] = 1;
		}
		else{
			$authorization['expenses_access'] = 0;
		}
        if($this->input->post('profitloss_access') && $this->input->post('profitloss_access')==1){
			$authorization['profitloss_access'] = 1;
		}
		else{
			$authorization['profitloss_access'] = 0;
		}
        
		if($this->input->post('attendences_access') && $this->input->post('attendences_access')==1){
			$authorization['attendences_access'] = 1;
		}
		else{
			$authorization['attendences_access'] = 0;
		}
        if($this->input->post('logs_access') && $this->input->post('logs_access')==1){
			$authorization['logs_access'] = 1;
		}
		else{
			$authorization['logs_access'] = 0;
		}
        if($this->input->post('charts_access') && $this->input->post('charts_access')==1){
			$authorization['charts_access'] = 1;
		}
		else{
			$authorization['charts_access'] = 0;
		}
        if($this->input->post('calendar_access') && $this->input->post('calendar_access')==1){
			$authorization['calendar_access'] = 1;
		}
		else{
			$authorization['calendar_access'] = 0;
		}
        if($this->input->post('sms_access') && $this->input->post('sms_access')==1){
			$authorization['sms_access'] = 1;
		}
		else{
			$authorization['sms_access'] = 0;
		}
        if($this->input->post('settings_access') && $this->input->post('settings_access')==1){
			$authorization['settings_access'] = 1;
		}
		else{
			$authorization['settings_access'] = 0;
		}
        $data['status'] = 1;
        $data['super_gym_id']=$this->session->userdata('userid');
		$data['authorization']=serialize($authorization);
		return $this->db->insert('tbl_gym', $data);
	}

	public function update_adminuser(){
		$this->load->helper('url');
		$data = array();
		if($this->input->post('name')){
			$data['name'] = $this->input->post('name');
		}
		if($this->input->post('email')){
			$data['email'] = $this->input->post('email');
		}
		if($this->input->post('phone')){
			$data['phone'] = $this->input->post('phone');
		}
		if($this->input->post('password') && $this->input->post('password')!=""){
			$data['password'] = md5($this->input->post('password'));
		}
		if($this->input->post('address')){
			$data['address'] = $this->input->post('address');
		}
		if($this->input->post('role')){
			$data['role'] = $this->input->post('role');
		}
        if($this->input->post('user_name')){
			$data['user_name'] = $this->input->post('user_name')."_".$this->session->userdata('userid');
		}
		$authorization=array();
		if($this->input->post('dashboard_access') && $this->input->post('dashboard_access')==1){
			$authorization['dashboard_access'] = 1;
		}
		else{
			$authorization['dashboard_access'] = 0;
		}

		if($this->input->post('members_access') && $this->input->post('members_access')==1){
			$authorization['members_access'] = 1;
		}
		else{
			$authorization['members_access'] = 0;
		}
		if($this->input->post('packages_access') && $this->input->post('packages_access')==1){
			$authorization['packages_access'] = 1;
		}
		else{
			$authorization['packages_access'] = 0;
		}
        if($this->input->post('users_access') && $this->input->post('users_access')==1){
			$authorization['users_access'] = 1;
		}
		else{
			$authorization['users_access'] = 0;
		}
        if($this->input->post('staffmembers_access') && $this->input->post('staffmembers_access')==1){
			$authorization['staffmembers_access'] = 1;
		}
		else{
			$authorization['staffmembers_access'] = 0;
		}
        if($this->input->post('expenses_access') && $this->input->post('expenses_access')==1){
			$authorization['expenses_access'] = 1;
		}
		else{
			$authorization['expenses_access'] = 0;
		}
        if($this->input->post('profitloss_access') && $this->input->post('profitloss_access')==1){
			$authorization['profitloss_access'] = 1;
		}
		else{
			$authorization['profitloss_access'] = 0;
		}
        
		if($this->input->post('attendences_access') && $this->input->post('attendences_access')==1){
			$authorization['attendences_access'] = 1;
		}
		else{
			$authorization['attendences_access'] = 0;
		}
        if($this->input->post('logs_access') && $this->input->post('logs_access')==1){
			$authorization['logs_access'] = 1;
		}
		else{
			$authorization['logs_access'] = 0;
		}
        if($this->input->post('charts_access') && $this->input->post('charts_access')==1){
			$authorization['charts_access'] = 1;
		}
		else{
			$authorization['charts_access'] = 0;
		}
        if($this->input->post('calendar_access') && $this->input->post('calendar_access')==1){
			$authorization['calendar_access'] = 1;
		}
		else{
			$authorization['calendar_access'] = 0;
		}
        if($this->input->post('sms_access') && $this->input->post('sms_access')==1){
			$authorization['sms_access'] = 1;
		}
		else{
			$authorization['sms_access'] = 0;
		}
        if($this->input->post('settings_access') && $this->input->post('settings_access')==1){
			$authorization['settings_access'] = 1;
		}
		else{
			$authorization['settings_access'] = 0;
		}
		$data['authorization']=serialize($authorization);
		$this->db->where('id',$this->input->post('id'));
		return $this->db->update('tbl_gym',$data);
	}

	public function delete_adminuser($id = NULL){
		$this->load->helper('url');
		$this->db->where('id', $id);
		return $this->db->delete('tbl_gym');
	}
    public function get_user_by_email($email){
        $this->db->select('*');
        $query = $this->db->get_where('tbl_gym', array('tbl_gym.email' => $email));			
		return $query->row_array();
    }
    public function validate(){
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean(md5($this->input->post('password')));
        // Prep the query
        $this->db->where('user_name', $username);
        $this->db->where('password', $password);
        $this->db->where('status', 1);
        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();
           
		// Let's check if there are any results
        if(!empty($res)){
            // If there is a user, then create session data
            $row = $query->row();
            $logusername=$row->name; 
            $this->db->select('id');
            $this->db->where('refrence_no != ""');
            if($row->super_gym_id>0){
                $reference_query = $this->db->get('tbl_member_'.$row->super_gym_id);
            }else{
                $reference_query = $this->db->get('tbl_member_'.$row->id);
            }
            $reference_result = $reference_query->result_array();
            if(!empty($reference_result)){
                $referncenumber_status=true;
            }else{
                $referncenumber_status=false;
            }
            $this->db->select('*');
            $query = $this->db->get_where('users', array('id' => $res['id']));
            $pers = $query->row_array();
            if($row->parent_gym==0 && $row->super_gym_id!=0){
				$superadmindata=$this->getsuperadmindata($res['super_gym_id']);
				if(!empty($superadmindata)){
				    $row->name=$superadmindata['name'];
				    $row->timezone=$superadmindata['timezone'];
				    $row->image=$superadmindata['image'];
				    $row->phone=$superadmindata['phone'];
				    $row->email=$superadmindata['email'];
				    $row->address=$superadmindata['address'];
				    $row->show_fees=$superadmindata['show_fees'];
				    $row->show_phone=$superadmindata['show_phone'];
				}
				$data = array(
					'userid' => $row->super_gym_id,
					'add_user_status' => $row->add_user_status,
					'authorization' => unserialize($row->authorization),
					'parent_gym' => $row->parent_gym,
					'username' => $row->name,
					'log_username' => $logusername,
					'phone' => $row->phone,
					'email' => $row->email,
					'address' => $row->address,
					'image' => $row->image,
					'show_fees' => $row->show_fees,
					'show_phone' => $row->show_phone,
					'timezone' => $row->timezone,
					'referncenumber_status' => $referncenumber_status,
					'type' => 1,
                    'printer_option' => $row->printer_option,
					'validated' => true
				);
            }
            else{
                $data = array(
                    'userid' => $row->id,
                    'add_user_status' => $row->add_user_status,
                    'parent_gym' => $row->parent_gym,
                    'username' => $row->name,
                    'log_username' => $logusername,
                    'phone' => $row->phone,
                    'email' => $row->email,
                    'address' => $row->address,
                    'image' => $row->image,
                    'show_fees' => $row->show_fees,
                    'show_phone' => $row->show_phone,
                    'timezone' => $row->timezone,
                    'referncenumber_status' => $referncenumber_status,
                    'type' => 1,
                    'printer_option' => $row->printer_option,
                    'validated' => true
                );
            }
            $this->db->where('id', $row->currency_id);
			$query = $this->db->get('tbl_currencies');
			$currencydata = $query->row_array();
            if(!empty($currencydata)){
                $data['currency_name']=$currencydata['currency_name'];
                $data['currency_symbol']=$currencydata['currency_symbol'];
            }else{
                $data['currency_name']="Ruppes";
                $data['currency_symbol']="Rs";
            }
            $this->session->set_userdata($data);
            return true;
			}
			return false;
    }
    public function getsuperadmindata($id){
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_gym');
		$res = $query->row_array();
		return $res;
	}
    public function validate_admin_pass(){
        // grab user input
        $id = $this->security->xss_clean($this->input->post('staff_id'));
        $password = $this->security->xss_clean(md5($this->input->post('old_password')));
        // Prep the query
        $this->db->where('id', $id);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();
        // Let's check if there are any results
        if(!empty($res)){
            return true;
        }
    }
    public function validate_email(){
        // grab user input
        $email = $this->security->xss_clean($this->input->post('email'));
        // Prep the query
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();
        // Let's check if there are any results
        if(!empty($res)){				
            return true;
        }
    }
    public function checkadminuser_withusername(){
        $this->db->where('user_name', $_POST['user_name']."_".$_SESSION['userid']);
        $this->db->where_not_in('id', $_POST['id']);
        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();
        return $res;
    }
    public function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }public function update_admin_password_by_email($pass){
        $this->load->helper('url');
        $data = array();
        $data['password'] = md5($pass);
        $this->db->where('email', $this->input->post('email'));
        return $this->db->update('tbl_gym', $data); 
    }
    public function update_admin_password(){
        $this->load->helper('url');
        $data = array();
        if($this->input->post('new_password')){
            $data['password'] = md5($this->input->post('new_password'));
        }
        $this->db->where('id', $this->input->post('staff_id'));
        return $this->db->update('tbl_gym', $data);
    }
}