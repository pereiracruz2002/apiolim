<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_info_model extends My_Model {

    var $id_col = 'user_info_id';

    public function getPaymentInfo($user_id) {
        $fields = array(
            'cep',
            'endereco',
            'complemento',
            'numero',
            'bairro',
            'cidade',
            'estado'
        );
        $this->db->where_in('info_key', $fields);
        $where = array('user_info.user_id' => $user_id);
        $this->db->join('user', 'user.user_id=user_info.user_id');
        $infos = $this->get_where($where)->result();
        $output = array();
        foreach ($infos as $item) {
            $output[$item->info_key] = $item->info_value;
        }
        $output['email'] = $item->email;
        $output['nome'] = $item->name;
        return $output;
    }

    public function getRequestsChefs() {
        $this->db->select("user.*");
        $this->db->from("user_info");
        $this->db->join("user", "user_info.user_id = user.user_id");
        $this->db->where("user.status", "pendding");
        $this->db->where("user_info.info_key", "requestChef");
        $this->db->where("user_info.info_value", "admin");
        $this->db->group_by("user.user_id");
        $resultado = $this->db->get();

        return $resultado;
    }

    public function info($user_id) {
        $where = array('user_id' => $user_id);
        $this->db->select("user_info.*");
        $user_data = $this->db->get_where('user_info', $where)->result_array();
        $output = array();

        foreach ($user_data as $info) {
            if (isset($info['info_key']) && isset($info['info_value'])) {
                $output[$info['info_key']] = $info['info_value'];
            }
        }
        unset($output['user_info_id']);
        unset($output['info_key']);
        unset($output['info_value']);

        return $output;
    }

}
