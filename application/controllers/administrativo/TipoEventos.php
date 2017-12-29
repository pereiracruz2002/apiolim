<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class TipoEventos extends BaseCrud {

    var $modelname = 'event_types';
    var $base_url = 'administrativo/TipoEventos';
    var $actions = 'CRUD';
    var $titulo = 'Tipo de eventos';
    var $tabela = 'name,private';
    var $campos_busca = 'name';
    var $selects = "event_types.*, IF(private, 'Privado', 'Público') as private";

    public function __construct() {
        parent::__construct();
    }

    public function uploadIcon() {

        $config['upload_path'] = './assets/img/eventos/';
        $config['allowed_types'] = 'png';
        $config['max_size'] = 100;
        $config['max_width'] = 100;
        $config['max_height'] = 100;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image_type')) {
            $error = array('error' => $this->upload->display_errors());
            $this->form_validation->set_message("uploadIcon", $this->upload->display_errors());
            return false;
        } 
        $this->upload_data = $this->upload->data();
        return true;
    }
    
    public function _filter_pre_save(&$data) {
        if ($this->upload_data) {
            $data['image_type'] = $this->upload_data['file_name'];
        }
    }
    
    public function _pre_form(&$model, &$data) {
        $model->fields['image_type']['append'] .= "<div class='col-md-12'><div class='col-md-2'></div><div class='col-md-8'><img src='". base_url()."assets/img/eventos/{$data[0]['values']['image_type']}' class='img-thumbnail' style='background: #333'></div></div>";
    }

}
