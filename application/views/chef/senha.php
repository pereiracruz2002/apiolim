<?php include_once(dirname(__FILE__).'/header.php'); ?>

<div class="well bg-white">
    <div class="row user_perfil">
        <div class="row block_title">
            <div class="col-sm-10 h5_info">Alterar Senha</div>
        </div>
        <div class="row">
            <?php if(isset($save)) echo $save; ?>
            <form method="post" class="form-horizontal">
                <?php echo $form ?>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button class="btn btn-danger">Alterar Senha</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
