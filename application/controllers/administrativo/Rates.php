<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once(dirname(__FILE__) . '/BaseCrud.php');

class Rates extends BaseCrud {

    var $modelname = 'rates'; /* Nome do model sem o "_model" */
    var $base_url = 'administrativo/rates';
    var $actions = 'RU';
    var $titulo = 'Taxas';
    var $tabela = 'rate_global,rate_service';
    var $campos_busca = 'rate_global';


    public function __construct() {
        parent::__construct();
    }

}


