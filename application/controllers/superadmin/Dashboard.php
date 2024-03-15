<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	protected $title = 'Lead 2 Need'; 

	public function __construct()
        {
                parent::__construct();
                
				
				$this->load->model('dashboard_model');
				
		  }
	
	public function index( $msg = NULL)
	{
        
        $data=array();
        $data['page'] = 'dashboard';
		
		if(! $this->session->userdata('userrole')){
            
			redirect('auth2');
		}
        else{
            $this->load->view('superadmin/templates/header', $data);
				$this->load->view('superadmin/templates/sidebar', $data);
				$this->load->view('superadmin/dashboard', $data);
				$this->load->view('superadmin/templates/footer', $data);
        }
				
		}
	
	
		public function edit($id = NULL)
		{
			if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		if($this->session->userdata('user_role')=='AGENT'){
				redirect('walkCustomer');
			}
			$user = $this->session->get_userdata();
			$data['page'] = 'dashboard';
			$image ='';
			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['shipments'] = $this->dashboard_model->get_shipments($id);
			$data['agents'] = $this->dashboard_model->get_agents();
			$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|alpha_numeric_spaces');
			$this->form_validation->set_rules('pick_address', 'Pick Address', 'required');
			$this->form_validation->set_rules('drop_address', 'Drop Address', 'required');
			$this->form_validation->set_rules('item_price', 'Item Price', 'required|numeric');
			$this->form_validation->set_rules('shipment_cost', 'Shipment Cost', 'required|numeric');
			//$this->form_validation->set_rules('payment_type', 'Item Price', 'required');
			$this->form_validation->set_rules('weight', 'Weight', 'required');
			//$this->form_validation->set_rules('agent_id', 'Agent Name', 'required');	
			$this->form_validation->set_rules('shipment_status', 'Shipment Status', 'required');	
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('administrator/templates/header', $data);
				$this->load->view('administrator/templates/sidebar', $data);
				$this->load->view('administrator/dashboard/edit', $data);
				$this->load->view('administrator/templates/footer', $data);
			}
			else
			{
				$weight = ($this->input->post('weight')*1000);
				
				
				/* Updated Code */
				$this->db->select('*');
            	$query = $this->db->get_where('shipment_rates', array('id' => $this->input->post('rate_id')));
            	$dataRates = $query->result_array();
				$city_from = $dataRates[0]['city_from'];
				$city_to = $dataRates[0]['city_to'];
				$type = $dataRates[0]['type'];
				if($type==1)
				{
					
					//echo "123";
					//exit;
					/*Cash On delivery  */
					$this->db->select('*');
					$query = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																		  'weight_to>=' => $weight,
																		  'city_from' => $city_from,
																		  'city_to' => $city_to,
																		  'type' => 1		
																					));
					$dataW = $query->result_array();
					if(empty($dataW)){
					/*Cash On delivery Weights Greater */
			
					$this->db->select('*');
				//$this->db->from('shipment_rates');
					$this->db->order_by("weight_to", "Desc");
					$this->db->limit('1');
					$QrySelect = $this->db->get_where('shipment_rates',array ( 'city_from' => $city_from,
										 'city_to' => $city_to,
											'type' => 1	)); 
				
					//$QrySelect = $this->db->get(); 
					$priceData = $QrySelect->result_array();
					
					if(empty($priceData))
					{
						
					//$dataResult['error']='true';
					//$dataResult['error_msg']="Shipments rates are not available.";
				
					}else{
				
					$weight_to = $priceData[0]['weight_to'];
					$extraW = ($weight-$weight_to); 
					$priceToHW = $priceData[0]['price'];
					
					
					$this->db->select('*');
					$query = $this->db->get_where('shipment_type', array('id' => 1));
					$shipmentTypeData =  $query->result_array();
					
					//$shipmentTypeData = $this->calculater_model->getShipmentType(1);
					
					$extraWInKG =ceil(($extraW/1000));
				
					/*Extra Price */
					$this->db->select('*');
					//$this->db->from('shipment_rates');
					$QrySelectExtra = $this->db->get_where('shipment_rates',array ( 'city_from' => $city_from,
										 'city_to' => $city_to,
										 'title'=>'extra',
											'type' => 1	)); 
					//$QrySelectExtra = $this->db->get(); 
					$priceDataExt = $QrySelectExtra->result_array();
					
					if(empty($priceDataExt))
					{
						//$dataResult['error']='true';
						//$dataResult['error_msg']="Shipments rates are not available ";
					
					}else{
						
						$extraPrice = ($extraWInKG*$priceDataExt[0]['price']);
						$price = ceil(($extraPrice+ $priceToHW));
						//$dataUP['fuel_charges'] = ceil(($price/100)*$shipmentTypeData[0]['fuel_charges']);
						//$dataUP['tax'] =  ceil(($price/100)*$shipmentTypeData[0]['tax']);
						//$dataUP['flyer_cost'] = ceil($shipmentTypeData[0]['flyer_cost']);
						$dataUP['shipment_cost'] = $price;//+$dataUP['fuel_charges']+$dataUP['tax'];//+$dataUP['flyer_cost'];
						//$dataResult['total_cost'] = $price+$fualCharges+$tax+$flyer;
						$dataResult['rate_id'] = $priceDataExt[0]['id'];
						$dataResult['total_cost'] = $price;
						$dataResult['total_cost'] = ceil($dataResult['total_cost']);
						$dataUP['rate_id'] = $priceDataExt[0]['id'];
						$dataUP['shipping'] = $dataResult['total_cost'];
						$dataUP['type'] = 1;
					}
				}
			
			}else{
				/*Cash On delivery Weights Less */
			
				$this->db->select('*');
				$QrySelect = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																  'weight_to>=' => $weight,
																  'city_from' => $city_from,
																  'city_to' => $city_to,
																  'type' => 1		
																			));
				$priceData = $QrySelect->result_array();
			
				if(empty($priceData))
				{
					//$dataResult['error']='true';
					//$dataResult['error_msg']="Shipments rates are not available ";
				}else{
					$price = $priceData[0]['price'];
			
					 
					$this->db->select('*');
					$query = $this->db->get_where('shipment_type', array('id' => 1));
					$shipmentTypeData =  $query->result_array();
			
					//$dataUP['fuel_charges'] = ceil(($price/100)*$shipmentTypeData[0]['fuel_charges']);
					//$dataUP['tax'] =  ceil(($price/100)*$shipmentTypeData[0]['tax']);
					//$dataUP['flyer_cost'] = ceil($shipmentTypeData[0]['flyer_cost']);
					$dataUP['shipment_cost'] = $price;//+$dataUP['fuel_charges']+$dataUP['tax'];//+$dataUP['flyer_cost'];
					//$data['shipment_cost'] = $price+$data['fual_charges']+$data['tax']+$data['flyer_cost'];
					
					//$fualCharges = ($price/100)*$shipmentTypeData[0]['fuel_charges'];
					//$tax =  ($price/100)*$shipmentTypeData[0]['tax'];
					//$flyer = $shipmentTypeData[0]['flyer_cost'];
					//$dataResult['total_cost'] = $price+$fualCharges+$tax+$flyer;
					$dataResult['rate_id'] = $priceData[0]['id'];
					$dataResult['total_cost'] = $price;
					$dataResult['total_cost'] = ceil($dataResult['total_cost']);
					$dataUP['rate_id'] = $priceData[0]['id'];
					$dataUP['shipping'] = $dataResult['total_cost'];
					$dataUP['type'] = 1;
				}
			}
				
		}else{
			
			/*Advance Payment */
		
			$this->db->select('*');
            $query = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																  'weight_to>=' => $weight,
																  'city_from' => $city_from,
																  'city_to' => $city_to,
																  'type' => 2		
																			));
            $dataW = $query->result_array();
			//var_dump($dataW);
			//exit;
			
			if(empty($dataW)){
				/*Advance Payment Weights Greater */
				
				$this->db->select('*');
				$this->db->order_by("weight_to", "Desc");
				$this->db->limit('1');//$this->db->from('shipment_rates');
				$QrySelect = $this->db->get_where('shipment_rates' , array ( 'city_from' => $city_from,
										 'city_to' => $city_to,
											'type' => 2	)); 
				
				//$QrySelect = $this->db->get(); 
				$priceData = $QrySelect->result_array();
				//var_dump($_POST);
					//exit;
				
				if(empty($priceData))
				{
					//$dataResult['error']='true';
					//$dataResult['error_msg']="Shipments rates are not available ";
				}else
				{
				    $weight_to = $priceData[0]['weight_to'];
					$extraW = ($weight-$weight_to); 
					$priceToHW = $priceData[0]['price'];
				
					$this->db->select('*');
					$query = $this->db->get_where('shipment_type', array('id' => 2));
					$shipmentTypeData =  $query->result_array();
					
					
					
					//$shipmentTypeData = $this->calculater_model->getShipmentType(2);
					
					
					
					
					$extraWInKG =ceil(($extraW/1000));
					/*Extra Price */
					
					$this->db->select('*');
					//$this->db->from('shipment_rates');
					$QrySelectExtra = $this->db->get_where('shipment_rates' , array ( 'city_from' => $city_from,
											 'city_to' => $city_to,
											 'title'=>'extra',
												'type' => 2	)); 
					//$QrySelectExtra = $this->db->get(); 
					$priceDataExt = $QrySelectExtra->result_array();
					
					
					if(empty($priceDataExt))
					{
						//$dataResult['error']='true';
						//$dataResult['error_msg']="Shipments rates are not available ";
					}else{
						$extraPrice = ($extraWInKG*$priceDataExt[0]['price']);
						$price = ceil(($extraPrice+ $priceToHW));
						//$dataUP['flyer_cost'] = $shipmentTypeData[0]['flyer_cost'];
						
						$dataUP['shipment_cost'] = $price; //+$dataUP['flyer_cost'];
						
						$dataResult['rate_id'] = $priceDataExt[0]['id'];//+$flyer;
						$dataResult['total_cost'] = $price;//+$flyer;
						$dataResult['total_cost'] = ceil($dataResult['total_cost']);
						$dataUP['rate_id'] = $priceDataExt[0]['id'];
						$dataUP['shipping'] = $dataResult['total_cost'];
						$dataUP['type'] = 2;
						
					}
				}
							
			}else{
				/*Advance Payment Weights Less */
				
				$this->db->select('*');
				$QrySelect = $this->db->get_where('shipment_rates', array('weight_from<' => $weight,
																  'weight_to>=' => $weight,
																  'city_from' => $city_from,
																  'city_to' => $city_to,
																  'type' => 2		
																			));
				$priceData = $QrySelect->result_array();
				
				//var_dump($priceData);
				//exit;
				if(empty($priceData))
					{
						//$dataResult['error']='true';
						//$dataResult['error_msg']="Shipments rates are not available ";
					}else{
						$price = $priceData[0]['price'];
						
						$this->db->select('*');
						$query = $this->db->get_where('shipment_type', array('id' => 2));
						$shipmentTypeData =  $query->result_array();
					
						
						//$shipmentTypeData = $this->calculater_model->getShipmentType(2);
						
						
						//$dataUP['flyer_cost'] = $shipmentTypeData[0]['flyer_cost'];
						$dataUP['shipment_cost'] = $price;//+$dataUP['flyer_cost'];
						$dataResult['rate_id'] = $priceData[0]['id'];
						$dataResult['total_cost'] = $price;//+$flyer;
						$dataResult['total_cost'] = ceil($dataResult['total_cost']);
						$dataUP['rate_id'] = $priceData[0]['id'];
						$dataUP['shipping'] = $dataResult['total_cost'];
						$dataUP['type'] = 2;
						
					}
				
        	}
		
		}
		 //$dataResult['total_cost'] = ceil($dataResult['total_cost']);
		//echo json_encode($dataResult);
	
				
			
			/*end*/
			
			//exit;
				
					//var_dump($dataUP);
				//exit;
				
				
				$this->dashboard_model->update_shipments($dataUP);
				//exit;
				
				if($this->input->post('shipment_status')!='Pending')
				{
						
					$userData	= $this->users_model->get_users($this->input->post('user_id'));
					
					//var_dump($userData);
					//exit;
					$to = $userData[0]['email'];
					$from= "info@lead2need.com";
					$subject= "Information About Change status of your Shipment";
					$text = "Congrats! Your Shipment is under processing <br/>";
					//echo "123";
					//var_dump($_POST);
					//exit;
					send_email_custom($to, $from, $subject, $text);
						
				}
				$this->session->set_flashdata('msg', 'Shipments Information is updated successfully!');
				redirect('cargodash');
			}
		}
		public function view($id = NULL)
        {
			if(! $this->session->userdata('validated')){
			redirect('auth');
		}
		if($this->session->userdata('user_role')=='AGENTS'){
				redirect('walkCustomer');
			}
			$data['page'] = 'dashboard';
            $data['shipments'] = $this->dashboard_model->get_shipments($id);
			$this->load->view('administrator/templates/header', $data);
			$this->load->view('administrator/templates/sidebar', $data);
			$this->load->view('administrator/dashboard/view', $data);
			$this->load->view('administrator/templates/footer', $data);
		}
	/*public function view($page = 'dashboard')
	{
			if ( ! file_exists(APPPATH.'/views/'.$page.'.php'))
			{
					// Whoops, we don't have a page for that!
					show_404();
			}
	
			$data['title'] = ucfirst($page); // Capitalize the first letter
	
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view($page, $data);
			$this->load->view('templates/footer', $data);
	}*/
	
	public function delete($id = NULL){
		if($this->session->userdata('user_role')=='AGENT'){
				redirect('walkCustomer');
			}
			if($this->session->userdata('user_role')=='ADMIN'){
				redirect('cargodash');
			}
			$user = $this->session->get_userdata();
			if($this->dashboard_model->delete_shipments($id)){
				$this->session->set_flashdata('msg', 'Shipment is deleted successfully!');
				redirect('cargodash');
			}
			
		}
}
