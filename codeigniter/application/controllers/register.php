<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index(){
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$this->load->view('roomView', $data);
		}
		else{
			//If no session, redirect to login page
			$this->load->view('registerView.php');
		}
		
	}
	
	public function verifyRegister(){
		$this->load->helper('form');
		
		$this->load->library('form_validation','url');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');

		if ($this->form_validation->run() == FALSE){
			$this->load->view('registerView');       //if validation fails load the registrationForm
		}
		else{
			$username = htmlspecialchars($_POST['username']);
			$email = htmlspecialchars($_POST['email']);
			$password =sha1(htmlspecialchars($_POST['password']));
			
			$this->load->model('DBFunctions');
			
			$result = $this->DBFunctions->register($username,$email,$password);
			
			if($result){
				$data['message']="<p>Registration successful! Provide your Username and Password to login.</p>";
				$this->load->view('loginView',$data);          //if registration successful load the loginForm  
			}
			else{
				$data['message']="<p>Registration unsuccessful! Try it again.</p>";
				$this->load->view('registerView',$data);          //if registration failed load the registerForm 	
			}	
		}	
	}
}