<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Tweet_model extends CI_MODEL {

        public function __construct() {
            parent::__construct();

            $this->load->library('driver');

            $this->load->driver('cache');

            $this->load->database();
        }

        // ツイートを呼び出す
        public function get($limit) {

            $check_cache = $this->cache->memcached->get($limit);

            if (! $check_cache) {
                $this->db->order_by('tweet_id', 'desc');
                $result = $this->db->get('tweet', $limit)->result_array();

                $this->cache->memcached->save($limit, $result, 300);
                return $result;
            }

            $result = $this->cache->memcached->get($limit);
            return $result;
        }

        // ツイートを入力する
        public function insert($user_id, $name, $tweet) {

            $this->cache->memcached->clean();

            $data = array(
                'tweet_id' => NULL,
                'user_id' => $user_id,
                'tweet' => $tweet,
                'time' => date('Y-m-d H:i:s', now()),
                'name' => $name
            );          
            $this->db->insert('tweet', $data);
        }
    }
?>
