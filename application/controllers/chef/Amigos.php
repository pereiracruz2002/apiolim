<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Amigos extends CI_Controller {

    var $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('login');
        }
    }
    
    protected function UR_exists($url) {
        $headers = get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }

    public function index() 
    {
        $this->data['page_title'] = 'Meus Amigos';
        $this->load->model('friends_model', 'friends');
        $this->load->model('user_model', 'users');
        $this->load->model('chef_model', 'chef');
        $user_id = $this->session->userdata('user')->user_id;
        $this->data['token'] = $this->encrypt->encode(($this->session->userdata('user')->user_id));
        $this->data['user'] = array('picture' => $this->chef->info($user_id)['picture']);

        $this->db->select("user.*,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           friends.status,
                           friends.id
                           ");
        $this->db->join("user", "friends.user_id = user.user_id");
        $where = array("friends.friend_id" => $this->session->userdata('user')->user_id);
        $friends = $this->friends->get_where($where)->result();
        $this->data['friends'] = array();
        $this->data['friends_pendding'] = array();
        foreach ($friends as $item) {
            if (!$this->UR_exists($item->picture))
                $item->picture = SITE_URL."assets/img/user_default.png";
            
            if(strstr($item->picture, 'user_default.png') and $item->facebook_id){
                $item->picture = 'https://graph.facebook.com/'.$item->facebook_id.'/picture?type=square';
            }
            if ($item->status == 'accepted') {
                $this->data['friends'][] = $item;
            }
        }

        $this->db->select("friends.status, friends.id, user.*,
            CONCAT(user.name,' ',user.lastname) as name,
            CONCAT('" . SITE_URL . "uploads/', user.picture) as picture
                ");
        $this->db->join("user", "friends.friend_id=user.user_id");
        $where = array("friends.user_id" => $this->session->userdata('user')->user_id, "friends.status" => "pendding");
        $friends_pendding = $this->friends->get_where($where)->result();
        foreach ($friends_pendding as $key => $item) {
            $this->data['friends_pendding'][$key] = $item;
            if(strstr($item->picture, 'user_default.png') and $item->facebook_id){
                $this->data['friends_pendding'][$key]->picture = 'https://graph.facebook.com/'.$item->facebook_id.'/picture?type=square';
            }
        }

        $where = array("friends.friend_id" => $this->session->userdata('user')->user_id, 'friends.status' => 'pendding', 'user.status' => 'enable');
        $this->db->select("user.*,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           friends.status,
                           friends.id
                           ");
        $this->db->join("user", "friends.user_id = user.user_id");

        $this->data['friends_request'] = $this->friends->get_where($where)->result();
        foreach ($this->data['friends_request'] as $key => $item) {
            if (!$this->UR_exists($item->picture))
                $item->picture = SITE_URL."assets/img/user_default.png";
            
            if(strstr($item->picture, 'user_default.png') and $item->facebook_id){
                $this->data['friends_request'][$key]->picture = 'https://graph.facebook.com/'.$item->facebook_id.'/picture?type=square';
            }

        }
        $this->data['cssFiles'] = array('amigos.css');

        $this->load->view('chef/amigos', $this->data);
    }

    public function buscaUser() {
        $this->load->model('user_model', 'users');
        $this->db->select("user.*,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                           user.user_id as userID
                           ")
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $this->session->userdata('user')->user_id . " AND friend_id = userID and status='accepted') as isFriend", false)
                ->select("(SELECT count(*) FROM friends WHERE user_id = " . $this->session->userdata('user')->user_id . " AND friend_id = userID and status='pendding') as isPending", false)
                ->like('name', $this->input->post('q'))
                ->or_like('lastname', $this->input->post('q'))
                ->or_like('email', $this->input->post('q'));
        $users = $this->users->get_where(array('status' => 'enable'))->result();

        if ($users) {
            $output = '<ul class="lista-users">';
            foreach ($users as $item) {
                if ($item->user_id == $this->session->userdata('user')->user_id)
                    continue;
                if (!$this->UR_exists($item->picture))
                    $item->picture = SITE_URL."assets/img/user_default.png";
                
                $type_user = ($item->user_type_id == 2) ? 'chef.jpg' : 'pacman.jpg';
                $output .= "
                <li class=\"list-friends\">
                    <div class=\"col-sm-6 row-friend\">
                        <div class=\"col-sm-3 col-photo\">
                            <img src=\"{$item->picture}\" alt=\"{$item->name}\" class=\"photo-friends\" />
                        </div>
                        <div class=\"col-sm-2 col-type-user\">
                            <img src=\"" . base_url() . "assets/img/{$type_user}\" class=\"picture-type-user\" />
                        </div>
                        <div class=\"col-sm-7 col-friend\">
                            <div class=\"row-desc-friends\">
                                <div class=\"friend-name\">{$item->name}</div>
                                <div class=\"quant-friends\">{$this->users->totalComum($this->session->userdata('user')->user_id, $item->user_id)} amigos em comum</div>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-sm-6 row-friend\">
                        <div class=\"col-add-friend\">";
                if ($item->isFriend) {
                    $output .= "<span class=\"padding bg-success pull-right\">Amigo</span>";
                } else if ($item->isPending) {
                    $output .= "<span class=\"padding bg-warning pull-right\">Solicitação enviada</span>";
                } else {
                    $output .= "<a href=\"" . site_url("chef/amigos/enviarsolicitacao/{$item->user_id}") . "\" class=\"text-success btn-friendship\"><i class=\"fa fa-plus-circle fa-2x\"></i></a>";
                }
                $output .= "
                        </div>
                    </div>
                </li>
                ";
            }
            $output .= '</ul>';
        } else {
            $output = '<p class="alert alert-warning">Não encontramos nenhum resultado em sua pesquisa.</p>';
        }
        $this->output->set_output($output);
    }

    public function buscaMeusAmigos() {
        $this->load->model('friends_model', 'friends');
        $this->load->model('user_model', 'users');
        $query = $this->db->query("SELECT `user`.*, 
                CONCAT(user.name, ' ', user.lastname) as name, 
                CONCAT('" . SITE_URL . "uploads/', user.picture) as picture,
                `friends`.`status`, `friends`.`id` 
                FROM `friends` JOIN `user` ON `friends`.`friend_id` = `user`.`user_id` 
                WHERE (`user`.`name` LIKE '%{$this->input->post('q')}%' ESCAPE '!' 
                OR `user`.`lastname` LIKE '%{$this->input->post('q')}%' ESCAPE '!' 
                OR `user`.`email` LIKE '%{$this->input->post('q')}%' ESCAPE '!') 
                AND `friends`.`user_id` = '{$this->session->userdata('user')->user_id}'
                AND `friends`.`status` = 'accepted' GROUP BY `user`.`user_id`");
        $friends = $query->result();
        $return = array();
        foreach ($friends as $item):
            $totalComum = $this->users->totalComum($item->user_id, $this->session->userdata('user')->user_id);
            if (!$this->UR_exists($item->picture))
                $item->picture = SITE_URL."assets/img/user_default.png";
            $return[] = "
                        <li>
                            <div class=\"col-sm-12 row-friend\">
                                <div class=\"col-sm-3 col-photo\">
                                    <img src=\"{$item->picture}\" alt=\"{$item->name}\" class=\"photo-friends\" />
                                </div>
                                <div class=\"col-sm-2 col-type-user\">
                                    <img src=\"" . base_url() . "assets/img/" . (($item->user_type_id == 2) ? 'chef.jpg' : 'pacman.jpg') . "\" class=\"picture-type-user\" />
                                </div>
                                <div class=\"col-sm-7 col-friend\">
                                    <div class=\"row-desc-friends\">
                                        <div class=\"friend-name\">{$item->name}</div>
                                        <div class=\"quant-friends\">{$totalComum}&nbsp;amigo" . (($totalComum > 0) ? 's' : '') . " em comum
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>";
        endforeach;
        $this->output->set_output(join("", $return));
    }

    public function solicitacoes() {
        $this->load->model('friends_model', 'friends');
        if (isset($this->session->userdata('user')->user_id)) {
            $this->db->select("friends.status, friends.id, user.status");
            $this->db->join("user", "friends.user_id = user.user_id");
            $where = array("friends.friend_id" => $this->session->userdata('user')->user_id, "friends.status" => "pendding", "user.status" => "enable");
            $solicitacoes = $this->friends->get_where($where)->result();
            $output = array("solicitacoes" => count($solicitacoes));
        } else {
            $output = array("erro" => "você não tem permissão");
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function enviarSolicitacao($friend) {
        if ($this->db->insert('friends', array('user_id' => $this->session->userdata('user')->user_id, 'friend_id' => $friend, 'status' => 'pendding'))) {
            $output = array('status' => 'success', 'id' => $this->db->insert_id());
        } else {
            $output = array('status' => 'error');
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode($output));
    }

    public function cancelarSolicitacao($id) {
        $this->load->model('friends_model', 'friends');
        $this->friends->delete(array('id' => $id, 'user_id' => $this->session->userdata('user')->user_id));
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success')));
    }

    public function confirmarSolicitacao($id) {
        $this->load->model('friends_model', 'friends');
        $where = array('id' => $id, 'friend_id' => $this->session->userdata('user')->user_id);
        $this->friends->update(array('status' => 'accepted'), $where);
        $friend = $this->friends->get_where($where)->row();
        if ($friend) {
            $save = array(
                'user_id' => $this->session->userdata('user')->user_id,
                'friend_id' => $friend->user_id,
                'status' => 'accepted'
            );
            $this->friends->save($save);
        }
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success')));
    }

    public function ignorarSolicitacao($id) {
        $this->load->model('friends_model', 'friends');
        $this->friends->update(array('status' => 'rejected'), array('id' => $id, 'friend_id' => $this->session->userdata('user')->user_id));
        $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success')));
    }

    public function sendInviteEmail() {
        
    }

}
