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
			$this->load->library('session');
			$this->load->library('encrypt');

			#form validation rules
			$this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required');
			$this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

			if($this->form_validation->run() == FALSE) {
				$this->load->view('login');
			} else {
				$this->load->library('input');
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");
				// $password = $this->encrypt->encode($password);

				//mail validation
				if(valid_email($mail)) {
					$this->load->model("user_model");
					$result = $this->user_model->getUser($mail, $password);
					
					if($result[0] != NULL) {
					
						$sessiondata = array(
							'username' => $result['name'],
							'mail' => $mail
							);
						$this->session->set_userdata($sessiondata);
						$this->user_model->setStatus($mail, 'ON');
						// $this->load->view('mainpage');
						redirect('twitter/homepage');

					} else {
						// $this->load->view('login');
						$this->session->set_flashdata('error_msg', '<div class="text-danger">メールとかパスワードが間違います！</div>');
						redirect('twitter/login');
					}
				} else {
					$this->session->set_flashdata('error_msg', '<div class="text-danger">メールのフォーマットが間違います！</div>');
					redirect('twitter/login');
				}	
			}		
		}


		public function register() {
			// $this->load->helper('form');
			// $this->load->helper('email');
			$this->load->helper(array('form','url', 'email'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('encrypt');

			#form validation rules
			$this->form_validation->set_rules('name', '名前', 'trim|required');
			$this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required');
			$this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

			if($this->form_validation->run() == FALSE) {
				$this->load->view('register');
			} else {
				$this->load->library('input');
				$name = $this->input->post("name");
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");
				$password = $this->encrypt->encode($password);

				//mail validation
				if(valid_email($mail)) {
					$this->load->model("user_model");
					
					$result = $this->user_model->insertUser($name, $mail, $password);
					// redirect('twitter/homepage');
					if($result) {
						$sessiondata = array(
							'username' => $name,
							'mail' => $mail
						);

						$this->session->set_userdata($sessiondata);
						$this->user_model->setStatus($mail, 'ON');
						redirect('twitter/homepage');
					} else {
						$this->session->set_flashdata('error_msg', '<div class="text-danger">メールは存在しました！</div>');
						// $this->load->view('register');
						redirect('twitter/register');
					}

				} else {
					$this->session->set_flashdata('error_msg', '<div class="text-danger">メールのフォーマットが間違います！</div>');
					redirect('twitter/register');
				}
				
				
			}


		}

		public function homepage() {
			$this->load->view('mainpage');
			
			
		}

	}

?>