<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Tweet_controller extends CI_CONTROLLER
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

		// 新しいツイートを投稿する
		public function tweet($limit)
		{
			$this->load->model('tweet_model');

			$data['tweets'] = $this->tweet_model->get_tweet($limit);
			$this->load->view('tweet', $data);
		}

		// 新しいツイートを投稿する
		public function post_tweet($tweet)
		{
			$this->load->model('tweet_model');

			$name = $this->session->userdata('username');
			$userID = $this->session->userdata('id');

			$tweet = str_replace("_", "&nbsp", $tweet);
			$tweet = $this->security->xss_clean($tweet);
			$tweet = str_replace(";", "", $tweet);

			$this->tweet_model->insert_tweet($userID, $name, $tweet);

			$data['tweets'] = $this->tweet_model->get_tweet(10);
			$this->load->view('tweet', $data);
		}

	}

?>