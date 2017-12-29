<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="hero hero-right">
    <img src="<?php echo base_url() ?>assets/img/site/fale.jpg" class="img-banner" />
</div>
<div class="contato">
    <div class="col-sm-10">
        <div class="page-title">
            <h2 class="text-danger"><strong>Fale conosco!</strong></h2>
        </div>

        <div class="row">
            <form class="col-sm-9 form-contato" method="post" action="<?php echo current_url() ?>">
                <?php if (isset($msg)): ?>
                    <?php echo $msg; ?>
                <?php endif ?>
                <div class="form-group">
                    <label for="nome">Seu nome*</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                </div>

                <div class="form-group">
                    <label for="email">Seu e-mail*</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="assunto">Assunto</label>
                    <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Assunto" required>
                </div>
                <div class="form-group">
                    <label for="msg">Mensagem</label>
                    <textarea class="form-control" id="msg" name="msg" placeholder="Mensagem" rows="10" required></textarea>
                    <label>Os campos sinalizados são obrigatórios</label>
                </div>
                <button type="submit" class="btn btn-danger btn-lg unic">Enviar</button>
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
