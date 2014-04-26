<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index(){
		if($this->session->userdata('logged_in')){
			redirect('room','refresh');
		}
		else{
			//If no session, redirect to login page
			$data['message'] = "NOT_SET";
			$this->load->view('registerView',$data);
		}
		
	}
	
	public function verifyRegister(){
		$this->load->helper('form');
		
		$this->load->library('form_validation','url');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
			
		if ($this->form_validation->run() == FALSE){
			//echo any type of errors
			$username_error=form_error('username');
			$email_error=form_error('email');
			$password_error=form_error('password');

			if($username_error==true && $password_error==true){
				$data['message'] = "USERNAME_PASSWORD";
			}	
			else{
				if($username_error==true){
					$data['message'] = "USERNAME";	
				}
				elseif($password_error==true){
					$data['message'] = "PASSWORD";
				}
				else{
					$data['message'] = "UNKNOWN";
				}
			}
			
			if($email_error==true){
				if($email_error == "<p>The Email field is required.</p>"){
					if(isset($data['message'])){
						$data['message'] = $data['message'] . "_EMAIL";
					}
					else{
						$data['message'] = "EMAIL"; 
					}
				}
				elseif($email_error == "<p>The Email field must contain a valid email address.</p>"){
					if(isset($data['message'])){
						$data['message'] = $data['message'] . "_EMAIL_INVALID";
					}
					else{
						$data['message'] = "EMAIL_INVALID"; 
					}	
				}
				else{
					$data['message'] = "UNKNOWN";
				}
			}
			
			$this->load->view('registerView',$data);       //if validation fails load the registrationForm
		}
		else{
			$username = htmlspecialchars($_POST['username']);
			$email = htmlspecialchars($_POST['email']);
			$password =sha1(htmlspecialchars($_POST['password']));
			
			$this->load->model('DBFunctions');
			
			$result = $this->DBFunctions->register($username,$email,$password);
			
			if($result){
				$data['message']="REGISTRATION_SUCCESSFUL";
				$this->load->view('loginView',$data);          //if registration successful load the loginForm  
			}
			else{
				$data['message']="REGISTRATION_FAILED";
				$this->load->view('registerView',$data);          //if registration failed load the registerForm 	
			}	
		}	
	}
}