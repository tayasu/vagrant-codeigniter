<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	public function _remap($method, $args) {
		if (method_exists($this, $method)){
			// Call before action
			$this->before();
			return call_user_func_array(array($this, $method), $args);
		}
		show_404();
	}
	
	private function before() {
		if($this->session->userdata('logged_in')){
			redirect('room','refresh');
		}
	}
	
	public function index(){
		$this->load->view('registerView');	
	}
	
	private function verifyRegister(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
		$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'trim|xss_clean|matches[password]|required');	
	
		if ($this->form_validation->run() == FALSE){    // if form validation fails,load the registrationForm 
			$this->load->view('registerView');       
		} else {                                        //if form validation passes,authenticate,set the session and redirect to room 
			$username = htmlspecialchars($_POST['username']);
			$password =sha1(htmlspecialchars($_POST['password']));
			$email = $_POST['email'];
			$this->load->model('users');
			$isRegistered = $this->users->register($username,$email,$password);
			if ($isRegistered) {
				$singleRowResult=$this->users->authenticate($email,$password);
				$sess_array = array();
				$sess_array = array('userid' => $singleRowResult['userid'],'username' => $singleRowResult['username']);
				$this->session->set_userdata('logged_in', $sess_array);
				redirect('room','refresh');
			} else {
				echo("A technical error has occurred!");
			}
		}
	}
}