<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends CI_Controller {
	public function _remap($method, $args) {
		if (method_exists($this, $method)){
			// Call before action
			$this->before();
			return call_user_func_array(array($this, $method), $args);
		}
		show_404();        //if the user enters any other function which is not in this class
	}
	
	private function before() {
		if($this->session->userdata('logged_in')){
			return true;
		}
		else{
			redirect('login','refresh');
		}	
	}	
	
	public function index(){
		$posts = $this->showInitialPosts();
		if($posts){                             //if result exists send the result to room for display
			$data['jsonObject'] = $posts;
			$this->load->view('roomView',$data);
		}
		else{                                    
			$data['message'] = "NO_POSTS_YET";
			$this->load->view('roomView',$data);
		}
	}
	
	public function showInitialPosts(){
		$this->load->model('posts');
		$postsFromDB = $this->posts->getInitialPosts();
		
		if ($postsFromDB) {
			return json_encode($postsFromDB);
		} else {
			return false;
		}		
	} 
	
	public function showPosts($parameter){
		$postid = (int) $parameter;  //type casting the parameter to integer will cause page to be 0 is it contains alphabets
		
		$this->load->model('posts');
		$postsFromDB = $this->posts->getPosts($postid);
		
		if ($postsFromDB) {
			return json_encode($postsFromDB);
		} else {
			return false;
		}		
	} 
	
	public function ajaxDisplay(){
		$postid = $_POST['postid'];
		$posts = $this->showPosts($postid);
		if($posts){
			print_r($posts);                         //returns the JSON Object Array to ajax responseText
		}
		else{
			echo("[{\"message\":\"OUT_OF_INDEX\"}]");
		}
	}
	
	public function ajaxPost(){
		$session_data = $this->session->userdata('logged_in');
		if(isset($_POST['status'])){
			$userid = $session_data['userid'];
		 	$username = $session_data['username'];
			$posts = $_POST['status'];
			$time_of_post = date("Y-m-d H:i:s");
			
			$this->load->model('posts');
			$insertPost = $this->posts->post($userid,$username,$posts,$time_of_post);
		} else {
			echo("VARIABLES_NOT_SET_IN_AJAXPOST");
		}
		
		if($insertPost){
			echo($time_of_post);
		}
		else{
			echo("POST_NOT_INSERTED");
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}

?>
