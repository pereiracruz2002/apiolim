<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Painel extends CI_Controller
{

    var $data = array();

    public function __construct() 
    {
        parent::__construct();
        if(!$this->session->userdata('user')){
            redirect('login');
        }
    }

    public function index() 
    {
        $this->load->model('user_model','user');
        $user = $this->user->get($this->session->userdata('user')->user_id)->row();
        $set = array('last_login' => date('Y-m-d H:i:s'));
        $this->user->update($set, $this->session->userdata('user')->user_id);
        if(!$user->last_login){
            redirect('login/first');
        } else {
            redirect("chef/evento");
        }
    }

}
