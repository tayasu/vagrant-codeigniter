<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tweet_model extends CI_MODEL {
		
		public function __construct() {
			parent::__construct();
			$this->load->database();		
		}

		public function getTweet() {
			$sql = "select * from tweet order by time desc limit 10";
			$result = $this->db->query($sql)->result_array();
			return $result;
		}
		

		public function insertTweet($userID, $name, $tweet) {
			// $sql = "INSERT INTO tweet VALUES (NULL, '$userID', '$tweet', CURRENT_TIMESTAMP)";
			$sql = "insert into tweet values (NULL, '$userID', '$tweet', CURRENT_TIMESTAMP, '$name')";
			$result = $this->db->query($sql);
		}
	}
?>
