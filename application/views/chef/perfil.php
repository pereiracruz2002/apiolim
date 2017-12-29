<?php include_once(dirname(__FILE__).'/header.php'); ?>
<input type="hidden" name="token" id="token" value="<?php echo $token ?>" />
<div class="well well-sm bg-white well-title">
    <h5 class="title_header"><strong>Chef</strong> <?php echo "{$user['name']} {$user['lastname']}" ?></h5>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row user_perfil">
                <div class="row block_title">
                    <div class="col-sm-10 h5_info">Perfil</div>
                    <div class="col-sm-2 text-right">
                        <button class="btn-edit" data-id="user_perfil">Editar</button>
                        <button class="btn-cancel hide" data-id="user_perfil">Cancelar</button>
                        <button class="btn-save hide" data-id="user_perfil" data-type="user">Salvar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Foto de perfil:</label></div>
                    <div class="col-sm-9 noedit-user_perfil">
                        <img src="<?php echo base_url() ?>uploads/<?php echo $user['picture'] ?>" class="perfil-picture" />
                    </div>

                    <div class="col-sm-9 form-group edit-user_perfil hide">
                        <div class="col-sm-6">
                            <form id="form_upload_picture" method="post" enctype="multipart/form-data">
                                <div class="form-group has-feedback group-upload">
                                    <input type="hidden" class="user_perfil" name="picture" id="picture" value="<?php echo $user['picture'] ?>" data-id="<?php echo $user['picture'] ?>" />
                                    <input type="file" id="photo" value="" class="form-control" />
                                    <span class="glyphicon glyphicon-ok form-control-feedback upload-ok hide" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-remove form-control-feedback upload-error hide" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                <div class="box_photo">
                                    <input type="hidden" name="photo" value="" class="formPhoto">

                                    <div style="width:600px; text-align:center;">
                                      <h1>Selecione a area de imagem</h1>
                                      <img src='' class="photo" style='max-width:500px' />
                                      <div class="thumbs" style="padding:5px;"></div>
                                    </div>
                                    <p style="display:block;text-align: center;"><input type="button" class="enviarCrop" style="display: none;padding: 5px;" value="Cortar imagem"></p>
                                </div>
                                <div class="cols-sm-6 area-message text-info" data-message="Formato permitido: JPG e PNG">Formato permitido: JPG e PNG</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row info_aboutyou">
                <div class="row block_title">
                    <div class="col-sm-10 h5_info">Sobre você</div>
                    <div class="col-sm-2 text_right">
                        <button class="btn-edit" data-id="info_aboutyou">Editar</button>
                        <button class="btn-cancel hide" data-id="info_aboutyou">Cancelar</button>
                        <button class="btn-save hide" data-id="info_aboutyou" data-type="info">Salvar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Sobre você:</label></div>
                    <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['sobrevoce'][0]) ? $user['info']['sobrevoce'][0] : '' ) ?></div>
                    <div class="col-sm-9 form-group edit-info_aboutyou hide">
                        <div class="col-sm-6">
                            <select class="form-control info_aboutyou" name="sobrevoce" id="sobrevoce" data-id="<?php echo (isset($user['info']['sobrevoce'][1]) ? $user['info']['sobrevoce'][1] : '') ?>">
                                <option value="">Escolha</option>
                                <option>Sou Cozinheiro(a) da família</option>
                                <option>Sou Chef recém formado</option>
                                <option>Sou Chef experiente</option>
                                <option>Tenho um restaurante próprio</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Prato preferido:</label></div>
                    <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['pratopreferido'][0]) ? $user['info']['pratopreferido'][0] : '') ?></div>
                    <div class="col-sm-9 form-group edit-info_aboutyou hide">
                        <div class="col-sm-6">
                            <input type="text" class="form-control info_aboutyou" id="pratopreferido" name="pratopreferido" value="<?php echo (isset($user['info']['pratopreferido'][0]) ? $user['info']['pratopreferido'][0] : '') ?>" data-id="<?php echo (isset($user['info']['pratopreferido'][1]) ? $user['info']['pratopreferido'][1] : '') ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Profissão:</label></div>
                    <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['profissao'][0]) ? $user['info']['profissao'][0] : '') ?></div>
                    <div class="col-sm-9 form-group edit-info_aboutyou hide">
                        <div class="col-sm-6">
                            <input type="text" class="form-control info_aboutyou" id="profissao" name="profissao" value="<?php echo (isset($user['info']['profissao'][0]) ? $user['info']['profissao'][0] : '') ?>" data-id="<?php echo (isset($user['info']['profissao'][1]) ? $user['info']['profissao'][1] : '') ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Formação:</label></div>
                    <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['formacao'][0]) ? $user['info']['formacao'][0] : '') ?></div>
                    <div class="col-sm-9 form-group edit-info_aboutyou hide">
                        <div class="col-sm-6">
                            <input type="text" class="form-control info_aboutyou" id="formacao" name="formacao" value="<?php echo (isset($user['info']['formacao'][0]) ? $user['info']['formacao'][0] : '') ?>" data-id="<?php echo isset($user['info']['formacao'][1]) ? $user['info']['formacao'][1] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Currículo</label></div>
                    <div class="col-sm-9 noedit-info_aboutyou">
                        <?php if (isset($user['info']['curriculo'][0]) && $user['info']['curriculo'][0] != ""): ?>
                            <a href="<?php echo SITE_URL."uploads/".$user['info']['curriculo'][0]; ?>" target="_blank">Ver currículo</a>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-9 form-group edit-info_aboutyou hide">
                        <div class="col-sm-6">
                            <form id="form_upload_curriculo" method="post" enctype="multipart/form-data">
                                <div class="form-group has-feedback group-upload">
                                    <input type="hidden" class="info_aboutyou" name="fcurriculo" id="field_curriculo" value="<?php echo $user['info']['curriculo'][0]; ?>" data-id="<?php echo $user['info']['curriculo'][1] ?>" />
                                    <input type="file" id="curriculo" value="" class="form-control" />
                                    <span class="glyphicon glyphicon-ok form-control-feedback upload-ok hide" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-remove form-control-feedback upload-error hide" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                                <div class="cols-sm-6 area-message text-info" data-message="Formato permitido: PDF">Formato permitido: PDF</div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Mensagem de apresentação:</label></div>
                    <div class="col-sm-9 form-group noedit-info_aboutyou">
                        <?php echo isset($user['info']['mensagem'][0]) ? $user['info']['mensagem'][0] : '' ?>
                        <h6>
                            <strong>Escreva algo sobre você! (Ex: experiências gastronômicas, prato favorito etc)</strong>
                            Seus convidados terão acesso a essa informação quando receberem seu convite para um encontro gastronômico.
                            Esse texto será sua aprensentação, então capriche!
                        </h6>
                    </div>
                    <div class="col-sm-9 edit-info_aboutyou hide">
                        <div class="col-sm-12">
                            <textarea class="form-control info_aboutyou" rows="5" id="mensagem" name="mensagem" data-id="<?php echo $user['info']['mensagem'][1] ?>"><?php echo $user['info']['mensagem'][0] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row info_personal">
                <div class="row block_title">
                    <div class="col-sm-10 h5_info">Informações pessoais</div>
                    <div class="col-sm-2 text_right">
                        <button class="btn-edit" data-id="info_personal">Editar</button>
                        <button class="btn-cancel hide" data-id="info_personal">Cancelar</button>
                        <button class="btn-save hide" data-id="info_personal" data-type="info">Salvar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Data de nascimento:</label></div>
                    <div class="col-sm-9 noedit-info_personal"><?php echo isset($user['info']['nascimento'][0]) ? date("d/m/Y", strtotime($user['info']['nascimento'][0])) : '' ?></div>
                    <div class="col-sm-9 form-group noedit-info_personal hide">
                        <div class="col-sm-4">
                            <input type="text" data-mask="00/00/0000" id="nascimento" name="nascimento" class="form-control info_personal" value="<?php echo isset($user['info']['nascimento'][0]) ? date("d/m/Y", strtotime($user['info']['nascimento'][0])) : ''  ?>" data-id="<?php echo isset($user['info']['nascimento'][1]) ? $user['info']['nascimento'][1] : '' ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">E-mail:</label></div>
                    <div class="col-sm-9"><?php echo $user['email'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Telefone / Celular:</label></div>
                    <div class="col-sm-9 noedit-info_personal"><?php echo isset($user['info']['telefone'][0])? $user['info']['telefone'][0] : '' ?></div>
                    <div class="col-sm-9 form-group noedit-info_personal hide">
                        <div class="col-sm-4">
                            <input type="text" id="telefone" name="telefone" class="form-control info_personal" value="<?php echo isset($user['info']['telefone'][0])? $user['info']['telefone'][0] : '' ?>" data-id="<?php echo isset($user['info']['telefone'][1])? $user['info']['telefone'][1] : '' ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row info_address">
                <div class="row block_title">
                    <div class="col-sm-10 h5_info">Endereço</div>
                    <div class="col-sm-2 text_right">
                        <button class="btn-edit" data-id="info_address">Editar</button>
                        <button class="btn-cancel hide" data-id="info_address">Cancelar</button>
                        <button class="btn-save hide" data-id="info_address" data-type="info">Salvar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">CEP:</label></div>
                    <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['cep'][0]) ? $user['info']['cep'][0] : '' ?></div>
                    <div class="col-sm-9 form-group noedit-info_address hide">
                        <div class="col-sm-4">
                            <input type="text" data-mask="00000-000" id="cep" name="cep" class="form-control info_address" value="<?php echo isset($user['info']['cep'][0]) ? $user['info']['cep'][0] : '' ?>" data-id="<?php echo isset($user['info']['cep'][1]) ? $user['info']['cep'][1] : '' ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Endereço:</label></div>
                    <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['endereco'][0]) ? $user['info']['endereco'][0]. (isset($user['info']['numero'][0]) ? ', '.$user['info']['numero'][0] : '') : '' ?></div>
                    <div class="col-sm-9 form-group noedit-info_address hide">
                        <div class="col-sm-10">
                            <input type="text" class="form-control info_address" name="endereco" id="endereco" value="<?php echo isset($user['info']['endereco'][0]) ? $user['info']['endereco'][0] : '' ?>" data-id="<?php echo isset($user['info']['endereco'][1]) ? $user['info']['endereco'][1] : '' ?>" />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="numero" name="numero" class="form-control info_address" value="<?php echo isset($user['info']['numero'][0]) ? $user['info']['numero'][0] : '' ?>" data-id="<?php echo isset($user['info']['numero'][1]) ? $user['info']['numero'][1] : '' ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Complemento:</label></div>
                    <div class="col-sm-9 edit-info_address"><?php echo (isset($user['info']['complemento'][0]))? "{$user['info']['complemento'][0]}": "-" ?></div>
                    <div class="col-sm-9 form-group noedit-info_address hide">
                        <div class="col-sm-12">
                            <input type="text" class="form-control info_address" name="complemento" id="complemento" value="<?php echo (isset($user['info']['complemento'][0]))? "{$user['info']['complemento'][0]}": "" ?>"
                                   <?php echo (isset($user['info']['complemento'][1]))? "data-id='{$user['info']['complemento'][1]}'" : "" ?> />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Cidade / Estado:</label></div>
                    <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['cidade'][0]) ? $user['info']['cidade'][0] : '' ?><?php echo isset($user['info']['estado'][0]) ? ' / '.$user['info']['estado'][0] : '' ?></div>
                    <div class="col-sm-9 form-group noedit-info_address hide">
                        <div class="col-sm-10">
                            <input type="text" class="form-control info_address" name="cidade" id="cidade" value="<?php echo isset($user['info']['cidade'][0]) ? $user['info']['cidade'][0] : '' ?>" data-id="<?php echo isset($user['info']['cidade'][1]) ? $user['info']['cidade'][1] : '' ?>" />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control info_address" name="estado" id="estado" value="<?php echo isset($user['info']['estado'][0]) ? $user['info']['estado'][0] : '' ?>" data-id="<?php echo isset($user['info']['estado'][1]) ? $user['info']['estado'][1] : '' ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row info_bank">
                <div class="row block_title">
                    <div class="col-sm-10 h5_info">Dados bancários</div>
                    <div class="col-sm-2 text_right">
                        <button class="btn-edit" data-id="info_bank">Editar</button>
                        <button class="btn-cancel hide" data-id="info_bank">Cancelar</button>
                        <button class="btn-save hide" data-id="info_bank" data-type="info">Salvar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Banco:</label></div>
                    <div class="col-sm-9"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Agência:</label></div>
                    <div class="col-sm-9"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3"><label class="label_info">Conta:</label></div>
                    <div class="col-sm-9"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once(dirname(__FILE__).'/footer.php'); ?>
<script>
    $(document).ready(function(){
        $("#sobrevoce").val('<?php echo isset($user['info']['sobrevoce'][0])? "{$user['info']['sobrevoce'][0]}": "" ?>');
        $(".btn-edit").on('click', function(){
            var id = $(this).attr('data-id');
            switchButton(id);
        });

        $(".btn-save").on('click', function(){
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            
            if (type === "info") {
                getUserInfoData(id);
            } else if (type === "user") {
                getUserData(id);
            }
        });
        $(".btn-cancel").on('click', function(){
            var id = $(this).attr('data-id');
            switchButton(id);
        });
        
        function switchButton(id) {
            $(".noedit-"+id).toggleClass('hide');
            $(".edit-"+id).toggleClass('hide');
            $(".btn-edit[data-id="+id+"]").toggleClass('hide');
            $(".btn-save[data-id="+id+"]").toggleClass('hide');
            $(".btn-cancel[data-id="+id+"]").toggleClass('hide');
        }

        function getUserInfoData(id) {
            var updateForm = []
            var addForm = []
            var token = $('#token').val()
            
            $("."+id).find("."+id).each(function(){
                var value = $(this).val();
                var key = $(this).attr('data-id');
                
                if (key == "" || key == undefined) {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if (name == "nascimento")
                        value = value.split("/")[2]+"-"+value.split("/")[1]+"-"+value.split("/")[0];
                    if (value !== "")
                        addForm.push({'info_key': name, 'info_value': value});
                } else {
                    var name = $(this).attr('name');
                    if (name == "nascimento")
                        value = value.split("/")[2]+"-"+value.split("/")[1]+"-"+value.split("/")[0];
                    updateForm.push({'key': key, 'value': value});
                }
            });
            
            if (addForm.length > 0) {
                jQuery.ajax({
                    url: site + 'api/usuario/adicionarinfo/',
                    type: 'POST',
                    dataType: 'json',
                    data: {'fields': addForm, 'token': token},
                    success: function (data, textStatus, xhr) { }
                });
            }
            
            $.ajax({
                url: site + 'api/usuario/atualizarinfo/',
                type: 'POST',
                dataType: 'json',
                data: {'fields': updateForm, 'token': token},
                success: function (data, textStatus, xhr) {
                    location.href = location.href
                }
            });
        }
        
        function getUserData(id) {
            var updateForm = []
            var token = $("#token").val()
            
            $("."+id).find("."+id).each(function (){
                var name = $(this).attr('name');
                var value = $(this).val();
                var data_id = $(this).attr('data-id');
                updateForm.push({'key': name, 'value': (value !== "")? value: data_id});
            });
            $.ajax({
                url: site + "api/usuario/atualizar/",
                type: 'POST',
                dataType: 'json',
                data: {'fields': updateForm, 'token': token},
                success: function (data, textStatus, xhr) {
                    swal("Aguarde...");
                    location.href = location.href;
                }
            });
            
        }
        
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
        $('#phone').mask(SPMaskBehavior, spOptions);
        
        $("#cep").on('keyup', function () {
            var field = $(this);
            var type = field.val();
            if (type.length < 9) {
                $("#endereco").val("")
                $("#cidade").val("")
                $("#estado").val("")
                return false;
            }
            $.post(site + "api/cep", {cep: type}, function (data) {
                if (data !== null) {
                    $("#endereco").val(data['logradouro'])
                    $("#cidade").val(data['localidade'])
                    $("#estado").val(data['uf'])
                } else {
                    $("#endereco").val("")
                    $("#cidade").val("")
                    $("#estado").val("")
                }
            });
        });
        
        checkPicture();
        checkCurriculo();
        
        function checkCurriculo() {
            var curriculo = $("#field_curriculo").val()
            if (curriculo != "") {
                $('#form_upload_curriculo .upload-ok').removeClass('hide');
                $('#form_upload_curriculo .group-upload').removeClass('has-error').addClass('has-success');
                if (!$('#form_upload_curriculo .upload-error').hasClass('hide')) {
                    $('#form_upload_curriculo .upload-error').toggleClass('hide');
                }
                $('#curriculo').attr('disabled', 'disabled');
                var btn_remove = "<button type=\"button\" class=\"btn btn-danger btn-sm btn-remove-curriculo\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>Substituir / Remover currículo</button>";
                $("#form_upload_curriculo .area-message").removeClass('text-danger').removeClass('text-info').html(btn_remove);
            }
        }
        
        function checkPicture() {
            var picture = $("#field_picture").val();
            if (picture != "") {
                $("#form_upload_picture .upload-ok").removeClass('hide');
                $('#form_upload_picture .group-upload').removeClass('has-error').addClass('has-success');
                if (!$('#form_upload_picture .upload-error').hasClass('hide')) {
                    $('#form_upload_picture .upload-error').toggleClass('hide');
                }
                $('#photo').attr('disabled', 'disabled');
                var btn_remove = "<button type=\"button\" class=\"btn btn-danger btn-sm btn-remove-picture\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>Substituir / Remover Foto de perfil</button>";
                $("#form_upload_picture .area-message").removeClass('text-danger').removeClass('text-info').html(btn_remove);
            }
        }
        
        $("#curriculo").on('change', function(e) {
            $("#form_upload_curriculo .area-message").removeClass('text-info').removeClass('text-danger').removeClass('text-success').addClass('text-default').html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span>aguarde...</span>');
            var form_curriculo = new FormData();
            form_curriculo.append('curriculo', e.target.files[0]);
            
            $.ajax({
                url: site + "api/upload/curriculo",
                type: "POST",
                data: form_curriculo,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var convert = JSON.parse(data);
                    if (convert.error) {
                        $('#form_upload_curriculo .area-message').removeClass('text-info').addClass('text-danger').html(convert.error);
                        $("#form_upload_curriculo .upload-error").removeClass('hide');
                        $('#form_upload_curriculo .group-upload').removeClass('has-success').addClass('has-error');
                        if (!$('#form_upload_curriculo .upload-ok').hasClass('hide')) {
                            $('#form_upload_curriculo .upload-ok').toggleClass('hide');
                        }
                        $('#field_curriculo').val("");
                    } else {
                        $('#form_upload_curriculo .upload-ok').removeClass('hide');
                        $('#form_upload_curriculo .group-upload').removeClass('has-error').addClass('has-success');
                        if (!$('#form_upload_curriculo .upload-error').hasClass('hide')) {
                            $('#form_upload_curriculo.upload-error').toggleClass('hide');
                        }
                        $('#curriculo').attr('disabled', 'disabled');
                        var btn_remove = "<button type=\"button\" class=\"btn btn-danger btn-sm btn-remove-curriculo\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>Substituir / Remover currículo</button>";
                        $("#form_upload_curriculo .area-message").removeClass('text-danger').removeClass('text-info').html(btn_remove);
                        $('#field_curriculo').val(convert.upload_data.file_name);
                    }
                }
            });
        });
        
        $("#photo").on('change', function(e) {
            $("#form_upload_picture .area-message").removeClass('text-info').removeClass('text-danger').removeClass('text-success').addClass('text-default').html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span>aguarde...</span>');
            
            var form_picture = new FormData();
            form_picture.append('picture', e.target.files[0]);
            //console.log(e.target.files[0]);
            $.ajax({
                url: site + "api/upload/picture",
                type: "POST",
                data: form_picture, 
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    data = JSON.parse(data)
                    if(data.error) {
                        $('#form_upload_picture .area-message').removeClass('text-info').addClass('text-danger').html(data.error);
                        $("#form_upload_picture .upload-error").removeClass('hide');
                        $('#form_upload_picture .group-upload').removeClass('has-success').addClass('has-error');
                        if (!$('#form_upload_picture .upload-ok').hasClass('hide')) {
                            $('#form_upload_picture .upload-ok').toggleClass('hide');
                        }
                        $('#picture').val("");
                    } else {
                        var urlFinal = data.upload_data['urlbase']+'/'+data.upload_data.dados['file_name'];
                        $('.photo').attr("src",urlFinal);
                        $('.formPhoto').val(data.upload_data.dados['file_name']);
                        $('.photo_w').val(data.upload_data.dados['image_height']);
                        $('.photo_h').val(data.upload_data.dados['image_width']);

                        var htmlblock = $('.box_photo').show();
                        $('.enviarCrop').show();
                        $('.area-message').hide();

                        var mc = $('.photo');
                        mc.croppie({
                            viewport: {
                                width: 150,
                                height: 150,
                                type: 'circle'
                            },
                            boundary: {
                                width: 200,
                                height: 200
                            },
      
                            enforceBoundary: false
                        });

                        $('#form_upload_picture .upload-ok').removeClass('hide');
                        $('#form_upload_picture .group-upload').removeClass('has-error').addClass('has-success');
                        if (!$('#form_upload_picture .upload-error').hasClass('hide')) {
                            $('#form_upload_picture.upload-error').toggleClass('hide');
                        }
                        $('#photo').attr('disabled', 'disabled');
                        var btn_remove = "<button type=\"button\" class=\"btn btn-danger btn-sm btn-remove-picture\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>Substituir / Remover Foto de perfil</button>";
                        $("#form_upload_picture .area-message").removeClass('text-danger').removeClass('text-info').html(btn_remove);
                           
                    }
                }
            });
        });

        $('.enviarCrop').on('click', function (ev) {
            var mc = $('.photo')
            mc.croppie('result', {
                type: 'base64',
                // size: { width: 300, height: 300 },
                format: 'png'
            }).then(function (resp) {
                popupResult({
                    src: resp
                });

                var img = $('.formPhoto').val();

                var dados = {img:resp,output:img};
                $.ajax({
                    url: site + 'api/upload/base64_to_jpeg/',
                    dataType: 'json',
                    type: 'POST',
                    data:dados,
                    async: false,
                    success: function(data){
                        if(data.result ==true){
                           $('#picture').val(data.file_name);
                           $('.formPhoto').val(data.file_name);
                           $('.area-message').hide();
                          // $('.box_photo').hide();
                          // $('#imagemFinal').attr("src",data.urlbase+data.image);
                        }else{
                            alert("Erro ao fazer o upload da imagem");
                        }

                    },
                    error:function(error){
                        alert("Não foi possivel enviar sua imagem");
                    }
                });
            });
        });

        function popupResult(result) {
            var html;
            if (result.html) {
                html = result.html;
            }
            if (result.src) {
                html = '<img src="' + result.src + '" />';

            }
            swal({
                title: '',
                html: true,
                text: html,
                allowOutsideClick: true,

            },
            function(){
                getUserData('user_perfil');
            });
            setTimeout(function(){
                $('.sweet-alert').css('margin', function() {
                    var top = -1 * ($(this).height() / 2),
                        left = -1 * ($(this).width() / 2);

                    return top + 'px 0 0 ' + left + 'px';
                });

            }, 1);
        }
        
        
        $("body").on('click', '.btn-remove-curriculo', function(){
            var token = $('#token').val();
            $.post(site + 'api/upload/remove', 
            {'file': $("#field_curriculo").val(), 'token': token},
            function (data) {
                data = JSON.parse(data);
            });
            var msg = $("#form_upload_curriculo .area-message").attr("data-message");
            $('#form_upload_curriculo .area-message').text(msg).addClass('text-info');
            $('#form_upload_curriculo .group-upload').removeClass('has-error').removeClass('has-success');
            $('#curriculo').removeAttr('disabled').val("");
            if (!$('#form_upload_curriculo .upload-ok').hasClass('hide'))
                $('#form_upload_curriculo .upload-ok').addClass('hide');
            if (!$('#form_upload_curriculo .upload-error').hasClass('hide'))
                $('#form_upload_curriculo .upload-error').addClass('hide');
            $('#field_curriculo').val("");
        });
        
        $("body").on('click', '.btn-remove-picture', function(){
            var token = $('#token').val();
            var picture_old = $("#field_picture").val();
            
            if (picture_old != "user_default.png") {
                $.post(site + 'api/upload/remove',
                {'file': picture_old, 'token': token},
                function (data){
                    data = JSON.parse(data)
                });
            }
            var msg = $("#form_upload_picture .area-message").attr("data-message");
            $('#form_upload_picture .area-message').text(msg).addClass('text-info');
            $('#form_upload_picture .group-upload').removeClass('has-error').removeClass('has-success');
            $('#photo').removeAttr('disabled').val("");
            if (!$('#form_upload_picture .upload-ok').hasClass('hide'))
                $('#form_upload_picture .upload-ok').addClass('hide');
            if (!$('#form_upload_picture .upload-error').hasClass('hide'))
                $('#form_upload_picture .upload-error').addClass('hide');
            $('#picture').val("");
        });
    });
</script>
