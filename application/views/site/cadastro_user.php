<?php include_once(dirname(__FILE__).'/header.php'); ?>

<div class="cadastro">
  <header>
    <h2><strong class="text-danger">Cadastre-se!</strong></h2>
    <p>Mensagem de cadastro para o usuário</p>
  </header>
  <div class="container">
    <div class="row">
      <div class="col-sm-10 col-offset-1">
        <article class="row">
          <div class="area-message-errors">
            <?php echo validation_errors('<div class="text-danger error">', '</div>'); ?>
          </div>
          <div class="col-sm-12 well-cadastro">
            <!--<form id="form_register_user" method="post">-->
              <?php echo form_open(); ?>
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="field_name">Nome*</label>
                  <input type="text" id="field_name" name="field_name" class="form-control" placeholder="Nome" value="<?php echo set_value('field_name'); ?>" />
                </div>
                <div class="form-group col-sm-6">
                  <label for="field_lastname">Sobrenome*</label>
                  <input type="text" id="field_lastname" name="field_lastname" class="form-control" placeholder="Sobrenome" value="<?php echo set_value('field_lastname'); ?>" />
                </div>
                <div class="form-group col-sm-4">
                  <label for="field_cep">CEP*</label>
                  <input type="text" id="field_cep" name="field_cep" class="form-control" placeholder="CEP" value="<?php echo set_value('field_cep'); ?>" />
                </div>
                <div class="form-group col-sm-8">
                  <label for="field_address">Endereço*</label>
                  <div class="ui-widget">
                    <input type="text" class="form-control" name="field_address" id="field_address" placeholder="Rua / Avenida - Bairro, Cidade, Estado" value="<?php echo set_value('field_address'); ?>" />
                  </div>
                </div>
                <div class="form-group col-sm-4">
                  <label for="field_number">Número</label>
                  <input type="text" id="field_number" name="field_number" class="form-control" placeholder="Número" value="<?php echo set_value('field_number'); ?>" />
                </div>

                <div class="form-group col-sm-4">
                  <label for="field_phone">Telefone*</label>
                  <input type="text" id="field_phone" name="field_phone" class="form-control" placeholder="Telefone" value="<?php echo set_value('field_phone'); ?>" />
                </div>
                <div class="form-group col-sm-4">
                  <label for="field_sex">Sexo*</label>
                  <select class="form-control" id="field_sex" name="field_sex">
                    <option value="masculino">Masculino</option>
                    <option value="masculino">Feminino</option>
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <label for="field_email">E-mail*</label>
                  <input type="email" id="field_email" name="field_email" class="form-control" placeholder="E-mail" value="<?php echo set_value('field_email'); ?>" />
                </div>
                <div class="form-group col-sm-3">
                  <label for="field_password">Senha*</label>
                  <input type="password" id="field_password" name="field_password" class="form-control" placeholder="Senha" value="<?php echo set_value('field_password'); ?>" />
                </div>
                <div class="form-group col-sm-3">
                  <label for="field_confirm">Confirmar*</label>
                  <input type="password" id="field_confirm" name="field_confirm" class="form-control" placeholder="Confirme a senha" value="<?php echo set_value('field_confirm'); ?>" />
                </div>
                <div class="form-group col-sm-3">
                  <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
              </div>

            <!--</form>-->
          </div>
        </article>
      </div>
    </div>
  </div>
</div>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
