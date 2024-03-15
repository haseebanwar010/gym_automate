<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
        $this->load->library('session');
        $this->load->model('logs_model');
        if(check_permission('logs_access')){
            
        }else{
            redirect('admin/restricted');
        }
    }
	
    public function alllogs(){
        $data=array();
        $data['page']='logs';
        if($this->input->post('date') && !empty($this->input->post('date'))){
            $date=date('Y-m-d',strtotime($this->input->post('date')));
        }
        else{
            $date=date('Y-m-d');
        }
        $logs=$this->logs_model->get_log_by_date($date);
        $data['logs']=array();
        if(!empty($logs)){
            $logsdetails=unserialize($logs['log_details']);
            
            foreach($logsdetails as $log){
                $logtext=$this->get_logtext($log);
                $data['logs'][]=$logtext;
            }
        }
        $this->load->view('admin/templates/header');
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/logs/index', $data);
        $this->load->view('admin/templates/footer');
    }
    public function get_logtext($log){
        $baseurl=$this->config->item('base_url');
        if(!empty($log)){
            if($log['log_type']=='delete_member'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has deleted ".$log['member_name'];
            }
            else if($log['log_type']=='payfee_active'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has paid fee (".$log['currency_symbol'].$log['feee_amount'].") and activated <a href='".$baseurl."admin/members/view/".$log['member_id']."'>".$log['member_name']."</a>";
            }
            else if($log['log_type']=='payfee_rejoin'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has paid fee (".$log['currency_symbol'].$log['feee_amount'].") and rejoined <a href='".$baseurl."admin/members/view/".$log['member_id']."'>".$log['member_name']."</a>";
            }
            else if($log['log_type']=='payfee'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has paid fee (".$log['currency_symbol'].$log['feee_amount'].") of  <a href='".$baseurl."admin/members/view/".$log['member_id']."'>".$log['member_name']."</a>";
            }
            else if($log['log_type']=='edit_member'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has updated a member <a href='".$baseurl."admin/members/view/".$log['member_id']."'>".$log['member_name']."</a>";
            }
            else if($log['log_type']=='add_member'){
                $text=$log['date']." ".$log['time']." ".$log['admin_name']." has added a new member <a href='".$baseurl."admin/members/view/".$log['member_id']."'>".$log['member_name']."</a>";
            }
            return $text;
        }
    }

}
?>