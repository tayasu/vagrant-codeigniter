<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class User_model extends CI_MODEL {
        
        public function __construct() {
            parent::__construct();

            $this->load->database();        
        }

        // ユーザー情報を呼び出す
        public function get($mail, $password) {

            $result = $this->db->get_where('users', array('mail' => $mail));

            if ($result->num_rows() > 0) {
                if ($password === $this->encrypt->decode($result->row()->password)) {
                    return $result->row();
                }   
            } 

            return NULL;       
        }
        
        // メールの存在をチェック
        public function is_mail_unique($mail) {

            $result = $this->db->get_where('users', array('mail' => $mail));

            if ($result->num_rows() > 0) {
                return FALSE;
            }

            return TRUE;
        }

        // ユーザーのステータスを変更する
        public function set_status($mail, $status) {

            $data = array('status' => $status);
            $this->db->where('mail', $mail);
            $this->db->update('users', $data);
        }

        // 新しいユーザーをデータベースに入力する
        public function insert($name, $mail, $password) {

            $data = array(
                'user_id' => NULL,
                'name' => $name,
                'mail' => $mail,
                'password' => $password,
                'status' => 'ON'
            );
            $this->db->insert('users', $data);
        }
    }
?>
