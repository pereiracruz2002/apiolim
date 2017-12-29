<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Rates_model extends MY_Model
{
    var $id_col = 'rate_id';
    var $fields = array(   
        'rate_global' => array(
            'type' => 'text',
            'label' => 'Taxa Global',
            'class' => 'currency',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
             'extra' => array('class' => 'currency')
        ),
        'rate_service' => array(
            'type' => 'text',
            'label' => 'Taxa de Serviço',
            'class' => 'currency',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
             'extra' => array('class' => 'currency')
        ),
    );

    
}




