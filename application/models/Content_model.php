<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content_model extends MY_Model 
{
    var $id_col = 'content_id';

    var $fields = array(
        'title' => array(
            'label' => 'Titulo',
            'type' => 'text',
            'class' => '',
            'rules' => 'required',
            'extra' => array('required' => 'required'),
			'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-6">',
            'append' => '</div>',
        ),
        'permalink' => array(
            'label' => 'Link Permanente',
            'type' => 'text',
            'class' => '',
            'rules' => 'required',
            'extra' => array('required' => 'required'),
			'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-6">',
            'append' => '</div>',
        ),
        'sort' => array(
            'label' => 'Ordem',
            'type' => 'text',
            'class' => '',
            'rules' => 'required',
            'extra' => array('required' => 'required'),
			'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
        ),
        'html' => array(
            'label' => 'Conteúdo',
            'type' => 'textarea',
            'class' => '',
            'rules' => 'required',
            'extra' => array('class' => 'form-control tinymce'),
			'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-10">',
            'append' => '</div>',
        ),
    );

    public function __construct() 
    {
        parent::__construct();
    }


}
