<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends MY_Model {

    var $id_col = 'user_id';
    var $fields = array(
        'name' => array(
            'type' => 'text',
            'class' => '',
            'label' => 'Nome',
            'rules' => 'required|min_length[3]',
            'extra' => array('required' => 'required'),
			'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
        ),
        'lastname' => array(
            'type' => 'text',
            'class' => '',
            'label' => 'Sobrenome',
            'rules' => 'required|min_length[3]',
            'extra' => array('required' => 'required'),
        ),
        'email' => array(
            'type' => 'text',
            'label' => 'Email',
            'class' => '',
            'rules' => 'required|valid_email|callback_uniqEmail',
            'extra' => array('required' => 'required')
        ),
        'password' => array(
            'type' => 'password',
            'label' => 'Senha',
            'rules' => 'required|min_length[4]',
            'class' => 'medium vObrigatorio',
            'extra' => array('required' => 'required'),
        ),
        'status' => array(
            'type' => 'select',
            'label' => 'Status',
            'class' => '',
            'rules' => 'required',
            'values' => array(
                "" => "Selecione um status",
                "enable" => "Ativo",
                "disable" => "Inativo",
                "not_activated" => "Não aprovado",
                "pendding" => "Aguardando aprovação",
                "confirm_email" => "Aguardando usuário confirmar email"
            ),
            'empty' => '--Selecine um status--',
        ),
        'user_type_id' => array(
            'type' => 'select',
            'label' => 'Perfil',
            'rules' => 'required',
            'class' => '',
            'values' => array(),
            'empty' => '--Selecine um perfil--',
            'from' => array('model' => 'user_types', 'value' => 'label')
        ),
        'rate' => array(
            'type' => 'text',
            'label' => 'Taxa',
            'class' => '',
            'extra' => array('class' => 'currency')
        ),
    );

    public function info($where) {
        $this->db
                ->select("
                    user.*,
                    user_info.user_info_id,
                    user_info.info_key,
                    user_info.info_value,
                    user_types.label
                ")
                ->join('user_info', 'user_info.user_id=user.user_id', 'left')
                ->join('user_types', 'user_types.user_type_id=user.user_type_id')
                ->order_by('user.user_id', 'asc');

        $user_data = $this->db->get_where('user', $where)->result_array();
        $output = array();

        foreach ($user_data as $info) {
            if (!$output) {
                $output = $info;
                $output['info'] = array();
            }
            
            if (isset($info['info_key']) && isset($info['info_value'])) {
                $output['info'][$info['info_key']] = array(
                    $info['info_value'], $info['user_info_id']
                );
            }
        }
        unset($output['user_info_id']);
        unset($output['info_key']);
        unset($output['info_value']);

        return $output;
    }

    public function relatorio($where) {
        $this->db
                ->select("
                    user.user_id,
                    user.name as nome,
                    user.lastname as sobrenome,
                    user.email as email,
                    user.status as status,
                    DATE_FORMAT(user.last_login, '%d/%m/%Y %H:%i:%s') as ultimo_acesso,
                    user_info.info_key,
                    user_info.info_value
                ")
                ->join('user_info', 'user_info.user_id=user.user_id', 'left')
                ->join('user_types', 'user_types.user_type_id=user.user_type_id')
                ->order_by('user.user_id', 'asc');

        $user_data = $this->db->get_where('user', $where)->result_array();

        $output = array();
        $header = array();
        $rows = array();

        foreach ($user_data as $indice => $info) {
            if (!array_key_exists($info['user_id'], $output)) {
                $output[$info['user_id']] = $info;
            }
            if (isset($info['info_key']) && isset($info['info_value'])) {
                $output[$info['user_id']][$info['info_key']] = $this->isDate($info['info_value']);
            }
            unset($output[$info['user_id']]['info_key']);
            unset($output[$info['user_id']]['info_value']);
        }

        foreach ($output as $values) {
            foreach ($values as $field => $value) {
               if (!in_array($field, $header)) {
                   $header[] = $field;
               }
            }
        }

        foreach ($output as $row) {
            $_row = array();
            foreach ($header as $head) {
                if (isset($row[$head])) {
                    $_row[$head] = "\"{$row[$head]}\"";
                } else {
                    $_row[$head] = "\"\"";
                }
            }
            $rows[] = implode(";", $_row);
        }
    
        $result = implode(";", $header). "\n" . implode("\n", $rows);
        return $result;
    }
    
    protected function isDate($str) {
        $time = false;
        if ($str == "") return $str;
        if (!strrpos($str, "-")) return $str;
        if (strrpos($str, ":")) $time = true;
        
        try {
            $old = $str;
            $date = new DateTime($str);
            if ($time) return $date->format("d/m/Y H:i:s");
            return $date->format("d/m/Y");
        } catch (Exception $ex) {
            return $str;
        }
    }

    public function getUserInfo($where) {
        $this->select("user.user_id, user.email, user.name, user.lastname, user.status, user.user_type_id, user.onesignal_userid");
        $result = $this->get_where($where)->row();
        return $result;
    }

    public function beFriends($user_id, $friend_id) {
        $this->db->insert('friends', array('user_id' => $user_id, 'friend_id' => $friend_id));
        $this->db->insert('friends', array('friend_id' => $user_id, 'user_id' => $friend_id));
    }

    public function canRequestChef($user_id) {
        $where_usuario = array('user_id' => $user_id, 'user_type_id' => 2);
        $user = $this->get_where($where_usuario)->row();
        if (!$user) {
            $this->db->where("user_id", $user_id);
            $resultadoVerificacao = $this->db->get("friends");

            if ($resultadoVerificacao->num_rows() >= 20) {
                $info = $this->db->where(array('user_id' => $user_id, 'info_key' => 'requestChef', 'info_value' => 'admin'))->get('user_info')->row();
                if (!$info) {
                    $output = array('status' => 'yes');
                } else {
                    $output = array('status' => 'no', 'msg' => 'Você já fez sua solicitação, aguarde nossa análise.');
                }
            } else {
                $output = array('status' => 'no', 'msg' => 'Você precisa ter 20 amigos convidados para virar um chefe');
            }
        } else {
            $output = array('status' => 'no', 'msg' => 'Você já é um Chef, acesse o site para criar seus eventos.');
        }
        return $output;
    }

    public function getFriends($user_id) {
        $this->db->select("user.user_id,
                           user.user_type_id,
                           user.email,
                           user.facebook_id,
                           CONCAT(user.name,' ',user.lastname) as name,
                           CONCAT('" . SITE_URL . "uploads/', user.picture) as picture");
        $this->db->join("user", "friends.friend_id = user.user_id and friends.status='accepted'");
        $this->db->where("friends.user_id", $user_id);
        $resultado = $this->db->get('friends')->result();
        foreach ($resultado as $key => $item) {
            if (!$this->UR_exists($item->picture))
                $item->picture = SITE_URL."assets/img/user_default.png";
            if(strstr($item->picture, 'user_default.png') and $item->facebook_id){
                $item->picture = 'https://graph.facebook.com/'.$item->facebook_id.'/picture?type=square';
            }

        }
        return $resultado;
    }

    public function totalComum($user_id, $friend_id) 
    {
        $this->db->select("friends.friend_id")
                ->where(array("friends.status" => "accepted", "friends.user_id" => $user_id))
                ->having("friends.friend_id IN (SELECT friend_id FROM friends WHERE user_id = ".$friend_id." AND status = 'accepted')");
        $friends_in_commum = $this->db->get('friends');
        return $friends_in_commum->num_rows();
    }

    public function rankingChefsEventos() {
        $this->db->select("CONCAT(user.name,' ', user.lastname) as name, 
                           user.user_id as userID, 
                           (SELECT COUNT(*) FROM events WHERE user_id = userID) as total")
                ->order_by('total', 'desc')
                ->where(array('user_type_id' => 2))
                ->limit(10);
        return $this->get_all()->result();
    }

    public function rankingConvidadosEventos() {
        $this->db->select("CONCAT(user.name,' ', user.lastname) as name, 
                           user.user_id as userID, 
                           (SELECT COUNT(*) FROM event_guests WHERE user_id = userID AND status = 'confirmed') as total")
                ->order_by('total', 'desc')
                ->where(array('user_type_id !=' => 1))
                ->limit(10);
        return $this->get_all()->result();
    }

    public function getQtdPerMonth() {
        $output = array();
        $user_types = $this->db->get_where('user_types', array('user_type_id >' => 1))->result();
        foreach ($user_types as $item) {
            $total[$item->name] = 0;

            for ($i = 12; $i >= 0; $i--) {
                $date1 = date('Y-m-01 00:00:00', strtotime('-' . $i . ' months'));
                $date2 = date('Y-m-01 00:00:00', strtotime(substr($date1, 0, 10) . ' +1 month'));
                $this->db->select('count(*) as total')
                        ->where('user_type_id', $item->user_type_id)
                        ->where('create_time >=', date($date1))
                        ->where('create_time <', date($date2));
                $total[$item->name] += $this->get_all()->row()->total;
                $output[$item->name][substr($date1, 5, 2) . '/' . substr($date1, 0, 4)] = (int) $total[$item->name];
            }
        }
        return $output;
    }

    public function getQtdUsers($date = null) {
        $output = array();
        $user_types = $this->db->get_where('user_types', array('user_type_id >' => 1))->result();
        foreach ($user_types as $item) {
            if ($date == null) {
                for ($i = 11; $i >= 0; $i--) {
                    $date_ = date('Y-m-d H:i:s', strtotime("-{$i} months"));
                    $this->db->select("count(*) as total")
                            ->where('user_type_id', $item->user_type_id)
                            ->where('create_time <', date($date_));
                    $output[$item->name][substr($date_, 5, 2) . "/" . substr($date_, 0, 4)] = (int) $this->get_all()->row()->total;
                }
            } else {
                $date_explode = explode("/", $date);
                $days = ($date_explode[0] == date("m"))? date("j"): date("t", strtotime("{$date_explode[1]}-{$date_explode[0]}"));
                $last_month = date('Y-m-01 00:00:00', strtotime("{$date_explode[1]}-{$date_explode[0]}"));
                $this->db->select("count(*) as total")
                        ->where('user_type_id', $item->user_type_id)
                        ->where('create_time <', $last_month);
                $total = (int) $this->get_all()->row()->total;

                $this->db->select("count(*) as total, create_time")
                        ->where('user_type_id', $item->user_type_id)
                        ->where('MONTH(create_time)', $date_explode[0])
                        ->where('YEAR(create_time)', $date_explode[1])
                        ->group_by('DAY(create_time)')
                        ->order_by('user_id')
                        ;
                $result = $this->get_all()->result();
                $days_result = array();
                foreach ($result as $row) {
                    $days_result[date("j", strtotime($row->create_time))] = (int) $row->total;
                }
                
                for ($i = 1; $i <= $days; $i++) {
                    if (isset($days_result[$i])) {
                        $total += $days_result[$i];
                        $output[$item->name][$i] = $total;
                    } else {
                        $output[$item->name][$i] = $total;
                    }
                }
            }
        }
        return $output;
    }

    public function getQtdSexoChef() {
        $this->db->select("user_info.info_value, user.user_id");
        $this->db->join("user", "user_info.user_id = user.user_id");
        $this->db->where(array('user_type_id' => 2, 'user_info.info_key' => 'sexo'));
        $result = $this->db->get('user_info')->result();
        $output = array(
            'Masculino' => 0,
            'Feminino' => 0
        );
        foreach ($result as $item) {
            $output[ucfirst($item->info_value)] ++;
        }
        return $output;
    }

    public function getQtdSexoGuest() {
        $this->db->select("user_info.info_value, user.user_id");
        $this->db->join("user", "user_info.user_id = user.user_id");
        $this->db->where(array('user_type_id' => 3, 'user_info.info_key' => 'sexo'));
        $result = $this->db->get('user_info')->result();
        $output = array(
            'Masculino' => 0,
            'Feminino' => 0
        );
        foreach ($result as $item) {
            $output[ucfirst($item->info_value)] ++;
        }
        return $output;
    }

    protected function UR_exists($url) {
        $headers = get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }
}
