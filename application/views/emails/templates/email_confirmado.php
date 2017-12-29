<?php include_once(dirname(__FILE__) . "/../../site/header.php"); ?>
<div class="container" style="min-height: 350px">
    <div class="col-sm-10 col-sm-offset-1">
        <h2 class="text-danger">Olá Chef <?php echo "{$name} {$lastname}"; ?>,</h2>
        <h4>Seu email foi confirmado com sucesso!
            <br/>Seu cadastro está quase completo. Sua solicitação está em análise, ok? Fique atento a sua caixa de entrada e em breve você receberá um email de confirmação.</h4>
        <h5>O Dinner for Friends preza pela segurança dos Chefs e por isso selecionamos pessoas que realmente amam cozinhar! Não se preocupe, nosso objetivo é fazer parte do crescimento da comunidade Gastronômica!</h5>
    </div>
    <div class="col-sm-9 col-md-6 col-sm-offset-2 col-md-offset-3 text-muted marginTop">
        <div class="col-sm-4 text-center">
            <span class="circle-purple"><i class="fa fa-bars"></i></span>
            <strong>Cadastro efetuado</strong>
        </div>
        <div class="col-sm-4 text-center">
            <span class="circle-purple center-icon"><i class="d4ficon-3"></i></span>
            <strong>Em análise</strong>
        </div>
        <div class="col-sm-4 text-center">
            <span class="circle-gray"><i class="fa fa-check"></i></span>
            <strong>Confirmação</strong>
        </div>
    </div>
</div>
<?php include_once(dirname(__FILE__) . "/../../site/footer.php"); ?>