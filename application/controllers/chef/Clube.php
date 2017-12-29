<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clube extends CI_Controller
{
    var $data = array();

    public function __construct() 
    {
        parent::__construct();
        if(!$this->session->userdata('user')){
            redirect('login');
        }
        $this->load->model('chef_model', 'chef');
        $user_id = $this->session->userdata('user')->user_id;
        $this->data['user'] = array('picture' => $this->chef->info($user_id)['picture']);
    }

    public function index() 
    {
        $this->data['page_title'] = 'CLUBE DE VANTAGENS';
        $this->load->view('chef/clube', $this->data);
    }
}
