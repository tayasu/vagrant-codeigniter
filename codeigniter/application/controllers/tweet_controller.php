<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class Tweet_controller extends CI_CONTROLLER {
        
        public function __construct() {
            parent::__construct();

            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->library('encrypt');
            $this->load->library('security');
            $this->load->library('javascript');
            $this->load->library('javascript/jquery', FALSE);

            $this->load->library('driver');
            $this->load->driver('cache');

            $this->load->model('tweet_model');
            $this->load->model("user_model");

            $this->load->helper(array('form','url', 'email', 'date', 'html'));
        }

        // ツイート・リストをもっと表示する
        public function tweet($limit) {
            
            $data['tweets'] = $this->tweet_model->get($limit);
            $this->load->view('tweet', $data);
        }

        // 新しいツイートを投稿する
        public function post($tweet) {
            
            $tweet = urldecode($tweet);
            $name = $this->session->userdata('username');
            $user_id = $this->session->userdata('id');

            $tweet = str_replace(" ", "&nbsp", $tweet);
            $tweet = $this->security->xss_clean($tweet);
            $tweet = str_replace(";", "", $tweet);
            $this->tweet_model->insert($user_id, $name, $tweet);
            $data['tweets'] = $this->tweet_model->get(TWEET_LIMIT);
            $this->load->view('tweet', $data);
        }

        public function homepage() {  

            $data['library_src'] = $this->jquery->script();            
            $username = $this->session->userdata('username');

            if ($username === FALSE) {
                redirect('twitter/login');
            } 

            $data['name'] = $this->session->userdata('username');
            $user_id = $this->session->userdata('id');
            $data['user_id'] = $user_id;
            $data['tweets'] = $this->tweet_model->get(TWEET_LIMIT);

            $this->form_validation->set_rules('tweet', 'ツイート', 'trim|required|max_lenght[140]|min_length[0]');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('mainpage',$data);    
            }             
        }
    }
?>