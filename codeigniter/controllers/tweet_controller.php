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
        $this->load->library('driver');

        $this->load->driver('cache');

        $this->load->model('tweet_model');
        $this->load->model("user_model");

        $this->load->helper(array('form','url', 'email', 'date', 'html'));
    }

    // ツイート・リストをもっと表示する
    public function tweet($limit)
    {
        $username = $this->session->userdata('username');
        $user_id = $this->session->userdata('id');

        if ($username === FALSE) {
            redirect('twitter/login');
        }

        $data['tweets'] = $this->tweet_model->get($user_id, $limit);
        $this->load->view('tweet', $data);
    }

    // 新しいツイートを投稿する
    public function post()
    {
        $name = $this->session->userdata('username');
        $user_id = $this->session->userdata('id');

        if ($username === FALSE) {
            redirect('twitter/login');
        }

        $tweet = $this->input->post('tweet');
        $tweet_length = strlen($tweet);
        if (($tweet_length == 0) || ($tweet_length > 140)) {
            return;
        }

        $this->tweet_model->insert($user_id, $name, $tweet);
        $data['tweets'] = $this->tweet_model->get($user_id, TWEET_LIMIT);
    }

    public function homepage()
    {  
        $data['library_src'] = $this->jquery->script();            
        $username = $this->session->userdata('username');

        if ($username === FALSE) {
            redirect('twitter/login');
        } 

        $data['name'] = $this->session->userdata('username');
        $user_id = $this->session->userdata('id');
        $data['user_id'] = $user_id;
        $data['tweets'] = $this->tweet_model->get($user_id, TWEET_LIMIT);
        $this->form_validation->set_rules('tweet', 'ツイート', 'trim|required|max_lenght[140]|min_length[0]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('mainpage',$data);    
        }             
    }
}
