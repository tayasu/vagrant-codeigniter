<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Twitter extends CI_CONTROLLER {

		public function __construct() {
			parent::__construct();
		}

		public function login() {
			$this->load->helper('form');
			$this->load->helper('email');
			$this->load->helper(array('form','url'));
			$this->load->library('form_validation');

			#form validation rules
			$this->form_validation->set_rules('mail', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|min_lenght[6]');

			if($this->form_validation->run() == FALSE) {
				$this->load->view('login');
			} else {
				$this->load->view('mainpage');
				$this->load->library('input');
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");
				print_r("$mail -- $password") ;
				$this->load->model("user_model");
				$result = $this->user_model->getUser($mail, $password);
				if($result[0] != NULL) {
					print_r($result[0]);
				}
				
			}


			

		}


		public function testdb($name) {
			$this->load->view('mainpage');
			$this->load->database();
			$sql = "select * from users where mail = '$name'";
			print_r($sql);
			$result = $this->db->query($sql)->result_array();
			print_r($result);
			if ($result[0] != NULL) {
				print_r($result[0]);
				return $result;
			} 
			
		}

	}

?>