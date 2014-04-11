<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {
	
	public function index()
	{
		$this->load->helper('form');
		
		$this->load->library('form_validation','url');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|callback_check_database');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('loginForm');       //if validation fails load the loginForm
		}
		else                                       
		{                                         //if validation passes go to private area
			redirect('room','refresh');
		}	
	}
	
	public function check_database($password){
		$username=htmlspecialchars($_POST['username']);
				
		$this->load->model('DBFunctions');
			
		$result=$this->DBFunctions->authenticate($username,$password);
			
		if($result){
			$sess_array = array();
				
			foreach($result as $row){
				$sess_array = array('userID' => $row->userID,'username' => $row->username);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return true;
		}
		else{
			$this->form_validation->set_message('check_database', 'Invalid username or password!!');
			return false;
		}
	}
	
}
?>