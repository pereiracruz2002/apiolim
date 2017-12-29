<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="container">
    <h1>Olá <?php echo "{$name} {$lastname}"; ?>,</h1>
    <h3>Sua solicitação à chefe não foi aceita!</h3>
    <h4>Entre em contato no e-mail <a href="mailto:app@dinner4friends.com.br?Subject=Solicitação%20não%20aceita-%20<?php echo $email ?>" target="_top">app@dinner4friends.com.br</a> caso queira saber o motivo.</h4>
    <h4>Você permanece com acesso de usuário comilão.</h4>
    <br/>
    <h5>Abraço,<br/> equipe Dinner 4 Friends.</h5>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>