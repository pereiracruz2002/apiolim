<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<h2>Perfil do chefe</h2>
<div class="panel-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="area-buttons">
                <button value="aceitar" data-user="<?php echo $user['user_id']; ?>" class="btn btn-success btn-solicitacao" ><i class="fa fa-pencil"></i> Aceitar</button>
                <button value="recusar" data-user="<?php echo $user['user_id']; ?>" class="btn btn-warning btn-solicitacao" ><i class="fa fa-pencil"></i> Recusar</button>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="well bg-white">
                <div class="row info_aboutyou">
                    <div class="row block_title">
                        <div class="col-sm-10 h5_info">Sobre o chef</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Sobre o chef:</label></div>
                        <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['sobrevoce'][0]) ? $user['info']['sobrevoce'][0] : '' ) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Profissão:</label></div>
                        <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['profissao'][0]) ? $user['info']['profissao'][0] : '') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Formação:</label></div>
                        <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['formacao'][0]) ? $user['info']['formacao'][0] : '') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Currículo</label></div>
                        <div class="col-sm-9 noedit-info_aboutyou">
                            <?php if (isset($user['info']['curriculo'][0]) && $user['info']['curriculo'][0] != ""): ?>
                                <a href="<?php echo SITE_URL . "uploads/" . $user['info']['curriculo'][0]; ?>" target="_blank">Ver currículo</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Mensagem de apresentação:</label></div>
                        <div class="col-sm-9 form-group noedit-info_aboutyou">
                            <?php echo isset($user['info']['mensagem'][0]) ? $user['info']['mensagem'][0] : '' ?>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Data de nascimento:</label></div>
                        <div class="col-sm-9 noedit-info_personal"><?php echo isset($user['info']['nascimento'][0]) ? $user['info']['nascimento'][0] : '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">E-mail:</label></div>
                        <div class="col-sm-9"><?php echo $user['email'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Telefone / Celular:</label></div>
                        <div class="col-sm-9 noedit-info_personal"><?php echo isset($user['info']['telefone'][0]) ? $user['info']['telefone'][0] : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="well bg-white">
                <div class="row info_address">
                    <div class="row block_title">
                        <div class="col-sm-10 h5_info">Endereço</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">CEP:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['cep'][0]) ? $user['info']['cep'][0] : '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Endereço:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['endereco'][0]) ? $user['info']['endereco'][0] . (isset($user['info']['numero'][0]) ? ', ' . $user['info']['numero'][0] : '') : '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Complemento:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo (isset($user['info']['complemento'][0])) ? "{$user['info']['complemento'][0]}" : "-" ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><label class="label_info">Cidade / Estado:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['cidade'][0]) ? $user['info']['cidade'][0] : '' ?><?php echo isset($user['info']['estado'][0]) ? ' / ' . $user['info']['estado'][0] : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>

<script>
    $(document).ready(function($) {
        $("body").on("click",".btn-solicitacao",function(e){
            $(this).attr("disabled", "disabled");
            $(this).text("aguarde");
            var resposta = $(this).val();
            var user = $(this).attr('data-user');
            var url = site_url+"api/usuario/confirmaChefe";

            jQuery.ajax({
                'url': url,
                type: 'POST',
                dataType: 'json',
                data: {"resposta": resposta,"user_id":user},
                complete: function(xhr, textStatus) {
                  //called when complete
                },
                success: function(data, textStatus, xhr) {
                    location.href = base_url + "solicitacoes";
                },
                error: function(xhr, textStatus, errorThrown) {
                    location.href = base_url + "solicitacoes";
                }
            });
        });
    });
</script>