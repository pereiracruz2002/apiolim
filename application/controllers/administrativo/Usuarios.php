<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class Usuarios extends BaseCrud 
{
    var $modelname = 'user'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/usuarios';
    var $actions = 'CRUD';
    var $acoes_extras = array(array('url'=>'administrativo/usuarios/perfil','title'=>'Ver Perfil','class'=>'btn btn-success'),);
    var $acoes_controller = array(); //array("url" => "methodo do controller", "title" => "texto que aparece", "class" => "classe do link")
    var $titulo = 'Usuários';
    var $tabela = 'name,email,status';
    var $campos_busca = 'email,name,lastname';
    var $joins = array('user_types' => 'user_types.user_type_id=user.user_type_id');
    var $selects = "user.*, CONCAT(user.name, ' ', user.lastname) as name";

    public function __construct() 
    {
        parent::__construct();
    }

    public function index() {
        $this->listar();
    }

    public function admins() {
        $this->titulo = "Administradores";
        $this->joins = array('user_types' => 'user_types.user_type_id=user.user_type_id AND user.user_type_id=1');
        if(isset($action)){
            $this->{$action}($user_id);
        } else {
            $this->index();
        }
    }
    
    public function deletar($id) {
        $this->load->model('user_model', 'user');
        if ($this->user->update(array('status' => 'disable'), array('user_id' => $id))) {
            $this->output->set_output("ok");
        } else {
            $this->output->set_output("erro ao desabilitar");
        }
    }

    public function chefs($action=false, $user_id=false) {
        $this->titulo = "Chefes";
        $this->base_url = 'administrativo/usuarios/chefs';
        $this->joins = array('user_types' => 'user_types.user_type_id=user.user_type_id AND user.user_type_id=2');
        if($action){
            $this->{$action}($user_id);
        } else {
            $this->index();
        }
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
        header("Content-Type: application/csv; charset=ISO-8859-9");
        header('Content-Disposition: attachment; filename='.$tipo.'.csv');
        header('Cache-Control: max-age=0');
        force_download($tipo . '.csv', utf8_decode($tabela));
    }


    public function acompanhantes($action=false, $user_id=false) {
        $this->titulo = "Acompanhantes";
        $this->base_url = 'administrativo/usuarios/acompanhantes';
        if($action){
            $this->{$action}($user_id);
        } else {
            $this->index();
        }
    }

    public function users($action=false, $user_id=false) {
        $this->base_url = 'administrativo/usuarios/users';
        $this->titulo = "Convidados";
        $this->joins = array('user_types' => 'user_types.user_type_id=user.user_type_id AND user.user_type_id=3');
        if($action){
            $this->{$action}($user_id);
        } else {
            $this->index();
        }
    }

    public function _filter_pre_form(&$data) {
        if ($this->uri->segment(3) == 'editar' or $this->uri->segment(4) == 'editar') {
            $data[0]['values']['password'] = $this->encrypt->decode($data[0]['values']['password']);
        }
    }


    public function _filter_pre_listar(&$where, &$where_ativo) 
    {
        if ($this->uri->segment(3) == "admins") {
            $where['user.user_type_id'] = 1;
        } elseif ($this->uri->segment(3) == "chefs") {
            $where['user.user_type_id'] = 2;
        }elseif ($this->uri->segment(3) == "acompanhantes") {
            $where['user.user_type_id'] = 4;
        }else {
            $where['user.user_type_id'] = 3;
        }
    }

    public function _filter_pre_save(&$data) {
        $this->load->library('encrypt');
        if (isset($data['password']))
            $data['password'] = $this->encrypt->encode($data['password']);
    }

    public function _filter_pre_read(&$data) {
        if ($this->uri->segment(3) == "admins")
            $this->acoes_controller = array(array("url" => "administrativo/usuarios/exportar/1", "title" => "Exportar Admins", "class" => "btn btn-info","icon"=>"glyphicon glyphicon-download-alt")); 
        elseif($this->uri->segment(3) == "chefs")
            $this->acoes_controller = array(array("url" => "administrativo/usuarios/exportar/2", "title" => "Exportar Chefs", "class" => "btn btn-info","icon"=>"glyphicon glyphicon-download-alt")); 
        elseif($this->uri->segment(3) == "acompanhantes")
            $this->acoes_controller = array(array("url" => "administrativo/usuarios/exportar/4", "title" => "Exportar Acompanhantes", "class" => "btn btn-info","icon"=>"glyphicon glyphicon-download-alt")); 
        else
            $this->acoes_controller = array(array("url" => "administrativo/usuarios/exportar/3", "title" => "Exportar Convidados", "class" => "btn btn-info","icon"=>"glyphicon glyphicon-download-alt")); 

        foreach ($data as $key) {
            if ($key->status == "enable")
                $key->status = "Habilitado";
            elseif($key->status == "confirm_email")
                 $key->status = "Aguardando usuário confirmar email";
            elseif($key->status == "pendding")
                 $key->status = "Aguardando aprovação";
            elseif($key->status == "not_activated")
                 $key->status = "Não aprovado";
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
