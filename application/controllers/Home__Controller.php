<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home__Controller extends CI_Controller {

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
		$this->form_validation->set_rules('UserName', 'Username', 'trim|required|valid_email');
		$this->form_validation->set_rules('PassWord', 'Password', 'trim|required|min_length[8]|max_length[36]');

		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('forms/Login');
		} else {
			
			if($data=$this->Emp__CURD->DB__Employee__WithId__Get($this->input->post('UserName'),base64_encode($this->input->post('PassWord')))){
				if(count($data) > 0) { 
					foreach($data as $row){
						$user_id=$row->DB_UserId ;
						$user_name=$row->DB_UserName;
						$user_email=$row->DB_UserEmailId;
						$user_mobile=$row->DB_UserMobileNo;
						$user_Role=$row->DB_UserRole;
						$user_Designation=$row->DB_Designation;
					}
					$newdata = array(
						"user_id"=>$user_id,
						"user_name"=>$user_name,
						"user_email"=>$user_email,
						"user_mobile"=>$user_mobile,
						"user_Role"=>$user_Role,
						"user_Designation"=>$user_Designation
						);
					$this->session->set_userdata($newdata);
					redirect(base_url('DashBoard'));
					}
			}else{
				$this->session->set_flashdata('error', 'Invalid credentials !');
				redirect(base_url());
			}
		
		}
	}
	Public function DashBoard(){
	if(!empty($this->session->userdata('user_id'))){
		$data['Payment_Due_List']=$this->Cust__CURD->DB__CustomerPaymentPendingDashboard__Get($this->session->userdata('user_id'));
		$data['AMC_Expired_List']=$this->Cust__CURD->DB__CustomerAMCExpiredDashboard__Get($this->session->userdata('user_id'));
		$data['Total_Live_Customer']=$this->Cust__CURD->DB__CustomerLiveDashboard__Get($this->session->userdata('user_id'));
		$data['Total_Demo_Customer']=$this->Cust__CURD->DB__CustomerDemoDashboard__Get($this->session->userdata('user_id'));
		$data['Total_Lead_Customer']=$this->Cust__CURD->DB__CustomerLeadDashboard__Get($this->session->userdata('user_id'));
		$data['Total_Payment_Pending_Customer']=$this->Cust__CURD->DB__CustomerPaymentPendingDashboardN__Get($this->session->userdata('user_id'));
		$data['Total_Payment_Recived_Customer']=$this->Cust__CURD->DB__CustomerPaymentRecivedDashboard__Get($this->session->userdata('user_id'));
		$data['Total_AMC_Expired_Customer']=$this->Cust__CURD->DB__CustomerAMCExpiredDashboardN__Get($this->session->userdata('user_id'));
		$data['Today_Demo_Customer']=$this->Cust__CURD->DB__CustomerTodayDemoDashboard__Get($this->session->userdata('user_id'));
		$data['Today_Lead_Customer']=$this->Cust__CURD->DB__CustomerTodayLeadDashboard__Get($this->session->userdata('user_id'));
		$data['Today_Live_Customer']=$this->Cust__CURD->DB__CustomerTodayLiveDashboard__Get($this->session->userdata('user_id'));
		$data['Today_Payment_Pending_Customer']=$this->Cust__CURD->DB__CustomerTodayPaymentPendingDashboard__Get($this->session->userdata('user_id'));
		$data['Today_Payment_Recived_Customer']=$this->Cust__CURD->DB__CustomerTodayPaymentRecivedDashboard__Get($this->session->userdata('user_id'));
		$data['Today_AMC_Expired_Customer']=$this->Cust__CURD->DB__CustomerTodayAMCExpiredDashboard__Get($this->session->userdata('user_id'));	

		
		$this->load->view('Header/__header');
		$this->load->view('index',$data);
		$this->load->view('Footer/__footer');
		}else{
		$this->session->set_flashdata('error', 'Your Access Denied...Please Login Once Again!');
		redirect(base_url());
	}		
	}
	public function LogOut(){
	    $this->session->sess_destroy();
        redirect(base_url(),'refresh');
	}

}
