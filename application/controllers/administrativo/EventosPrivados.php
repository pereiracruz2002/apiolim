<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class EventosPrivados extends BaseCrud {

    var $modelname = 'events'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/eventosPrivados';
    var $actions = 'URD';
    var $acoes_extras = array(); //array("url" => "methodo do controller", "title" => "texto que aparece", "class" => "classe do link")
    var $acoes_controller = array(); //array("url" => "methodo do controller", "title" => "texto que aparece", "class" => "classe do link")
    var $titulo = 'Eventos Privados';
    var $tabela = 'name,description,city,start';
    var $campos_busca = 'name';
    var $joins = array('user' => 'user.user_id=events.user_id AND events.private = 1');
    var $selects = "events.event_id, CONCAT(user.name,' ', user.lastname) as name, events.name as description, CONCAT(events.city,' - ', events.state, ' - ', events.neighborhood) as city, DATE_FORMAT(events.start, '%d/%m/%Y %H:%i') as start";

    public function __construct() {
        parent::__construct();
    }
    public function _filter_pre_listar(&$where, &$where_ativo) {
        $this->model->fields['name']['label'] = 'Chef';
        $this->model->fields['description']['label'] = 'Evento';
        $this->model->fields['city']['label'] = 'Local';
        $this->model->fields['private']['label'] = 'Tipo';
        $where['events.status !='] = "deleted";
    }
    
    public function editar($id, $ok = NULL) {
        $this->load->model('event_types_model', 'event_type');
        $token = base64_encode($this->encrypt->encode($this->session->userdata("admin")->user_id));
        $out['token'] = $token;
        $out['id'] = $id;
        
        if (!$this->session->userdata('admin')) {
            redirect('/');
        }

        $c = & $this;
        $model = $this->_model();
        $crud = $this->_crud();

        if (!in_array('U', $crud)) {
            redirect($this->base_url);
        }

        $event = $model->get($id)->row();
        $info = $model->info($event->event_id);
        
        $out['event'] = $event;
        $out['info'] = $info;

        $out['jsFiles'] = array('eventos.js', 'editar_evento.js', 'bootstrap-datepicker.min.js');

        if ($out['event']->private == 0) {
            $out['event_type'] = $this->event_type->info(array('private' => 0));
            $this->load->view('administrativo/form_editar_evento', $out);
        } else if ($out['event']->private == 1) {
            $out['event_type'] = $this->event_type->info(array('private' => 1));
//            echo "<pre>";
//            print_r($out);
            $this->load->view('administrativo/form_editar_evento_privado', $out);
        }
    }

}
