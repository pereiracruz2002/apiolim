<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="page_ativacao">
    <h2>
        <h2><strong class="text-danger">Ativação de conta</strong></h2>
        <?php if (isset($msg['success'])) : ?>
            <h4><?php echo $msg['success'] ?></h4>
            <h5>Você será redirecionado para a tela de Login...</h5>
            <script>
                setTimeout(function(){
                    window.location = "<?php echo SITE_URL; ?>login/"
                }, 5000);
            </script>
        <?php elseif (isset($msg['error'])) : ?>
            <h4 class="text-danger"><?php echo $msg['error']?></h4>
        <?php endif; ?>
    </h2>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>