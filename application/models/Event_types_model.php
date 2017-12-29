<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_types_model extends MY_Model
{
    var $id_col = 'event_type_id';
    var $fields = array(
        'name' => array(
            'type' => 'text',
            'label' => 'Nome',
            'rules' => 'required|min_length[4]',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div>',
            'extra' => array('required' => 'required')
        ),
        'private' => array(
            'type' => 'select',
            'label' => 'Tipo',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div>',
            'values' => array(
                0 => 'Público',
                1 => 'Privado'
            ),
            'extra' => array('required' => 'required')
        ),
        'image_type' => array(
            'type' => 'file',
            'label' => 'Ícone',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div><div class="col-md-2"><span class="label label-warning">*tamanho da imagem: 100px X 100px</span></div>',
            'rules' => 'callback_uploadIcon'
        ),
    );     

    public function ranking($where, $select = false) 
    {
        $this->db->select("event_type_id as ID, name, (SELECT COUNT(*) FROM events WHERE status='enable' AND events.event_type_id=ID) as total")
                 ->order_by('total', 'desc');
        if($select){
            $this->db->select($select);
        }
        return $this->get_where($where)->result();
    }
    
    public function info($where)
    {
        $this->db->select("event_types.event_type_id, event_types.name");
        return $this->get_where($where)->result();
    }
}
