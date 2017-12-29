<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Free_invitation_model extends MY_Model
{
    var $id_col = 'id_free_invitation';
    var $fields = array(   
        'value_free_invitation' => array(
            'type' => 'text',
            'label' => 'Taxa de evento Grátis',
            'class' => 'currency',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
             'extra' => array('class' => 'currency')
        ),
    );

    
}