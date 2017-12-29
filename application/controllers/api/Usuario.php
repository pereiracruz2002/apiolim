<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;

FacebookSession::setDefaultApplication(FB_ID, FB_SECRET);

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
    }

    public function checkCode() {
        $this->load->model('invite_codes_model', 'invites_codes');
        $this->load->model('invite_codes_friends_model', 'invites_codes_friends');
        $where['code'] = $this->input->post('codigo');
        $where['status'] = 'pending';

        $output['invite'] = $this->invites_codes->get_where($where)->row();
        if ($output['invite']) {
            $output['status'] = 'success';
        } else {
            $where_friends['code'] = $this->input->post('codigo');
            $where_friends['status'] = 'pending';
            $output['invite'] = $this->invites_codes_friends->get_where($where_friends)->row();
            if ($output['invite']) {
                $output['status'] = 'success';
            } else {
                $output['status'] = 'error';
                $output['msg'] = 'Código não encontrado';
            }
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function info() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        $this->load->model('user_model', 'user');
        $this->load->model('categories_model', 'categories');
        $this->db->select("user.user_id,
            user.username,
            user.email,
            user.name,
            user.lastname,
            CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
            user.facebook_id,
            user.user_type_id,
            user_info.info_key,
            user_info.info_value
            ")->join('user_info', 'user_info.user_id=user.user_id', 'left');
        $usuario = $this->user->get($user_id)->result_array();

        $output = array();
        foreach ($usuario as $item) {
            if (!$output) {
                if (strstr($item['picture'], 'user_default.png') and $item['facebook_id']) {
                    $item['picture'] = 'https://graph.facebook.com/' . $item['facebook_id'] . '/picture?type=square';
                }
                $output = $item;
            }
            if (!isset($output['extra'])) {
                $output['extra'] = array();
            }
            if ($item['info_key']) {
                if ($item['info_key'] == 'category_id') {
                    $this->db->select('name');
                    $category = $this->categories->get($item['info_value'])->row();
                    $output['extra']['especialidades'][] = $category->name;
                } else if ($item['info_key'] == 'picture' or $item['info_key'] == 'cover') {
                    $output['extra'][$item['info_key']] = (strstr($item['info_value'], 'http') ? '' : SITE_URL . 'uploads/') . $item['info_value'];
                }else {
                    $output['extra'][$item['info_key']] = $item['info_value'];
                }
            }
            unset($output['info_key'], $output['info_value']);
        }
        
        if (isset($output['extra']['endereco']))
            $output['extra']['formated_address'] = $output['extra']['endereco'];
        if (isset($output['extra']['bairro']))
            $output['extra']['formated_address'] .= " - {$output['extra']['bairro']}";
        if (isset($output['cidade']))
            $output['extra']['formated_address'] .= ", {$output['cidade']}";
        if (isset($output['estado']))
            $output['extra']['formated_address'] .= " - {$output['estado']}";

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function buscaAmigoEvento() {
        $convidado = $this->input->post("convidado");

        $evento = $this->input->post("evento");

        $this->db->select("user.*,event_guests.*");
        $this->db->from("user");
        $this->db->join("event_guests", "event_guests.user_id = user.user_id");
        $this->db->where("event_guests.event_id", $evento);
        $this->db->where("event_guests.user_id", $convidado);
        $resultado = $this->db->get()->row();

        $output["status"] = "success";
        $output["usuario"] = $resultado;

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function lembrarSenha() {
        $email = $this->input->post("email");
        $buscaUser = $this->db->where("email", $email)->get("user");
        if ($buscaUser->num_rows() > 0) {
            $usuario = $buscaUser->row();
            $senhaCript = $usuario->password;
            $senha = $this->encrypt->decode($usuario->password);
            $para = $usuario->email;
            $msg = "<h1>Recuperação de senha Chef Amigo</h1>";
            $msg .= "<p><strong>Senha:</strong>" . $senha . "</p>";

            $this->load->library('email');
            $this->email->from(EMAIL_FROM, 'Recuperação de senha Chef Amigo');
            $this->email->to($para);
            $this->email->subject('Recuperação de senha Chef Amigo');
            $this->email->message($msg);

            if ($this->email->send()) {
                $output["status"] = "success";
                $output["msg"] = "Sua senha foi enviada para o e-mail cadastrado";
            } else {
                //echo $this->email->print_debugger();
                //exit();

                $output["status"] = "error";
                $output["msg"] = "Não foi possivel enviar e-mail no momento";
                $output["debug"] = $this->email->print_debugger();
            }
        } else {
            $output["status"] = "error";
            $output["msg"] = "E-mail não encontrado no sistema";
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function listagemUsuariosNaoConvidados() {
        $evento = $this->input->post("evento");
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $this->db->select("user.*");
        $this->db->from("user");
        $this->db->join("friends", "friends.friend_id = user.user_id");
        $this->db->where("friends.friend_id not in (select user_id from event_guests where event_id = {$evento})", null, false);
        $this->db->where("friends.user_id", $user_id);
        $resultado = $this->db->get();

        $listagem = $resultado->result();
        $output["status"] = "success";
        $output["listagem"] = $listagem;

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function listagemUsuariosConvidados() {

        $evento = $this->input->post("evento");
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $this->db->select("user.*");
        $this->db->from("user");
        $this->db->join("friends", "friends.friend_id = user.user_id");
        $this->db->where("friends.friend_id in (select user_id from event_guests where event_id = {$evento})", null, false);
        $this->db->where("friends.user_id", $user_id);
        $resultado = $this->db->get();

        $listagem = $resultado->result();
        foreach ($listagem as $item) {
            if (strstr($item->picture, 'user_default.png') and $item->facebook_id) {
                $item->picture = 'https://graph.facebook.com/' . $item->facebook_id . '/picture?type=square';
            }
        }
        $output["status"] = "success";
        $output["listagem"] = $listagem;

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function convidar() {
        $convidado = $this->input->post("convidado");
        $evento = $this->input->post("evento");
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $dados_evento = $this->db->where("event_id", $evento)->get("events")->row();

        $quantidadeConvitePossiveis = $dados_evento->num_users;

        $quantidadeJaConvidadosEvento = $this->db->where("event_id", $evento)->get("event_guests")->num_rows();

        if ($quantidadeConvitePossiveis > $quantidadeJaConvidadosEvento) {

            $dadosParaInsert = array(
                'event_id' => $evento,
                'user_id' => $convidado,
                'status' => "invited",
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert("event_guests", $dadosParaInsert);

            $this->db->select("user.*");
            $this->db->from("user");
            $this->db->join("friends", "friends.friend_id = user.user_id");
            $this->db->where("friends.friend_id not in (select user_id from event_guests where event_id = {$evento})", null, false);
            $this->db->where("friends.user_id", $user_id);
            $resultadoNaoConvidados = $this->db->get()->result();

            $this->db->select("user.*");
            $this->db->from("user");
            $this->db->join("friends", "friends.friend_id = user.user_id");
            $this->db->where("friends.friend_id in (select user_id from event_guests where event_id = {$evento})", null, false);
            $this->db->where("friends.user_id", $user_id);
            $resultadoConvidados = $this->db->get()->result();

            $output = array();
            $output["status"] = "success";
            $output["listaConvidados"] = $resultadoConvidados;
            $output["listaNaoConvidados"] = $resultadoNaoConvidados;
        } else {
            $output["status"] = "error";
            $output["msg"] = "Evento já alcançou o maximo de convites possiveis";
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function convidarLista() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $evento = $this->input->post("evento");

        $this->db->select("user.*");
        $this->db->from("user");
        $this->db->join("friends", "friends.friend_id = user.user_id");
        $this->db->where("friends.friend_id not in (select user_id from event_guests where event_id = {$evento})", null, false);
        $this->db->where("friends.user_id", $user_id);
        $resultadoNaoConvidadosTable = $this->db->get();

        $quantidadeDeAmigosDisponiveis = $resultadoNaoConvidadosTable->num_rows();
        $resultadoNaoConvidados = $resultadoNaoConvidadosTable->result();
        $dados_evento = $this->db->where("event_id", $evento)->get("events")->row();
        $quantidadeConvitePossiveis = $dados_evento->num_users;
        $contador = 1;
        $quantidadeJaConvidadosEvento = $this->db->where("event_id", $evento)->get("event_guests")->num_rows();
        $quantidadeSobrando = $quantidadeConvitePossiveis - $quantidadeJaConvidadosEvento;
        if ($quantidadeDeAmigosDisponiveis > 0) {

            if ($quantidadeSobrando > 0) {
                foreach ($resultadoNaoConvidados as $convidado) {
                    if ($contador > $quantidadeConvitePossiveis) {
                        break;
                    } else {
                        $dadosParaInsert = array(
                            'event_id' => $evento,
                            'user_id' => $convidado->user_id,
                            'status' => "invited",
                            'updated_at' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert("event_guests", $dadosParaInsert);
                    }
                    $contador++;
                }
                $contador -= 1;

                $output["status"] = "success";
                $output["msg"] = "Sucesso foram convidados {$contador} amigos";
            } else {
                $output["status"] = "error";
                $output["msg"] = "No momento todos os convites para esse evento foram preenchidos";
            }
        } else {
            $output["status"] = "error";
            $output["msg"] = "Nenhum amigo para ser convidado no momento";
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function convidarPorEmail() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $email = $this->input->post("email");
        $evento = $this->input->post("event");

        $codigo = rand(11111111, 99999999);

        $dados = array(
            'code' => $codigo,
            'email' => $email,
            'event_id' => $evento
        );

        $this->db->insert("invite_codes", $dados);

        $para = $email;
        $msg = "<h1>Convite de partição Chef Amigo</h1>";
        $msg .= "<p><strong>Codigo:</strong>" . $codigo . "</p>";

        $this->load->library('email');
        $this->email->from(EMAIL_FROM, 'Convite de partição Chef Amigo');
        $this->email->to($para);
        $this->email->subject('Convite de partição Chef Amigo');
        $this->email->message($msg);

        if ($this->email->send()) {

            $output["status"] = "success";
            $output["msg"] = "Convite foi enviado com sucesso";
        } else {
            echo $this->email->print_debugger();
            exit();

            //$output["status"]="error";
            //$output["msg"] = "Não foi possivel enviar e-mail no momento";
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function procurar() {

        $dataAtual = date('Ymd');

        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $this->load->model('user_model', 'users');
        $this->db->select("user.user_type_id,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           user.user_id as userID,
                           user.facebook_id,
                           DATE_FORMAT(`user`.`create_time`,'%Y%m%d') as cadastro,
                           CONCAT(YEAR(`user`.`create_time`),'',MONTH(`user`.`create_time`),'',DAY(`user`.`create_time`)) as cadastro
                           ")
                ->select("(SELECT FLOOR(DATEDIFF(DATE(" . $dataAtual . "), DATE(cadastro))/7)) as semanas", false)
                ->select("(SELECT STR_TO_DATE((REPLACE((SELECT `user_info`.`info_value` FROM `user_info` WHERE `user_info`.`info_key`='nascimento' AND  `user_info`.`user_id` =userID),'/','-')),'%Y-%m-%d')) as nascimento", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='sobrevoce' AND user_info.user_id =userID) as sobrevoce", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='profissao' AND user_info.user_id =userID) as profissao", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='pratopreferido' AND user_info.user_id =userID) as pratopreferido", false)
                ->select("(SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(nascimento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(nascimento, '00-%m-%d'))) as age", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = userID and status='accepted') as isFriend", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = userID and status='pendding') as isPending", false)
                ->group_start()
                ->like('name', $this->input->post('q'))
                ->or_like('lastname', $this->input->post('q'))
                ->or_like('email', $this->input->post('q'))
                ->group_end();
        $users = $this->users->get_where(array('status' => 'enable', 'user_id !=' => $user_id))->result();

        $output = array();
        foreach ($users as $item) {
            if (strstr($item->picture, 'user_default.png') and $item->facebook_id) {
                $item->picture = 'https://graph.facebook.com/' . $item->facebook_id . '/picture?type=square';
            }

            $item->totalComum = $this->users->totalComum($user_id, $item->userID);
            $output[] = $item;
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function genUsername($name, $i = null) {
        $user = false;
        do {
            $username = url_title($name, '-', true);
            $i = rand(0, 99999);
            $where = array('username' => $username . $i);
            $user = $this->user->get_where($where)->row();
        } while ($user);

        return $username . $i;
    }

    public function atualizarinfo() {
        $this->load->model('user_model', 'user');
        $this->load->model('user_info_model', 'user_info');

        $fields = ($this->input->post('fields'));
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));

        foreach ($fields as $field) {
            if (isset($field['key']) && isset($field['value'])) {
                $update_fields['info_value'] = $field['value'];
                $where = array(
                    'user_info_id' => $field['key'],
                    'user_id' => $user_id
                );
                $this->user_info->update($update_fields, $where);
            }
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode('ok'));
    }

    public function atualizar() {
        $this->load->model('user_model', 'user');

        $fields = ($this->input->post('fields'));
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));

        $where = array(
            'user_id' => $user_id
        );
        foreach ($fields as $field) {
            if (isset($field['key']) && isset($field['value'])) {
                $update = array($field['key'] => $field['value']);
                $this->user->update($update, $where);
            }
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode('ok'));
    }

    public function adicionarinfo() {
        $this->load->model('user_info_model', 'user_info');

        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        $fields = $this->input->post('fields');
        $status = array();

        foreach ($fields as $key => $field) {
            $field['user_id'] = $user_id;
            if (!$this->db->insert('user_info', $field))
                $status[] = "erro";
        }
        if (count($status) > 0)
            $this->output->set_content_type('application/json')
                    ->set_output(json_encode('erro'));
        else
            $this->output->set_content_type('application/json')
                    ->set_output(json_encode('ok'));
    }

    public function editar() {
        $this->load->model('user_model', 'user');
        $this->load->model('user_info_model', 'user_info');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        $user_save['name'] = $this->input->post('name');
        $user_save['lastname'] = $this->input->post('lastname');
        $output['status'] = 'sucesso';

        if ($this->checkEmail($this->input->post('email'), $user_id)) {
            $user_save['email'] = $this->input->post('email');

            if ($this->input->post('new_picture')) {
                $this->load->helper('file');
                $picture_name = date('YmdHis') . uniqid() . '.jpg';
                if (write_file(FCPATH . 'uploads/' . $picture_name, base64_decode(str_replace('data:image/jpeg;base64,', '', $this->input->post('new_picture'))))) {
                    $user_save['picture'] = $picture_name;
                }
            }

            if ($this->input->post('password')) {
                $user_save['password'] = $this->encrypt->encode($this->input->post('password'));
            }

            $this->user->update($user_save, $user_id);

            $extra = $this->input->post('extra');
            unset($extra['formated_address']);
            $extra['nascimento'] = date("Y-m-d", strtotime($extra['nascimento']));
            
            foreach ($extra as $field => $value) {
                $this->user_info->delete(array('info_key' => $field), array('user_id', $user_id));
                $this->user_info->save(array('info_key' => $field, 'info_value' => $value, 'user_id' => $user_id));
            }
            
            $output['status'] = 'sucesso';
            $output['msg'] = 'Dados alterados com sucesso';
        } else {
            $output['status'] = 'erro';
            $output['msg'] = 'Esse email já está sendo usado por outra pessoa';
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    private function checkEmail($email, $user_id) {
        $where['email'] = $email;
        $where['user_id !='] = $user_id;
        $user = $this->user->get_where($where)->row();
        if ($user) {
            return false;
        } else {
            return true;
        }
    }

    public function register() {
        $this->load->model('user_model', 'user');
        $this->load->model('user_info_model', 'user_info');
        $this->load->model('invite_codes_model', 'invite_codes');
        $this->load->model('invite_codes_friends_model', 'invite_codes_friends');
        $this->load->model('event_guests_model', 'event_guests');
        $this->load->model('user_notifications_config_model', 'user_notifications_config');

        $where_user = array('email' => $this->input->post('email'));
        $user = $this->user->get_where($where_user)->row();
        if (!$user) {
            $save_user = array(
                'name' => $this->input->post('name'),
                'lastname' => $this->input->post('lastname'),
                'username' => $this->genUsername($this->input->post('name') . ' ' . $this->input->post('lastname')),
                'email' => $this->input->post('email'),
                'password' => $this->encrypt->encode($this->input->post('password')),
                'status' => 'confirm_email',
                'user_type_id' => 3 //ID type usuário
            );
            if ($this->input->post('picture')) {
                $this->load->helper('file');
                $picture_name = date('YmdHis') . uniqid() . '.jpg';
                if (write_file(FCPATH . 'uploads/' . $picture_name, base64_decode(str_replace('data:image/jpeg;base64,', '', $this->input->post('picture'))))) {
                    $save_user['picture'] = $picture_name;
                }
            }

            $user_id = $this->user->save($save_user);

            $data = (object) array();
            $data->name = $this->input->post('name');
            $data->lastname = $this->input->post('lastname');
            $data->email = $this->input->post('email');
            $data->user_id = $user_id;
            $this->sendConfirmarEmail($data);

            $output = array('status' => 'success', 'msg' => 'Cadastro efetuado com sucesso', 'token' => rtrim(base64_encode($this->encrypt->encode($user_id)), "="));
        } else {
            if($user->user_type_id == 4){
                $save_user = array(
                    'user_id' => $user->user_id,
                    'name' => $this->input->post('name'),
                    'lastname' => $this->input->post('lastname'),
                    'username' => $this->genUsername($this->input->post('name') . ' ' . $this->input->post('lastname')),
                    'email' => $this->input->post('email'),
                    'password' => $this->encrypt->encode($this->input->post('password')),
                    'status' => 'confirm_email',
                    'user_type_id' => 3 //ID type usuário
                );
                if ($this->input->post('picture')) {
                    $this->load->helper('file');
                    $picture_name = date('YmdHis') . uniqid() . '.jpg';
                    if (write_file(FCPATH . 'uploads/' . $picture_name, base64_decode(str_replace('data:image/jpeg;base64,', '', $this->input->post('picture'))))) {
                        $save_user['picture'] = $picture_name;
                    }
                }

                $user_id = $this->user->save($save_user);

                $data = (object) array();
                $data->name = $this->input->post('name');
                $data->lastname = $this->input->post('lastname');
                $data->email = $this->input->post('email');
                $data->user_id = $user_id;
                $this->sendConfirmarEmail($data);
                $output = array('status' => 'success', 'msg' => 'Cadastro efetuado com sucesso', 'token' => rtrim(base64_encode($this->encrypt->encode($user_id)), "="));

            } else {
                $output = array('status' => 'error', 'msg' => 'Esse email já está cadastrado.');
            }
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function login() {
        $this->load->model('user_model', 'user');

        $where['email'] = $this->input->post('email');
        $user = $this->user->get_where($where)->row();

        if ($user and $this->encrypt->decode($user->password) == $this->input->post('password')) {
            if ($user->status == 'enable') {
                unset($user->password);
                $this->session->set_userdata('user', $user);
                $output = array('status' => 'success', 'token' => rtrim(base64_encode($this->encrypt->encode($user->user_id)), '='), 'login' => "Login efetuado com sucesso");
            } elseif ($user->status == 'pendding') {
                $output = array('status' => 'pendding', 'user_id' => $user->user_id);
            } elseif ($user->status == 'confirm_email') {
                $output = array('status' => 'confirm_email', 'user_id' => $user->user_id, 'msg' => 'Você precisa ativar a sua conta. Acesse o seu email e clique no link para ativá-la.');
            } else {
                $output = array('status' => 'error', 'msg' => 'Sua conta está inativa');
            }
        } else {
            $output = array('status' => 'erro', 'msg' => 'Usuário ou senha incorretos');
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function reenviarEmail() {
        $email = $this->input->post('email');
        $this->load->model('user_model', 'user');
        $where = array('email' => urldecode($email));
        $user = $this->user->getUserInfo($where);
        $this->sendConfirmarEmail($user);
    }

    protected function sendConfirmarEmail($data) {
        if (is_array($data)) {
            $data = (object) $data;
        }
        $data->code = urlencode($this->encrypt->encode($data->user_id));
        unset($data->user_id);

        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from(EMAIL_FROM, 'Dinner for Friends');
        $this->email->to($data->email);
        $this->email->subject('Confirmação de email');
        $this->email->message($this->load->view("emails/templates/confirmar_email_comilao", $data, TRUE));
        $this->email->send();
    }

    public function ConfirmarEmail() {
        $this->load->model('user_model', 'user');
        $code = $this->encrypt->decode($this->input->get("code"));
        $email = urldecode($this->input->get("email"));

        $where = array("user_id" => $code, "email" => $email);
        $data = $this->user->get_where($where)->row();
        if ($data->status == "confirm_email") {
            $this->user->update(array('status' => 'enable'), $where);
            if ($this->db->affected_rows() > 0) {
                $this->load->view("emails/templates/conta_ativa_comilao", $data);
            } else {
                $this->load->view("emails/templates/erro_confirmacao", $data);
            }
        } else {
            $this->load->view("emails/templates/conta_ativada_comilao", $data);
        }
    }

    public function fbLogin() {
        $session = new FacebookSession($this->input->post('accessToken'));
        try {
            $me = (new FacebookRequest(
                    $session, 'GET', '/me?fields=name,email'
                    ))->execute()->getGraphObject(GraphUser::className());

            $this->load->model('user_model', 'user');
            $where_usuario['email'] = $me->getEmail();
            $user = $this->user->get_where($where_usuario)->row();
            if ($user) {
                if ((!$user->facebook_id or $user->facebook_id == $me->getId())) {
                    if (!$user->facebook_id) {
                        $save['facebook_id'] = $me->getId();
                        $save['user_id'] = $user->user_id;
                        $this->user->save($save);
                    }
                    if ($user->status == 'enable') {
                        $this->session->set_userdata('user', $user);
                        $json = array('status' => 'success', 'token' => rtrim(base64_encode($this->encrypt->encode($user->user_id)), '='), 'userdata' => $user);
                    } elseif ($user->status == 'pendding') {
                        $json = array('status' => 'pendding', 'user_id' => $user->user_id);
                    } else {
                        $json = array('status' => 'error', 'msg' => 'Sua conta está inativa');
                    }
                } else {
                    $json['status'] = 'error';
                    $json['msg'] = 'Desculpe, não foi possivel efetuar o login com o Facebook';
                }
            } else {
                $lastname = explode(" ", $me->getName());
                unset($lastname[0]);
                $user_data = array(
                    'email' => $me->getEmail(),
                    'name' => explode(" ", $me->getName())[0],
                    'lastname' => implode(" ", $lastname),
                    'username' => $this->genUsername($me->getName()),
                    'facebook_id' => $me->getId(),
                    'user_type_id' => 3
                );
                $user_id = $this->user->save($user_data);
                $user = $this->user->get_where($where_usuario)->row();
                $json = array('status' => 'success', 'token' => rtrim(base64_encode($this->encrypt->encode($user_id)), '='), 'userdata' => $user);
            }
        } catch (\Exception $ex) {
            $json['status'] = 'error';
            $json['msg'] = 'Desculpe, não foi possivel efetuar o login com o Facebook';
            $json['msg_fb'] = $ex->getMessage();
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($json));
    }

    public function canRequestChef() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        if ($user_id) {
            $this->load->model('user_model', 'user');
            $output = $this->user->canRequestChef($user_id);
            $this->output->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }
    }

    public function getNome($user_id) {
        $this->load->model('user_model', 'user');
        $user = $this->user->get($user_id)->row();
        if ($user) {
            $output = array('name' => $user->name . ' ' . $user->lastname);
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function requestChef() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        if ($user_id) {
            $this->load->model('user_info_model', 'user_info');
            $dados = $this->input->posts();
            $dados['user_id'] = $user_id;
            $save = array(array('user_id' => $user_id, 'info_key' => 'requestChef', 'info_value' => 'friend'));
            unset($_POST['token']);
            $posts = $this->input->posts();
            if ($posts['especialidades']) {
                foreach ($posts['especialidades'] as $category_id => $checked) {
                    if ($checked == "true") {
                        $save[] = array('user_id' => $user_id,
                            'info_key' => 'category_id',
                            'info_value' => $category_id
                        );
                    }
                }
                unset($posts['especialidades']);
            }

            foreach ($posts as $key => $item) {
                $save[] = array('user_id' => $user_id,
                    'info_key' => $key,
                    'info_value' => $item
                );
            }
            $this->db->insert_batch('user_info', $save);
            $output = array('status' => 'success', 'msg' => 'Aguarde até que possamos analisar seu cadastro de Chef, em breve você terá uma resposta em seu email.');
            $this->output->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }
    }

    public function solitacoesChef($token) {
        $this->load->model('user_model', 'user');
        $this->load->model('categories_model', 'categories');
        $user_id = $this->encrypt->decode(base64_decode($token));
        $this->db->select("user.user_id,
            user.username,
            user.email,
            user.name,
            CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
            user.facebook_id,
            user.user_type_id,
            user_info.info_key,
            user_info.info_value
            ")
                ->join('user_info', 'user_info.user_id=user.user_id')
                ->where("user.user_id IN (
                SELECT
                friend_id
                FROM
                friends
                JOIN
                user_info ON user_info.user_id = friends.friend_id
                WHERE
                friends.user_id = '$user_id'
                AND user_info.info_key = 'requestChef'
                AND user_info.info_value = 'friend'
            )", null, false);

        $usuario = $this->user->get_all()->result_array();
        $output = array();

        foreach ($usuario as $item) {
            if (!isset($output[$item['user_id']])) {
                if (strstr($item['picture'], 'user_default.png') and $item['facebook_id']) {
                    $item['picture'] = 'https://graph.facebook.com/' . $item['facebook_id'] . '/picture?type=square';
                }
                $output[$item['user_id']] = $item;
            }
            if (!isset($output[$item['user_id']]['extra'])) {
                $output[$item['user_id']]['extra'] = array();
            }
            if ($item['info_key']) {
                if ($item['info_key'] == 'category_id') {
                    $this->db->select('name');
                    $category = $this->categories->get($item['info_value'])->row();
                    $output[$item['user_id']]['extra']['especialidades'][] = $category->name;
                } else if ($item['info_key'] == 'picture') {
                    $output[$item['user_id']]['extra'][$item['info_key']] = (strstr($item['info_value'], 'http') ? '' : SITE_URL . 'uploads/') . $item['info_value'];
                } else {
                    $output[$item['user_id']]['extra'][$item['info_key']] = $item['info_value'];
                }
            }

            unset($output[$item['user_id']]['info_key'], $output[$item['user_id']]['info_value']);
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array_values($output)));
    }

    //função amigo
    public function getListFriends() {

        $this->load->model('friends_model', 'friends');
        $this->load->model('user_model', 'users');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $dataAtual = date('Ymd');
        $output = array();

        $this->db->select("
                           friends.status,
                           friends.id,
                           friends.friend_id as userID,
                           user.user_type_id,
                           user.facebook_id,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           DATE_FORMAT(`user`.`create_time`,'%Y%m%d') as cadastro,
                           CONCAT(YEAR(`user`.`create_time`),'',MONTH(`user`.`create_time`),'',DAY(`user`.`create_time`)) as cadastro
                           ")
                ->select("(SELECT FLOOR(DATEDIFF(DATE(" . $dataAtual . "), DATE(cadastro))/7)) as semanas", false)
                ->select("(SELECT count(event_id) FROM events WHERE user_id=userID and start<=NOW()) as total_eventos", false)
                ->select("(SELECT count(event_id) FROM events WHERE user_id=userID and start>=NOW()) as eventos_futuros", false)
                ->select("(SELECT STR_TO_DATE((REPLACE((SELECT `user_info`.`info_value` FROM `user_info` WHERE `user_info`.`info_key`='nascimento' AND  `user_info`.`user_id` =userID),'/','-')),'%Y-%m-%d')) as nascimento", false)
                ->select("(SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(nascimento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(nascimento, '00-%m-%d'))) as age", false)
                /*
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='sobrevoce' AND user_info.user_id =userID) as sobrevoce", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='profissao' AND user_info.user_id =userID) as profissao", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='pratopreferido' AND user_info.user_id =userID) as pratopreferido", false)
                */
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = userID and status='accepted') as isFriend", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = userID and status='pendding') as isPending", false);
        $this->db->join("user", "friends.friend_id=user.user_id");
        $where = array("friends.user_id" => $user_id, "friends.status" => "accepted", "user.status" => "enable");
        $friends = $this->friends->get_where($where)->result();
        
        //$output['query'] = $this->db->last_query();
        
        foreach ($friends as $item) {
            $this->db->select("user_info.info_key, user_info.info_value");
            $data = $this->db->get_where('user_info', array('user_id' => $item->userID))->result();
            if (count($data) > 0) {
                $output_info = array();
                foreach ($data as $info) {
                    $output_info[$info->info_key] = $info->info_value;
                }
                $item->info = $output_info;
            }
            
            if (strstr($item->picture, 'user_default.png') and $item->facebook_id) {
                $item->picture = 'https://graph.facebook.com/' . $item->facebook_id . '/picture?type=square';
            }
            $item->totalComum = $this->users->totalComum($user_id, $item->userID);
            $output[] = $item;
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function getListChefs() {
        $this->load->model('friends_model', 'friends');
        $this->load->model('user_model', 'users');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $dataAtual = date('Ymd');
        $output = array();

        $this->load->model('user_model', 'users');
        $this->db->select("user.user_type_id,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           user.user_id as userID,
                           DATE_FORMAT(`user`.`create_time`,'%Y%m%d') as cadastro,
                           CONCAT(YEAR(`user`.`create_time`),'',MONTH(`user`.`create_time`),'',DAY(`user`.`create_time`)) as cadastro
                           ")
                ->select("(SELECT FLOOR(DATEDIFF(DATE(" . $dataAtual . "), DATE(cadastro))/7)) as semanas", false)
                ->select("(SELECT STR_TO_DATE((REPLACE((SELECT `user_info`.`info_value` FROM `user_info` WHERE `user_info`.`info_key`='nascimento' AND  `user_info`.`user_id` =userID),'/','-')),'%Y-%m-%d')) as nascimento", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='sobrevoce' AND user_info.user_id =userID) as sobrevoce", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='profissao' AND user_info.user_id =userID) as profissao", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='pratopreferido' AND user_info.user_id =userID LIMIT 1) as pratopreferido", false)
                ->select("(SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(nascimento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(nascimento, '00-%m-%d'))) as age", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = userID and status='accepted') as isFriend", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = userID and status='pendding') as isPending", false)
                ->select("(SELECT STR_TO_DATE((REPLACE((SELECT `user_info`.`info_value` FROM `user_info` WHERE `user_info`.`info_key`='nascimento' AND  `user_info`.`user_id` =userID),'/','-')),'%Y-%m-%d')) as nascimento", false)
                ->select("(SELECT friends.friend_id FROM friends WHERE friend_id =".$user_id." AND user_id=userID) as jasolicitado", false);                
        $users = $this->users->get_where(array('status' => 'enable', 'user_type_id' => '2', 'user_id !=' => $user_id))->result();
        
        foreach ($users as $item) {
            if(is_null($item->jasolicitado)){
                $item->totalComum = $this->users->totalComum($user_id, $item->userID);
                $output[] = $item; 
            }
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function aprovarChef() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        $this->load->model('user_info_model', 'user_info');
        $this->load->model('user_model', 'user');

        $this->db->select('user_info.user_info_id');
        $this->user_info->join('friends', 'friends.friend_id=user_info.user_id');
        $where['user_info.user_id'] = $this->input->post('friend_id');
        $where['user_info.info_key'] = 'requestChef';
        $where['user_info.info_value'] = 'friend';
        $where['friends.user_id'] = $user_id;
        $user = $this->user_info->get_where($where)->row();
        if ($user) {
            $this->user_info->update(array('info_value' => 'admin'), $user->user_info_id);
            $output = array('status' => 1, 'Enviado para o administrador aprovar essa requisição');
        } else {
            $output = array('status' => 0, 'Requisição não encontrada');
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function geraCodigo() {
        $codigo = rand(11111111, 99999999);
        if ($this->input->post('evento')) {
            $evento = $this->input->post("evento");
            $dados = array(
                'code' => $codigo,
                'email' => null,
                'event_id' => $evento
            );
            $this->db->insert("invite_codes", $dados);
        } else {
            $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
            $dados = array('code' => $codigo,
                'user_id' => $user_id
            );
            $this->db->insert('invite_codes_friends', $dados);
        }

        $output["status"] = "sucesso";
        $output["codigo"] = $codigo;

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function convidaAmigos() {
        if (isset($this->session->userdata('user')->user_id))
            $user_id = $this->session->userdata('user')->user_id;
        else
            $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $email = $this->input->post("email");

        $codigo = rand(11111111, 99999999);

        $dados = array(
            'code' => $codigo,
            'email' => $email,
            'user_id' => $user_id
        );

        $this->db->insert("invite_codes_friends", $dados);

        $para = $email;

        $msg = "Faça parte da minha rede de amigos no Dinner for Friends, baixe agora o aplicativo e cadastre-se: <a href='{$this->input->post("baseurl")}download' target='_blank'>Clique aqui</a>";

        $this->load->library('email');
        $this->email->from(EMAIL_FROM, 'Convite para participar do Dinner for Friends');
        $this->email->to($para);
        $this->email->subject('Convite para participar do Dinner for Friends');

        $this->email->message($msg);

        if ($this->email->send()) {
            $output["status"] = "success";
            $output["msg"] = "Convite foi enviado com sucesso";
        } else {
            $output["status"] = "error";
            $output["msg"] = "Falha ao enviar o convite!";
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function convidaAmigosMessenger() {
        if (isset($this->session->userdata('user')->user_id))
            $user_id = $this->session->userdata('user')->user_id;
        else
            $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $codigo = rand(11111111, 99999999);

        $dados = array(
            'code' => $codigo,
            'email' => '',
            'user_id' => $user_id
        );
        $this->db->insert("invite_codes_friends", $dados);

        $output["invite_code"] = $codigo;
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function getPerfil() {
        $user_id = $this->input->post("user_id");
        $this->load->model('user_model', 'user');
        $this->load->model('events_model', 'events');

        $this->db->select("user.name,
                           user.lastname,
                           user.user_id as userId,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           user_types.label as user_type,
                           user.create_time")
                ->select("(SELECT COUNT(events.event_id) FROM events WHERE user_id = userId AND events.end < NOW()) as eventos_anteriores")
                ->select("(SELECT COUNT(events.event_id) FROM events WHERE user_id = userId AND events.start > NOW()) as eventos_futuros")
                ->select("(SELECT info_value FROM user_info WHERE user_id = userId AND info_key = 'curriculo') as curriculo")
                ->select("(SELECT info_value FROM user_info WHERE user_id = userId AND info_key = 'sobrevoce') as sobrevoce")
                ->select("(SELECT info_value FROM user_info WHERE user_id = userId AND info_key = 'mensagem') as mensagem")
                ->select("(SELECT info_value FROM user_info WHERE user_id = userId AND info_key = 'profissao') as profissao")
                ->select("(SELECT info_value FROM user_info WHERE user_id = userId AND info_key = 'nascimento') as nascimento")
                ->select("(SELECT info_value FROM user_info WHERE user_id = userId AND info_key = 'pratopreferido') as pratopreferido")
                ->select("(SELECT STR_TO_DATE((REPLACE((SELECT `user_info`.`info_value` FROM `user_info` WHERE `user_info`.`info_key`='nascimento' AND  `user_info`.`user_id` =" . $user_id . "),'/','-')),'%Y-%m-%d')) as nascimento", false)
                ->select("(SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(nascimento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(nascimento, '00-%m-%d'))) as idade", false)
                ->join('user_types', 'user_types.user_type_id=user.user_type_id');
        $output = $this->user->get($user_id)->row();
        if ($output) {
            $output->cadastro_d4f = time_elapsed_string(strtotime($output->create_time));
        }

        $buscaAmigos = $this->db->select("user.user_id,
                                          user.name,
                                          user.lastname,
                                          CONCAT('" . SITE_URL . "uploads/', user.picture) as picture")
                ->from("user")
                ->join("friends", "friends.friend_id = user.user_id")
                ->where("friends.user_id", $user_id);
        $output->friends = $buscaAmigos->get()->result();

        $this->db->select("events.event_id as eventId,
                           events.name,
                           events.description,
                           DATE_FORMAT(events.start,'%m/%d/%Y %h:%i') as data,
                           (SELECT COUNT(*) FROM event_guests WHERE event_id = eventId) as total_guests,
                           (SELECT COUNT(*) FROM event_guests WHERE event_id = eventId AND status = 'confirmed') as total_confirmed,
                           CONCAT('" . SITE_URL . "uploads/', events.picture) as picture
                          ")
                ->join("event_guests", "event_guests.event_id=events.event_id");
        $output->events = $this->events->get_where(array("event_guests.user_id" => $user_id))->result();

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function verificacaoSolicitacaoChef() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $this->db->where("user_id", $user_id);
        $resultado = $this->db->get("friends");


        if ($resultado->num_rows() >= 20) {
            $output["pode"] = true;
        } else {
            $output["pode"] = false;
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function getRequestChef() {
        $this->load->model("User_info_model", "info");
        $resultado = $this->info->getRequestsChefs()->result();
        $output["listagem"] = $resultado;

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function getFriendsRequests() {

        $this->load->model('friends_model', 'friends');
        $this->load->model('user_model', 'users');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $dataAtual = date('Ymd');
        $this->db->select("
                           friends.status, 
                           friends.id, 
                           friends.friend_id as userID,
                           friends.user_id as friendID,
                           user.user_type_id,
                           user.facebook_id,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           DATE_FORMAT(`user`.`create_time`,'%Y%m%d') as cadastro,
                           CONCAT(YEAR(`user`.`create_time`),'',MONTH(`user`.`create_time`),'',DAY(`user`.`create_time`)) as cadastro
                           ")
                ->select("(SELECT FLOOR(DATEDIFF(DATE(" . $dataAtual . "), DATE(cadastro))/7)) as semanas", false)
                ->select("(SELECT STR_TO_DATE((REPLACE((SELECT `user_info`.`info_value` FROM `user_info` WHERE `user_info`.`info_key`='nascimento' AND  `user_info`.`user_id` =friendID),'/','-')),'%Y-%m-%d')) as nascimento", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='sobrevoce' AND user_info.user_id =friendID) as sobrevoce", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='profissao' AND user_info.user_id =friendID) as profissao", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='mensagem' AND user_info.user_id =friendID) as mensagem", false)
                ->select("(SELECT user_info.info_value FROM user_info WHERE user_info.info_key='pratopreferido' AND user_info.user_id =friendID) as pratopreferido", false)
                ->select("(SELECT DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(nascimento, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(nascimento, '00-%m-%d'))) as age", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = friendID and status='accepted') as isFriend", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $user_id . " AND friend_id = friendID and status='pendding') as isPending", false);
        $this->db->join("user", "friends.user_id=user.user_id");
        $where = array("friends.friend_id" => $user_id, "friends.status" => "pendding");
        $friends_pendding = $this->friends->get_where($where)->result();

        $output = array();
        foreach ($friends_pendding as $item) {
            if (strstr($item->picture, 'user_default.png') and $item->facebook_id) {
                $item->picture = 'https://graph.facebook.com/' . $item->facebook_id . '/picture?type=square';
            }

            $item->totalComum = $this->users->totalComum($user_id, $item->userID);
            $output[] = $item;
        }

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function sendFriendRequest() 
    {
        $this->load->library('lib_onesignal');
        $this->load->model('user_model','user');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        if ($this->input->post('friend_id')) {
            $this->load->model('friends_model', 'friends');
            $this->db->select("friends.id");
            $where = array('user_id' => $user_id, 'friend_id' => $this->input->post('friend_id'));
            $result = $this->friends->get_where($where)->result();
            $user = $this->user->get($user_id)->row();
            $friend = $this->user->get($this->input->post('friend_id'))->row();
            $msg = 'Nova solicitação de amizade de '.$user->name;
            if (count($result) == 0) {
                if ($this->db->insert('friends', array('user_id' => $user_id, 'friend_id' => $this->input->post('friend_id'), 'status' => 'pendding'))) {
                    $output = array('status' => 'success');
                    if($friend->onesignal_userid){
                        $this->lib_onesignal->send(array($friend->onesignal_userid), $msg, array('redirect' => 'tab.friends'));
                    }
                } else {
                    $output = array('status' => 'error');
                }
            } else {
                $output = array('status' => 'success');
                if($friend->onesignal_userid){
                    $this->lib_onesignal->send(array($friend->onesignal_userid), $msg, array('redirect' => 'tab.friends'));
                }
            }
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function cancelFriendRequest() {
        if ($this->input->post('id')) {
            $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

            $this->load->model('friends_model', 'friends');
            $this->friends->delete(array('id' => $this->input->post('id'), 'user_id' => $user_id));
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success')));
    }

    public function acceptFriendRequest() {

        $this->load->model('friends_model', 'friends');
        $this->load->model('user_model','user');
        $this->load->library('lib_onesignal');
        if ($this->input->post('id')) {
            $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
            $where = array('id' => $this->input->post('id'), 'friend_id' => $user_id);
            $this->friends->update(array('status' => 'accepted'), $where);
            $friend = $this->friends->get_where($where)->row();
            if ($friend) {
                $save = array(
                    'user_id' => $user_id,
                    'friend_id' => $friend->user_id,
                    'status' => 'accepted'
                );
                $this->friends->save($save);

                $user = $this->user->get($friend->user_id)->row();
                $data_friend = $this->user->get($user_id)->row();
                if($user->onesignal_userid){
                    $msg = 'Solicitação de amizade com '.$data_friend->name.' foi aceita.';
                    $this->lib_onesignal->send(array($user->onesignal_userid), $msg, array('redirect' => 'tab.friends'));
                }
            }
        }
//        echo $this->db->last_query();
//        exit();
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success')));
    }

    public function rejectFriendRequest() {
        $this->load->model('friends_model', 'friends');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        if ($this->input->post('id')) {
            $where = array('id' => $this->input->post('id'), 'friend_id' => $user_id);
            if ($this->friends->update(array('status' => 'rejected'), $where)) {
                $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array('status' => 'success')));
            } else {
                $this->output->set_content_type('application/json')
                        ->set_output(json_encode(array('status' => 'error', 'op' => 'not update')));
            }
        } else {
            $this->output->set_content_type('application/json')
                    ->set_output(json_encode(array('status' => 'error', 'op' => 'not found')));
        }
    }
    
    public function desfazerAmizade()
    {
        $this->load->model('friends_model', 'friends');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post('token')));
        $output = array();
        if ($this->input->post('friend_id')) {
            $where_user = array('friend_id' => $this->input->post('friend_id'), 'user_id' => $user_id);
            $where_friend = array('friend_id' => $user_id, 'user_id' => $this->input->post('friend_id'));
            if ($this->friends->delete($where_user) && $this->friends->delete($where_friend))
                $output = array('status' => 'success');
            else
                $output = array('status' => 'error');
        } else {
            $output = array('status' => 'error');
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function confirmaChefe() {
        $resposta = $this->input->post("resposta");
        $user_id = $this->input->post("user_id");

        $this->load->model("user_model", "user");
        $this->load->model("user_info_model", "user_info");

        $where = array('user_id' => $user_id);
        if ($resposta == "aceitar") {
            $this->user->update(array('status' => 'enable'), $where);

            $where['info_key'] = "requestChef";
            $where['info_value'] = "admin";
            $this->user_info->update(array('info_value' => "chefe"), $where);
        } else {
            $this->user->update(array('status' => 'enable', 'user_type_id' => 3), $where);

            $where['info_key'] = "requestChef";
            $where['info_value'] = "admin";
            $this->user_info->update(array('info_value' => "cancelado"), $where);
        }

        $resultado = $this->user_info->getRequestsChefs()->result();
        $output["listagem"] = $resultado;

        $data = $this->user->getUserInfo(array('user_id' => $user_id));
        $this->AtivarConta($data);

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    protected function AtivarConta($data) {
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from(EMAIL_FROM, 'Dinner for Friends');
        $this->email->to($data->email);
        $this->email->subject('Ativação de conta');

        if ($data->user_type_id == 3) {
            $this->email->message($this->load->view("emails/templates/solicitacao_recusada", $data, TRUE));
        } else if ($data->status == "enable") {
            $this->email->message($this->load->view("emails/templates/conta_ativa", $data, TRUE));
        }
        $this->email->send();
    }

    public function getNotificationUser() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $this->db->select("*,DATE_FORMAT(data,'%d/%c/%Y %H:%i:%S') as data_formatada");
        $this->db->where("user_id", $user_id);
        $this->db->order_by("notification_id", "desc");
        $output = $this->db->get("notification")->result();

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function updatePicture() {

        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        $imagem = $this->input->post("imagem");
        $this->db->update("user", array('picture' => $imagem), array('user_id' => $user_id));

        $output["status"] = "sucesso";
        $output["imagem"] = SITE_URL . "uploads/" . $imagem;

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function updatePushNotification() {
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));

        $data = array(
            'player_id' => $this->input->post("player_id"),
            'device_token' => $this->input->post("device_token")
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('user', $data);

        $output["status"] = "sucesso";
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function importContactsGmail() {
        $this->load->library('Lib_google');
        $this->load->model('invite_codes_friends_model', 'invite_codes_friends');
        if (isset($_GET['code'])) {
            $friends = $this->lib_google->getFriends();

            $i = 0;
            foreach ($friends as $item) {
                if ($this->invite_codes_friends->sendInvite($item, $this->session->userdata('user')->user_id)) {
                    $i++;
                }
            }
            $output = array('status' => 'success', 'msg' => $i . ' convite' . ($i != 1 ? 's' : '') . ' enviados');
        } else {
            $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
            $googleImportUrl = $this->lib_google->getAuthUrl();
            $output = array("url" => $googleImportUrl);
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function importContactsOutlook() {
        $this->load->library('Lib_outlook');
        $this->load->model('invite_codes_friends_model', 'invite_codes_friends');

        if (isset($_GET['code'])) {
            $friends = $this->lib_outlook->getFriends();
            $i = 0;
            foreach ($friends as $item) {
                if ($this->invite_codes_friends->sendInvite($item, $this->session->userdata('user')->user_id)) {
                    $i++;
                }
            }
            $output = array('status' => 'success', 'msg' => $i . ' convite' . ($i != 1 ? 's' : '') . ' enviados');
        } else {
            $url = $this->lib_outlook->getLoginUrl($redirectUri);
            $output = array('url' => $url);
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function notificacoesConfig() {
        $this->load->model('user_notifications_config_model', 'user_notifications_config');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        if ($this->input->post('key')) {
            $set = array($this->input->post('key') => $this->input->post('value'));
            $this->user_notifications_config->update($set, array('user_id' => $user_id));
        }
        $result = $this->user_notifications_config->get_where(array('user_id' => $user_id))->row();
        $output = array();
        foreach ($result as $key => $item) {
            $output[$key] = $item;
        }
        unset($output['user_notifications_config_id'], $output['user_id']);

        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function updateOnesignalId() 
    {
        $this->load->model('user_model','user');
        $user_id = $this->encrypt->decode(base64_decode($this->input->post("token")));
        if($this->input->post('onesignal_userid')){
            $set = array('onesignal_userid' => $this->input->post('onesignal_userid'));
            $this->user->update($set, $user_id);
        }

    }

}
