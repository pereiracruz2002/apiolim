<?php

class Painel extends CI_Controller
{
    var $data = array();
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect('/administrativo/login');
        }
    }
    
    function index()
    {
        $this->load->model('events_model','events');
        $this->load->model('event_types_model','event_types');
        $this->load->model('user_model','users');

        $this->db->join('event_types', 'event_types.event_type_id=events.event_type_id');
        $this->data['avg_num_users'] = $this->events->getAvg('num_users', array('event_types.private' => 1));

        $this->data['avg_events_users_confirmed'] = $this->events->getAvgConfirmed();
        $this->data['avg_invites'] = $this->events->getAvgInvites();
        $this->data['avg_payments'] = $this->events->getAvgPayments();

        $this->data['ranking_chef_eventos'] = $this->users->rankingChefsEventos();
        $this->data['ranking_convidados_eventos'] = $this->users->rankingConvidadosEventos();
        $result_categorias_privadas = $this->event_types->ranking(array('private' => 1));
        $this->data['ranking_categorias'] = array();
        foreach ($result_categorias_privadas as $item) {
            $this->data['ranking_categorias'][$item->name] = (int) $item->total;
        }

        $select = "(SELECT COUNT(*) FROM events WHERE status='enable' AND event_type_id = ID AND start <= '".date('Y-m-d H:i:s')."' AND end >= '".date('Y-m-d H:i:s')."') as em_andamento";
        $this->data['ranking_publicos'] = $this->event_types->ranking(array('private' => 0), $select);
        
        $this->data['ranking_publicos_cidades'] = $this->events->rankingCity(array('event_types.private' => 0));

        $select = "(SELECT COUNT(*) FROM events WHERE status='enable' AND event_type_id = ID AND start <= '".date('Y-m-d H:i:s')."' AND end >= '".date('Y-m-d H:i:s')."') as em_andamento";
        $this->data['ranking_privados'] = $this->event_types->ranking(array('private' => 1), $select);

        $this->data['ranking_privados_cidades'] = $this->events->rankingCity(array('event_types.private' => 1));
        $this->data['ranking_publicos_cidades'] = $this->events->rankingCity(array('event_types.private' => 0));
        
        $this->data['ranking_cidades'] = array();
        foreach ($this->data['ranking_privados_cidades'] as $item) {
            foreach ($item['cidades'] as $cidade => $total) {
                if(!isset($this->data['ranking_cidades'][$cidade])){
                    $this->data['ranking_cidades']['privados'][$cidade] = $total;
                } else {
                    $this->data['ranking_cidades']['privados'][$cidade] += $total;
                }
            }
        }
        
        foreach ($this->data['ranking_publicos_cidades'] as $item) {
            foreach ($item['cidades'] as $cidade => $total) {
                if(!isset($this->data['ranking_cidades'][$cidade])){
                    $this->data['ranking_cidades']['publicos'][$cidade] = $total;
                } else {
                    $this->data['ranking_cidades']['publicos'][$cidade] += $total;
                }
            }
        }
        
        //$this->data['users_register'] = $this->users->getQtdPerMonth();
        $this->data['users_register'] = $this->users->getQtdUsers();
        $this->data['users_sexo']['chef'] = $this->users->getQtdSexoChef();
        $this->data['users_sexo']['guest'] = $this->users->getQtdSexoGuest();
        
        $this->data['cssFiles'] = array('MonthPicker.css', 'jquery-ui.css');
        $this->data['jsFiles'] = array('bootstrap-datepicker.min.js', 'jquery.maskedinput.min.js', 'jquery-ui.min.js', 'MonthPicker.js');
        $this->data['token'] = base64_encode($this->encrypt->encode($this->session->userdata("admin")->user_id));
        $this->load->view('administrativo/painel', $this->data);
    }
    
    public function getAnnualUserRegisters()
    {
        $this->load->model('user_model','users');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        if ($this->session->userdata("admin")->user_id == $user_id) {
            $this->data['users_register'] = $this->users->getQtdUsers();
            $this->data['labels'] = json_encode(array_keys(end($this->data['users_register'])), JSON_OBJECT_AS_ARRAY);
        } else {
            $this->data = array(
                'status' => 'error',
                'msg' => 'Você não tem permissão.'
            );
        }
        
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($this->data));
    }
    
    public function getMonthlyUserRegisters()
    {
        $this->load->model('user_model','users');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        if ($this->session->userdata("admin")->user_id == $user_id) {
            $this->data['users_register'] = $this->users->getQtdUsers($this->input->post('month'));
        } else {
            $this->data = array(
                'status' => 'error',
                'msg' => 'Você não tem permissão.'
            );
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($this->data));
    }
}
