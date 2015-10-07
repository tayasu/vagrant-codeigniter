<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class User_model extends CI_MODEL {
		
		public function __construct() {
			parent::__construct();
			$this->load->database();
			// $this->load->model('user_model', 'model');
		}

		public function getUser($mail, $password) {
			$sql = "select * from users where mail = '$mail' and password = '$password'";
			$result = $this->db->query($sql)->result_array();
			var_dump($result[0]); exit;
			if ($result != NULL) {
				return $result[0];
			} else {
				return FALSE;
			}

		}
	}
?>
