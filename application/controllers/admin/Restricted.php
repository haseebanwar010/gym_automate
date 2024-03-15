<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restricted extends CI_Controller {
   
	protected $title = 'Gym';

	public function __construct(){
        parent::__construct();
        date_default_timezone_set($this->session->userdata['timezone']);
    }
	
	public function index( $msg = NULL){
        $data=array();
        $this->load->view('admin/templates/header');
        $this->load->view('admin/templates/sidebar', $data);
        $this->load->view('admin/restricted', $data);
        $this->load->view('admin/templates/footer');
	}

}
?>