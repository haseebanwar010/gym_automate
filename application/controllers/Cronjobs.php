<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cronjobs extends CI_Controller {
   // public $baseUrl="http://localhost/calarepair2";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cronjobs_model');
        date_default_timezone_set('Asia/Karachi');
        
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
        //$this->check_isvalidated();
    }
    public function get_database_backup(){
        
        $currentdate_5daysbefore = date('d-M-Y', mktime(0, 0, 0, date('m'), date('d') - 5, date('Y')));
        $filetodelete="Gymautomate-db(".$currentdate_5daysbefore.").sql";
//        $filetodelete='Gymautomate-db(15-Nov-2018).sql';
        @unlink("./db_backups/$filetodelete");
        
        $this->load->dbutil();
        $db_format=array('format'=>'sql', 'filename' =>'my_db_backup.sql');
        $backup= $this->dbutil->backup($db_format);
        $dbname='Gymautomate-db('.date('d-M-Y').').sql';
        $save=('db_backups/'.$dbname);
        write_file($save,$backup);
//        force_download($dbname,$backup);
    }
    
    public function dailyreport(){
        $gyms=$this->cronjobs_model->getallgyms();
//        Status Report
//8 Pack Fitness 
//Date: 22 Nov 2018
//Today's Income: ($)400
//New Registrations: 0
//Active Members: 150
        
        foreach($gyms as $gym){
            $activemembers=$this->cronjobs_model->getactivemembers($gym['id']);
            $totalusersincome=0;
            $totalincome = $this->cronjobs_model->get_total_income2($gym['id']);
            $currencydetail=$this->cronjobs_model->getcurrencydetails($gym['currency_id']);
            $todaysregistrations=$this->cronjobs_model->get_todaysregistrations($gym['id']);
            $numberofregistrations=sizeof($todaysregistrations);
            $currentdate=date('d-m-y');
            
            if(!empty($totalincome)){
                for($i=0;$i<sizeof($totalincome);$i++){
                    $feedate=unserialize($totalincome[$i]['fees_detail']);
                    if(!empty($feedate)){
                    foreach($feedate as $fee){
                        if(date('d-m-y',$fee['payment_date'])==$currentdate){
                            $totalusersincome=$totalusersincome+$fee['fees'];
                        }
                    }
                }
                }
            }
            $totalincometext=$currencydetail["currency_symbol"].''.$totalusersincome;
            $gymname=$gym['name'];
            $currentdate=date('d M Y');
            $message="Status Report\n".$gymname."\nDate: ".$currentdate."\nToday's Income: ".$totalincometext."\nNew Registrations: ".$numberofregistrations."\nActive Members: ".$activemembers;
            $message=urlencode($message);
            $url="http://api.bizsms.pk/api-send-branded-sms.aspx?username=abaskatech@bizsms.pk&pass=ab3sth99&text=".$message."&masking=SMS%20Alert&destinationnum=".$gym['phone']."&language=English";
            
            $result = file_get_contents($url);
//            echo $result;
        }
    }
    
}


?>
