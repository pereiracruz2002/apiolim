<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class Admins extends BaseCrud 
{
    var $modelname = 'user'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/admins';
    var $actions = 'CRUD';
    var $acoes_extras = array(array('url'=>'administrativo/admins/perfil','title'=>'Ver Perfil','class'=>'btn btn-success'),);
    var $acoes_controller = array(array("url" => "administrativo/admins/exportar/1", "title" => "Exportar Chefs", "class" => "btn btn-info","icon"=>"glyphicon glyphicon-download-alt"));
    var $titulo = 'Convidados';
    var $tabela = 'name,email,status';
    var $campos_busca = 'email,name,lastname';
    var $joins = array('user_types' => 'user_types.user_type_id=user.user_type_id AND user.user_type_id=1');
    var $selects = "user.*, CONCAT(user.name, ' ', user.lastname) as name";

    public function __construct() 
    {
        parent::__construct();
    }

    public function _filter_pre_listar(&$where, &$where_ativo) 
    {
        $where_ativo['user.user_type_id'] = 1;
    }

    public function perfil ($user_id){
        $this->load->model('user_model', 'user');
        $this->db->select('user.user_type_id');
        $tipoUser = $this->db->get_where('user',array('user_id'=>$user_id))->row();

        $where = array(
            'user.user_id' => $user_id,
            'user.user_type_id' => $tipoUser->user_type_id
        );
        $this->data['user'] = $this->user->info($where);
        $this->load->view("administrativo/perfil", $this->data);
    }

    public function exportar($tipoUser){
        $this->load->model('user_model', 'user');
        $this->db->select('user_types.label');
        $tipo = $this->db->get_where('user_types',array('user_type_id'=>$tipoUser))->row();
        $where = array(
            'user.user_type_id' => $tipoUser
        );
        $this->xlsx($this->user->relatorio($where),$tipo->label);
    }

    public function xlsx($tabela,$tipo)
    {
        $this->load->helper('download');
        force_download($tipo.'.xlsx', utf8_decode($tabela));
    }


    public function _filter_pre_form(&$data) {
        if ($this->uri->segment(3) == 'editar' or $this->uri->segment(4) == 'editar') {
            $data[0]['values']['password'] = $this->encrypt->decode($data[0]['values']['password']);
        }
    }



    public function _filter_pre_save(&$data) {
        $this->load->library('encrypt');
        if (isset($data['password']))
            $data['password'] = $this->encrypt->encode($data['password']);
    }

    public function _filter_pre_read(&$data) 
    {
        foreach ($data as $key) {
            if ($key->status == "enable")
                $key->status = "Habilitado";
            elseif($key->status == "confirm_email")
                 $key->status = "Confirmar Email";
            elseif($key->status == "pendding")
                 $key->status = "Pendente";
            else
                $key->status = "Desabilitado";
        }
    }

    public function uniqlogin($username) {
        $where['username'] = $username;
        if ($this->uri->segment(3) == 'editar') {
            $where['user_id !='] = $this->uri->segment(4);
        }
        $cadastro = $this->model->get_where($where)->row();

        if ($cadastro) {
            $this->form_validation->set_message('uniqlogin', 'Esse login já está em uso');
            return false;
        } else {
            return true;
        }
    }

    public function uniqEmail($email) {

        $where['email'] = $email;
        if ($this->uri->segment(3) == 'editar') {
            $where['user_id !='] = $this->uri->segment(4);
        }
        $cadastro = $this->model->get_where($where)->row();

        if ($cadastro) {
            $this->form_validation->set_message('uniqEmail', 'Esse email já está em uso');
            return false;
        } else {
            return true;
        }
    }

}
