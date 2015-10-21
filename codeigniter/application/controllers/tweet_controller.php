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

            $this->load->helper(array('form','url', 'email', 'date', 'html'));
        }

        // ツイート・リストをもっと表示する
        public function tweet($limit) {
            $this->load->model('tweet_model');

            $data['tweets'] = $this->tweet_model->get($limit);
            $this->load->view('tweet', $data);
        }

        // 新しいツイートを投稿する
        public function post($tweet) {
            $this->load->model('tweet_model');

            $name = $this->session->userdata('username');
            $userID = $this->session->userdata('id');

            $tweet = str_replace("_", "&nbsp", $tweet);
            $tweet = $this->security->xss_clean($tweet);
            $tweet = str_replace(";", "", $tweet);

            $this->tweet_model->insert($userID, $name, $tweet);

            $data['tweets'] = $this->tweet_model->get(10);
            $this->load->view('tweet', $data);
        }

        public function homepage() {  
            $this->load->model("tweet_model");
            $this->load->model("user_model");

            $data['library_src'] = $this->jquery->script();
            
            $username = $this->session->userdata('username');

            if ($username === FALSE) {
                redirect('twitter/login');
            } 
                $data['name'] = $this->session->userdata('username');
                $userID = $this->session->userdata('id');
                $data['userID'] = $userID;
                $data['tweets'] = $this->tweet_model->get(10);

                $this->form_validation->set_rules('tweet', 'ツイート', 'trim|required|max_lenght[140]|min_length[0]');

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('mainpage',$data);    
                }
                  
        }

    }

?>