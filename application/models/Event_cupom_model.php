<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Event_cupom_model extends MY_Model
{
    var $id_col = "event_cupom_id";
    var $fields = array(
        'cupom_id' => array(
            'type' => 'text',
            'label' => 'Evento'
        ),
        'cupom' => array(
            'type' => 'text',
            'label' => 'Cupom'
        )
    );
}
