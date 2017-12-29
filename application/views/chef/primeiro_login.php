<?php include_once(dirname(__FILE__).'/../site/header.php'); ?>
<div class="container">
    <div class="col-sm-10 col-sm-offset-1">
        <h2 class="text-danger h4"><strong>Oi Chef <?php echo $user->name.' '.$user->lastname ?>!</strong></h2>

        <h5><strong>Seja bem vindo!</strong></h5>
        <p>Sua conta foi ativada com sucesso, agora você já faz parte da nossa rede de amigos! <br /> 
        Clique no botão "Acessar a minha Área do Chef" abaixo e comece a criar seus eventos e desfrutar das vantagens de ser um Cozinheiro na rede Dinner for Friends!</p>
    </div>

    <div class="clearfix"></div>
    <div class="well well-transparent">
        <div class="col-sm-4 col-sm-offset-4">
            <a href="<?php echo site_url('chef/painel') ?>" class="btn btn-block btn-success border-round">Acessar a minha Área do Chef</a>
        </div> 
    </div>
    <div class="col-sm-9 col-md-6 col-sm-offset-2 col-md-offset-3 text-muted marginTop cadastroCompleto">
        <div class="col-sm-4 text-center">
            <span class="circle-purple"><i class="fa fa-bars"></i></span>
            <strong>Cadastro efetuado</strong>
        </div>
        <div class="col-sm-4 text-center">
            <span class="circle-purple center-icon"><i class="d4ficon-3"></i></span>
            <strong>Em análise</strong>
        </div>
        <div class="col-sm-4 text-center">
            <span class="circle-green"><i class="fa fa-check"></i></span>
            <strong>Confirmação</strong>
        </div>

    </div>
</div>
<?php include_once(dirname(__FILE__).'/../site/footer.php'); ?>
