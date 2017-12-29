<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Administrativo</title>
        <link href="<?php echo base_url() ?>administrativo-assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/font-d4f.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>administrativo-assets/css/dashboard.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>administrativo-assets/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>administrativo-assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lightslider.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/croppie.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datepicker3.min.css" />

        <?php if (isset($cssFiles)): ?>
            <?php foreach ($cssFiles as $item): ?>
                <link rel="stylesheet" href="<?php echo base_url() ?>administrativo-assets/css/<?php echo $item ?>" />
            <?php endforeach; ?>
        <?php endif; ?>
        <script>
            var base_url = '<?php echo site_url('administrativo') ?>/';
            var site_url = '<?php echo site_url('/') ?>';
        </script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="show" data-target="#navside" aria-expanded="false" aria-controls="navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('administrativo/painel') ?>">Dinner for Friends</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo site_url('administrativo/login/sair') ?>">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar show" id="navside">
                    <ul class="nav nav-sidebar">
                        <li><a href="<?php echo site_url('administrativo/admins') ?>">Administradores</a></li>
                        <li><a href="<?php echo site_url('administrativo/chefs') ?>">Chefs</a></li>
                        <li><a href="<?php echo site_url('administrativo/convidados') ?>">Convidados</a></li>
                        <li><a href="<?php echo site_url('administrativo/acompanhantes') ?>">Acompanhantes</a></li>
                        <li><a href="<?php echo site_url('administrativo/tipoEventos') ?>">Tipos de Eventos</a></li>
                        <li><a href="<?php echo site_url('administrativo/eventosPublicos') ?>">Eventos Públicos</a></li>
                        <li><a href="<?php echo site_url('administrativo/eventosPrivados') ?>">Eventos Privados</a></li>
                        <li><a href="<?php echo site_url('administrativo/conteudo') ?>">Conteúdo</a></li>
                        <?php /* <li><a href="<?php echo site_url('administrativo/relatorios') ?>">Relatórios</a></li> */ ?>
                        <li>
                            <a href="<?php echo site_url('administrativo/solicitacoes') ?>">
                                Solicitações <span class="badge" id="solicitacoes_badge"></span>
                            </a>
                        </li>
                        <li><a href="<?php echo site_url('administrativo/rates') ?>">Taxas Global</a></li>
                        <li><a href="<?php echo site_url('administrativo/free_events') ?>">Taxas Evento Gratuito</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
