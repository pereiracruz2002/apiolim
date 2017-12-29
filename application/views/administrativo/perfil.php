<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="panel-header">
    <div class="row">
        <div class="col-sm-9">
            <h2>Perfil do <?php echo $user['label'] ?></h2>
        </div>
        <div class="col-sm-3">
            <div class="row info_photo text-center">
                <?php if (isset($user['picture'])): ?>
                    <?php if (preg_match("/facebook/", $user['picture'])): ?>
                        <img src="<?php echo "{$user['picture']}" ?>" />
                    <?php else: ?>
                        <img src="<?php echo /* site_url(). */"https://www.dinnerforfriends.com.br/uploads/{$user['picture']}" ?>" />
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="row block_title">
                <div class="col-sm-10 h5_info">Informações pessoais</div>
            </div>
            <div class="well bg-white">
                <div class="row info_personal">
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">Nome:</label></div>
                        <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['name']) ? $user['name'] : '' ) ?> <?php echo (isset($user['lastname']) ? $user['lastname'] : '' ) ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">Data de nascimento:</label></div>
                        <div class="col-sm-9 noedit-info_personal"><?php echo isset($user['info']['nascimento'][0]) ? date("d/m/Y", strtotime($user['info']['nascimento'][0])) : '' ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">E-mail:</label></div>
                        <div class="col-sm-9"><?php echo $user['email'] ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">Telefone / Celular:</label></div>
                        <div class="col-sm-9 noedit-info_personal"><?php echo isset($user['info']['telefone'][0]) ? $user['info']['telefone'][0] : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row block_title">
                <div class="col-sm-10 h5_info">Endereço</div>
            </div>
            <div class="well bg-white">
                <div class="row info_address">
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">CEP:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['cep'][0]) ? $user['info']['cep'][0] : '' ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">Endereço:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['endereco'][0]) ? $user['info']['endereco'][0] . (isset($user['info']['numero'][0]) ? ', ' . $user['info']['numero'][0] : '') : '' ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">Complemento:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo (isset($user['info']['complemento'][0])) ? "{$user['info']['complemento'][0]}" : "-" ?></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"><label class="label_info">Cidade / Estado:</label></div>
                        <div class="col-sm-9 edit-info_address"><?php echo isset($user['info']['cidade'][0]) ? $user['info']['cidade'][0] : '' ?><?php echo isset($user['info']['estado'][0]) ? ' / ' . $user['info']['estado'][0] : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($user['user_type_id'] == 2): ?>
            <div class="col-sm-12">
                <div class="row block_title">
                    <div class="col-sm-10 h5_info"><?php echo $user['label'] ?></div>
                    </div>
                <div class="well bg-white">
                    <div class="row info_aboutyou"> 
                        <div class="col-sm-12">
                            <div class="col-sm-3"><label class="label_info">Sobre o chef:</label></div>
                            <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['sobrevoce'][0]) ? $user['info']['sobrevoce'][0] : '' ) ?></div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3"><label class="label_info">Profissão:</label></div>
                            <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['profissao'][0]) ? $user['info']['profissao'][0] : '') ?></div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3"><label class="label_info">Formação:</label></div>
                            <div class="col-sm-9 noedit-info_aboutyou"><?php echo (isset($user['info']['formacao'][0]) ? $user['info']['formacao'][0] : '') ?></div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3"><label class="label_info">Currículo</label></div>
                            <div class="col-sm-9 noedit-info_aboutyou">
                                <?php if (isset($user['info']['curriculo'][0]) && $user['info']['curriculo'][0] != ""): ?>
                                    <a href="<?php echo SITE_URL . "uploads/" . $user['info']['curriculo'][0]; ?>" target="_blank">Ver currículo</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3"><label class="label_info">Mensagem de apresentação:</label></div>
                            <div class="col-sm-9 form-group noedit-info_aboutyou">
                                <?php echo isset($user['info']['mensagem'][0]) ? $user['info']['mensagem'][0] : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
