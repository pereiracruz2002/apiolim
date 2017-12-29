<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Conta extends CI_Controller {

    var $data = array();

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect("chef/painel");
    }

    public function upgrade($upgrade = "nao") {
        if (!$this->session->userdata('user_upgrade'))
            redirect(SITE_URL . "login");

        $this->load->model('user_model', 'user');
        $this->load->model('user_info_model', 'user_info');

        $user = $this->session->userdata('user_upgrade');
        $info = $this->user_info->info($user->user_id);
        $this->data['user'] = (object) array_merge($info, (array) $user);
        $this->data['token'] = base64_encode($this->encrypt->encode($user->user_id));

        $this->data['jsFiles'] = array('assets/js/cadastro/upgrade.js');
        
        if ($upgrade == "nao") {
            $this->load->view("chef/message_upgrade", $this->data);
        } elseif ($upgrade == "sim") {
            $validation = array(
                array(
                    'field' => 'field_name',
                    'label' => 'Nome',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_lastname',
                    'label' => 'Sobrenome',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_sex',
                    'label' => 'Sexo',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_nascimento',
                    'label' => 'Data de nascimento',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_phone',
                    'label' => 'Telefone / Celular',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_cep',
                    'label' => 'CEP',
                    'rules' => 'required|min_length[8]'
                ),
                array(
                    'field' => 'field_city',
                    'label' => 'Cidade',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_state',
                    'label' => 'Estado',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_address',
                    'label' => 'Endereço',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_number',
                    'label' => 'Número',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'field_email',
                    'label' => 'E-mail',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => "O campo %s é obrigatório",
                        'is_unique' => "O E-mail informado já foi cadastrado"
                    )
                ),
                array(
                    'field' => 'field_confirm_email',
                    'label' => 'Confirmar e-mail',
                    'rules' => 'trim|required|matches[field_email]',
                    'errors' => array(
                        'required' => "O campo %s é obrigatório"
                    )
                ),
                array(
                    'field' => 'field_password',
                    'label' => 'Senha',
                    'rules' => 'trim|required|min_length[6]'
                ),
                array(
                    'field' => 'field_confirm',
                    'label' => 'Confirmar senha',
                    'rules' => 'trim|required|matches[field_password]|min_length[6]'
                ),
                array(
                    'field' => 'field_message',
                    'label' => 'Mensagem',
                    'rules' => 'trim|required|min_length[10]'
                ),
                array(
                    'field' => 'field_profession',
                    'label' => 'Profissão',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'field_formation',
                    'label' => 'Formação',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'field_license',
                    'label' => 'Termos de adesão',
                    'rules' => 'required'
                )
            );
            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view("site/upgrade", $this->data);
            } else {
                $user_id = $this->session->userdata('user_upgrade')->user_id;
                $where = array('user_id' => $user_id);
                $user = array(
                    'name' => $this->input->post('field_name'),
                    'lastname' => $this->input->post('field_lastname'),
                    'email' => $this->input->post('field_email'),
                    'password' => $this->encrypt->encode($this->input->post('field_password')),
                    'status' => 'pendding',
                    'user_type_id' => 2
                );
                $this->user->update($user, $where);
                
                $field_nascimento = explode("/", $this->input->post('field_nascimento'));
                $user_info = array(
                    'cep' => $this->input->post('field_cep'),
                    'endereco' => $this->input->post('field_address'),
                    'cidade' => $this->input->post('field_city'),
                    'estado' => $this->input->post('field_state'),
                    'numero' => $this->input->post('field_number'),
                    'complemento' => $this->input->post('field_complement'),
                    'telefone' => $this->input->post('field_phone'),
                    'sexo' => $this->input->post('field_sex'),
                    'codigo' => $this->input->post('field_code'),
                    'sobrevoce' => $this->input->post('field_about_you'),
                    'nascimento' => "{$field_nascimento[2]}-{$field_nascimento[1]}-{$field_nascimento[0]}",
                    'profissao' => $this->input->post('field_profession'),
                    'formacao' => $this->input->post('field_formation'),
                    'mensagem' => $this->input->post('field_message'),
                    'profissao' => $this->input->post('field_profession'),
                    'curriculo' => $this->input->post('field_curriculo'),
                    'requestChef' => "admin"
                );
                $this->user_info->delete($where);
                foreach ($user_info as $key => $item) {
                    $save_info = array(
                        'info_key' => $key,
                        'info_value' => $item,
                        'user_id' => $user_id
                    );
                    $this->user_info->save($save_info);
                }
                $user = array(
                    'user_id' => $user_id,
                    'name' => $this->input->post('field_name'),
                    'lastname' => $this->input->post('field_lastname'),
                    'email' => $this->input->post("field_email")
                );
                $data['user'] = (object) $user;
                $data = (object) $data;
                $this->sendPenddingEmail($user);
                $this->load->view('chef/pendding', $data);
            }
        }
    }

    protected function sendPenddingEmail($data) {
        if (is_array($data)) {
            $data = (object) $data;
        }
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from(EMAIL_FROM, 'Dinner for Friends');
        $this->email->to($data->email);
        $this->email->subject('Atualização de cadastro');
        $this->email->message($this->load->view("emails/templates/pendding_email", $data, TRUE));
        $this->email->send();
    }

    public function CancelUpgrade() {
        $this->session->unset_userdata('user_upgrade');
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array()));
    }

}
