<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer__Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	 public function __construct(){
                parent::__construct();
                // Your own constructor code
        }

	public function index()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->form_validation->set_rules('FirmName', 'Firm Name.', 'trim|required');
			$this->form_validation->set_rules('CustomerName', 'Customer Name', 'trim|required');
			$this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'trim|required|numeric|max_length[12]|min_length[10]');
			$this->form_validation->set_rules('Address', 'Address.', 'trim|required');			
			$this->form_validation->set_rules('city', 'city.', 'trim|required');
			$this->form_validation->set_rules('State', 'State.', 'trim|required');
			
			$this->form_validation->set_rules('serialnumber', 'Serial Number', 'trim|required|is_unique[db_tbl__customerdetails.DB_Cust__SerialKey]');
			
			$this->form_validation->set_rules('partnerno', 'Partner Name', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['partner']=$this->Emp__CURD->DB_GetAllPartners();
				$this->load->view('Header/__header');
				$this->load->view('forms/CustomerRegister',$data);
				$this->load->view('Footer/__footer');
			} else {
			//Setting values for tabel columns
				$data = array(
				'DB_Cust__Name' => $this->input->post('CustomerName'),
				'DB_Cust__MobileNo' => $this->input->post('mobilenumber'),
				'DB_Cust__State' => $this->input->post('State'),
				'DB_Cust__Address' => $this->input->post('Address'),
				'DB_Cust__city' =>$this->input->post('city'),
				'DB_Cust__SerialKey' => $this->input->post('serialnumber'),
				'DB_Cust__FirmName' => $this->input->post('FirmName'),
				'DB_Cust__ParntnerNo' => $this->input->post('partnerno'),
				'DB_Cust__SathiPaymentStatus' => 'P',
				'DB_Cust__SathiCurrentStatus' => 'Lead',
				'DB_Cust__UserId' => $this->session->userdata('user_id'),
				'DB_Cust__LastUpdateUserId' =>$this->session->userdata('user_id'),
				'DB_Cust__InstalltionDate' => date('Y-m-d H:i:s'),
				'DB_Cust__LeadDate' => date('Y-m-d H:i:s'),
				'DB_User__DemoDate' => '',
				'DB_User__LetusActivationDate' => '',
				'DB_Cust__NextAMCDate' => '',
				'DB_Cust__LastUpdateDate' => date('Y-m-d H:i:s'),
				'DB_Cust__AMCExpired' => '0',
				'DB_Cust__Status' => '1'
				);
				//Transfering data to Model
				if($id=$this->Cust__CURD->DB__Customer__Add($data)){
					
					$this->session->set_flashdata('success', 'Customer Register Successfully');
				}else{
					$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
				}
			
			//Loading View
			
			redirect(base_url('Customer'));
			}
	}else{
		$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
		redirect(base_url());
	}
			 
	}
	//Lead Customer List View
	public function CustomerLead__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerLead');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	//Lead Customer List
	public function CustomerLead__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerLead__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] = $row->DB_Cust__FirmName;
						$data[$i]['DB_Cust__Name'] ="<a href='".base_url('CustomerU/'.$row->DB_Cust__Id)."'>".$row->DB_Cust__Name." &nbsp;<i class='fa fa-edit'></i></a>";
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;						
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
						$data[$i]['DB_Cust__LeadDate'] =(!empty($row->DB_Cust__LeadDate))?(date('d-m-Y h:i:s a', strtotime($row->DB_Cust__LeadDate))):('NA');
						if (!empty($row->DB_Cust__LeadDate)) {
						$leadDate = new DateTime($row->DB_Cust__LeadDate);
						$currentDate = new DateTime(); // today's date
						$interval = $leadDate->diff($currentDate);
						$data[$i]['DB_lead_Days'] = $interval->days; // number of days difference
						} else {
							$data[$i]['DB_lead_Days'] = 'NA';
						}
											
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}

//Customer Demo Activation
public function Customer__Demo__Activation()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->form_validation->set_rules('CustomerID', 'Customer', 'required|trim');
				//$this->form_validation->set_rules('VoucherType[]', 'Voucher Type', 'callback_validate_voucher_type');
				$this->form_validation->set_rules('ApiKey', 'API Key', 'required|trim');
			
			if ($this->form_validation->run() == FALSE) {
			$data['customerdata']=$this->Cust__CURD->DB__CustomerDemoActivation__Get();
			$this->load->view('Header/__header');
			$this->load->view('forms/CustomerDemoActivation',$data);
			$this->load->view('Footer/__footer');
			} else {
				// Prepare data for insertion
				$data = array(
					'DB_Cust__Id' => $this->input->post('CustomerID'),
					'DB_VoucherType' => implode(',', $this->input->post('VoucherType')),
					'DB_ApiKey' => $this->input->post('ApiKey'),
					'DB_Api_Current__Date' => date('Y-m-d H:i:s'),
					'DB_Api__SaleKey' => $this->input->post('SaleApiKey'),
					'DB_Api__PurchaseKey' => $this->input->post('PurchaseApiKey'),
					'DB_User__CreditNoteKey' => $this->input->post('CreditNoteApiKey'),
					'DB_Api__DebitNoteKey' => $this->input->post('DebitNoteApiKey'),
					'DB_Api__PaymentKey' => $this->input->post('PaymentApiKey'),	
					'DB_Api__ReciptKey' => $this->input->post('ReceiptApiKey'),
					'DB_InsertId' => $this->session->userdata('user_id'),
					'DB_Api__LastUpdateId' => $this->session->userdata('user_id'),
					'DB_User__LastUpdateDate' => date('Y-m-d H:i:s'),
					'DB_ApiKey__Status' => 1

				);
				
				$userId = $this->input->post('CustomerID');
				$data_to_Update = array(
					'DB_Cust__SathiCurrentStatus' => 'Demo',
					'DB_Cust__AMCExpired' => 1,
					'DB_Cust__LastUpdateUserId' => $this->session->userdata('user_id'),
					'DB_Cust__LastUpdateDate' => date('Y-m-d H:i:s'),
					'DB_User__DemoDate' => date('Y-m-d H:i:s'),
					'DB_Cust__NextAMCDate' => date('Y-m-d H:i:s', strtotime('+10 days'))
				);
				// Insert data into the database
				if ($this->Cust__CURD->DB__CustomerActivation__Add($data) && $this->Cust__CURD->DB__Customer__Update($userId, $data_to_Update)) {
					$this->session->set_flashdata('success', 'Customer Demo Activation  Successfully');
				} else {
					$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
				}
				redirect(base_url('Customer-Demo'));
			}
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}

//Customer Profile API
public function Customer__Profile()
	{
		
		if(!empty($this->session->userdata('user_id'))){
			
				$customer_id=trim($this->input->post('id', TRUE)); 

				if (!$customer_id) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}
	
			if ($data=$this->Cust__CURD->DB__Customer__Get__WithId($customer_id)) {
					echo json_encode([
						'success' => true,
						'data' => $data,
						'message' => 'Customer Information Get successfully.'
					]);
				} else {
					echo json_encode([
						'success' => false,
						'data' => $data,
						'message' => 'Failed to Customer Information Get.'
					]);
				}
			}else{
				echo json_encode([
							'success' => false,
							'data' => $data,
							'message' => 'Your Access Denied...Please Contact Administator!.'
						]);
				
			}
			 
	}
	//Customer Activation API Profile
	public function Customer__Profile__Activation()
	{
		
		if(!empty($this->session->userdata('user_id'))){
			
				$customer_id=trim($this->input->post('id', TRUE)); 

				if (!$customer_id) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}
	
			if ($data=$this->Cust__CURD->DB__ActivationCustomer__Get__WithId($customer_id)) {
					echo json_encode([
						'success' => true,
						'data' => $data,
						'message' => 'Customer Information Get successfully.'
					]);
				} else {
					echo json_encode([
						'success' => false,
						'data' => $data,
						'message' => 'Failed to Customer Information Get.'
					]);
				}
			}else{
				echo json_encode([
							'success' => false,
							'data' => $data,
							'message' => 'Your Access Denied...Please Contact Administator!.'
						]);
				
			}
			 
	}

	
	//Demo Customer List view
	public function CustomerDemo__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerDemoAct');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	//Demo Customer List 
	public function CustomerDemo__Table__GetData(){
		
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerDemo__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
			
            $data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModalWithKeys('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
			$data[$i]['DB_Cust__Name'] =$row->DB_Cust__Name;
            $data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
            $data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
			$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
            $data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
            $data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
			
			$data[$i]['DB_ApiKey'] ="<a href='".base_url('CustomerActivationU/'.$row->DB_Cust__Id)."'>".$row->DB_ApiKey." &nbsp;<i class='fa fa-edit'></i></a>";
			$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
            $data[$i]['DB_User__DemoDate'] =(!empty($row->DB_User__DemoDate))?(date('d-m-Y h:i:s a', strtotime($row->DB_User__DemoDate))):('NA');
			
			if (!empty($row->DB_Cust__LeadDate)) {
			$leadDate = new DateTime($row->DB_Cust__LeadDate);
			$currentDate = new DateTime(); // today's date
			$interval = $leadDate->diff($currentDate);
			$data[$i]['DB_lead_Days'] = $interval->days; // number of days difference
			} else {
				$data[$i]['DB_lead_Days'] = 'NA';
			}		
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}

	public function Customer__Demo__Extended()
	{
		if(!empty($this->session->userdata('user_id'))){
			
				$customer_id=trim($this->input->post('DB_Cust__Id', TRUE)); 
				$api_key_id=trim($this->input->post('DB_ApiKeyId', TRUE)); 

				if (!$customer_id || !$api_key_id) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}
				$data_to_Update = array(					
					'DB_Cust__LastUpdateUserId' => $this->session->userdata('user_id'),
					'DB_Cust__LastUpdateDate' => date('Y-m-d H:i:s'),
					'DB_Cust__NextAMCDate' => date('Y-m-d H:i:s', strtotime('+10 days')),
					'DB_Cust__AMCExpired' => '1'
				);
				$data = array(
				'DB_ApiKeyId' => $api_key_id,
				'DB_Cust__Id' => $customer_id,
				'DB_DemoEx__CurrentDate' => date('Y-m-d H:i:s'),
				'DB_DemoEx__UserId' => $this->session->userdata('user_id'),
				'DB_DemoEx__Status' => 1
			);
			if ($this->Cust__CURD->DB__Customer__Update($customer_id, $data_to_Update) && $this->Cust__CURD->DB__CustomerDemoExtended__Add($data)) {
					echo json_encode([
						'success' => true,
						'message' => 'Customer Demo Extended successfully.'
					]);
				} else {
					echo json_encode([
						'success' => false,
						'message' => 'Failed to Customer Demo Extend.'
					]);
				}
			}else{
				echo json_encode([
							'success' => false,
							'message' => 'Your Access Denied...Please Contact Administator!.'
						]);
				
			}
			 
	}








	public function Customer__SerialKey__Check(){
		$serialkey=trim($this->input->post('DB_Cust__SerialKey', TRUE));
		$result = $this->Cust__CURD->DB__Customer__SerialKey__Check($serialkey);
		$data=array();
		if(count($result) > 0){
			$data['response'] = 'true'; //If username exists set true
		}else{
			$data['response'] = 'false'; //Set false if user not valid
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE);

	}
	public function Customer__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerTables');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	public function Customer__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__Customer__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] = "<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] ="<a href='".base_url('CustomerU/'.$row->DB_Cust__Id)."'>".$row->DB_Cust__Name." &nbsp;<i class='fa fa-edit'></i></a>";
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
												
						$data[$i]['DB_Cust__SathiPaymentStatus'] =($row->DB_Cust__SathiPaymentStatus == 'R')?('Received'):('Pending');
						$data[$i]['DB_Cust__SathiCurrentStatus'] =$row->DB_Cust__SathiCurrentStatus;
						$data[$i]['DB_Cust__InstalltionDate'] =date('d-m-Y h:i:s a', strtotime($row->DB_Cust__InstalltionDate));
						$data[$i]['DB_Cust__NextAMCDate'] =date('d-m-Y h:i:s a', strtotime($row->DB_Cust__NextAMCDate));
						$data[$i]['DB_Cust__AMCExpired'] =($row->DB_Cust__AMCExpired == 1)?('No'):('Yes');
						$data[$i]['DB_Cust__UserId'] =$this->Emp__CURD->getUserNameById($row->DB_Cust__UserId);
						$data[$i]['DB_Cust__LastUpdateUserId'] =$this->Emp__CURD->getUserNameById($row->DB_Cust__LastUpdateUserId);
						$data[$i]['DB_Cust__LastUpdateDate'] =date('d-m-Y h:i:s a', strtotime($row->DB_Cust__LastUpdateDate));
						
						// Status column with link and symbol
						if ($row->DB_Cust__Status == 1) {
							$data[$i]['DB_Cust__Status'] = "<a href='javascript:void(0);' class='btn btn-sm btn-danger' onclick=\"changeCustomerStatus('0', '{$row->DB_Cust__Id  }', 'Deactivate')\">Deactivate</a>";
						} else {
							$data[$i]['DB_Cust__Status'] = "<a href='javascript:void(0);' class='btn btn-sm btn-success' onclick=\"changeCustomerStatus('1', '{$row->DB_Cust__Id }', 'Activate')\">Activate</a>";
						}
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}
	public function Customer__Details__API(){
		if(!empty($this->session->userdata('user_id'))){
			
				$customer_id=trim($this->uri->segment(2)); 

				if (!$customer_id) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}
	
			if ($data=$this->Cust__CURD->DB__ActivationCustomer__Get__WithId($customer_id)) {
					echo json_encode([
						'success' => true,
						'data' => $data,
						'message' => 'Customer Information Get successfully.'
					]);
				} else {
					echo json_encode([
						'success' => false,
						'data' => $data,
						'message' => 'Failed to Customer Information Get.'
					]);
				}
			}else{
				echo json_encode([
							'success' => false,
							'data' => $data,
							'message' => 'Your Access Denied...Please Contact Administator!.'
						]);
				
			}
			 
	}
	public function Change__Customer__Status(){
		if(!empty($this->session->userdata('user_id'))){
			
				$userId = $this->input->post('userId');
				$status = $this->input->post('status'); 

				if (!$userId || !in_array($status, ['0', '1'])) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}
			$data = array(
				'DB_Cust__Status' => $status,
				'DB_Cust__LastUpdateUserId' => $this->session->userdata('user_id'),
				'DB_Cust__LastUpdateDate' => date('Y-m-d H:i:s')
			);
		
		
			if ($this->Cust__CURD->DB__Customer__Update($userId, $data)) {
					echo json_encode([
						'success' => true,
						'message' => 'Employee status updated successfully.'
					]);
				} else {
					echo json_encode([
						'success' => false,
						'message' => 'Failed to update employee status.'
					]);
				}
			}else{
				echo json_encode([
							'success' => false,
							'message' => 'Your Access Denied...Please Contact Administator!.'
						]);
				
			}
	}
	public function Customer__Update(){
		if(!empty($this->session->userdata('user_id'))){
			$this->form_validation->set_rules('FirmName', 'Firm Name.', 'trim|required');
			$this->form_validation->set_rules('CustomerName', 'Customer Name', 'trim|required');
			$this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'trim|required|numeric|max_length[12]|min_length[10]');
			$this->form_validation->set_rules('city', 'city', 'trim|required');
			$this->form_validation->set_rules('State', 'State.', 'trim|required');
			$this->form_validation->set_rules('Address', 'Address.', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data=array();
				$data['customerdata']=$this->Cust__CURD->DB__Customer__Get__WithId($this->uri->segment(2));
				$this->load->view('Header/__header');
				$this->load->view('forms/CustomerUpdate',$data);
				$this->load->view('Footer/__footer');
			} else {
			//Setting values for tabel columns
				$data = array(
				'DB_Cust__Name' => $this->input->post('CustomerName'),
				'DB_Cust__MobileNo' => $this->input->post('mobilenumber'),
				'DB_Cust__State' => $this->input->post('State'),
				'DB_Cust__Address' => $this->input->post('Address'),
				'DB_Cust__FirmName' => $this->input->post('FirmName'),
				'DB_Cust__city' => $this->input->post('city'),
				'DB_Cust__LastUpdateUserId' =>$this->session->userdata('user_id'),
				'DB_Cust__LastUpdateDate' => date('Y-m-d H:i:s')
				);
				//Transfering data to Model
				if($id=$this->Cust__CURD->DB__Customer__Update($this->uri->segment(2),$data)){
					
					$this->session->set_flashdata('success', 'Customer Update Successfully');
				}else{
					$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
				}
			
			//Loading View
			
			redirect(base_url('CustomerU/'.$this->uri->segment(2)));
			}
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
		
	}
	//AMC Expired
	public function AMCExpired__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/AMCExpired');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	public function AMCExpiredCustomer__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerAMCExpired__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] =$row->DB_Cust__Name;
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
												
						$data[$i]['DB_Cust__NextAMCDate'] ="<Span style='color:red;'>".date('d-m-Y h:i:s a', strtotime($row->DB_Cust__NextAMCDate))."</span>";
						$data[$i]['DB_Cust__AMCExpired'] =($row->DB_Cust__AMCExpired == 1)?('No'):('Yes');
						// Days to expire AMC
						$next_amc_date = strtotime($row->DB_Cust__NextAMCDate);
						$today = strtotime(date('Y-m-d'));
						$diff_days = ceil(($next_amc_date - $today) / 86400);

						$data[$i]['DB_HowMuchDays'] = $diff_days; 
					
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}
	//Live Customer List
	public function CustomerLive__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerLive');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	public function CustomerLive__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerLive__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] =$row->DB_Cust__Name;
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
						$data[$i]['DB_Cust__Status'] =($row->DB_Cust__Status == 1)?('<Span style="color:green;">Active</span>'):('<Span style="color:red;">Deactive</span>');
					
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}
	//Lead Customer List
	//AMC Expired
	
	//Payment recived Customer List
	public function CustomerPaymentRecived__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerPaymentRecived');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	public function CustomerPaymentRecived__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerPaymentRecived__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] =$row->DB_Cust__Name;
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
						$data[$i]['DB_User__LetusActivationDate'] =$row->DB_User__LetusActivationDate;

					
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}
	//Payment Pending
	//AMC Expired
	public function CustomerPaymentPending__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerPaymentPending');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	public function CustomerPaymentPending__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerPaymentPending__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] =$row->DB_Cust__Name;
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);				
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}





	public function FirmName__Get__Autocomplete(){
		$result = $this->Cust__CURD->DB__Customer__Autocomplete__Get(trim($this->input->get('term', TRUE)));
		$data=array();
		if(count($result) > 0){
			$data['response'] = 'true'; //If username exists set true
        	$data['message'] = array();
			$i = 0;
				foreach($result as $row ){
					$data['message'] []= array(
						'label' => $row->Firm__Name,
						'value' => $row->Firm__Name
					);	
					$i++;
				}
				
			}else{
            $data['response'] = 'false'; //Set false if user not valid
        }
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
	}
	
	
	public function validate_voucher_type($voucherType)
		{
			// Now, this check will correctly catch the manually set empty array []
			if (empty($voucherType) || (is_array($voucherType) && count($voucherType) === 0)) {
				$this->form_validation->set_message('validate_voucher_type', 'The {field} field is required.');
				return FALSE;
			}
			return TRUE;
		}

	//Customer Activation Status
	public function Customer__Activation(){
		if(!empty($this->session->userdata('user_id'))){
			
			$this->form_validation->set_rules('CustomerIDAct', 'Customer', 'required|trim');
			$this->form_validation->set_rules('paymentMode', 'Payment Mode', 'required|trim');
			$this->form_validation->set_rules('PaymentProof', 'Payment Received', 'required|trim');
			
			if ($this->form_validation->run() == FALSE) {
				$data['customerdata']=$this->Cust__CURD->DB__CustomerActivation__Get();
				$this->load->view('Header/__header');
				$this->load->view('forms/CustomerActivation',$data);
				$this->load->view('Footer/__footer');
			} else {
				//Setting values for tabel columns

				$userId = $this->input->post('CustomerIDAct');
				$data=array(
					'DB_Cust__Id' => $this->input->post('CustomerIDAct'),
					'DB_Cust__PaymentMode' => $this->input->post('paymentMode'),
					'DB_Cust__PaymentProof' => $this->input->post('PaymentProof'),
					'DB_Cust__PaymentDate' => date('Y-m-d H:i:s'),
					'DB_Payment__Status' => 1,
					'DB_Cust__UserId' => $this->session->userdata('user_id')
				);
				$data_to_Update = array(
					'DB_Cust__SathiCurrentStatus' => 'Live',
					'DB_Cust__SathiPaymentStatus' => 'R',
					'DB_Cust__LastUpdateUserId' => $this->session->userdata('user_id'),
					'DB_User__LetusActivationDate' => date('Y-m-d H:i:s'),
					'DB_Cust__LastUpdateDate' => date('Y-m-d H:i:s'),
					'DB_Cust__NextAMCDate' => date('Y-m-d H:i:s', strtotime('+1 year')),
					'DB_Cust__AMCExpired' => '1'
				);
				// Insert data into the database
				if ( $this->Cust__CURD->DB__Customer__Update($userId, $data_to_Update) && $this->Cust__CURD->DB__Customer__PaymentDetails__Add($data)) {
					$this->session->set_flashdata('success', 'Customer Activation Added Successfully');
				} else {
					$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
				}
				redirect(base_url('Customer-Activation'));
			}
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
	}

	//AMC Expired after days
	public function Customer__AfterDays__AMCExpired()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/AfterAMCExpired');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
	}
	public function AMCExpiredthirtydaysCustomer__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__CustomerAMCExpiredbeforethirtydays__Get(30);
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] =$row->DB_Cust__Name;
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);						
						$data[$i]['DB_Cust__NextAMCDate'] ="<Span style='color:red;'>".date('d-m-Y h:i:s a', strtotime($row->DB_Cust__NextAMCDate))."</span>";
						$data[$i]['DB_Cust__AMCExpired'] =($row->DB_Cust__AMCExpired == 1)?('No'):('Yes');					
					
							
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	}
	public function Customer__Activation__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('tables/CustomerActivationTable');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	//Customer Activation Status
	public function ActivationsCustomer__Table__GetData(){
		$data=array();
		$result = $this->Cust__CURD->DB__ActivationsCustomer__Get();
			if(count($result) > 0){
			$i = 0;
				foreach($result as $row ){				
					
						
						$data[$i]['DB_Cust__FirmName'] ="<a href='javascript:void(0);' onclick=\"openCustomerModal('{$row->DB_Cust__Id}')\">{$row->DB_Cust__FirmName} <i class='fa fa-info'></i></a>";
						$data[$i]['DB_Cust__Name'] ="<a href='".base_url('CustomerU/'.$row->DB_Cust__Id)."'>".$row->DB_Cust__Name." &nbsp;<i class='fa fa-edit'></i></a>";
						$data[$i]['DB_Cust__Address'] =$row->DB_Cust__Address;
						$data[$i]['DB_Cust__MobileNo'] =$row->DB_Cust__MobileNo;
						$data[$i]['DB_Cust__city']=$row->DB_Cust__city;
						$data[$i]['DB_Cust__State'] =$row->DB_Cust__State;
						$data[$i]['DB_Cust__SerialKey'] =$row->DB_Cust__SerialKey;
						$data[$i]['DB_ApiKey'] ="<a href='".base_url('CustomerActivationU/'.$row->DB_Cust__Id)."'>".$row->DB_ApiKey." &nbsp;<i class='fa fa-edit'></i></a>";
						$data[$i]['DB_Cust__ParntnerNo'] = $this->Emp__CURD->getUserNameById($row->DB_Cust__ParntnerNo);
						$data[$i]['DB_Cust__LeadDate'] =(!empty($row->DB_Cust__LeadDate))?(date('d-m-Y h:i:s a', strtotime($row->DB_Cust__LeadDate))):('NA');
						$data[$i]['DB_User__DemoDate'] =(!empty($row->DB_User__DemoDate))?(date('d-m-Y h:i:s a', strtotime($row->DB_User__DemoDate))):('NA');
						$data[$i]['DB_User__LetusActivationDate'] =(!empty($row->DB_User__LetusActivationDate))?(date('d-m-Y h:i:s a', strtotime($row->DB_User__LetusActivationDate))):('NA');
						
						
						if (!empty($row->DB_Cust__LeadDate)) {
						$leadDate = new DateTime($row->DB_Cust__LeadDate);
						$currentDate = new DateTime(); // today's date
						$interval = $leadDate->diff($currentDate);
						$data[$i]['DB_lead_Days'] = $interval->days; // number of days difference
						} else {
							$data[$i]['DB_lead_Days'] = 'NA';
						}	
						
					$i++;
				}
				
			}
			

			$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
			/* Output header */
			echo json_encode($results,JSON_UNESCAPED_UNICODE);

	} 
	public function Change__ActiveCustomer__Status(){
		if(!empty($this->session->userdata('user_id'))){
			
				$userId = $this->input->post('userId');
				$status = $this->input->post('status'); 

				if (!$userId || !in_array($status, ['0', '1'])) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}
			$data = array(
				'DB_ApiKey__Status' => $status,
				'DB_Api__LastUpdateId' => $this->session->userdata('user_id'),
				'DB_User__LastUpdateDate' => date('Y-m-d H:i:s')
			);
		
		
			if ($this->Cust__CURD->DB__CustomerActivation__Update($userId, $data)) {
					echo json_encode([
						'success' => true,
						'message' => 'Employee status updated successfully.'
					]);
				} else {
					echo json_encode([
						'success' => false,
						'message' => 'Failed to update employee status.'
					]);
				}
			}else{
				echo json_encode([
							'success' => false,
							'message' => 'Your Access Denied...Please Contact Administator!.'
						]);
				
			}
	}
	public function Customer__Activation__Update(){
		if(!empty($this->session->userdata('user_id'))){
			$this->form_validation->set_rules('ApiKey', 'API Key', 'required|trim');
			
			if ($this->form_validation->run() == FALSE) {
			$data['customerdata']=$this->Cust__CURD->DB__ActivationsCustomerWithId__Get($this->uri->segment(2));
			$this->load->view('Header/__header');
			$this->load->view('forms/CustomerActivationUpdates',$data);
			$this->load->view('Footer/__footer');
			} else {
				// Prepare data for insertion
				$data = array(
					'DB_VoucherType' => implode(',', $this->input->post('VoucherType')),
					'DB_ApiKey' => $this->input->post('ApiKey'),
					'DB_Api__SaleKey' => $this->input->post('SaleApiKey'),
					'DB_Api__PurchaseKey' => $this->input->post('PurchaseApiKey'),
					'DB_User__CreditNoteKey' => $this->input->post('CreditNoteApiKey'),
					'DB_Api__DebitNoteKey' => $this->input->post('DebitNoteApiKey'),
					'DB_Api__PaymentKey' => $this->input->post('PaymentApiKey'),	
					'DB_Api__ReciptKey' => $this->input->post('ReceiptApiKey'),
					'DB_Api__LastUpdateId' => $this->session->userdata('user_id'),
					'DB_User__LastUpdateDate' => date('Y-m-d H:i:s'),
				);		
				if ($this->Cust__CURD->DB__CustomerActivation__Update($this->uri->segment(2), $data)) {
					$this->session->set_flashdata('success', 'Customer Keys Updated Successfully');
				} else {
					$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
				}
				redirect(base_url('CustomerActivationU/'.$this->uri->segment(2)));
			}
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
	}
}
