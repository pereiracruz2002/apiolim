<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<?php
    $params = "?code={$code}&email=".urlencode($email)."";
    $link = SITE_URL."api/usuario/ConfirmarEmail/{$params}";
?>
<div class="container">
    <h1>Olá Comilão <?php echo "{$name} {$lastname}"; ?>,</h1>
    <h3>Estamos felizes com a sua participação.</h3>
    <h4><a href="<?php echo $link; ?>">Clique aqui</a> <?php echo ("para ativar a sua conta!") ?></h4>
    <br/>
    <h5>Abraço,<br/> equipe Dinner 4 Friends.</h5>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>