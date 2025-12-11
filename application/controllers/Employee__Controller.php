<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee__Controller extends CI_Controller {

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
			
			$this->form_validation->set_rules('EmployeeName', 'Employee Name.', 'trim|required');
			$this->form_validation->set_rules('UserPassword', 'Password', 'trim|required|max_length[36]|min_length[8]');
			$this->form_validation->set_rules('CUserPassword', 'Confirm Password', 'trim|required|max_length[36]|min_length[8]|matches[UserPassword]');
			$this->form_validation->set_rules('EmployeeEmailId', 'Email Id', 'trim|required|valid_email|is_unique[db_tbl__userdetails.DB_UserEmailId]');
			$this->form_validation->set_rules('EmployeeMobileNo', 'Mobile Number', 'trim|required|numeric|max_length[13]|min_length[10]');
			$this->form_validation->set_rules('EDesignation', 'Employee Designation', 'trim|required');
			$this->form_validation->set_rules('EmployeeRole', 'Employee Role', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('Header/__header');
				$this->load->view('Employee/index');
				$this->load->view('Footer/__footer');
			} else {
			
					$file_name = ""; // Initialize variable

					if (!empty($_FILES['EmployeeProfile']['name'])) {
						$upload_path = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'EmployeeProfile' . DIRECTORY_SEPARATOR;

						// ✅ Step 2: Configure the upload library
						$config['upload_path']   = $upload_path;
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['max_size']      = 5240; // 2MB
						
						// Sanitize the file name
						$safe_name = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['EmployeeProfile']['name']));
						$config['file_name']     = time() . '_' . $safe_name;

						// ✅ Step 3: Load and initialize the library
						$this->load->library('upload', $config);
						$this->upload->initialize($config); // Ensures the new config is used

						// ✅ Step 4: Perform the upload
						if (!$this->upload->do_upload('EmployeeProfile')) {
							// If it fails, show the error
							$error = $this->upload->display_errors();
							$this->session->set_flashdata('error', 'Upload Error: ' . strip_tags($error));
							redirect(base_url('EmployeeRegister'));
						} else {
							// Success!
							$upload_data = $this->upload->data();
							$file_name = $upload_data['file_name'];
						}

					} else {
						// No file was uploaded, use the default
						$file_name = "download.jpg";
					}

			//Setting values for tabel columns
			$AutoGenrated__Pass=base64_encode($this->input->post('UserPassword'));
			$data = array(
			'DB_UserName' => $this->input->post('EmployeeName'),
			'DB_User__Password' => $AutoGenrated__Pass,
			'DB_UserEmailId' => $this->input->post('EmployeeEmailId'),
			'DB_UserMobileNo' => $this->input->post('EmployeeMobileNo'),
			'DB_Designation' => $this->input->post('EDesignation'),
			'DB_UserRole' => $this->input->post('EmployeeRole'),
			'DB_UserProfile' => $file_name,
			'DB_User__ID' => $this->session->userdata('user_id'),
			'DB_User__LastUpdateId' =>$this->session->userdata('user_id'),
			'DB_User__CurrentDate' => date('Y-m-d H:i:s'),
			'DB_User__LastUpdateDate' => date('Y-m-d H:i:s'),
			'DB_UserStatus' => '1'
			);
			//Transfering data to Model
			if($id=$this->Emp__CURD->DB__Employee__Add($data)){
				
				$this->session->set_flashdata('success', 'Employee Add Successfully');
			}else{
				$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
			}
			
			//Loading View
			
			redirect(base_url('EmployeeRegister'));
			}
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
			 
	}
	public function Employee__Table()
	{
		if(!empty($this->session->userdata('user_id'))){
			$this->load->view('Header/__header');
			$this->load->view('Employee/Table');
			$this->load->view('Footer/__footer');
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
		
			 
	}
	public function Employee__Table__GetData(){//user_Role
		if(!empty($this->session->userdata('user_id'))){
			$data=array();
			$result = $this->Emp__CURD->DB__Employee__Get();
				if(count($result) > 0){
				$i = 0;
					foreach($result as $row ){
					
						$data[$i]['DB_UserName'] ="<a href='".base_url('EmployeeU/'.$row->DB_UserId)."'>".$row->DB_UserName." &nbsp;<i class='fa fa-edit'></i></a>";
						if($this->session->userdata('user_Role') == 'SuperAdmin'){
							$data[$i]['DB_User__Password'] =base64_decode($row->DB_User__Password);
						}
						$data[$i]['DB_UserEmailId'] =$row->DB_UserEmailId;
						$data[$i]['DB_UserMobileNo'] =$row->DB_UserMobileNo;
						$data[$i]['DB_Designation'] =$row->DB_Designation;
						$data[$i]['DB_UserRole'] =$row->DB_UserRole;
						$profile_image = !empty($row->DB_UserProfile)?$row->DB_UserProfile : 'download.jpg';
						$data[$i]['DB_UserProfile'] = '<img src="' . base_url('assets/EmployeeProfile/' . $profile_image) . '" alt="Profile" width="50" height="50">';
						$data[$i]['DB_User__ID'] =$row->DB_User__ID;
						$data[$i]['DB_User__LastUpdateId'] =$row->DB_User__LastUpdateId;
						$data[$i]['DB_User__CurrentDate'] =date('d-m-Y h:i:s a', strtotime($row->DB_User__CurrentDate));
						$data[$i]['DB_User__LastUpdateDate'] =date('d-m-Y h:i:s a', strtotime($row->DB_User__LastUpdateDate));
						// Status column with link and symbol
						if ($row->DB_UserStatus == 1) {
							$data[$i]['DB_UserStatus'] = "<a href='javascript:void(0);' class='btn btn-sm btn-danger' onclick=\"changeEmployeeStatus('0', '{$row->DB_UserId}', 'Deactivate')\">Deactivate</a>";
						} else {
							$data[$i]['DB_UserStatus'] = "<a href='javascript:void(0);' class='btn btn-sm btn-success' onclick=\"changeEmployeeStatus('1', '{$row->DB_UserId}', 'Activate')\">Activate</a>";
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

			}else{
				$results = array(
				"sEcho" => 1,
				"iTotalRecords" => '0',
				"iTotalDisplayRecords" => '0',
				"aaData"=>'');
				/* Output header */
				echo json_encode($results,JSON_UNESCAPED_UNICODE);
		}

	}
	public function Employee__Update()
	{	
		if(!empty($this->session->userdata('user_id'))){
			$this->form_validation->set_rules('EmployeeName', 'Employee Name.', 'trim|required');
			$this->form_validation->set_rules('EmployeeEmailId', 'Email Id', 'trim|required|valid_email');
			$this->form_validation->set_rules('EmployeeMobileNo', 'Mobile Number', 'trim|required|numeric|max_length[13]|min_length[10]');
			$this->form_validation->set_rules('EDesignation', 'Employee Designation', 'trim|required');
			$this->form_validation->set_rules('EmployeeRole', 'Employee Role', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) {
				$data=array();
				$data['Employeedata']=$this->Emp__CURD->DB__Employee__Get__WithId($this->uri->segment(2));
				$this->load->view('Header/__header');
				$this->load->view('Employee/Update',$data);
				$this->load->view('Footer/__footer');
			} else {
				//Prev_EmployeeProfile
				
					$file_name = "";
					
				if (!empty($_FILES['EmployeeProfile']['name'])) {
					// ✅ FIXED PATH HANDLING
					$upload_path = rtrim(FCPATH, '/\\') . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'EmployeeProfile' . DIRECTORY_SEPARATOR;

					$config['upload_path']   = $upload_path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']      = 5240;

					$safe_name = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($_FILES['EmployeeProfile']['name']));
					$config['file_name']     = time() . '_' . $safe_name;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('EmployeeProfile')) {
						$error = $this->upload->display_errors();
						$this->session->set_flashdata('error', 'Upload Error: ' . strip_tags($error));
						redirect(base_url('EmployeeRegister'));
					} else {
						$upload_data = $this->upload->data();
						$file_name = $upload_data['file_name'];

						$prev_file = $this->input->post('Prev_EmployeeProfile');
						$old_path = $upload_path . $prev_file;

						if (!empty($prev_file) && file_exists($old_path)) {
							if($prev_file != 'download.jpg'){
								unlink($old_path);
							}
							
						} 
					}
				} else {
					$file_name = $this->input->post('Prev_EmployeeProfile');
				}
				
				$data = array(
				'DB_UserName' => $this->input->post('EmployeeName'),
				'DB_UserEmailId' => $this->input->post('EmployeeEmailId'),
				'DB_UserMobileNo' => $this->input->post('EmployeeMobileNo'),
				'DB_Designation' => $this->input->post('EDesignation'),
				'DB_UserRole' => $this->input->post('EmployeeRole'),
				'DB_UserProfile' => $file_name,
				'DB_User__LastUpdateId' =>$this->session->userdata('user_id'),
				'DB_User__LastUpdateDate' => date('Y-m-d H:i:s')
				);
				//Transfering data to Model
				if($id=$this->Emp__CURD->DB__Employee__Update($this->uri->segment(2),$data)){
					
					$this->session->set_flashdata('success', 'Employee Update Successfully');
				}else{
					$this->session->set_flashdata('error', 'Something Wrong...Please Try Again!');
				}
				
				//Loading View
				
				redirect(base_url('EmployeeU/'.$this->uri->segment(2)));
			}
		}else{
			$this->session->set_flashdata('error', 'Your Access Denied...Please Contact Administator!');
			redirect(base_url());
		}
		
			 
	}
	public function Change__Employee__Status(){
		
		if(!empty($this->session->userdata('user_id'))){
			
				$userId = $this->input->post('userId');
				$status = $this->input->post('status'); 

				if (!$userId || !in_array($status, ['0', '1'])) {
					echo json_encode(['success' => false, 'message' => 'Invalid input']);
					return;
				}

				// Update logic (example)
				$data = array(
				'DB_UserStatus' => $status,
				'DB_User__LastUpdateId' =>$this->session->userdata('user_id'),
				'DB_User__LastUpdateDate' => date('Y-m-d H:i:s')
				);

				if ($this->Emp__CURD->DB__Employee__Update($userId,$data)) {
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
}
