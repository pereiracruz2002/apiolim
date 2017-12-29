<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Evento extends CI_Controller
{
    var $data = array();

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('login');
        }
        
        $this->load->model('chef_model', 'chef');
        $user_id = $this->session->userdata('user')->user_id;
        $this->data['user'] = array('picture' => $this->chef->info($user_id)['picture']);
    }

    public function index() 
    {
        $this->load->model('events_model','events');
        $this->load->model('chef_model', 'chef');
        
        $user_id = $this->session->userdata('user')->user_id;
        $this->data['user'] = array('picture' => $this->chef->info($user_id)['picture']);
        
        $this->data['page_title'] = 'ÁREA DO CHEF';
        
        $where_publicados['user_id'] = $this->session->userdata('user')->user_id;
        $where_publicados['start >='] = date("Y-m-d H:i:s");
        $where_publicados['status'] = 'enable';
        
        $where_salvos['user_id'] = $this->session->userdata('user')->user_id;
        $where_salvos['status'] = 'incomplete';

        $where_anteriores['user_id'] = $this->session->userdata('user')->user_id;
        $where_anteriores['start <'] = date("Y-m-d H:i:s");
        $where_anteriores['status'] = 'enable';

        $this->data['eventos'] = array();
        $this->data['eventos']['publicados'] = $this->events->get_where($where_publicados)->result();
        $this->data['eventos']['salvos'] = $this->events->get_where($where_salvos)->result();
        $this->data['eventos']['anteriores'] = $this->events->get_where($where_anteriores)->result();
        
        $this->load->view('chef/painel', $this->data);
    }


    public function pagamento()
    {
        $this->load->model('payments_events_model','payments_events');
        $this->load->model('events_model','events');
        $dados_pagseguro = $this->input->posts();
        $this->load->library("lib_apipagseguroevento");
        $dados_pagseguro['notificationURL'] = SITE_URL.'api/evento/notificacao';
        $this->lib_apipagseguroevento->redirectURL = SITE_URL.'chef/evento/novo'.$dados_pagseguro['itemId1'];
        $save_payment = array(
            'user_id' => $this->session->userdata('user')->user_id,
            'event_id' => $dados_pagseguro['itemId1'],
            'price' => number_format($dados_pagseguro['itemAmount1'],2, '.',''),
            'status' => 'Aguardando Pagto'
        );

        $save['event_id'] = $dados_pagseguro['itemId1'];
        $save['status_payment'] = 'Aguardando Pagto';
        $this->events->save($save);
        $dados_pagseguro['payment_id'] = $this->payments_events->save($save_payment);
        $this->lib_apipagseguroevento->novaCompra($dados_pagseguro);
    }



    
    public function novo($event_id = false) 
    {

        $this->data['event_id'] = $event_id;
        $this->data['user_id'] = base64_encode($this->encrypt->encode($this->session->userdata('user')->user_id));
        $this->data['page_title'] = 'Novo Evento';
                
        $this->load->model('events_model','events');
        $this->load->model('event_types_model','event_types');
        $this->load->model('event_types_other_model','event_type_other');
        $this->load->model('event_info_types_model','event_info_types');
        $this->load->model('event_infos_model','event_infos');
        $this->load->model('user_model','user');
        $this->load->model('rates_model','rates');
        $this->load->model('free_invitation_model','free');

        $user = $this->user->get($this->session->userdata('user')->user_id)->row();
        
        $this->data['amigos'] = $this->user->getFriends($this->session->userdata('user')->user_id);
        $this->data['tipos'] = $this->event_types->get_where(array('private' => 1))->result();
      
        $this->data['usuario'] = $user;
        
        $this->data['menu'] = $this->event_info_types->get_all()->result();
        
        if ($event_id != false ) {
            $this->data['event'] = $this->events->info($event_id);
            $this->data['event_type_other'] = $this->event_type_other->info($event_id);
            if (count($this->data['event_type_other']) == 0) unset($this->data['event_type_other']);
            if (isset($this->data['event']['menu'])) {
                $this->data['menu'] = $this->data['event']['menu'];
                unset($this->data['event']['menu']);
            }
        }
        $this->data['rates'] = $this->rates->get_all()->row();
        $this->data['free']  = $this->free->get_all()->row();
        if($user->rate){
            $this->data['rates']->rate_global = $user->rate;
        }
        
        $this->data['jsFiles'] = array('chef/lightslider.js', 'chef/eventos.js', 'bootstrap-datepicker.min.js', 'jquery.maskMoney.min.js');
        $this->data['cssFiles'] = array('lightslider.css', 'bootstrap-datepicker3.min.css');
        
        if (isset($this->data['event']) && $this->data['event']['status'] == "enable") {
            redirect("chef/evento/editar/{$event_id}");
        } else {
            $this->load->view('chef/evento_novo', $this->data);
        }
    }

    public function editar($event_id, $save = null)
    {
        $this->load->model('events_model','events');
        $this->load->model('event_types_model','event_types');
        $this->load->model('event_types_other_model','event_type_other');
        $this->load->model('event_info_types_model','event_info_types');
        $this->load->model('event_infos_model','event_infos');
        $this->load->model('user_model','user');
        
        if($this->input->posts()){
            $save_event = $this->input->posts();
            $save_event['start'] = $this->input->post('start'). ' '.$this->input->post('start_hour');
            unset($save_event['event_info'], $save_event['start_hour']);
            $this->events->update($save_event, $event_id);

            $save_info = array();
            foreach ($this->input->post('event_info') as $event_info_type_id => $item) {
                $save_info[] = array(
                    'event_id' => $event_id,
                    'event_info_type_id' => $event_info_type_id,
                    'info_value' => $item
                    );
            }
            $this->event_infos->delete(array('event_id' => $event_id));
            $this->db->insert_batch('event_infos', $save_info);
            $this->data['save'] = true;
        }
        
        if ($save != null) {
            $this->data['save'] = true;
        }

        //$where['events.user_id'] = $this->session->userdata('user')->user_id;
        $this->data['evento'] = $this->events->info($event_id);
        $this->data['event_type_other'] = $this->event_type_other->info($event_id);
        if (count($this->data['event_type_other']) == 0) unset($this->data['event_type_other']);
        $this->data['page_title'] = $this->data['evento']['name'];
        $this->data['tipos'] = $this->event_types->get_where(array('private' => 1))->result();
        $this->data['user_id'] = base64_encode($this->encrypt->encode($this->session->userdata('user')->user_id));
        $extras = $this->event_info_types->get_all()->result();
        $extras = array_replace(array_flip(array(4, 0, 5, 1, 6, 2, 3, 7)), $extras);
        $this->data['extras'] = array();
        
        foreach ($extras as $item) {
            $info = $this->event_infos->get_where(array('event_infos.event_id' => $event_id, 'event_info_type_id' => $item->event_info_type_id))->row();
            $value = ($info ? $info->info_value : '');
            $this->data['extras'][$item->event_info_type_id] = array('label' => $item->name, 'value' => $value);
        }

        $this->data['users_convidados'] = array();
        foreach ($this->data['evento']['guests'] as $user_id => $item) {
            $this->data['users_convidados'][] = $user_id;
        }

        $this->data['amigos'] = $this->user->getFriends($this->session->userdata('user')->user_id);
        $this->data['jsFiles'] = array('chef/lightslider.js');
        $this->data['cssFiles'] = array('lightslider.css');

//        echo "<pre>";
//        print_r($this->data);
//        exit();
        if (isset($this->data['evento']) && $this->data['evento']['status'] == "enable") {
            $this->load->view('chef/evento_editar', $this->data);
        } else {
            redirect("chef/evento/novo/{$event_id}");
        }
    }

    public function addFoto($event_id=false) 
    {
        if($event_id){
            $this->load->model('events_model','events');
            $where = array(
                'event_id' => $event_id,
                'user_id' => $this->session->userdata('user')->user_id
                );
            $event = $this->events->get_where($where)->row();
            if(!$event){
                redirect('chef/painel');
            }
        }
        $config['upload_path'] = FCPATH.'uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['encrypt_name'] = true;
          
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('picture')) {
            $this->data['error'] = $this->upload->display_errors(); 
        } else { 
            $upload_data = $this->upload->data();

            $config_img['image_library'] = 'gd2';
            $config_img['source_image'] = $upload_data['full_path'];
            $config_img['maintain_ratio'] = TRUE;
            $config_img['width']  = 500;
            $config_img['master_dim'] = 'width';

            $this->load->library('image_lib', $config_img);
            $this->image_lib->resize();

            $output['upload_data']['href'] = SITE_URL.'uploads/'.$upload_data['file_name'];
            if($event_id){
                $this->load->model('event_gallery_model','event_gallery');
                $save['event_id']=$event_id;
                $save['picture'] = $upload_data['file_name'];
                $this->event_gallery->save($save);
                $this->data['save'] = true;
            }
        } 
        $this->editar($event_id);

    }

    public function convidar($evento, $convidado)
    {
        $this->load->model('User_model', 'user');
        $this->load->library('lib_onesignal');

        $user_id = $this->session->userdata('user')->user_id;
        $dados_evento = $this->db->where("event_id",$evento)->get("events")->row();
        $dados_convidado = $this->user->getUserInfo(array('user_id' => $convidado));
        $quantidadeConvitePossiveis = $dados_evento->num_users;
        $quantidadeJaConvidadosEvento = $this->db->where("event_id", $evento)->where("status", 'confirmed')->get("event_guests")->num_rows();
        $query_convidados = $this->db->query("SELECT count(event_guest_id) as confirmados FROM event_guests WHERE event_id={$evento} AND status='confirmed'");
        $result_convidados = $query_convidados->result_array();
        $quantidadeJaConvidadosEvento = $result_convidados[0]['confirmados'];
        
        $data = (object) array();
        $data->convidado = $dados_convidado;
        $data->evento = $dados_evento;

        $output = array();
        
        if($quantidadeConvitePossiveis > $quantidadeJaConvidadosEvento){
            $dadosParaInsert = array(
                'event_id' => $evento,
                'user_id' => $convidado,
                'status' => "invited",
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert("event_guests",$dadosParaInsert);

            $this->db->select("user.*");
            $this->db->from("user");
            $this->db->join("friends","friends.friend_id = user.user_id");
            $this->db->where("friends.friend_id not in (select user_id from event_guests where event_id = {$evento})",null,false);
            $this->db->where("friends.user_id",$user_id);
            $resultadoNaoConvidados = $this->db->get()->result();

            $this->db->select("user.*");
            $this->db->from("user");
            $this->db->join("friends","friends.friend_id = user.user_id");
            $this->db->where("friends.friend_id in (select user_id from event_guests where event_id = {$evento})",null,false);
            $this->db->where("friends.user_id",$user_id);
            $resultadoConvidados = $this->db->get()->result();

            $output["status"] = "success";
            $output["listaConvidados"] = $resultadoConvidados;
            $output["listaNaoConvidados"] = $resultadoNaoConvidados;
            
            $this->sendEmailFromGuest($data);

            $msg = 'Você foi convidado para o evento '.$data->evento->name;
            $this->lib_onesignal->send(array($data->convidado->onesignal_userid), $msg);

        }else{
            $output["status"] = "error";
            $output["msg"] = "Evento já alcançou o maximo de convites possiveis";
        }
        $output['dados_evento'] = $dados_evento;
        $output['dados_convidado'] = $dados_convidado;
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($output));
    }
    
    protected function sendEmailFromGuest($data)
    {
        $this->load->library('email');
        
        $this->email->from(EMAIL_FROM, "Dinner for Friends");
        $this->email->to($data->convidado->email);
        $this->email->subject("Convite para participar do evento {$data->evento->name}");
        
        $header = $this->load->view("emails/templates/header", $data, TRUE);
        $body = $this->load->view("emails/templates/convite_evento", $data, TRUE);
        $footer = $this->load->view("emails/templates/footer", $data, TRUE);

        $this->email->message("{$header}{$body}{$footer}");
        if ($this->email->send()) {
            return true;
        }
        return false;
    }

}
