<?php include_once(dirname(__FILE__)."/../../site/header.php"); ?>
<div class="container" style="min-height: 350px">
    <h1 class="text-danger">Olá Chef <?php echo "{$name} {$lastname}"; ?>,</h1>
    <?php if ($status == "pendding"): ?>
        <h3>Seu email já foi confirmado!</h3>
        <h3>Seu cadastro está quase completo. Sua solicitação está em análise ok? Fique atento a sua caixa de entrada e em breve você receberá um email de confirmação.</h3>
        <h4>O Dinner for Friends preza pela segurança dos Chefs e por isso selecionamos pessoas que realmente amam cozinhar! Não se preocupe, nosso objetivo é fazer parte do crescimento da comunidade Gastronômica!</h4>
    <?php endif; ?>
    <?php if ($status == "enable"): ?>
        <h3>Sua conta já foi ativada! </h3>
        <h4>Agora você faz parte da nossa rede de amigos. Acesse o nosso <a href="<?php echo SITE_URL ?>">site</a> e desfrute!</h4>
        <h5>Já baixou o aplicativo? Nele você tem acesso as informações sobre seu eventos criados e também pode receber convites de seus amigos cozinheiros. Aproveite!</h5>
    <?php endif; ?>
</div>
<?php include_once(dirname(__FILE__)."/../../site/footer.php"); ?>