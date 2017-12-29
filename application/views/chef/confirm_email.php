<?php include_once(dirname(__FILE__) . '/../site/header.php'); ?>
<div class="container" style="min-height: 350px">
    <div class="col-sm-10 col-sm-offset-1">
        <h2 class="text-danger">Oopa Chef <?php echo $user->name . ' ' . $user->lastname ?>,</h2>
        <h4>O seu cadastro está quase completo!
            <br/>Acesse o seu email e clique no link para confirmar a sua conta para que o seu perfil possa entrar processo de análise pela equipe do Dinner for Friends.</h4>
        <!--<p>Sua solicitação está em análise pela equipe do Dinner for Friends <br /> 
        e em breve você receberá um email com a confirmação!<br />
        Obrigado por acessar o Dinner for Friends!</p>-->
    </div>

    <div class="col-sm-9 col-md-6 col-sm-offset-2 col-md-offset-3 text-muted marginTop">
        <div class="col-sm-4 text-center">
            <span class="circle-purple"><i class="fa fa-bars"></i></span>
            <strong>Cadastro efetuado</strong>
        </div>
        <div class="col-sm-4 text-center">
            <span class="circle-gray center-icon"><i class="d4ficon-3"></i></span>
            <strong>Em análise</strong>
        </div>
        <div class="col-sm-4 text-center">
            <span class="circle-gray"><i class="fa fa-check"></i></span>
            <strong>Confirmação</strong>
        </div>
    </div>
</div>
<?php include_once(dirname(__FILE__) . '/../site/footer.php'); ?>