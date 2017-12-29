<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="hero hero-right" style="margin-top: -3px">
    <img src="<?php echo base_url() ?>assets/img/site/area-chef.jpg" class="img-banner" />
</div>

<div class="login">
    <div class="col-sm-10">
        <div class="page-title">
            <h2 class="text-danger"><strong>Área do Chef</strong></h2>
            <div class="row">
                <div class="col-sm-8">
                    <h3><strong>Oi, Chef!</strong></h3>
                    <h4>Faça seu login e senha  e tenha acesso a todas as informações sobre seus encontros gastronômicos.</h4>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-7">
                <div class="well bg-danger">
                    <form method="post" action="<?php echo current_url() ?>">
                        <?php if (isset($msg)): ?>
                            <p class="alert alert-danger"><?php echo $msg ?></p>
                        <?php endif; ?>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                        </div>
                        <button class="btn btn-block btn-link" data-toggle="modal" type="button" data-target="#recuperar_senha">Esqueci minha senha</button>
                        <button class="btn btn-block btn-danger btn-lg">OK</button>
                    </form>
                </div>

                <?php /* <button class="btn btn-block btn-primary fbLogin border-round"><i class="fa fa-facebook" style="height: 30px; padding-top: 7px;"></i> Entrar com Facebook</button> */ ?>

                <div class="pos-login">
                    <?php /* <p class="text-center text-danger h3"><strong>ou</strong></p>*/ ?>
                    <a href="<?php echo site_url('cadastro') ?>" class="btn btn-cadastro btn-danger border-round btn-block btn-lg">Cadastre-se</a>
                </div>

            </div>
        </div>
    </div>


</div>

<div class="modal fade" tabindex="-1" role="dialog" id="recuperar_senha">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Recuperar senha</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('api/usuario/lembrarSenha') ?>" method="post">
          <div class="input-group">
              <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Digite aqui seu Email" required>
              <span class="input-group-btn">
                <button type="submit" class="btn btn-danger">Recuperar Senha</button>
              </span>
          </div>
        </form>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
