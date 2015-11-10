<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tweet_model extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('driver');
        $this->load->driver('cache');

        $this->load->database();
    }

    // ツイートを読み出す
    public function get($limit)
    {
        $result = array();
        $limit = (int) $limit;
        $on_cache = $this->cache->memcached->get($limit);
        
        if ($on_cache === FALSE) {
            for ($key = TWEET_LIMIT; $key < $limit; $key += TWEET_LIMIT) {
                $result = array_merge($result, $this->cache->memcached->get($key));
            }
            $last_tweets = $this->cache->memcached->get($limit - TWEET_LIMIT);
            $last_tweet_id = $last_tweets[count($last_tweets) - 1]['tweet_id'];

            $this->db->order_by('tweet_id', 'desc');
            if ($last_tweet_id !== NULL) {
                $this->db->where('tweet_id <', $last_tweet_id);
            }
            $add_to_cache = $this->db->get('tweet', TWEET_LIMIT)->result_array();
            $this->cache->memcached->save($limit, $add_to_cache, CACHE_TIME_OUT);
            $result = array_merge($result, $add_to_cache);
            return $result;
        }

        for ($key = TWEET_LIMIT; $key <= $limit; $key += TWEET_LIMIT) {
            $result = array_merge($result, $this->cache->memcached->get($key));
        }
        $tweet_num = count($result);
        if ($tweet_num < $limit) {
            $last_tweet_id = $result[$tweet_num - 1]['tweet_id'];
            $this->db->order_by('tweet_id', 'desc');
            $this->db->where('tweet_id <', $last_tweet_id);
            $add_to_cache = $this->db->get('tweet', TWEET_LIMIT)->result_array();
            $result = array_merge($result, $add_to_cache);
            $add_to_cache = array_merge($this->cache->memcached->get($limit), $add_to_cache);
            $this->cache->memcached->save($limit, $add_to_cache, CACHE_TIME_OUT);
        }
        return $result;
    }

    // ツイートを入力する
    public function insert($user_id, $name, $tweet)
    {
        $time = date('Y-m-d H:i:s', now());
        $data = array(
            'tweet_id' => NULL,
            'user_id' => $user_id,
            'tweet' => $tweet,
            'time' => $time,
            'name' => $name
        );
        $this->db->insert('tweet', $data);

        $temp = $this->db->get_where('tweet', array('time' => $time))->result_array();
        $key = TWEET_LIMIT;

        while (1) {
            $cache = $this->cache->memcached->get($key);
            if ($cache !== FALSE) {
                $cache_length = count($cache); 
                if($cache_length === 10) {          
                    $cache = array_merge($temp, $cache);
                    $temp = $cache[count($cache) - 1];
                    array_pop($cache);
                    $this->cache->memcached->save($key, $cache, CACHE_TIME_OUT);
                    $key += TWEET_LIMIT;
                    continue;
                }
                $this->cache->memcached->save($key, array_merge($temp, $cache), CACHE_TIME_OUT);
                break;
            }
            $this->cache->memcached->save($key, array($temp), CACHE_TIME_OUT);
            break;
        }
    }
}
