<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events_publics_model extends MY_Model {

    var $id_col = 'event_id';
    var $fields = array(
        'user_id' => array(
            'type' => 'select',
            'label' => 'Usuário',
            'rules' => 'required',
            'values' => array(),
            'empty' => '--Selecine o dono do evento--',
            'from' => array('model' => 'user', 'value' => 'name')
        ),
        'start' => array(
            'type' => 'date',
            'label' => 'Inicio do Evento',
            'rules' => 'required|min_length[8]',
            'extra' => array('required' => 'required')
        ),
        'end' => array(
            'type' => 'date',
            'label' => 'Fim do Evento',
            'rules' => 'required|min_length[8]',
            'extra' => array('required' => 'required')
        ),
        'name' => array(
            'type' => 'text',
            'label' => 'Titulo',
            'rules' => 'required|min_length[4]',
            'extra' => array('required' => 'required')
        ),
        'event_type_id' => array(
            'type' => 'select',
            'label' => 'Tipo do Evento',
            'rules' => 'required',
            'values' => array(),
            'empty' => '--Selecine um perfil--',
            'from' => array('model' => 'event_types', 'value' => 'name')
        ),
        'num_users' => array(
            'type' => 'text',
            'label' => 'Número de Convidados',
            'rules' => 'required',
            'extra' => array('required' => 'required')
        ),
        'price' => array(
            'type' => 'password',
            'label' => 'Preço'
        //'rules' => 'required|min_length[2]',
        //'extra' => array('required' => 'required')
        ),
        'status' => array(
            'type' => 'select',
            'label' => 'Status',
            'rules' => '',
            'values' => array("enable" => "Ativo", "disable" => "Inativo", "deleted" => "Removido"),
            'empty' => '--Selecine um status--',
        ),
        'zipcode' => array(
            'type' => 'text',
            'label' => 'CEP',
            'rules' => 'required',
            'extra' => array('required' => 'required')
        ),
        'street' => array(
            'type' => 'text',
            'label' => 'Endereço',
            'rules' => 'required|min_length[4]',
            'extra' => array('required' => 'required')
        ),
        'state' => array(
            'type' => 'text',
            'label' => 'Estado',
            'rules' => 'required|min_length[2]',
            'extra' => array('required' => 'required')
        ),
        'number' => array(
            'type' => 'text',
            'label' => 'Numero',
            'rules' => 'required',
            'extra' => array('required' => 'required')
        ),
        'city' => array(
            'type' => 'text',
            'label' => 'Cidade',
            'rules' => 'required|min_length[4]',
            'extra' => array('required' => 'required')
        ),
        'neighborhood' => array(
            'type' => 'text',
            'label' => 'Bairro',
            'rules' => 'required|min_length[4]',
            'extra' => array('required' => 'required')
        ),
        'latitude' => array(
            'type' => 'text',
            'label' => 'Latitude',
            'rules' => '',
            'extra' => array()
        ),
        'longitude' => array(
            'type' => 'text',
            'label' => 'Longitude',
            'rules' => '',
            'extra' => array()
        ),
        'description' => array(
            'type' => 'text',
            'label' => 'Descrição',
            'rules' => 'required|min_length[4]',
            'extra' => array('required' => 'required')
        ),
        'picture' => array(
            'type' => 'file',
            'label' => 'Foto Principal',
        //'rules' => 'callback_uploadImg[picture]',
        //'extra' => array('required' => 'required')
        ),
        'end_subscription' => array(
            'type' => 'date',
            'label' => 'Data Final de Cadastro',
            'rules' => 'required|min_length[8]',
            'extra' => array('required' => 'required')
        ),
        'invite_limit' => array(
            'type' => 'text',
            'label' => 'Foto Principal',
            'rules' => '',
            'extra' => array('required' => 'required')
        ),
        'private' => array(
            'type' => 'select',
            'label' => 'Privado',
            'rules' => '',
            'values' => array("Sim" => "1", "Não" => "0"),
            'empty' => '--Evento Privado?--',
        ),
        'rate' => array(
            'type' => 'text',
            'label' => 'Taxa',
        ),
    );

    public function info($event_id) {
        $where = array('events.event_id' => $event_id);

        $this->db->select("events.*,
                           DATE_FORMAT(events.start, '%d/%m/%Y') as data_inicio,
                           DATE_FORMAT(events.start, '%H:%i') as hora_inicio,
                           event_types.name as tipo,
                           CONCAT('" . SITE_URL . "uploads/', events.picture) as picture,
                           user_event.name as owner_name,
                           user_event.lastname as owner_lastname,
                           user_event.user_id as owner_id,
                           CONCAT('" . SITE_URL . "uploads/', user_event.picture) as owner_picture,
                           event_infos.event_info_id,
                           event_infos.info_value,
                           event_info_types.event_info_type_id as info_type_id,
                           event_info_types.name as info_key,
                           event_info_types.field_type as info_type,
                           event_info_categories.event_info_category_id as info_category_id,
                           event_info_categories.title as info_category_title,
                           event_guests.event_guest_id, 
                           event_guests.user_id as guest_id, 
                           event_guests.status as guest_status, 
                           guests.name as guest_name,
                           guests.lastname as guest_lastname,
                           guests.user_type_id as guest_type_id,
                           guests.picture as guest_picture,
                           event_gallery.event_gallery_id,
                           event_gallery.picture as gallery_picture,
                           event_cupom.event_cupom_id,
                           event_cupom.cupom,
                           event_comments.event_comment_id,
                           event_comments.comment,
                           DATE_FORMAT(event_comments.datetime, '%d/%m/%Y %H:%i') as comment_datetime,
                           user_comment.user_id as user_comment_id,
                           user_comment.name as user_comment_name,
                           user_comment.lastname as user_comment_lastname,
                           user_comment.picture as comment_picture,
                          ")
                ->join('event_types', 'event_types.event_type_id=events.event_type_id')
                ->join('user as user_event', 'user_event.user_id=events.user_id')
                ->join('event_infos', 'event_infos.event_id=events.event_id', 'left')
                ->join('event_info_types', 'event_info_types.event_info_type_id=event_infos.event_info_type_id', 'left')
                ->join('event_info_categories', 'event_info_types.event_info_category_id=event_info_categories.event_info_category_id', 'left')
                ->join('event_guests', 'event_guests.event_id=events.event_id', 'left')
                ->join('user as guests', 'guests.user_id=event_guests.user_id', 'left')
                ->join('event_gallery', 'event_gallery.event_id=events.event_id', 'left')
                ->join('event_cupom', 'event_cupom.event_id=events.event_id', 'left')
                ->join('event_comments', 'event_comments.event_id=events.event_id', 'left')
                ->join('user as user_comment', 'user_comment.user_id=event_comments.user_id', 'left')
                ->order_by('event_info_categories.event_info_category_id', 'asc');

        $event_data = $this->get_where($where)->result_array();

        $output = array();

        $confirmed = 0;
        $event_value_id = array();
        foreach ($event_data as $item) {
            if (!$output) {
                $output = $item;
                $output['extra'] = array();
                $output['guests'] = array();
                $output['pictures'] = array();
                $output['comments'] = array();
                $output['cupons'] = array();
                $output['menu'] = array();
            }

            if ($item['info_key']) {
                $output['extra'][$item['info_category_id']]['title'] = $item['info_category_title'];
                $output['extra'][$item['info_category_id']]['values'][$item['info_key']] = $item['info_value'];

                if (!in_array($item['event_info_id'], $event_value_id)) {
                    $new_array = array();
                    $new_array['event_info_type_id'] = $item['info_type_id'];
                    $new_array['event_value_id'] = $item['event_info_id'];
                    $new_array['name'] = $item['info_key'];
                    $new_array['field_type'] = $item['info_type'];
                    $new_array['info_value'] = $item['info_value'];
                    $output['menu'][] = (object) $new_array;
                    $event_value_id[] = $item['event_info_id'];
                }
            }

            if ($item['event_cupom_id']) {
                $output['cupons'][$item['event_cupom_id']] = array('cupom' => $item['cupom']);
            }

            if ($item['guest_name']) {
                $output['guests'][$item['guest_id']] = array('user_id' => $item['guest_id'],
                    'name' => $item['guest_name'],
                    'lastname' => $item['guest_lastname'],
                    'status' => $item['guest_status'],
                    'picture' => SITE_URL . 'uploads/' . $item['guest_picture'],
                    'type' => (int) $item['guest_type_id']
                );
            }

            if ($item['event_gallery_id'])
                $output['pictures'][$item['event_gallery_id']] = array('href' => SITE_URL . 'uploads/' . $item['gallery_picture'],
                    'principal' => (bool) ($item['gallery_picture'] == $output['picture'] ? 1 : 0));

            if ($item['comment']) {
                $output['comments'][$item['event_comment_id']] = array('user_id' => $item['user_comment_id'], 'name' => $item['user_comment_name'], 'lastname' => $item['user_comment_lastname'], 'date' => $item['comment_datetime'], 'comment' => $item['comment'], 'picture' => $item['comment_picture']);
            }
        }

        foreach ($output['guests'] as $guest) {
            if ($guest['status'] == 'confirmed') {
                $confirmed++;
            }
        }

        $output['total_invites'] = $item['num_users'] - $confirmed;
        $output['total_confirmed'] = $confirmed;
        //$output['invite_limit'] = (int) ($item['invite_limit'] ? $item['invite_limit'] : $output['total_invites']);

        $output['comments'];
        unset($output['info_key'], $output['info_value'], $output['guest_name'], $output['guest_lastname'], $output['guest_id'], $item['guest_status'], $item['guest_picture'], $output['event_gallery_id'], $output['gallery_picture'], $output['user_comment_name'], $output['user_comment_lastname'], $output['user_comment_id'], $output['comment_datetime'], $output['comment'], $output['comment_picture']);
        if (isset($output['cupom']))
            unset($output['cupom']);
        if (isset($output['event_cupom_id']))
            unset($output['event_cupom_id']);

        return $output;
    }
    public function getInfoEvent($where)
    {
        $this->db->select("events.name, events.start, events.end, events.description, events.picture");
        $output = $this->get_where($where)->row();
        return $output;
    }

    public function getAvg($field, $where=false) 
    {
        if($where){
            $this->db->where($where);
        }
        $this->db->select('AVG('.$field.') as avg');
        return $this->get_all()->row()->avg;
    }

    public function getAvgConfirmed() 
    {
        $this->db->select("AVG(eventos.confirmados) as avg")
                 ->from("(SELECT events.event_id as ID, (
                              SELECT COUNT(*) as total 
                              FROM event_guests 
                              WHERE event_id = ID AND status = 'confirmed') as confirmados 
                          FROM events
                          JOIN event_types ON event_types.event_type_id=events.event_type_id AND event_types.private=1
                          ) eventos", false);
        return $this->db->get()->row()->avg;
    }

    public function getAvgInvites() 
    {
        $this->db->select("AVG(eventos.convidados) as avg")
                 ->from("(SELECT events.event_id as ID, (
                              SELECT COUNT(*) as total 
                              FROM event_guests 
                              WHERE event_id = ID) as convidados 
                          FROM events
                          JOIN event_types ON event_types.event_type_id=events.event_type_id AND event_types.private=1
                          ) eventos", false);
        return $this->db->get()->row()->avg;
    }

    public function getAvgPayments() 
    {
        $this->db->select("AVG(eventos.total) as avg")
                 ->from("(SELECT SUM(netAmount) total 
                          FROM events
                          JOIN event_types ON event_types.event_type_id=events.event_type_id AND event_types.private=1
                          JOIN event_guests ON event_guests.event_id=events.event_id
                          JOIN payments_guests ON event_guests.event_guest_id=payments_guests.event_guest_id
                          JOIN payments ON payments.payment_id=payments_guests.payment_id
                          ) eventos", false);
        return $this->db->get()->row()->avg;
    }

    public function rankingCity($where) 
    {
        $this->db->select("DISTINCT city as eventCity, event_id as ID, events.event_type_id as eventTypeID, event_types.name as eventType, (SELECT COUNT(*) FROM events WHERE city = eventCity AND event_type_id = eventTypeID) as total", false)
            ->join('event_types', 'event_types.event_type_id=events.event_type_id')
            ->order_by('total', 'desc');
        $result = $this->get_where($where)->result();

        $output = array();
        foreach ($result as $item) {
            if(!$item->eventCity){
                $item->eventCity = 'Não Cadastrado';
            }
            $output[$item->eventTypeID]['tipo'] = $item->eventType;
            $output[$item->eventTypeID]['cidades'][$item->eventCity] = $item->total;
        }
        return $output;
    }
}
