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
        if (!$this->_is_login()) {
            redirect('twitter/login');
        }   
    }

    private function _is_login()
    {
        return $this->session->userdata('username');
    }

    // ツイート・リストをもっと表示する
    public function tweet($limit)
    {
        $user_id = $this->session->userdata('id');
        $data['tweets'] = $this->tweet_model->get($user_id, $limit);
        $this->load->view('tweet', $data);
    }

    // 新しいツイートを投稿する
    public function post()
    {
        $user_id = $this->session->userdata('id');

        $tweet = $this->input->post('tweet');
        $tweet_length = strlen($tweet);
        if (($tweet_length === 0) || ($tweet_length > 140)) {
            return;
        }

        $this->tweet_model->insert($user_id, $tweet);
        $data['tweets'] = $this->tweet_model->get($user_id, TWEET_LIMIT);
    }

    public function homepage()
    {  
        $data['library_src'] = $this->jquery->script();            

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
