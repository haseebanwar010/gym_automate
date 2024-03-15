<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appservices extends CI_Controller {
   // public $baseUrl="http://localhost/calarepair2";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('appservices_model');
        $this->load->helper('url_helper');
        $this->load->library('session');
        //$this->check_isvalidated();
    }
    public function index( $msg = NULL)
    {

      //echo "there";
        //exit;
        $data=0;
        $admins = $this->appservices_model->get_admins();
      //$this->load->view('front/appservicesview', $data);
      
    }
    public function login(){
        $data = json_decode(file_get_contents("php://input"));

        $email=$data->email;
        $password=$data->password;
        $result = $this->appservices_model->authenticate($email,$password);
if($result=="error"){
    echo $result;
}
        else{
            echo json_encode($result);
        }

    }

    public function dashboarddata(){

        $data = json_decode(file_get_contents("php://input"));

        $gymid=$data->gymid;

        $totalmembers = $this->appservices_model->get_total_members($gymid);
        $activemembers = $this->appservices_model->get_total_active_members($gymid);
        $inactivemembers = $this->appservices_model->get_total_inactive_members($gymid);
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);


        $pastfees=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);

            if ($cdate>$feedate){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);

                $pastfees[]=$upcomingfeedata[$i];
            }

        }
        $data=array();
        $data['totalmembers']=$totalmembers;
        $data['activemembers']=$activemembers;
        $data['inactivemembers']=$inactivemembers;
        $data['pastfees']=sizeof($pastfees);

        echo json_encode($data);
    }


    public function pastfeesmembers(){
        $data = json_decode(file_get_contents("php://input"));
        $gymid=$data->gymid;
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);
        $pastfees=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);

            if ($cdate>$feedate){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);

                $pastfees[]=$upcomingfeedata[$i];
            }

        }

        echo json_encode($pastfees);
    }

    public function upcomingfee(){

        $data = json_decode(file_get_contents("php://input"));

        $gymid=$data->gymid;
        $upcomingfeedata=$this->appservices_model->get_activemembers($gymid);


        $upcomingfee=array();
        for($i=0;$i<sizeof($upcomingfeedata);$i++){
            $feedate=$upcomingfeedata[$i]['fee_date'];
            $cdateplus2mont = strtotime("+2 month", strtotime(date('Y-m-d')));
            $feedateplus2mont = strtotime("+2 month", $feedate);


            $cdate = strtotime(date('Y-m-d'));
            $feedateminus5days = strtotime("-5 days", $feedate);


            if($cdate>=$feedateplus2mont){
                /*comment the auto deactivate code of 2 month older meber without fee*/
                /*if($upcomingfeedata[$i]['payment_criteria']==1){
                    $this->dashboard_model->deactivate_member($upcomingfeedata[$i]['id']);
                }*/

            }
            elseif ($cdate>=$feedateminus5days && $cdate<=$feedate){
                $upcomingfeedata[$i]['fee_date']=date("d-M-Y",$upcomingfeedata[$i]['fee_date']);

                $upcomingfee[]=$upcomingfeedata[$i];
            }

        }
        $dataa=array();
        $dataa['upcomingfee']=$upcomingfee;
        $dataa['upcomingfeecount']=sizeof($upcomingfee);

        echo json_encode($dataa);
    }
    public function memberregistration(){
        $data = json_decode(file_get_contents("php://input"));
        $validate=$this->appservices_model->uservalidate($data);


        if(empty($validate)) {
            if ($this->appservices_model->registeredmember($data)) {
                echo "success";
            } else {
                echo "error";
            }
        }
        else{
            echo "alreadyuser";
        }
    }
    public function packages(){
        $data = json_decode(file_get_contents("php://input"));
        $packages=$this->appservices_model->getpackages($data);
        echo json_encode($packages);
    }

    public function memberlist(){
        $data = json_decode(file_get_contents("php://input"));
        $gymid=$data->gymid;

        $memberslist=$this->appservices_model->get_members($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        echo json_encode($memberslist);
    }
    public function activemembers(){
        $data = json_decode(file_get_contents("php://input"));
        $gymid=$data->gymid;

        $memberslist=$this->appservices_model->get_activemembers($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        echo json_encode($memberslist);
    }
    public function inactivemembers(){
        $data = json_decode(file_get_contents("php://input"));
        $gymid=$data->gymid;

        $memberslist=$this->appservices_model->get_inactivemembers($gymid);
        for($i=0;$i<sizeof($memberslist);$i++){
            $memberslist[$i]['joining_date']=date("d-M-Y",$memberslist[$i]['joining_date']);
            if($memberslist[$i]['package']!="" && $memberslist[$i]['package']!="custom"){
                $packagedetail=$this->appservices_model->GetpackageById($memberslist[$i]['package']);
                $memberslist[$i]['fees']=$packagedetail[0]['fees'];
            }
        }
        echo json_encode($memberslist);
    }
    public function memberprofile($memberid=null){

        $data=array();

        $EmpData = $this->appservices_model->GetMemberDetailById($memberid);
        $data['member'] = $EmpData[0];


        $record=array();
        $record['memberdetail']['id']=$data['member']['id'];
        $record['memberdetail']['name']=$data['member']['name'];
        $record['memberdetail']['email']=$data['member']['email'];
        $record['memberdetail']['phone']=$data['member']['phone'];
        $record['memberdetail']['cnic']=$data['member']['cnic'];
        $record['memberdetail']['address']=$data['member']['address'];
        $record['memberdetail']['package']=$data['member']['package'];
        $record['memberdetail']['image']=$data['member']['image'];

        if($record['memberdetail']['package']=="" || $record['memberdetail']['package']=="custom"){
            $record['memberdetail']['fees']=$data['member']['fees'];
        }
        else{

            $packagedetail = $this->appservices_model->GetpackageById($record['memberdetail']['package']);
            $record['memberdetail']['fees']=$packagedetail[0]['fees'];
        }

        $record['memberdetail']['joining_date']=date("d-M-Y",$data['member']['joining_date']);
        $record['memberdetail']['fee_date']=date("d-M-Y",$data['member']['fee_date']);

        if($data['member']['status']==1){$record['memberdetail']['status']="Active";}
        else{$record['memberdetail']['status']="Inctive";}

        $datatosearlize=array();
            if($data['member']['fees_detail']!=null){
                $fees_detail=$data['member']['fees_detail'];
                $unserdata=unserialize($fees_detail);

                for($j=0;$j<sizeof($unserdata);$j++){
                    $datatosearlize[]=$unserdata[$j];
                }

            }
        $record['fees_record']=$datatosearlize;
        for($i=0;$i<sizeof($record['fees_record']);$i++){
            $record['fees_record'][$i]['payment_date']=date("d-M-Y",$record['fees_record'][$i]['payment_date']);
        }

        echo json_encode($record);

    }

    public function searchmember(){
        $data=json_decode(file_get_contents("php://input"));
/*echo "<pre>";
        var_dump($data);
        exit;*/
        $members=$this->appservices_model->searchmembers($data);
        echo json_encode($members);
    }

    public function forgotpassword(){
        $data = json_decode(file_get_contents("php://input"));



        $this->load->helper('email');
        $this->load->library('email');



        if(isset($data)){
            $email=$data->email;

            $check=$this->appservices_model->Checkemail($email);

            if($check){


                $new_password= $this->appservices_model->Random_Code();


                $master_email = "danish.khan@abaskatech.com";
                $master_name = "Abaska";
                $customer_name=$check[0]['name'];

                $message = 'Dear '.$customer_name.'<br /><br />
				<br />Your password has been changed successfully.<br>
                New Password: '.$new_password;

                    $config['protocol'] = "smtp";
                    $config['smtp_host'] = "ssl://smtp.gmail.com";
                    $config['smtp_port'] = "465";
                    $config['smtp_user'] = "mike.smith92333@gmail.com";
                    $config['smtp_pass'] = "admin123asdf123";

                $config['charset']    = 'utf-8';
                $config['newline']    = "\r\n";
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->email->initialize($config);
                $this->email->from($master_email, $master_name);
                $this->email->to($email);
                $this->email->subject('New Password');
                $this->email->message($message);
                $this->email->send();
                echo $this->email->print_debugger();
                //$update=$this->appservices_model->customer_new_password($check[0]['id'],$new_password);
                /*if($update)
                {
                    echo 1;
                }*/
            }
            else{
                echo 0;
                exit;
            }


        }
    }


    public function payfee(){
        $data=json_decode(file_get_contents("php://input"));


        if($this->appservices_model->payfee($data)){
            echo 1;
        }
        else{
            echo 0;
        }
    }




public function addhundredmembers(){
    exit;
    $name=array("iqbal gym","samnabad gym","valencia gym","rana gym","johar town gym","DHA gym","builder night","wapda town gym","builders house","Shadman gym",
                "iqbal gym12","samnabad gym12","valencia gym12","rana gym12","johar town gym12","DHA gym12","builder night12","wapda town gym12","builders house12","Shadman gym12",
                "iqbal gym34","samnabad gym34","valencia gym34","rana gym34","johar town gym34","DHA gym34","builder night34","wapda town gym34","builders house34","Shadman gym34",
                "iqbal gym45","samnabad gym45","valencia gym45","rana gym45","johar town gym45","DHA gym45","builder night45","wapda town gym45","builders house45","Shadman gym45",
                "iqbal gym65","samnabad gym65","valencia gym65","rana gym65","johar town gym65","DHA gym65","builder night65","wapda town gym65","builders house65","Shadman gym65",
                "iqbal gym76","samnabad gym76","valencia gym76","rana gym76","johar town gym76","DHA gym76","builder night76","wapda town gym76","builders house76","Shadman gym76",
                "iqbal gym88","samnabad gym88","valencia gym88","rana gym88","johar town gym88","DHA gym88","builder night88","wapda town gym88","builders house88","Shadman gym88",
                "iqbal gym99","samnabad gym99","valencia gym99","rana gym99","johar town gym99","DHA gym99","builder night99","wapda town gym99","builders house99","Shadman gym99",
                "iqbal gym44","samnabad gym44","valencia gym44","rana gym44","johar town gym44","DHA gym44","builder night44","wapda town gym44","builders house44","Shadman gym44",
                "iqbal gym11","samnabad gym11","valencia gym11","rana gym11","johar town gym11","DHA gym11","builder night11","wapda town gym11","builders house11","Shadman gym11"
               );
    $email=array('dansih@gmail.com','dawood@gmail.com','usman@gmail.com','umair@gmail.com','ahsan@gmail.com','sheri@gmail.com','ali@gmail.com','mahad@gmail.com','naqash@gmail.com','hussain@gmail.com',
                 'dansih@gmail12.com','dawood@gmail12.com','usman@gmail12.com','umair@gmail12.com','ahsan@gmail12.com','sheri@gmail12.com','ali@gmail12.com','mahad@gmail12.com','naqash@gmail12.com','hussain@gmail12.com',
                 'dansih@gmail33.com','dawood@gmail33.com','usman@gmail33.com','umair@gmail33.com','ahsan@gmail33.com','sheri@gmail33.com','ali@gmail33.com','mahad@gmail33.com','naqash@gmail33.com','hussain@gmail33.com',
                 'dansih@gmail55.com','dawood@gmail55.com','usman@gmail55.com','umair@gmail55.com','ahsan@gmail55.com','sheri@gmail55.com','ali@gmail55.com','mahad@gmail55.com','naqash@gmail55.com','hussain@gmail55.com',
                 'dansih@gmail76.com','dawood@gmail76.com','usman@gmail76.com','umair@gmail76.com','ahsan@gmail76.com','sheri@gmail76.com','ali@gmail76.com','mahad@gmail76.com','naqash@gmail76.com','hussain@gmail76.com',
                 'dansih@gmail88.com','dawood@gmail88.com','usman@gmail88.com','umair@gmail88.com','ahsan@gmail88.com','sheri@gmail88.com','ali@gmail88.com','mahad@gmail88.com','naqash@gmail88.com','hussain@gmail88.com',
                 'dansih@gmail98.com','dawood@gmail98.com','usman@gmail98.com','umair@gmail98.com','ahsan@gmail98.com','sheri@gmail98.com','ali@gmail98.com','mahad@gmail98.com','naqash@gmail98.com','hussain@gmail98.com',
                 'dansih@gmail14.com','dawood@gmail14.com','usman@gmail14.com','umair@gmail14.com','ahsan@gmail14.com','sheri@gmail14.com','ali@gmail14.com','mahad@gmail14.com','naqash@gmail14.com','hussain@gmail14.com',
                 'dansih@gmail87.com','dawood@gmail87.com','usman@gmail87.com','umair@gmail87.com','ahsan@gmail87.com','sheri@gmail87.com','ali@gmail87.com','mahad@gmail87.com','naqash@gmail87.com','hussain@gmail87.com',
                 'dansih@gmail54.com','dawood@gmail54.com','usman@gmail54.com','umair@gmail54.com','ahsan@gmail54.com','sheri@gmail54.com','ali@gmail54.com','mahad@gmail54.com','naqash@gmail54.com','hussain@gmail54.com'
                );
    $phone=array('0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
                '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757');
   
    
    $pcriteria=array(1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1,1,2,3,1,2,3,1,2,3,1);
    
    for($i=0;$i<100;$i++){
        $record=array();
        $record['name']=$name[$i];
        $record['user_name']="admin".$i;
        $record['email']=$email[$i];
        $record['phone']=$phone[$i];
        $record['address']="sample address".$i;
        $record['password']="40be4e59b9a2a2b5dffb918c0e86b3d7";
        $record['parent_gym']=0;
        $record['package_type']=$pcriteria[$i];
        $record['payment_criteria']=$pcriteria[$i];
        $record['status']=1;
        $this->appservices_model->registeredgym100($record);
    }
    
    
}



public function addspecifichundredmembers(){
exit;


$name=array('danish','usman','dawood','umair','ahmad','naqash','mahad','hussain','hassan','waqas',
    'danish 11','usman 11','dawood 11','umair 11','ahmad 11','naqash 11','mahad 11','hussain 11','hassan 11','waqas 11',
    'danish 22','usman 22','dawood 22','umair 22','ahmad 22','naqash 22','mahad 22','hussain 22','hassan 22','waqas 22',
    'danish 33','usman 33','dawood 33','umair 33','ahmad 33','naqash 33','mahad 33','hussain 33','hassan 33','waqas 33',
    'danish 44','usman 44','dawood 44','umair 44','ahmad 44','naqash 44','mahad 44','hussain 44','hassan 44','waqas 44',
    'danish 55','usman 55','dawood 55','umair 55','ahmad 55','naqash 55','mahad 55','hussain 55','hassan 55','waqas 55',
    'danish 66','usman 66','dawood 66','umair 66','ahmad 66','naqash 66','mahad 66','hussain 66','hassan 66','waqas 66',
    'danish 99','usman 99','dawood 99','umair 99','ahmad 99','naqash 99','mahad 99','hussain 99','hassan 99','waqas 99',
    'danish 77','usman 77','dawood 77','umair 77','ahmad 77','naqash 77','mahad 77','hussain 77','hassan 77','waqas 77',
    'danish 88','usman 88','dawood 88','umair 88','ahmad 88','naqash 88','mahad 88','hussain 88','hassan 88','waqas 88',);
    $email=array('danish@gmail.com','usman@gmail.com','dawood@gmail.com','umair@gmail.com','ahmad@gmail.com','naqash@gmail.com','mahad@gmail.com','hussain@gmail.com','hassan@gmail.com','waqas@gmail.com',
        'danish11@gmail.com','usman11@gmail.com','dawood11@gmail.com','umair11@gmail.com','ahmad11@gmail.com','naqash11@gmail.com','mahad11@gmail.com','hussain11@gmail.com','hassan11@gmail.com','waqas11@gmail.com',
        'danish22@gmail.com','usman22@gmail.com','dawood22@gmail.com','umair22@gmail.com','ahmad22@gmail.com','naqash22@gmail.com','mahad22@gmail.com','hussain22@gmail.com','hassan22@gmail.com','waqas22@gmail.com',
        'danish33@gmail.com','usman33@gmail.com','dawood33@gmail.com','umair33@gmail.com','ahmad33@gmail.com','naqash33@gmail.com','mahad33@gmail.com','hussain33@gmail.com','hassan33@gmail.com','waqas33@gmail.com',
        'danish44@gmail.com','usman44@gmail.com','dawood44@gmail.com','umair44@gmail.com','ahmad44@gmail.com','naqash44@gmail.com','mahad44@gmail.com','hussain44@gmail.com','hassan44@gmail.com','waqas44@gmail.com',
        'danish55@gmail.com','usman55@gmail.com','dawood55@gmail.com','umair55@gmail.com','ahmad55@gmail.com','naqash55@gmail.com','mahad55@gmail.com','hussain55@gmail.com','hassan55@gmail.com','waqas55@gmail.com',
        'danish66@gmail.com','usman66@gmail.com','dawood66@gmail.com','umair66@gmail.com','ahmad66@gmail.com','naqash66@gmail.com','mahad66@gmail.com','hussain66@gmail.com','hassan66@gmail.com','waqas66@gmail.com',
        'danish77@gmail.com','usman77@gmail.com','dawood77@gmail.com','umair77@gmail.com','ahmad77@gmail.com','naqash77@gmail.com','mahad77@gmail.com','hussain77@gmail.com','hassan77@gmail.com','waqas77@gmail.com',
        'danish88@gmail.com','usman88@gmail.com','dawood88@gmail.com','umair88@gmail.com','ahmad88@gmail.com','naqash88@gmail.com','mahad88@gmail.com','hussain88@gmail.com','hassan88@gmail.com','waqas88@gmail.com',
        'danish99@gmail.com','usman99@gmail.com','dawood99@gmail.com','umair99@gmail.com','ahmad99@gmail.com','naqash99@gmail.com','mahad99@gmail.com','hussain99@gmail.com','hassan99@gmail.com','waqas99@gmail.com',);
    $phone=array('0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757',
        '0302 5678901','0305 1234567','0301 76554321', '0345 7687686', '0987 7686888','0654 1278654','8765 9863421','0854 5674321', '0543 6789054', '8761 7656757');
    $cnic=array('03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87669863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09887686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03457687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757',
        '03025678901','03051234567','030176554321', '03497687686', '09877686888','06541278654','87659863421','08545674321', '05436789054', '87617656757');
    $fees=array(800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,
        1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,
        2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500,800,900,1000,1200,1500,1800,2000,1000,2500,1500);
    $pcriteria=array(1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6,1,2,1,3,1,4,1,5,1,6);
    $jdate=array(strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),
        strtotime('07/14/2017'),strtotime('06/1/2017'),strtotime('05/1/2017'),strtotime('04/5/2017'),strtotime('03/1/2017'),strtotime('02/5/2017'),strtotime('01/14/2017'),strtotime('07/14/2017'),strtotime('04/14/2017'),
        strtotime('04/14/2017'),);
    $fdate=array(strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),
        strtotime('08/14/2017'),strtotime('08/1/2017'),strtotime('06/1/2017'),strtotime('07/5/2017'),strtotime('04/1/2017'),strtotime('06/5/2017'),strtotime('02/14/2017'),strtotime('12/14/2017'),strtotime('06/14/2017'),
        strtotime('10/14/2017'),);

    for($i=6;$i<106;$i++){
        for($j=0;$j<100;$j++){
            $record=array();
            $record['name']=$name[$j]." admin".$i;
            $record['email']=$email[$j];
            $record['phone']=$phone[$j];
            $record['cnic']=$cnic[$j];
            $record['address']="sample address ".$j;
            $record['fees']=$fees[$j];
            $record['payment_criteria']=$pcriteria[$j];
            $record['joining_date']=$jdate[$j];
            $record['fee_date']=$fdate[$j];
            $record['gym_id']=$i;
            $record['status']=1;

            $this->appservices_model->addspecifichundredmembers($record);
        }
    }
}

    
}


?>
