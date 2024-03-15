<?php
class Webappservices_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    
   public function authenticateuser($input){
        $this->db->select('id');
        $this->db->where('user_name', $input->username);
        $this->db->where('password', md5($input->password));
        $this->db->where('status', 1);
        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();
       return $res;
   }
    
    
    public function get_activemembers($gymid){
        $tablename="tbl_member_".$gymid;
        $this->db->select('id');
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    }
    
     public function addattendence($gymid,$date,$memberid,$time){
        
        $dataa=array();
        $data=array();
        $datatosearlize=array();
        
        $dataa['date'] = date("Y-m-d",strtotime($date));
        $dataa['member_id'] = $memberid;
		
        
        $dataa['time_in']=$time;
        $dataa['time_out']="00:00:00";
        
        
        $currentdate=date("Y-m-d",strtotime($date));
       
        
		$tablename="tbl_attendence_".$gymid;
		$this->db->where('date', $currentdate);
		$query=$this->db->get($tablename);
		$checkdate = $query->result_array();
      
        if(empty($checkdate)){
            
            $datatosearlize[]=$dataa;
            $data['attendence']=serialize($datatosearlize);
            $data['date']=$currentdate;
            
            return $this->db->insert($tablename, $data);
        }
        else{
           
            $checkdateattendence=$checkdate[0]['attendence'];
            
            $checkdateattendence=unserialize($checkdateattendence);
            
            $addstatus=true;
            for($i=0;$i<sizeof($checkdateattendence);$i++){
                $datatosearlize[]=$checkdateattendence[$i];
                if($checkdateattendence[$i]['time_in']==$dataa['time_in'] && $checkdateattendence[$i]['member_id']==$dataa['member_id']){
                    $addstatus=false;
                }
            }
            if($addstatus==true){
                $datatosearlize[]=$dataa;
            }
            
            $data['attendence']=serialize($datatosearlize);
            $this->db->where('id', $checkdate[0]['id']);
		    return $this->db->update($tablename, $data);
        }
        
        
        
    }
    
    public function get_inactivemembers($gymid){
        
        $tablename="tbl_member_".$gymid;
        $this->db->select($tablename.'.id');
        $this->db->from($tablename);
        $this->db->where($tablename.'.gym_id', $gymid);
        $this->db->where($tablename.'.status', 0);
        $this->db->where($tablename.'.archive_status', 0);
//        if($gymid==2){
//            $this->db->limit(5);
//        }
        
        $this->db->join('tbl_backup', 'tbl_backup.member_id = '.$tablename.'.id', 'left');
        $where = "(tbl_backup.member_id IS NULL OR tbl_backup.restore_status=1)";
        $this->db->where($where);

      //  $this->db->where('tbl_backup.member_id =', NULL);
        $query = $this->db->get(); 
      
        $result = $query->result_array();   
        /*echo "<pre>";
        var_dump($result);
        exit;
        */
        /*$this->db->select('id');
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 0);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();*/
        return $result;
    }
    
    public function SetBackup($gymid,$backupdata){
        $data=array();
        $data['gym_id']=$gymid;
        $data['member_id']=$backupdata->member_id;
        $data['name']=$backupdata->name;
        $data['password']=$backupdata->Password;
        $data['prvlg']=$backupdata->prvlg;
        $data['enabled']=$backupdata->enabled;
        $data['fingerIndex']=$backupdata->fingerIndex;
        $data['flag']=$backupdata->flag;
        $data['templateData']=$backupdata->templateData;
        $tablename='tbl_backup';
        
        $this->db->where('member_id', $data['member_id']);
        $this->db->where('templateData', $data['templateData']);
        $this->db->where('restore_status', 0);
		$query=$this->db->get($tablename);
        $result = $query->result_array();
        if(empty($result)){
            return $this->db->insert($tablename, $data);
        }
        
    }
    
    public function getbackupactivemembers($gymid){
        $tablename="tbl_member_".$gymid;
        
        $this->db->select('tbl_backup.id, tbl_backup.gym_id, tbl_backup.member_id, tbl_backup.name, tbl_backup.password, tbl_backup.prvlg, tbl_backup.enabled, tbl_backup.fingerIndex, tbl_backup.flag, tbl_backup.templateData');
        $this->db->from('tbl_backup');
        $this->db->join($tablename, 'tbl_backup.member_id = '.$tablename.'.id');
        $this->db->where('status', 1);
        $this->db->where('tbl_backup.restore_status', 0);
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result;
    }
    public function deletebackupactivemembers($id){
        $this->db->where('id', $id);
		return $this->db->delete('tbl_backup');
    }
    public function changestatusbackupactivemembers($id){
        $data['restore_status']=1;
        $this->db->where('id', $id);
        return $this->db->update("tbl_backup", $data);
    }
    public function get_members($gymid){
        $tablename="tbl_member_".$gymid;
        $this->db->where('gym_id', $gymid);
        //$this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get($tablename);
        $result = $query->result_array();
        return $result;
    }
    

    public function GetpackageById($id){
        $this->db->where('id', $id);

        $query=$this->db->get('tbl_packages');
        $result = $query->result_array();

        return $result;
    }
    
   


}