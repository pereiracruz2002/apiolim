<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class Conteudo extends BaseCrud 
{
    var $modelname = 'content'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/conteudo';
    var $actions = 'CRUD';
    var $titulo = 'Conteúdo';
    var $tabela = 'title,sort';
    var $campos_busca = 'title';

    public function __construct() 
    {
        parent::__construct();
        $this->data['jsFiles'] = array('tinymce/tinymce.min.js');
    }
    public function getPermalink($count=0) 
    {
        $this->load->model('content_model','content');
        $url = url_title($this->input->post('title'), '-', true);
        $i=true;
        while($i){
            if($count > 0){
                $url .= '-'.$count;
            }

            $where = array('permalink' => $url);
            $conteudo = $this->content->count_where($where);
            if($conteudo){
                $count++;
                $where['permalink'] = $url.($count);
            } else {
                $i=false;
            }
        }
        $this->output->set_content_type('application/json')
            ->set_output(json_encode($where));

    }
}
