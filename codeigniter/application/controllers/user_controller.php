<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class User_controller extends CI_CONTROLLER {

        public function __construct() {
            parent::__construct();

            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->library('encrypt');
            $this->load->library('security');
            $this->load->library('javascript');
            $this->load->library('javascript/jquery', FALSE);
            $this->load->library('input');
            $this->load->library('driver');

            $this->load->driver('cache');

            $this->load->model("user_model");

            $this->load->helper(array('form','url', 'email', 'date', 'html'));
        }

        public function login() {
    
            $this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('login');
            } else {         
                $mail = $this->input->post("mail");
                $password = $this->input->post("password");              
                $result = $this->user_model->get($mail, $password);

                if ($result !== NULL) {
                    $sessiondata = array(
                        'username' => $result->name,
                        'mail' => $mail,
                        'id' => $result->user_id
                    );
                    $this->session->set_userdata($sessiondata);
                    $this->user_model->set_status($mail, 'ON');
                    
                    redirect('twitter/homepage');
                } 
                    
                $this->session->set_flashdata('error_msg', '<div class="text-danger">メールとかパスワードが間違います！</div>');
                redirect('twitter/login');        
            }       
        }

        public function register() {

            $this->form_validation->set_rules('name', '名前', 'trim|required');
            $this->form_validation->set_rules('mail', 'メールアドレス', 'trim|required|valid_email|callback_mail_unique');
            $this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[6]|user_password_unique');
            $this->form_validation->set_rules('confirm_password', '確認パスワード', 'trim|required|min_length[6]|callback_password_confirm');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('register');
            } else {
                $name = $this->input->post("name");
                $mail = $this->input->post("mail");
                $password = $this->input->post("password");
                $password = $this->encrypt->encode($password);

                $this->load->model("user_model");
                $this->user_model->insert($name, $mail, $password);

                $sessiondata = array(
                    'username' => $name,
                    'mail' => $mail,
                    'id' => $result->user_id
                );
                $this->session->set_userdata($sessiondata);
                $this->user_model->set_status($mail, 'ON');
                    
                redirect('twitter/homepage');                
            }                                       
        }

        // 確認パスワードをチェック
        public function password_confirm($confirm_password) {

            $password = $this->input->post("password");

            if ($confirm_password === $password) {
                return TRUE;
            }

            $this->form_validation->set_message('password_confirm', '確認パスワードは違います。');
            return FALSE;
        }

        // 登録メールの存在をチェック
        public function mail_unique($mail) {

            $is_mail_unique = $this->user_model->is_mail_unique($mail);

            if ($is_mail_unique === FALSE) {
                $this->form_validation->set_message('mail_unique', 'メールは存在しました！');
            }
            
            return $is_mail_unique;
        }

        public function logout() {

            $mail = $this->session->userdata('mail');
            $this->user_model->set_status($mail, 'OFF');
            $this->session->sess_destroy();
            
            $this->cache->memcached->clean();

            redirect('twitter/login');
        }
    }
?>