<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Tweet_model extends CI_MODEL {

        public function __construct() {
            parent::__construct();

            $this->load->database();        
        }

        // ツイートを呼び出す
        public function get($limit) {
            $this->db->order_by('time', 'desc');
            $result = $this->db->get('tweet', $limit)->result_array();

            return $result;
        }

        // ツイートを入力する
        public function insert($userID, $name, $tweet) {
            $data = array(
                'tweetID' => NULL,
                'userID' => $userID,
                'tweet' => $tweet,
                'time' => date('Y-m-d H:i:s', now()),
                'name' => $name
            );          
            $this->db->insert('tweet', $data);
        }

    }
?>
