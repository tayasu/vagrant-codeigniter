<!-- ツイートのデータを処理するモデル -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Tweet_model extends CI_MODEL {
		
		public function __construct() {
			parent::__construct();
			$this->load->database();		
		}

		// ツイートを呼び出す
		public function getTweet($limit) {
			$sql = "select * from tweet order by time desc limit $limit";
			$result = $this->db->query($sql)->result_array();
			return $result;
		}
		// ツイートを入力する
		public function insertTweet($userID, $name, $tweet) {
			$sql = "insert into tweet values (NULL, '$userID', '$tweet', CURRENT_TIMESTAMP, '$name')";
			$result = $this->db->query($sql);
		}
	}
?>
