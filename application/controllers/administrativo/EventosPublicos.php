<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class EventosPublicos extends BaseCrud {

    var $modelname = 'events'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/eventosPublicos';
    var $actions = 'CRUD';
    var $acoes_extras= array(array('url' => 'administrativo/eventosPublicos/cuponsUtilizados', 'title' => 'Cupons Utilizados', 'class' => 'btn-primary'));
    var $titulo = 'Eventos Públicos';
    var $tabela = 'description,event_name,city,start,code';
    var $campos_busca = 'name';
    var $joins = array('user' => 'user.user_id=events.user_id AND events.private = 0', 'event_types' => "events.event_type_id=event_types.event_type_id");
    var $selects = "events.event_id, CONCAT(user.name,' ', user.lastname) as name, events.name as description, CONCAT(events.city,' - ', events.state, ' - ', events.neighborhood) as city, DATE_FORMAT(events.start, '%d/%m/%Y %H:%i') as start, events.code, event_types.name as event_name";


    public function __construct() {
        parent::__construct();
    }

    public function novo() {
        $token = base64_encode($this->encrypt->encode($this->session->userdata("admin")->user_id));
        $this->data['token'] = $token;
        
        $this->load->model('event_types_model', 'event_type');
        $this->data['event_type'] = $this->event_type->info(array('private' => 0));
        
        $this->data['jsFiles'] = array('eventos.js', 'evento_novo.js', 'bootstrap-datepicker.min.js');
        $this->load->view('administrativo/form_novo_evento', $this->data);
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

        $out['jsFiles'] = array('eventos.js','editar_evento.js', 'bootstrap-datepicker.min.js');

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


    public function _filter_pre_delete(&$data) {
        $this->db->where('event_id', $data);
        if($this->db->update('events', array('status' => 'deleted'))) {
            echo "ok";
        } else {
            echo "erro ao deletar registro";
        }
        exit();
    }
    
    public function _filter_pre_listar(&$where, &$where_ativo) {
        $this->model->fields['name']['label'] = 'Chef';
        $this->model->fields['description']['label'] = 'Evento';
        $this->model->fields['city']['label'] = 'Local';
        $this->model->fields['code']['label'] = 'Cód. Ativação';
        $this->model->fields['event_name']['label'] = 'Tipo de evento';
        $where['events.status !='] = "deleted";
    }

    public function cuponsUtilizados($event_id) 
    {
        $this->load->model('event_cupom_user_model', 'event_cupom_user');
        $this->load->model('events_model','event');
        $where = array('event_cupom.event_id' => $event_id);

        $this->db->select("event_cupom_user.data, event_cupom.event_cupom_id, event_cupom.cupom, CONCAT(user.name,' ', user.lastname) as nome, user.email")
                 ->join('event_cupom', 'event_cupom.event_cupom_id=event_cupom_user.event_cupom_id')
                 ->join('user', 'user.user_id = event_cupom_user.user_id');
        $this->data['descontos'] = $this->event_cupom_user->get_where($where)->result();
        $this->data['evento'] = $this->event->get($event_id)->row();
        $this->db->select("event_cupom.event_cupom_id, event_cupom.cupom")
                ->join('events', 'events.event_id=event_cupom.event_id');
        $this->data['cupons'] = $this->db->get_where('event_cupom', array('event_cupom.event_id' => $event_id))->result();
        
        /*echo "<pre>";
        print_r($this->data);*/
        $this->load->view('administrativo/cuponsUtilizados', $this->data);
    }
}
