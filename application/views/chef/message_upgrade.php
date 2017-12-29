<?php include_once(dirname(__FILE__) . '/../site/header.php'); ?>
<div class="container" style="min-height: 350px">
    <div class="col-sm-10 col-sm-offset-1">
        <h2 class="text-danger"><strong>Oi Comilão <?php echo $user->name . ' ' . $user->lastname ?>,</strong></h2>
        <h4><strong>Seja bem vindo!</strong></h4>
        <h3 class="text-center">Sua conta é de acesso de comilão. Gostaria de se tornar um Chef?</h3>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="col-sm-6 text-center">
            <a href="#" class="btn-upgrade">
                <span class="circle-green"><i class="fa fa-check"></i></span>
                <strong>Sim, atualizar minha conta</strong>
            </a>
        </div>
        <div class="col-sm-6 text-center">
            <a href="#" class="btn-continue-comilao">
                <span class="circle-red"><i class="fa fa-close"></i></span>
                <strong>Não, continuar como comilão</strong>
            </a>
        </div>
    </div>
</div>
<?php include_once(dirname(__FILE__) . '/../site/footer.php'); ?>