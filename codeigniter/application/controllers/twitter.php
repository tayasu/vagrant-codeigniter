<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Twitter extends CI_CONTROLLER 
	{

		public function __construct() 
		{
			parent::__construct();

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->library('security');
			$this->load->library('javascript');
			$this->load->library('javascript/jquery', FALSE);

			$this->load->helper(array('form','url', 'email', 'date', 'html'));
		}

		// ホームページを表示する
		public function homepage() 
		{			
			$this->load->model("tweet_model");
			$this->load->model("user_model");

			$data['library_src'] = $this->jquery->script();
			
			$username = $this->session->userdata('username');

			if ($username === FALSE)
			{
				redirect('twitter/login');
			} 
			else 
			{
				$data['name'] = $this->session->userdata('username');
				$userID = $this->session->userdata('id');
				$data['userID'] = $userID;
				$data['tweets'] = $this->tweet_model->get_tweet(10);

				$this->form_validation->set_rules('tweet', 'ツイート', 'trim|required|max_lenght[140]');

				if ($this->form_validation->run() === FALSE) 
				{
					$this->load->view('mainpage',$data);	
				}
			}		
		}

	}

?>