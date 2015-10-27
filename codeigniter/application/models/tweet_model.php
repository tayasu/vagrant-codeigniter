<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Tweet_model extends CI_MODEL {

        public function __construct() {
            parent::__construct();

            $this->load->library('driver');

            $this->load->driver('cache');

            $this->load->database();
        }

        // ツイートを読み出す
        public function get($limit) {
            $limit = (int) $limit;
            $keys_array = $this->cache->memcached->get('keys_array');

            if ($keys_array !== FALSE) {
                $on_cache = count($keys_array);

                if ($on_cache < $limit) {
                    for ($i = 0; $i < $on_cache; $i++) {
                        $result[$i] = $this->cache->memcached->get($keys_array[$i]);
                    }

                    $last_tweet_id = $this->cache->memcached->get($keys_array[$on_cache - 1])['tweet_id'];                  
                    $this->db->order_by('tweet_id', 'desc');
                    $this->db->where('tweet_id <', $last_tweet_id);
                    $add_to_cache = $this->db->get('tweet', $limit - $on_cache)->result_array();

                    $new_keys_array = array();
                    for ($i = 0; $i < count($add_to_cache); $i++) {
                        $this->cache->memcached->save($add_to_cache[$i]['tweet_id'], $add_to_cache[$i], CACHE_TIME_OUT);
                        $new_keys_array[$i] = $add_to_cache[$i]['tweet_id'];
                    }                    
                    $keys_array = array_merge($keys_array, $new_keys_array);
                    $this->cache->memcached->save('keys_array', $keys_array, CACHE_TIME_OUT);
                    $result = array_merge($result, $add_to_cache);

                    return $result;
                }

                for ($i = 0; $i < $limit; $i++) {
                    $result[$i] = $this->cache->memcached->get($keys_array[$i]);
                }
                return $result;
            }

            $this->db->order_by('tweet_id', 'desc');
            $result = $this->db->get('tweet', $limit)->result_array();
            $i = 0;
            foreach ($result as $tweet) {
                $this->cache->memcached->save($tweet['tweet_id'], $tweet, CACHE_TIME_OUT);
                $keys_array[$i] = $tweet['tweet_id'];
                $i++;
            }
            $this->cache->memcached->save('keys_array', $keys_array, CACHE_TIME_OUT);
            return $result;            
        }

        // ツイートを入力する
        public function insert($user_id, $name, $tweet) {

            $time = date('Y-m-d H:i:s', now());
            $data = array(
                'tweet_id' => NULL,
                'user_id' => $user_id,
                'tweet' => $tweet,
                'time' => $time,
                'name' => $name
            );          
            $this->db->insert('tweet', $data);

            $add_to_cache = $this->db->get_where('tweet', array('time' => $time))->result_array();
            $keys_array = $this->cache->memcached->get('keys_array');
            $keys_array = array_merge(array($add_to_cache[0]['tweet_id']), $keys_array);
            $this->cache->memcached->save('keys_array', $keys_array, CACHE_TIME_OUT);
            $this->cache->memcached->save($add_to_cache[0]['tweet_id'], $add_to_cache[0], CACHE_TIME_OUT);            
        }
    }
?>
