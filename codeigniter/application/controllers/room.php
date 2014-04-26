<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Room extends CI_Controller {

	public function index(){
		if($this->session->userdata('logged_in')){
			
			$result = $this->showPosts("1");
		
			if($result){
				$this->load->view('roomView',$result);
			}
			else{
				redirect('room','refresh');
			}
		}
		else{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	public function showPosts($parameter){
		$page = (int) $parameter;  //type casting the parameter to integer will cause page to be 0 is it contains alphabets
		$session_data = $this->session->userdata('logged_in');
		
		$this->load->model('DBFunctions');
		
		$result = $this->DBFunctions->posts($page);
		
		if($result){
			if(!isset($result['message'])){
				$result['message'] = "NOT_SET";
			}
			$n = count($result);
			array_unshift($result,$session_data['username'],$n + 2,$page);
			//setting the data to be sent to the view
			for($i = 0; $i < $n + 2; $i++){
				$di = 'di'.$i;
				$data[$di] = $result[$i];
			}
			
			$data['message'] = $result['message'];
			
			return $data;
				
			//$this->load->view('roomView', $data);	
			
		}
		else{
			return false;
			redirect('room','refresh');                //handling uri entered by the user
		}		
	} 
	
	public function ajax($param){
		
		$result = $this->showPosts($param);
		
		
		if($result){
			print_r($result);
		}
		else{
			echo("NO!");
		}
	}
	
	public function more($param){
			
		$result = $this->showPosts($param);
		
		if($result){
			$this->load->view('roomView',$result);
		}
		else{
			redirect('room','refresh');
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}
}

?>
