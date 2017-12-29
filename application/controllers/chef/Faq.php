<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq extends CI_Controller
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
        $this->data['page_title'] = 'PERGUNTAS FREQUENTES';
        $this->load->model('faq_model','faqs');
        $this->db->like('type_faq', 'chef')->order_by('sort');
        $this->data['faqs'] = $this->faqs->get_all()->result();
        $this->load->view('chef/faq', $this->data);
    }

}
