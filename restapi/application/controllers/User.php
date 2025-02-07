<?php
 
class User extends CI_Controller {
 
public function __construct(){
 
        parent::__construct();
  			$this->load->helper('url');
  	 		$this->load->model('user_model');
        $this->load->library('session');
 
}
 
public function index()
{
$this->load->view("register.php");
}
 
public function register_user(){
 
      $user=array(
      'user_name'=>$this->input->post('user_name'),
      'user_email'=>$this->input->post('user_email'),
      'user_password'=>md5($this->input->post('user_password')),
      'user_age'=>$this->input->post('user_age'),
      'user_mobile'=>$this->input->post('user_mobile')
        );
        print_r($user);
 
$email_check=$this->user_model->email_check($user['user_email']);
 
if($email_check){
  $this->user_model->register_user($user);
  $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
  redirect('user/login_view');
 
}
else{
 
  $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
  redirect('user');
 
 
}
 
}
 
public function login_view(){
 
$this->load->view("login.php");
 
}
 
function login_user(){ 
  $user_login=array(
 
  'user_email'=>$this->input->post('user_email'),
  'user_password'=>md5($this->input->post('user_password'))
 
    ); 
//$user_login['user_email'],$user_login['user_password']
    $data['users']=$this->user_model->login_user();
    //  if($data)
      //{
		  
        $this->session->set_userdata('user_id',$data['users'][0]['user_id']);
        $this->session->set_userdata('user_email',$data['users'][0]['user_email']);
        $this->session->set_userdata('user_name',$data['users'][0]['user_name']);
        $this->session->set_userdata('user_age',$data['users'][0]['user_age']);
        $this->session->set_userdata('user_mobile',$data['users'][0]['user_mobile']);
		echo $this->session->set_userdata('user_id'); 
        $this->load->view('user_profile.php',$data);
 
    //  }
    //  else{
     //   $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
     //   $this->load->view("login.php");
 
     // }
 
 
}
 
function user_profile(){
 
$this->load->view('user_profile.php');
 
}
public function user_logout(){
 
  $this->session->sess_destroy();
  redirect('user/login_view', 'refresh');
}
 
}
 
?>

 