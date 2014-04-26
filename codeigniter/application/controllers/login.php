<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		if($this->session->userdata('logged_in')){
			redirect('room','refresh');
		}
		else{
			//If no session, redirect to login page
			$data['message'] = "NOT_SET";
			$this->load->view('loginView',$data);
		}
	}
	
	public function verifyLogin(){
		$this->load->helper('form');
		
		$this->load->library('form_validation','url');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|callback_check_database');

		if ($this->form_validation->run() == FALSE)
		{
			$data['message'] = "LOGIN_FAILED";
			$this->load->view('loginView',$data);       //if validation fails load the loginForm
		}
		else                                       
		{                                         //if validation passes go to private area
			redirect('room','refresh');
		}	
	}
	
	public function check_database($raw_password){
		$email = htmlspecialchars($_POST['email']);
		$password = sha1(htmlspecialchars($raw_password));	
		
		$this->load->model('DBFunctions');
			
		$result=$this->DBFunctions->authenticate($email,$password); //the authenticate function is in model:DBFunctions
			
		if($result){
			$sess_array = array();
				
			foreach($result as $row){
				$sess_array = array('userID' => $row->userID,'username' => $row->username);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return true;
		}
		else{
			return false;
		}
	}
}
