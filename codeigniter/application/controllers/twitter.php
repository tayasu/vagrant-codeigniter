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
					
					if($result != NULL) {
					
						$sessiondata = array(
							'username' => $result['name'],
							'mail' => $mail,
							'id' => $result['userID']
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
			
			$this->load->helper(array('form', 'url', 'email'));

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('javascript');
			$this->load->library('javascript/jquery', FALSE);

			$this->load->model("tweet_model");
			$this->load->model("user_model");

			// $this->load->library('javascript', array('js_library_driver	' => 'script', 'autoload' => FALSE));

			$data['library_src'] = $this->jquery->script();
    		// $data['btn_tweet'] = $this->jquery->_click('#btn_tweet', "$('#tweet_list').html('test')");
			
			

			$name = $this->session->userdata('username');
			$data['name'] = $name;
			$userID = $this->session->userdata('id');
			$data['tweets'] = $this->tweet_model->getTweet();

			$this->form_validation->set_rules('tweet', 'ツイート', 'trim|required|max_lenght[140]');

			

			if($this->form_validation->run() == FALSE) {
				$this->load->view('mainpage', $data);
				
			} else {

				$this->load->library('input');
				$tweet = $this->input->post("tweet");
				// $data['btn_tweet'] = $this->jquery->_click('#btn_tweet', "$('#tweet_list').html('test')");

				$this->tweet_model->insertTweet($userID, $name,  $tweet);
				// $data['tweets'] = $this->tweet_model->getTweet();

				// $data['btn_tweet'] = $this->jquery->_click('#btn_tweet', "$('#tweet_list').html('test')");
				// $this->load->view('mainpage', $data);

				
			}
			
			

		}

	}

?>