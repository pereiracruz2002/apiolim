<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller
{
    var $data = array();
    
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('login');
        }
    }
    
    public function index()
    {
        $this->load->model('chef_model', 'chef');
        $this->data['page_title'] = 'Perfil';
        $user_id = $this->session->userdata('user')->user_id;
        
        $token = base64_encode($this->encrypt->encode($this->session->userdata("user")->user_id));
        $this->data['token'] = $token;
        
        $this->data['user'] = $this->chef->info($user_id);
        $this->data['active'] = 'perfil';
        $this->load->view('chef/perfil', $this->data);
    }

}