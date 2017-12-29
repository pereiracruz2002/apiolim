<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Solicitacoes extends CI_Controller 
{
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect('/administrativo/login');
        }
    }

    public function index() {
        $this->load->model("User_info_model", "info");
        $resultado = $this->info->getRequestsChefs();
        $dados["listagem"] = $resultado;
        $this->load->view('administrativo/solicitacoes', $dados);
    }
    
    public function perfil ($user_id)
    {
        $this->load->model('chef_model', 'chef');
        $this->data['user'] = $this->chef->info($user_id);
      
        $this->load->view("administrativo/chef_perfil", $this->data);
    }
}
