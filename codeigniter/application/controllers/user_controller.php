<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	/**
	 * ユーザーコントローラー
	 * 
	 */
	class User_controller extends CI_CONTROLLER 
	{

		public function __construct() {
			parent::__construct();

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->library('security');
			$this->load->library('javascript');
			$this->load->library('javascript/jquery', FALSE);

			$this->load->helper(array('form','url', 'email', 'date', 'html'));
		}

		public function login()
		{
			$this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('login');
			} 
			else
			{
				$this->load->library('input');
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");

				$this->load->model("user_model");
				$result = $this->user_model->get_user($mail, $password);

				if ($result !== NULL)
				{
					$sessiondata = array(
						'username' => $result->name,
						'mail' => $mail,
						'id' => $result->userID
					);

					$this->session->set_userdata($sessiondata);
					$this->user_model->set_status($mail, 'ON');
					
					redirect('twitter/homepage');
				}
				else
				{
					$this->session->set_flashdata('error_msg', '<div class="text-danger">メールとかパスワードが間違います！</div>');

					redirect('twitter/login');
				}	
			}		
		}

		public function register()
		{
			$this->form_validation->set_rules('name', '名前', 'trim|required');
			$this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

			if($this->form_validation->run() === FALSE) 
			{
				$this->load->view('register');
			}
			else
			{
				$this->load->library('input');
				$name = $this->input->post("name");
				$mail = $this->input->post("mail");
				$password = $this->input->post("password");
				$password = $this->encrypt->encode($password);

				$this->load->model("user_model");
				$result = $this->user_model->insert_user($name, $mail, $password);

				if($result)
				{
					$sessiondata = array(
						'username' => $name,
						'mail' => $mail,
						'id' => $result->userID
					);

					$this->session->set_userdata($sessiondata);
					$this->user_model->set_status($mail, 'ON');
						
					redirect('twitter/homepage');
				} 
				else
				{
					$this->session->set_flashdata('error_msg', '<div class="text-danger">メールは存在しました！</div>');

					redirect('twitter/register');
				}
			}										
		}

		public function logout() 
		{
			$this->load->model("user_model");

			$mail = $this->session->userdata('mail');
			$this->user_model->set_status($mail, 'OFF');

			$this->session->sess_destroy();
			redirect('twitter/login');
		}

	}

?>