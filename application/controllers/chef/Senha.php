<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Senha extends CI_Controller
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
        $this->data['page_title'] = 'Alterar Senha';
        $this->user->fields['old_password'] = array(
            'type' => 'password',
            'label' => 'Senha Atual',
            'rules' => 'callback_checkpass',
            'class' => '',
            'prepend' => '<div class="col-sm-5">',
            'append' => '</div>',
            'label_class' => 'col-sm-3 control-label no-padding-right',
        );
        
        $this->user->fields['password'] = array(
            'type' => 'password',
            'label' => 'Nova Senha',
            'rules' => 'callback_checkpass',
            'class' => '',
            'prepend' => '<div class="col-sm-5">',
            'append' => '</div>',
            'label_class' => 'col-sm-3 control-label no-padding-right',
        );
        
        $this->user->fields['confirm_password'] = array(
            'type' => 'password',
            'label' => 'Confirmar Senha',
            'rules' => 'matches[password]',
            'class' => '',
            'prepend' => '<div class="col-sm-5">',
            'append' => '</div>',
            'label_class' => 'col-sm-3 control-label no-padding-right',
        );

        $this->data['form'] = $this->user->form('old_password', 'password', 'confirm_password');

        if($this->input->posts()){
            if($this->user->validar()){
                $set = array('password' => $this->encrypt->encode($this->input->post('password')));
                $this->user->update($set, $this->session->userdata('user')->user_id);
                $this->data['save'] = box_success('Senha alterada com sucesso');
            } else {
                $this->data['save'] = box_alert(validation_errors());
            }
        }
        $this->load->view('chef/senha', $this->data);
    }

    public function checkpass($password) 
    {
        $userdata = $this->user->get($this->session->userdata('user')->user_id)->row();
        if($userdata and $this->encrypt->decode($userdata->password) == $password){
            return true;
        } else {
            $this->form_validation->set_message('checkpass', 'Sua senha atual não está correta');
            return false;
        }
    }
}
