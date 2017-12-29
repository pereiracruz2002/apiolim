<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class Free_events extends BaseCrud {

    var $modelname = 'free_invitation'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/free_events';
    var $actions = 'RU';
    var $titulo = 'Taxa Evento Gratuito';
    var $tabela = 'value_free_invitation';
    var $campos_busca = 'value_free_invitation';


    public function __construct() {
        parent::__construct();
    }

}


