<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="cadastro well">
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0">
            <article class="row">
                <div>
                    <h2><strong class="text-danger">Atualizar cadastro!</strong></h2>
                    <p><strong>Oi, Chef!</strong></p>
                    <p>Atualize o seu cadastro e tenha acesso as vantagens de ser um cozinheiro Dinner for Friends</p>			
                </div><!--fim do header-->
                <div class="area-message-errors">
                    <?php echo validation_errors('<div class="text-danger error">', '</div>'); ?>
                </div>
                <!--<form id="form_register_user" method="post">-->
                <?php echo form_open(); ?>
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="field_name">Nome*</label>
                        <input type="text" id="field_name" name="field_name" class="form-control" value="<?php echo (set_value('field_name')) ? set_value('field_name') : (isset($user->name) ? $user->name : "") ?>" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="field_lastname">Sobrenome*</label>
                        <input type="text" id="field_lastname" name="field_lastname" class="form-control" value="<?php echo (set_value('field_lastname')) ? set_value('field_lastname') : (isset($user->lastname) ? $user->lastname : "") ?>" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="field_sex">Sexo*</label>
                        <select class="form-control" id="field_sex" name="field_sex">
                            <?php
                            $options_sexo = array(
                                '' => 'Escolha uma opção',
                                'masculino' => 'Masculino',
                                'feminino' => 'Feminino'
                            );
                            $selected = (set_value('field_sex')) ? set_value('field_sex') : ((isset($user->sexo)) ? $user->sexo : "");
                            foreach ($options_sexo as $key => $option):
                                if ($selected == $key):
                                    ?>
                                    <option value="<?php echo $key ?>" selected="selected"><?php echo $option ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $key ?>"><?php echo $option ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="field_nascimento">Data de nascimento*</label>
                        <input type="text" data-mask="00/00/0000" id="field_nascimento" name="field_nascimento" class="form-control" value="<?php echo $this->input->post('field_nascimento', (isset($user->nascimento)) ? date("d/m/Y", strtotime($user->nascimento)) : "") ?>" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="field_phone">Telefone / Celular*</label>
                        <input type="text" id="field_phone" name="field_phone" class="form-control" value="<?php echo (set_value('field_phone')) ? set_value('field_phone') : (isset($user->telefone) ? $user->telefone : "") ?>" />
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="field_cep">CEP*</label>
                        <input type="text" data-mask="00000-000" id="field_cep" name="field_cep" class="form-control" value="<?php echo (set_value('field_cep')) ? set_value('field_cep') : (isset($user->cep) ? $user->cep : "") ?>" />
                    </div>
                    <div class="form-group col-sm-7">
                        <label for="field_city">Cidade*</label>
                        <div class="ui-widget">
                            <input type="text" class="form-control" name="field_city" id="field_city" value="<?php echo (set_value('field_city')) ? set_value('field_city') : (isset($user->cidade) ? $user->cidade : "") ?>" />
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="field_state">Estado*</label>
                        <div class="ui-widget">
                            <input type="text" class="form-control" name="field_state" id="field_state" value="<?php echo (set_value('field_state')) ? set_value('field_state') : (isset($user->estado) ? $user->estado : "") ?>" />
                        </div>
                    </div>
                    <div class="form-group col-sm-7">
                        <label for="field_address">Endereço*</label>
                        <div class="ui-widget">
                            <input type="text" class="form-control" name="field_address" id="field_address" value="<?php echo (set_value('field_address')) ? set_value('field_address') : (isset($user->endereco) ? $user->endereco : "") ?>" />
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="field_number">Número*</label>
                        <input type="text" id="field_number" name="field_number" class="form-control" value="<?php echo (set_value('field_number')) ? set_value('field_number') : (isset($user->numero) ? $user->numero : "") ?>" />
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="field_complement">Complemento</label>
                        <div class="ui-widget">
                            <input type="text" class="form-control" name="field_complement" id="field_complement" value="<?php echo (set_value('field_complement')) ? set_value('field_complement') : (isset($user->complemento) ? $user->complemento : "") ?>" />
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="field_email">E-mail*</label>
                        <input type="email" id="field_email" name="field_email" class="form-control" value="<?php echo (set_value('field_email')) ? set_value('field_email') : (isset($user->email) ? $user->email : "") ?>" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="field_confirm_email">Confirmar e-mail*</label>
                        <input type="email" id="field_confirm_email" name="field_confirm_email" class="form-control" value="<?php echo (set_value('field_confirm_email')) ? set_value('field_confirm_email') : (isset($user->email) ? $user->email : "") ?>" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="field_password">Crie uma senha de 6 ou mais digitos*</label>
                        <input type="password" id="field_password" name="field_password" class="form-control" value="<?php echo set_value('field_password') ?>" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="field_confirm">Confirmar senha*</label>
                        <input type="password" id="field_confirm" name="field_confirm" class="form-control" value="<?php echo set_value('field_confirm') ?>" />
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="field_about_you">Sobre você</label>
                        <select class="form-control" name="field_about_you" id="field_about_you">
                            <?php
                            $options_about = array(
                                '' => 'Escolha',
                                'Sou Cozinheiro(a) da família' => 'Sou Cozinheiro(a) da família',
                                'Sou Chef recém formado' => 'Sou Chef recém formado',
                                'Sou Chef experiente' => 'Sou Chef experiente',
                                'Tenho um restaurante próprio' => 'Tenho um restaurante próprio'
                            );
                            $selected = (set_value('field_about_you')) ? set_value('field_about_you') : ((isset($user->sobrevoce)) ? $user->sobrevoce : "");
                            foreach ($options_about as $key => $option):
                                if ($selected == $key):
                                    ?>
                                    <option value="<?php echo $key ?>" selected="selected"><?php echo $option ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $key ?>"><?php echo $option ?></option>
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="msg">Conte-nos sobre suas experiências gastronómicas*</label>
                        <p>Essa será sua mensagem de apresentação aos seus convidados.<br/>Você poderá altera-lá quando quiser após o cadastro, na sua área de Chef.</p>
                        <textarea class="form-control" rows="5" id="field_message" name="field_message"><?php echo (set_value('field_message')) ? set_value('field_message') : (isset($user->mensagem) ? $user->mensagem : "") ?></textarea>
                        <div class="text-default contador-char">Máximo de 1000 caracteres</div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="">Profissão</label>
                        <input type="text" class="form-control" id="field_profession" name="field_profession" value="<?php echo (set_value('field_profession')) ? set_value('field_profession') : (isset($user->profissao) ? $user->profissao : "") ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="">Formação</label>
                        <input type="text" class="form-control" id="field_formation" name="field_formation" value="<?php echo (set_value('field_formation')) ? set_value('field_formation') : (isset($user->formacao) ? $user->formacao : "") ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <form id="form_upload" method="post" enctype="multipart/form-data">
                            <div class="form-group has-feedback group-upload">
                                <label for="">Currículo (opcional)</label>
                                <input type="hidden" name="field_curriculo" id="field_curriculo" value="<?php echo set_value('field_curriculo'); ?>" />
                                <input type="file" name="curriculo" id="curriculo" value="" class="form-control" />
                                <span class="glyphicon glyphicon-ok form-control-feedback upload-ok hide" aria-hidden="true"></span>
                                <span class="glyphicon glyphicon-remove form-control-feedback upload-error hide" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                            <div class="cols-sm-6 area-message text-info" data-message="Formato permitido: PDF">Formato permitido: PDF</div>
                        </form>
                    </div>
                    <div class="row"></div>
                    <!--<div class="form-group col-sm-12">
                        <label for="">Currículo (opcional)</label>
                        <textarea class="form-control" id="field_curriculum" name="field_curriculum"><?php echo set_value('field_curriculum'); ?></textarea>
                    </div>-->
                    <?php /* <div class="form-group col-sm-6">
                      <label for="formGroupExampleInput2">Código de Parceria (opcional)</label>
                      <input type="text" class="form-control form-control-sm" id="field_code" name="field_code" />
                      </div>
                      <div class="form-group col-sm-6">
                      <label></label>
                      <p>Se você não tem um código de parceria, o seu cadastro será avaliado pela equipe Dinner for Friends.</p>
                      </div> */ ?>

                    <div class="form-group col-sm-12">
                        <div class="col-right">
                            <label>
                            <input type="checkbox" name="field_license" id="field_license" <?php echo (set_value('field_license')) ? 'checked="checked"' : ''; ?> /> Li e aceito os <a href="<?php echo site_url('termos') ?>" target="_blank">termos de adesão</a>
                            </label>
                            <button type="submit" class="btn btn-cadastro">Atualizar cadastro</button>
                        </div>
                    </div>
                    <!--</form>-->
                </div>
            </article>					
        </div>					
    </div>	
</div><!--cadastro-->	
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
<script>
    $('document').ready(function () {
        var site = $("#site").val();
        var curriculo;
        var license = $('#field_license')
        if (license.is(':checked'))
            $("#field_license").attr("checked", "checked");
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        }, spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
        $('input[name=field_phone]').mask(SPMaskBehavior, spOptions);

        $("#curriculo").on('change', function (e) {
            form = new FormData();
            form.append('curriculo', e.target.files[0]);

            $.ajax({
                url: site + "api/upload/curriculo",
                type: "POST",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var convert = JSON.parse(data);
                    if (convert.error) {
                        $('.area-message').removeClass('text-info').addClass('text-danger').html(convert.error);
                        $(".upload-error").removeClass('hide');
                        $('.group-upload').removeClass('has-success').addClass('has-error');
                        if (!$('.upload-ok').hasClass('hide')) {
                            $('.upload-ok').toggleClass('hide');
                        }
                        $('#field_curriculo').val("");
                    } else {
                        $('.upload-ok').removeClass('hide');
                        $('.group-upload').removeClass('has-error').addClass('has-success');
                        if (!$('.upload-error').hasClass('hide')) {
                            $('.upload-error').toggleClass('hide');
                        }
                        $('#curriculo').attr('disabled', 'disabled');
                        var btn_remove = "<button type=\"button\" class=\"btn btn-danger btn-sm btn-remove-curriculo\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>Substituir / Remover currículo</button>";
                        $(".area-message").removeClass('text-danger').removeClass('text-info').html(btn_remove);
                        $('#field_curriculo').val(convert.upload_data.file_name);
                    }
                }
            });
        });

        $("body").on('click', '.btn-remove-curriculo', function () {
            var token = $('#token').val();
            $.post(site + 'api/upload/remove',
                    {'file': $("#field_curriculo").val(), 'token': token},
                    function (data) {
                        data = JSON.parse(data);
                        var msg = $(".area-message").attr("data-message");
                        $('.area-message').text(msg).addClass('text-info');
                        $('.group-upload').removeClass('has-error').removeClass('has-success');
                        $('#curriculo').removeAttr('disabled').val("");
                        if (!$('.upload-ok').hasClass('hide'))
                            $('.upload-ok').addClass('hide');
                        if (!$('.upload-error').hasClass('hide'))
                            $('.upload-error').addClass('hide');
                        $('#field_curriculo').val("");
                    });
        });

        var max_character = 1000;
        var count_character = 0;
        $("[name=field_message]").keypress(function (ev) {
            count_character = $(this).val().length;
            if (count_character == max_character)
                ev.preventDefault();
        });
        $("[name=field_message]").keyup(function (ev) {
            count_character = $(this).val().length;
            $(".contador-char").text((count_character) + " de " + max_character + " caracteres");
        });
    });
</script>
