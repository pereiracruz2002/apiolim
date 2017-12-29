<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<input type="hidden" id="token" value="<?php echo $token; ?>" />
<div class="col-sm-8">
    <div class="well bg-white procurar_amigos">
        <h2 class="h3 text-success"><i class="icon ion-person-add"></i> Adicionar Amigos</h2>
        <p>Amplie sua rede de amigos. Adicione pessoas que você conhece para fazer parte da sua rede e convida-las para um encontro gastronômico. Pessoas que já fazem parte da rede Dinner for Friends.</p>
        <form class="inline-form busca empty novos_amigos" action="<?php echo site_url('chef/amigos/buscaUser') ?>">
            <input type="search" name="search" class="form-control" value="Procurar" />
        </form>
        <div class="resultado-busca busca-amigos"></div>
    </div>

    <div class="well well-margin-sm bg-white">
        <h2 class="h3"><span class="text-danger"><i class="icon ion-person-stalker"></i></span> <span class="badge bg-danger solicitacoes_badge"><?php echo count($friends_request) ?></span> Solicitações de amizade</h2>
        <p>Pessoas que adicionaram você para fazer parte da rede de amigos delas. Você também tem acesso a suas Solicitações enviadas.</p>

        <ul class="nav nav-pills nav-requests">
            <li class="active"><a href="#friends_request">Recebidas</a></li>
            <li><a href="#friends_pendding">Enviadas (pendentes)</a></li>
        </ul>
    </div>
    <div class="well bg-white" id="nav-requests-content">
        <div class="resultado-busca" id="friends_request">
            <?php if (!$friends_request): ?>
                <p class="alert alert-info">Nenhuma Solicitação de amizade.</p>
            <?php endif ?>
                <ul class="lista-users">
                <?php foreach ($friends_request as $item): ?>
                    <li>
                        <div class="col-sm-6 row-friend">
                            <div class="col-sm-3 col-photo">
                                <img src="<?php echo $item->picture ?>" alt="<?php echo $item->name ?>" class="photo-friends" />
                            </div>
                            <div class="col-sm-2 col-type-user">
                                <img src="<?php echo base_url() ?>assets/img/<?php echo ($item->user_type_id == 2)? 'chef.jpg' : 'pacman.jpg'?>" class="picture-type-user" />
                            </div>
                            <div class="col-sm-7 col-friend">
                                <div class="row-desc-friends">
                                    <div class="friend-name"><?php echo $item->name; ?></div>
                                    <div class="quant-friends">
                                        <?php 
                                            $totalComum = $this->users->totalComum($item->user_id, $this->session->userdata('user')->user_id);
                                            echo $totalComum;
                                        ?>
                                        &nbsp;amigo<?php echo ($totalComum > 0)? 's': '' ?> em comum
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 row-friend">
                            <div class="col-add-friend">
                                <a href="<?php echo site_url('chef/amigos/confirmarSolicitacao/' . $item->id) ?>" data-id="accept" class="btn btn-success btn-sm pull-right">Aceitar</a>
                                <a href="<?php echo site_url('chef/amigos/ignorarSolicitacao/' . $item->id) ?>" data-id="ignore" class="btn btn-grey btn-sm pull-right">Ignorar</a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="resultado-busca" id="friends_pendding" style="display:none;">
            <?php if (!$friends_pendding): ?>
                <p class="alert alert-info">Nenhuma Solicitação de amizade pendente.</p>
            <?php endif ?>
            <ul class="lista-users">
                <?php foreach ($friends_pendding as $item): ?>
                    <li>
                        <div class="col-sm-6 row-friend">
                            <div class="col-sm-3 col-photo">
                                <img src="<?php echo $item->picture ?>" alt="<?php echo $item->name ?>" class="photo-friends" />
                            </div>
                            <div class="col-sm-2 col-type-user">
                                <img src="<?php echo base_url() ?>assets/img/<?php echo ($item->user_type_id == 2)? 'chef.jpg' : 'pacman.jpg'?>" class="picture-type-user" />
                            </div>
                            <div class="col-sm-7 col-friend">
                                <div class="row-desc-friends">
                                    <div class="friend-name"><?php echo $item->name; ?></div>
                                    <div class="quant-friends">
                                        <?php 
                                            $totalComum = $this->users->totalComum($item->user_id, $this->session->userdata('user')->user_id);
                                            echo $totalComum;
                                        ?>
                                        &nbsp;amigo<?php echo ($totalComum > 0)? 's': '' ?> em comum
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 row-friend">
                            <div class="col-add-friend">
                                <a href="<?php echo site_url('chef/amigos/cancelarSolicitacao/' . $item->id) ?>" data-id="cancel" class="btn btn-danger btn-sm pull-right">Cancelar</a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>

<div class="col-sm-4">
    <div class="well bg-white search-email-messenger">
        <p class="">Para adicionar amigos que ainda não conhecem o Dinner for Friends, basta convidá-los através de suas redes sociais, enviando uma mensagem contendo o link para download do aplicativo. Escolha uma opção de envio abaixo e amplie sua rede!!</p>
        <div class="row">
            <div class="col-sm-6 text-center">
                <button class="btn btn-email" data-toggle="modal" data-target="#modal_sendmail"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>
            </div>
            <div class="col-sm-6 text-center">
                <button class="btn btn-messenger messenger_function"><img src="<?php echo site_url() ?>assets/img/messenger-icon.png" /></button>
            </div>
        </div>
    </div>
    <div class="well well-margin-sm bg-white title-well total-friends">
        Você tem <span class="h1"><?php echo count($friends) ?></span> amigo(s)
    </div>

    <?php /*if ($friends):*/ ?>
        <div class="well well-margin-sm bg-white">
            <h4 class="text-success"><i class="icon ion-person-stalker"></i> Meus Amigos <span class="pull-right">(<?php echo str_pad(count($friends), 4, 0, STR_PAD_LEFT) ?>)</span></h4>
            <small>Pessoas que já fazem parte da sua rede de amigos</small>
        </div>
        <div class="well well-margin-sm bg-white">
            <form class="inline-form busca empty meus_amigos filter_list" action="<?php echo site_url('chef/amigos/buscaMeusAmigos') ?>">
                <input type="search" name="search" class="form-control filterinput" value="Procurar" />
            </form>
        </div>
        <div class="well bg-white">
            <div class="resultado-busca">
                <ul class="lista-users meus-amigos">
                    <?php foreach ($friends as $item): ?>
                        <li>
                            <div class="col-sm-12 row-friend">
                                <div class="col-sm-3 col-photo">
                                    <img src="<?php echo $item->picture ?>" alt="<?php echo $item->name ?>" class="photo-friends" />
                                </div>
                                <div class="col-sm-2 col-type-user">
                                    <img src="<?php echo base_url() ?>assets/img/<?php echo ($item->user_type_id == 2)? 'chef.jpg' : 'pacman.jpg'?>" class="picture-type-user" />
                                </div>
                                <div class="col-sm-7 col-friend">
                                    <div class="row-desc-friends">
                                        <div class="friend-name"><?php echo $item->name; ?></div>
                                        <div class="quant-friends">
                                            <?php 
                                                $totalComum = $this->users->totalComum($item->user_id, $this->session->userdata('user')->user_id);
                                                echo $totalComum;
                                            ?>
                                            &nbsp;amigo<?php echo ($totalComum > 0)? 's': '' ?> em comum
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php /*endif;*/ ?>

</div>

<div class="modal fade" id="modal_sendmail" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="inline-form" id="form_sendmail" action="<?php echo site_url("chef/amigos/sendInviteEmail") ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Convidar um amigo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="invite-email">Endereço de email</label>
                        <input type="email" class="form-control" id="invite_email" placeholder="ex.: amigo@amigochef.com.br" required="">
                    </div>
                    <div class="return_message"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary button_send_mail">Enviar email</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
