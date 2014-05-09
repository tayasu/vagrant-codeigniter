<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function _remap($method, $args) {
		if (method_exists($this, $method)){
			// Call before action
			$this->before();
			return call_user_func_array(array($this, $method), $args);
		}
		show_404();        //if the user enters any other function which is not in this class
	}
	
	private function before() {
		if($this->session->userdata('logged_in')){
			redirect('room','refresh');
		}
	}

	public function index(){
		$data['message'] = NO_MESSAGE;
		$this->load->view('loginView',$data);
	}
	
	private function verifyLogin(){
		$this->form_validation->set_rules('username', 'Username', 'trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {     //if form validation fails, redirect to login page with message
			$data['message'] = LOGIN_FAILED;
			return $this->load->view('loginView',$data);	
		} else {      									 //if form validation passes, get data and check database 
			$email = htmlspecialchars($_POST['email']);
			$password = sha1(htmlspecialchars($_POST['password']));     
			$this->load->model('users');
			$singleRowResult=$this->users->authenticate($email,$password); //the authenticate function is in model:users
		}
			
		if ($singleRowResult) {                    //if user exists create session and redirect to room
			$sess_array = array();
			$sess_array = array('userid' => $singleRowResult['userid'],'username' => $singleRowResult['username']);
			$this->session->set_userdata('logged_in', $sess_array);
			redirect('room','refresh');
		} else {                         // if user does not exist, redirect to login page with message
			$data['message'] = LOGIN_FAILED;
			$this->load->view('loginView',$data);
		}
	}
}
