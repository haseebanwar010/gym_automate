<?php
class Appservices_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    
    public function authenticate($email,$password){

        $this->db->where('user_name', $email);
        $this->db->where('password', md5($password));

        $query = $this->db->get('tbl_gym');
        $res = $query->row_array();

        if(!empty($res))
        {
            return $res;
        }
        return "error";


    }
    public function get_total_members($gymid){

        $gymid=$gymid;
        $this->db->where('gym_id', $gymid);
        $query=$this->db->get('members');
        //$result = $query->result_array();
        return $query->num_rows();
    }
    public function get_total_active_members($gymid){

        $gymid=$gymid;
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
        $query=$this->db->get('members');
        //$result = $query->result_array();

        return $query->num_rows();
    }
    public function get_total_inactive_members($gymid){

        $gymid=$gymid;
        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 0);
        $query=$this->db->get('members');
        //$result = $query->result_array();

        return $query->num_rows();
    }
    public function get_members($gymid){

        $this->db->where('gym_id', $gymid);
        //$this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get('members');
        $result = $query->result_array();
        return $result;
    }
    
    public function get_activemembers($gymid){

        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $query=$this->db->get('members');
        $result = $query->result_array();
        return $result;
    }
    public function get_inactivemembers($gymid){

        $this->db->where('gym_id', $gymid);
        $this->db->where('status', 0);
        $this->db->order_by("id", "desc");
        $query=$this->db->get('members');
        $result = $query->result_array();
        return $result;
    }

    public function GetpackageById($id){
        $this->db->where('id', $id);

        $query=$this->db->get('tbl_packages');
        $result = $query->result_array();

        return $result;
    }
    public function uservalidate($data){
        $gymid=$data->gym_id;

        $email = $data->email;
        $phone = $data->phone;
        $cnic = $data->cnic;
        if(isset($scnic) && $cnic!="" ) {
            $sql = "select * from members where gym_id='" . $gymid . "' AND (
        email='" . $email . "' OR phone='" . $phone . "' OR cnic='" . $cnic . "')";
        }
        else{
            $sql = "select * from members where gym_id='" . $gymid . "' AND(
        email='" . $email . "' OR phone='" . $phone . "')";
        }

        return $this->db->query($sql)->result_array();
    }


    public function registeredmember($data){

        $record=array();
        $record['name']=$data->name;
        $record['email']=$data->email;
        $record['phone']=$data->phone;
        $record['cnic']=$data->cnic;
        $record['address']=$data->address;

        $record['payment_criteria']=$data->payment_criteria;
        $record['package']=$data->package;
        $record['gym_id']=$data->gym_id;
        $record['status']=$data->status;
        $record['joining_date']=strtotime($data->joining_date);
        $record['fee_date'] = strtotime($data->joining_date);
        if($record['package']=="" || $record['package']=="custom"){
            $record['fees']=$data->fees;
            $record['fee_date'] = strtotime("+".$record['payment_criteria']." month", $record['fee_date']);

            $dataa=array();
            $dataa['payment_date'] = $record['joining_date'];
            $dataa['fees'] = $record['fees'];
            $dataa['comment']="";
        }
        else{




            $packagedetail=$this->GetpackageById($record['package']);
            $record['fee_date'] = strtotime("+".$packagedetail[0]['duration']." month", $record['fee_date']);
            $record['fees']=$packagedetail[0]['fees'];
            $dataa=array();
            $dataa['payment_date'] = $record['joining_date'];
            $dataa['fees'] = $packagedetail[0]['admission_fees']+$packagedetail[0]['fees'];
            $dataa['comment']="";
        }

        $datatosearlize[]=$dataa;
        $searilizeddetail=serialize($datatosearlize);
        $record['fees_detail']=$searilizeddetail;


        return $this->db->insert('members', $record);
    }
    public function getpackages($data){
        $gymid=$data->gymid;
        $this->db->where('gym_id', $gymid);
        $query=$this->db->get('tbl_packages');
        return $query->result_array();
    }

    public function GetMemberDetailById($id=NULL){
        $this->db->where('id', $id);
        $query=$this->db->get('members');
        return $query->result_array();
    }

    public function Checkemail($email=NULL){

        $this->db->where('email', $email);
        $query=$this->db->get('tbl_gym');
        return $query->result_array();
    }

    public function Random_Code($length=10)
    {
        $chars = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N",
            "O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3",
            "4","5","6","7","8","9","0");
        $max_chars = count($chars) - 1;
        srand((double)microtime()*1000000);
        $randChars='';
        for ($i = 0; $i < $length; $i++) {
            $randChars .= ($i == 0) ? $chars[rand(0, $max_chars)] :$chars[rand(0, $max_chars)];
        }
        return $randChars;
    }

    public function customer_new_password($customer_id='',$password='')
    {
        $this->load->helper('url');
        $data = array();
        if($customer_id!='' && $password!='')
        {
            $data['password']= md5($password);
            return $this->db->where('id',$customer_id)->set($data)->update_all('tbl_gym');
        }
        return false;
    }
    public function searchmembers($filter=null){

        if(isset($filter->name) && isset($filter->phone)){


            $phone=$filter->phone;
            $name=$filter->name;
            $gymid=$filter->gymid;

            $this->db->like('name', $name);
            $this->db->like('phone', $phone);
            $this->db->where('gym_id', $gymid);
            $query = $this->db->get('members');
            $res= $query->result_array();

        }
        else if(isset($filter->name)){
            $name=$filter->name;
            $gymid=$filter->gymid;

            $this->db->like('name', $name);
            $this->db->where('gym_id', $gymid);
            $query = $this->db->get('members');
            $res= $query->result_array();

        }
        else if(isset($filter->phone)){
            $phone=$filter->phone;
            $gymid=$filter->gymid;

            $this->db->like('phone', $phone);
            $this->db->where('gym_id', $gymid);
            $query = $this->db->get('members');

            $res= $query->result_array();
        }

        for ($i=0;$i<sizeof($res);$i++){
            $res[$i]['joining_date']=date("Y-M-d",$res[$i]['joining_date']);
            $res[$i]['fee_date']=date("Y-M-d",$res[$i]['fee_date']);
        }
return $res;


    }


    public function payfee($record){

        /*echo "<pre>";
        var_dump($record);
        exit;*/
        $dataa=array();

        if(isset($record->payment_date) && $record->payment_date!=""){
            $dataa['payment_date'] = strtotime($record->payment_date);
        }
        else{
            $dataa['payment_date'] = strtotime(date("d-M-y"));
        }

            $dataa['fees'] = $record->fees;
        if(isset($record->comment) && $record->comment!=""){
            $dataa['comment'] = $record->comment;
        }
        else{
            $dataa['comment'] = "";
        }




        $this->db->where('id',$record->memberid);
        $query=$this->db->get('members');
        $getdata=$query->result_array();

        if($getdata[0]['package']=="" || $getdata[0]['package']=="custom"){
            $updateddate = strtotime("+".$getdata[0]['payment_criteria'] ." months", $getdata[0]['fee_date']);
            $data['fee_date']=$updateddate;
        }
        else{
            $packagedetail=$this->GetpackageById($getdata[0]['package']);

            $updateddate = strtotime("+".$packagedetail[0]['duration'] ." months", $getdata[0]['fee_date']);
            $data['fee_date']=$updateddate;
        }

        $datatosearlize=array();
        for($i=0;$i<sizeof($getdata);$i++){
            if($getdata[$i]['fees_detail']!=null){
  $fees_detail=$getdata[$i]['fees_detail'];
                $unserdata=unserialize($fees_detail);
                for($j=0;$j<sizeof($unserdata);$j++){
                    $datatosearlize[]=$unserdata[$j];
                }

            }
        }
  $datatosearlize[]=$dataa;


        $searilizeddetail=serialize($datatosearlize);
        
        $data['fees_detail']=$searilizeddetail;




        $this->db->where('id', $record->memberid);
        return $this->db->update('members', $data);


    }




















     public function registeredgym100($data){

        
        $this->db->insert('tbl_gym', $data);
    }
    public function addspecifichundredmembers($data){


        $this->db->insert('members', $data);
    }


}