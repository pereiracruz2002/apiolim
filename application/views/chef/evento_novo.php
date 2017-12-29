<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<script>
    var rate_dinner = "<?php echo $rates->rate_global / 100 ?>";
    var rate_service = "<?php echo $rates->rate_service / 100 ?>";
</script>
<div class="well well-sm bg-white well-title">
    <h5 class="title_header">
        <strong>Crie um novo encontro gastronômico</strong>
    </h5>
</div>
<div class="bg-danger box-float-validate">Preencha os campos obrigatórios (sinalizados)</div>
<div class="row">
    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 1</div>
                    <div class="col-sm-12 h_desc">
                        Chef, insira as informações nas lacunas a seguir, como: lugar, data e hora. Além do seu telefone para contato.
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Essas informações não são editáveis depois que o evento for publicado.
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
                    <div class="form-group col-sm-12">
                        <label for="name">Título do evento  *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo (isset($event['name']) ? $event['name'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="date">Data início *</label>
                        <input type="text" class="form-control" id="date" name="date" value="<?php echo ((isset($event['start']) && (strtotime($event['start']) >= 0)) ? date("d/m/Y", strtotime($event['start'])) : '') ?>" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="timestart">Hora início *</label>
                        <input type="time" class="form-control" id="timestart" name="timestart" value="<?php echo ((isset($event['start']) && (strtotime($event['start']) >= 0)) ? date("H:i", strtotime($event['start'])) : '') ?>" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="timeend">Hora término *</label>
                        <input type="time" class="form-control" id="timeend" name="timeend" value="<?php echo ((isset($event['end']) && (strtotime($event['end']) >= 0)) ? date("H:i", strtotime($event['end'])) : '') ?>" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="zipcode">CEP *</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo (isset($event['zipcode']) ? $event['zipcode'] : '') ?>" data-mask="00000-000" />
                    </div>
                    <div class="form-group col-sm-10">
                        <label for="street">Endereço *</label>
                        <input type="text" class="form-control" id="street" name="street" value="<?php echo (isset($event['street']) ? $event['street'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="number">Número *</label>
                        <input type="text" class="form-control" id="number" name="number" value="<?php echo (isset($event['number']) ? $event['number'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="complement">Complemento</label>
                        <input type="text" class="form-control" id="complement" name="complement" value="<?php echo (isset($event['complement']) ? $event['complement'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="neighborhood">Bairro *</label>
                        <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?php echo (isset($event['neighborhood']) ? $event['neighborhood'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="city">Cidade *</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo (isset($event['city']) ? $event['city'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="state">Estado *</label>
                        <input type="text" class="form-control" id="state" name="state" value="<?php echo (isset($event['state']) ? $event['state'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="phone">Telefone contato *</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo (isset($event['phone']) ? $event['phone'] : '') ?>" />
                    </div>
                    <div class="form-group col-sm-8">
                        <label for="">
                            Informações adicionais 
                            <small>(Ex: Nome do lugar, ponto de referência etc...)</small>
                        </label>
                        <input type="text" class="form-control" id="reference" name="reference" value="<?php echo (isset($event['reference']) ? $event['reference'] : '') ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 2</div>
                    <div class="col-sm-12 h_desc">
                        Descreva um pouco sobre o evento
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Essas informações não são editáveis depois que o evento for publicado.
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="description">Descrição do evento *</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?php echo (isset($event['description']) ? $event['description'] : '') ?></textarea>
                        <div class="text-default contador-char" >Máximo de 1000 caracteres</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 3</div>
                    <div class="col-sm-12 h_desc">
                        Para você se organizar melhor é bom determinar a data limite para seus convidados aceitarem o convite e a quantidade de acompanhantes.
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Essas informações não são editáveis depois que o evento for publicado.
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="end_subscription">Data limite para reserva: *</label>
                        <input type="text" class="form-control" id="end_subscription" name="end_subscription" value="<?php echo ((isset($event['end_subscription']) && (strtotime($event['end_subscription']) >= 0)) ? date("d/m/Y", strtotime($event['end_subscription'])) : '') ?>" />
                    </div>

                    <div class="form-group col-sm-2">
                        <label class="convidado_gratuito">Entrada Convidado Gratuito: *</label>
                        <label class="radio-inline">
                          <input type="radio" name="free_invitation" id="free_invitation" <?php echo ((isset($event['free_invitation']) and $event['free_invitation'] == "sim") ? " checked='ckecked'" : '') ?> value="sim"> Sim
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="free_invitation" id="free_invitation"<?php echo ((isset($event['free_invitation']) and $event['free_invitation'] == "nao") ? " checked='ckecked'" : '') ?> value="nao"> Não
                        </label>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="price">Valor por pessoa: *</label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input type="text" class="form-control" id="price" name="price" <?php echo ((isset($event['free_invitation']) and $event['free_invitation'] == "sim") ? " disabled='disabled'" : '') ?>  value="<?php echo (isset($event['price']) ? number_format($event['price'], 2, ',','.') : '') ?>" />
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="num_users">Limite de convidados: *</label>
                        <input type="number" class="form-control" min="1" id="num_users" name="num_users" value="<?php echo (isset($event['num_users']) ? $event['num_users'] : '1') ?>" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="invite_limit">Limite de acompanhante por convidado: *</label>
                        <input type="text" class="form-control" id="invite_limit" name="invite_limit" value="<?php echo (isset($event['invite_limit']) ? $event['invite_limit'] : '0') ?>" />
                    </div>
                </div>
                <?php 

                if(isset($event['status_payment'])):?>
                    <?php /*if($event['status_payment']!="Pago"):*/?>
                        <?php if($event['free_invitation']!="nao"):?>
                            <div class="row row_warnig_free">
                                <div class="alert alert-danger text-center" role="alert"> O pagamento do seu evento gratuito está no momento: <span id="status_payment"><?php echo $event['status_payment']; ?></span></div>
                                <div class="row">
                                    <div class="col-sm-4 col-sm-offset-4">
                                        <form id="eventoFormFinaliza" method="post" action="<?php echo site_url('chef/evento/pagamento') ?>">
                                           <input type="hidden" name="itemDescription1" value="<?php echo (isset($event['name']) ? $event['name'] : '') ?>">
                                            <input type="hidden" name="itemQuantity1" value="1">
                                            <input type="hidden" name="itemId1" value="<?php echo (isset($event['event_id']) ? $event['event_id'] : '') ?>">
                                            <input type="hidden" name="itemWeight1" value="0" >
                                            <input type="hidden" name="itemAmount1" value="<?php echo (isset($free->value_free_invitation) ? $free->value_free_invitation : '') ?>" >
                                            <input type="hidden" name="senderName" value="<?php echo $this->session->userdata('user')->name ?>">
                                            <input type="hidden" name="senderEmail" value="<?php echo $this->session->userdata('user')->email ?>" >
                                            <input type="hidden" name="referencia" value="<?php echo (isset($event['event_id']) ? $event['event_id'] : '') ?>">
                                            <!-- <button type="button" id="pagseguro_pgto" class="btn btn-block btn-success">Pagar</button> -->
                                        </form>
                                        <?php echo "<script type='text/javascript' src='https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js'></script>"; ?>
                                        <form id="comprar" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
                                            <input type="hidden" name="code" id="code" value="" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php //endif;?>
                <?php else:?>
                <div class="row row_warnig_free" style="display:none;">
                    <div class="alert alert-danger" role="alert">Para que esse evento seja publicado será necessário antes fazer o pagamento da taxa de <strong> R$ <span id="free_invitation_label"><?php echo $free->value_free_invitation; ?></span></strong>. </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-4">
                            <form id="eventoFormFinaliza" method="post" action="<?php echo site_url('chef/evento/pagamento') ?>">
                               <input type="hidden" name="itemDescription1" value="">
                                <input type="hidden" name="itemQuantity1" value="1">
                                <input type="hidden" name="itemId1" value="">
                                <input type="hidden" name="itemWeight1" value="0" >
                                <input type="hidden" name="itemAmount1" value="" >
                                <input type="hidden" name="senderName" value="<?php echo $this->session->userdata('user')->name ?>">
                                <input type="hidden" name="senderEmail" value="<?php echo $this->session->userdata('user')->email ?>" >
                                <input type="hidden" name="referencia" value="">
                                <button type="button" id="pagseguro_pgto" class="btn btn-block btn-success">Pagar</button>
                            </form>
                            <?php echo "<script type='text/javascript' src='https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js'></script>"; ?>
                            <form id="comprar" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
                                <input type="hidden" name="code" id="code" value="" />
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <div class="row row_resume">
                    <div class="col-sm-12 block_title"></div>
                    <div class="col-sm-12 block_title">
                        <div class="col-sm-8">
                            <div class="col-sm-3">
                                <label class="label-resume">Valor por pessoa</label>
                                <div class="resume-calc value_person"></div>
                            </div>
                            <div class="col-sm-1" style="width: 15px">
                                <div>&nbsp;</div>
                                -
                            </div>
                            <div class="col-sm-3">
                                <label class="label-resume">Taxa Dinner (<?php echo($rates->rate_global) ?> %)</label>
                                <div class="resume-calc rate_dinner" data-value="<?php echo($rates->rate_global) ?>"></div>
                            </div>
                            <div class="col-sm-1" style="width: 15px">
                                <div>&nbsp;</div>
                                =
                            </div>
                            <div class="col-sm-4">
                                <label class="label-resume">Retorno por pessoa</label>
                                <div class="resume-calc return_chef"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 resume-calc-total">
                            <div class="col-sm-1" style="width: 15px">
                                <div>&nbsp;</div>
                                x
                            </div>
                            <div class="col-sm-3">
                                <label class="label-resume">Convidados</label>
                                <div class="resume-calc quant_invites"></div>
                            </div>
                            <div class="col-sm-1" style="width: 15px">
                                <div>&nbsp;</div>
                                =
                            </div>
                            <div class="col-sm-6">
                                <label class="label-resume">Valor a ser arrecadado</label>
                                <div class="resume-calc return_total_chef"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <label class="label-resume">Valor que cada convidado irá pagar (Valor por pessoa + Taxa de serviço [<?php echo $rates->rate_service; ?>%])</label>
                            <div class="resume-calc rate_service">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 4</div>
                    <div class="col-sm-12 h_desc">
                        Definindo uma categoria, os seus convidados já terão uma ideia sobre o seu evento.
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Essas informações não são editáveis depois que o evento for publicado.
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="category">Categoria: *</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">Escolha uma opção</option>
                            <?php foreach ($tipos as $item): ?>
                                <option value="<?php echo $item->event_type_id ?>"><?php echo $item->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 group-category <?php echo isset($event_type_other) ? "" : "hide" ?>">
                        <label for="category_other">Outra: *</label>
                        <input type="text" name="category_other" id="category_other" class="form-control" value="<?php echo isset($event_type_other) ? $event_type_other->value : "" ?>" data-id="<?php echo isset($event_type_other) ? $event_type_other->event_type_other_id : "" ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 5</div>
                    <div class="col-sm-12 h_desc">
                        Agora é com você, Chef ! Desenvolva um MENU apetitoso e mãos à obra!
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Você pode editar as informações do menu quando quiser. Vá na opção "menu" e, "meus encontros gastronômicos" e seus convidados serão informados sobre os ajustes.
                    </div>
                </div>
                <div class="row fields_extra">
                    <?php
                    $order = array_replace(array_flip(array(4, 0, 5, 1, 6, 2, 3, 7)), $menu);
                    foreach ($order as $field):
                        if ($field->field_type == "text"):
                            ?>
                            <?php
                            if (isset($field->event_value_id)):
                                $field_id = $field->event_value_id;
                            else:
                                $field_id = $field->event_info_type_id;
                            endif;
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="<?php echo $field_id ?>"><?php echo $field->name ?>:</label>
                                <input type="text" class="form-control event_info_type" name="<?php echo $field_id ?>" id="<?php echo $field_id ?>" value="<?php echo (isset($field->info_value)) ? $field->info_value : ""; ?>" />
                            </div>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 6</div>
                    <div class="col-sm-12 h_desc">
                        Você pode adicionar IMAGENS que ilustram seu evento especial.
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Você pode editar mais tarde. Lembre-se de que as imagens atraem seus convidados.
                    </div>
                </div>
                <div class="row">
                    <label for="photo">Fotos: *</label>
                    <div class="col-sm-12">
                        <div class="gallery" class="clearfix" style="max-width:100%;">
                            <ul id="gallery_event" class="gallery list-unstyled">
                                <?php
                                if (isset($event['picture']) && (explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1]) != ""):
                                    $li = "<li data-thumb='{$event['picture']}'>";
                                    $li .= "<div class='box-img-functions'>";
                                    $li .= "<div class='img-functions'><input type='radio' checked='checked' class='photo-main btn-photo-main' value='" . explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] . "' name='photo_main' id='" . explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] . "'/><label class='photo-main' for='" . explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] . "'>Foto principal</label></div>";
                                    //$li .= "<div class='img-functions' style='float: right'><p class='btn btn-excluir-foto' style='color: #d43f3a' data-img='" . explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] . "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></p></div>";
                                    $li .= "<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='" . explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] . "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>";
                                    //<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='" + img + "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>
                                    $li .= "</div>";
                                    $li .= "<img src='{$event['picture']}' class='img-responsive img-align-center' style='margin-top: -36px' />";
                                    $li .= "</li>";
                                    echo $li;
                                endif;
                                if (isset($event['pictures'])):
                                    foreach ($event['pictures'] as $picture) {
                                        $li = "<li data-thumb='{$picture['href']}'>";
                                        $li .= "<div class='box-img-functions'>";
                                        $li .= "<div class='img-functions'><input type='radio' class='photo-main btn-photo-main' value='" . explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] . "' name='photo_main' id='" . explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] . "'/><label class='photo-main' for='" . explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] . "'>Foto principal</label></div>";
                                        $li .= "<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='" . explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] . "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>";
                                        //$li .= "<div class='img-functions' style='float: right'><p class='btn btn-excluir-foto' style='color: #d43f3a' data-img='" . explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] . "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></p></div>";
                                        $li .= "</div>";
                                        $li .= "<img src='{$picture['href']}' class='img-responsive img-align-center' style='margin-top: -36px' />";
                                        $li .= "</li>";
                                        echo $li;
                                    }
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-upload">
                    <form id="form_upload_picture" method="post" enctype="multipart/form-data">
                        <div class="form-group has-feedback group-upload">
                            <input type="file" id="photo" value="" class="form-control file-upload" />
                            <label for="photo" class="file-upload" data-target="#adjustPhoto" data-toggle="modal" data-backdrop="static" data-keyboard="false"></label>
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw upload-spinner hide"></i>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <p class="bg-warning message-upload"></p>
                <div>
                    <button class="btn btn-danger btn-xs btn-cancel-upload hide">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Passo 7</div>
                    <div class="col-sm-12 h_desc">
                        Convide seus amigos
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Lembre-se, você pode convidar apenas amigos que já fazem parte da sua rede no
                        Dinner for Friends. Você pode convidar mais amigos no momento que você quiser,
                        na sua relação de enventos em andamento (vá na opção "menu" em "meus encontros gastronômicos")
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <form class="inline-form busca empty filter_list">
                            <input type="search" name="search" class="form-control filterinput" value="Procurar">
                        </form>
                        <div class="resultado-busca">
                            <ul class="lista-users">
                                <?php foreach ($amigos as $item): ?>
                                    <li>
                                        <div class="col-sm-6 row-friend">
                                            <div class="col-sm-3 col-photo">
                                                <img src="<?php echo $item->picture ?>" alt="<?php echo $item->name ?>" class="photo-friends" />
                                            </div>
                                            <div class="col-sm-2 col-type-user">
                                                <img src="<?php echo base_url() ?>assets/img/<?php echo ($item->user_type_id == 2) ? 'chef' : 'pacman' ?>.jpg" class="picture-type-user" />
                                            </div>
                                            <div class="col-sm-7 col-friend">
                                                <div class="row-desc-friends">
                                                    <div class="friend-name"><?php echo $item->name; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 row-friend">
                                            <div class="col-add-friend">
                                                <input type="checkbox" class="checkbox_invite" name="guests" id="friend-<?php echo $item->user_id ?>" value="<?php echo $item->user_id ?>"/>
                                                <label for="friend-<?php echo $item->user_id ?>" class="label_checkbox_invite">Convidar</label>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 area-message-ready">
        <div class="well bg-white">
            <div class="row">
                <div class="row block_title">
                    <div class="col-sm-12 h_info">Pronto</div>
                    <div class="col-sm-12 h_desc">
                        Se as informações principais estiverem preenchidas (não editáveis), você pode publicar.
                    </div>
                    <div class="col-sm-12 h_subdesc">
                        Caso queira continuar mais tarde, salve sem publicar e altere as informações quando quiser no "Meus Encontros Gastronômicos" no menu lateral.
                        Se tudo estiver completo, publique e aguarde seus convidados aceitarem o seu convite!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 area-button-fixed area-buttons">
        <div class="well bg-white">
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-8">
                        <button class="btn btn-block btn-danger" data-toggle="modal" data-target="#deleteEvent">Cancelar</button>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-10">
                        <button class="btn btn-block btn-default btn-functions" id="btn_save_event" data-label="Salvar">Salvar</button>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-10">
                        <button class="btn btn-block btn-success btn-functions" id="btn_save_publish_event"  data-label="Salvar e Publicar">Salvar e Publicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteEvent" tabindex="-1" role="dialog" aria-labelledby="deleteEvent">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span class="text-danger">Atenção</span></h4>
            </div>
            <div class="modal-body">
                <h2 class="text-center">Deseja mesmo cancelar este evento?</h2>
                <h3 class="text-center">Esta ação não poderá ser desfeita.</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-danger" id="btn_cancel_event">Sim, cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="adjustPhoto" tabindex="-1" role="dialog" aria-labelledby="adjustPhoto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><span class="text-danger">Ajustar tamanho da foto</span></h4>
            </div>
            <div class="modal-body">
                <div class="area-spinner">
                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                </div>
                <div class="area-img hide">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-cancel-upload" id="cleanCrop" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="enviarCrop">Salvar</button>
            </div>
        </div>
    </div>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
<script>
    $(document).ready(function () {

        
        //$('[name=date]').mask('00/00/0000');
        //$('[name=end_subscription]').mask('00/00/0000');
        var event_id = "<?php echo $event_id; ?>";
        var ajaxUploadFoto;

        setTimeout(function () {
            $('[name=photo_main]:checked').next().trigger('click');
        }, 500);

        $("[name=category]").val("<?php echo (isset($event['event_type_id']) ? $event['event_type_id'] : '') ?>");
        var fotos = [];
        var fotos_save = [];
        var guests_save = [];

        $("[name=category]").change(function () {
            if ($(this).val() == 6) {
                $(".group-category").removeClass('hide');
                $(".group-category input").focus();
            } else {
                $(".group-category").addClass('hide');
            }
        });

        $("ul#gallery_event li .box-img-functions .img-functions a").each(function (e) {
            var img = $(this).attr("data-img");
            $(this).popover({
                trigger: 'manual',
                html: true,
                placement: 'bottom',
                title: 'Remover esta foto?',
                content: '<a class="btn btn-danger cancelar" href="#">Cancelar</a> <a class="btn btn-primary btn-excluir-foto" href="#" data-img="' + img + '">Remover</a>'
            });
        });

<?php if (isset($event)): ?>
            var newObjt = {};
    <?php if (isset($event['picture']) && (explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1]) != "") { ?>
                newObjt.id_imagem = "event";
                newObjt.imagem = "<?php echo explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] ?>";
                newObjt.href = "<?php echo explode("/", $event['picture'])[count(explode("/", $event['picture'])) - 1] ?>";
                newObjt.principal = "sim";
                fotos.push(newObjt);
                fotos_save.push(newObjt);
                newObjt = {};
        <?php
    }
    foreach ($event['pictures'] as $key => $picture) {
        ?>
                newObjt.id_imagem = "<?php echo $key ?>";
                newObjt.imagem = "<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1]; ?>";
                newObjt.href = "<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1]; ?>";
                newObjt.principal = "não";
                fotos.push(newObjt);
                fotos_save.push(newObjt);
                newObjt = {};
    <?php } ?>

    <?php foreach ($event['guests'] as $guest) { ?>
                guests_save.push({'user_id': "<?php echo $guest['user_id'] ?>", 'status': "<?php echo $guest['status'] ?>"});
                $("#friend-<?php echo $guest['user_id'] ?>").attr("checked", "checked");
    <?php } ?>
<?php endif; ?>

        $("button.btn-cancel-upload").click(function () {
            if (ajaxUploadFoto)
                ajaxUploadFoto.abort();
        });

        $("body").on('change', '#photo', function (e) {
            $(".message-upload").html("");
            var form_picture = new FormData();
            form_picture.append('image', e.target.files[0]);

            ajaxUploadFoto = $.ajax({
                url: site + "api/upload/image",
                type: "POST",
                data: form_picture,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.error) {
                        $(".message-upload").html(data.error);
                        cleanAdjustPhoto();
                    } else {
                        cropImage(data.upload_data.file_name);
                    }
                }
            });
        });

        function cropImage(img) {
            var area_image = "<img id='image_crop' src='" + site + "uploads/" + img + "' class='img-responsive img-align-center' />";
            $("#adjustPhoto .modal-dialog").width($(document).width() * 0.80);
            $(".area-img").parent().height($(window).height() * 0.70);
            $(".area-img").html(area_image).removeClass('hide').fadeIn();
            $(".area-img").append("<input type='hidden' value='" + img + "' name='formPhoto' />");
            $(".area-spinner").fadeOut();

            var mc = $("#image_crop");
            mc.croppie({
                viewport: {
                    width: 800,
                    height: 400,
                }, boundary: {
                    width: ($(".area-img").parent().width() > 800) ? $(".area-img").parent().width() : 800,
                    height: ($(".area-img").parent().height() > 400) ? $(".area-img").parent().height() * 0.93 : 400
                }, enforceBoundary: false
            });

            return false;
        }

        $("#enviarCrop").on('click', function () {
            $("#enviarCrop").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw upload-spinner"></i>');
            var mc = $("#image_crop");
            mc.croppie('result', {
                type: 'base64',
                format: 'png'
            }).then(function (resp) {
                var img = $("input[name=formPhoto]").val();
                var dados = {img: resp, output: img};
                $.ajax({
                    url: site + 'api/upload/base64_to_image',
                    dataType: 'json',
                    type: 'POST',
                    data: dados,
                    async: false,
                    success: function (data) {
                        if (data.status == "ok") {
                            var newObj = {};
                            newObj.imagem = data.file_name;
                            newObj.href = data.file_name;

                            if (fotos.length == 0) {
                                newObj.principal = "sim";
                            } else {
                                newObj.principal = "não";
                            }
                            fotos.push(newObj);
                            gallery(newObj.imagem);
                            $("#photo").val("");

                            cleanAdjustPhoto();
                            $("#enviarCrop").html('Salvar');
                        }
                    }, error: function (error) {
                        alert(error);
                    }
                });
            });
        });

        function cleanAdjustPhoto() {
            $("#adjustPhoto").modal('toggle');
            $("#adjustPhoto .modal-dialog").width("600px");
            $(".area-img").parent().height("auto");
            $(".area-img").fadeOut().html("");
            $(".area-spinner").fadeIn();
        }

        $("button#cleanCrop").click(function () {
            cleanAdjustPhoto();
        });

        function gallery(img) {
            var li = "<li data-thumb='" + site + "uploads/" + img + "'>";
            li += "<div class='box-img-functions'>";
            li += "<div class='img-functions'><input type='radio' class='photo-main btn-photo-main' value='" + img + "' name='photo_main' id='" + img + "'/><label class='photo-main' for='" + img + "'>Foto principal</label></div>";
            li += "<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='" + img + "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>"
            li += "</div>"
            li += "<img src='" + site + "uploads/" + img + "' class='img-responsive img-align-center' style='margin-top: -36px' />";
            li += "</li>";
            $("#gallery_event").append(li);
            $("[data-img='" + img + "']").popover({
                trigger: 'manual',
                html: true,
                placement: 'bottom',
                title: 'Remover esta foto?',
                content: '<a class="btn btn-danger cancelar" href="#">Cancelar</a> <a class="btn btn-primary btn-excluir-foto" href="#" data-img="' + img + '">Remover</a>'
            });
            rebuildSlider();
            checkImageMain();
            checkQuantImage();
        }

        $("body").on('click', '.btn-excluir-foto', function (e) {
            e.preventDefault();

            var img = $(this).attr('data-img');
            $(this).parent("div").parent("div").parent("div").parent("div").parent("li").remove();

            for (foto in fotos) {
                if (fotos[foto].imagem == img) {
                    delete fotos[foto];
                    fotos.filter(Object);
                }
            }
            checkQuantImage();
            rebuildSlider();
            checkImageMain();
        });

        $("body").on('click', '.btn-photo-main', function (e) {
            var img = $(this).val();
            for (foto in fotos) {
                if (fotos[foto].imagem == img) {
                    fotos[foto].principal = "sim";
                } else {
                    fotos[foto].principal = "não";
                }
            }
        });

        $("#zipcode").on('keyup', function () {
            var field = $(this);
            var type = field.val();
            $.post(site + "/api/cep", {cep: type}, function (data) {
                if (data !== null) {
                    $("#street").val(data['logradouro'])
                    $("#neighborhood").val(data['bairro'])
                    $("#state").val(data['uf'])
                    $("#city").val(data['localidade'])
                } else {
                    $("#street").val("")
                    $("#neighborhood").val("")
                    $("#city").val("")
                    $("#state").val("")
                }
            });
        });

        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };
        $('#phone').mask(SPMaskBehavior, spOptions);

        var slide = $("#gallery_event").lightSlider({
            gallery: true,
            formUpload: $(".form-upload").html(),
            item: 1,
            loop: true,
            thumbItem: 9,
            slideMargin: 0,
            enableDrag: true,
            currentPagerPosition: 'left',
            onSliderLoad: function (el) {
                /*el.lightGallery({
                 selector: '#gallery_event .lslide'
                 });*/
            }
        });
        checkQuantImage();

        function rebuildSlider() {
            slide.destroy();
            slide = $("#gallery_event").lightSlider({
                gallery: true,
                formUpload: $(".form-upload").html(),
                item: 1,
                loop: true,
                thumbItem: 9,
                slideMargin: 0,
                enableDrag: true,
                currentPagerPosition: 'left',
                onSliderLoad: function (el) {
                    /*el.lightGallery({
                     selector: '#gallery_event .lslide'
                     });*/
                }
            });
        }

        function checkImageMain() {
            for (foto in fotos) {
                if (fotos[foto].principal == "sim") {
                    $('body').find("input[name=photo_main]").each(function () {
                        if (fotos[foto].imagem == $(this).val()) {
                            $(this).attr("checked", "checked");
                        }
                    });
                }
            }
        }

        function checkQuantImage() {
            if (fotos.length >= 4) {
                $(".lSFile").hide();
            } else {
                $(".lSFile").show();
            }
        }

        var div_reference = $(".area-message-ready").offset().top;
        $(".area-button-fixed").addClass('col-sm-10').removeClass('col-sm-12');
        $(window).scroll(function () {
            div_reference = $(".area-message-ready").offset().top;
            if (($(window).scrollTop() + $(window).height() - 200) > div_reference) {
                $(".area-button-fixed").removeClass('area-buttons').removeClass('col-sm-10').addClass('col-sm-12');
            } else {
                $(".area-button-fixed").addClass('area-buttons').addClass('col-sm-10').removeClass('col-sm-12');
            }
        });

        $("button#btn_cancel_event").click(function () {
            $(this).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> aguarde');
            if (event_id == "") {
                window.location.href = site + "chef/evento/";
            } else {
                var eventFormData = {
                    'event_id': event_id,
                    'status': 'deleted',
                    'user_id': $("[name=user_id]").val(),
                };
                jQuery.ajax({
                    url: site + 'api/evento/cancel/',
                    type: 'POST',
                    dataType: 'json',
                    data: eventFormData,
                    complete: function (xhr, textStatus) {},
                    success: function (data, textStatus, xhr) {
                        if (data.status == "ok") {
                            window.location.href = site + "chef/evento/";
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(xhr);
                    }
                });
            }
        });

        $("button.btn-functions").on('click', function () {
            $(this).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> aguarde').attr("disabled", "disabled");
        });

        $("button#btn_save_event").click(function () {
            var list = ['name', 'category'];
            if ($("[name=category]").val() == 6) {
                list.push('category_other');
            }
            if (validateForm(list)) {
                sendForm("incomplete");
            } else {
                $(".box-float-validate").show();
                setTimeout(function () {
                    $(".box-float-validate").hide();
                }, 5000);
                $(this).text($(this).attr("data-label")).removeAttr("disabled");
            }
        });

        $("button#btn_save_publish_event").click(function () {
            var list = ['name', 'date', 'timestart', 'timeend', 'zipcode', 'street', 'number', 'neighborhood', 'city', 'state', 'phone', 'description', 'end_subscription', 'price', 'num_users', 'invite_limit', 'category'];
            if ($("[name=category]").val() == 6) {
                list.push('category_other');
            }
            /*$(".fields_extra").find('input').each(function() {
             list.push($(this).attr('name'));
             });*/
            if (validateForm(list, true)) {
                sendForm("enable");
            } else {
                $(".box-float-validate").show();
                setTimeout(function () {
                    $(".box-float-validate").hide();
                }, 5000);
                $(this).text($(this).attr("data-label")).removeAttr("disabled");
            }
        });

        function sendFormPgto(status) {
            var picture;
            for (foto in fotos) {
                if (fotos[foto].principal == "sim")
                    picture = fotos[foto].imagem;
            }

            
            var date_start = "";
            var date_end = "";
            var date_end_subscription = "";
            if ($("[name=date]").val() != "") {
                date_start = (($("[name=date]").val()).split("/"))[2] + "-"
                        + (($("[name=date]").val()).split("/"))[1] + "-"
                        + (($("[name=date]").val()).split("/"))[0] + " "
                        + $("[name=timestart]").val();
                date_end = (($("[name=date]").val()).split("/"))[2] + "-"
                        + (($("[name=date]").val()).split("/"))[1] + "-"
                        + (($("[name=date]").val()).split("/"))[0] + " "
                        + $("[name=timeend]").val();
            }
            if ($("[name=end_subscription]").val() != "") {
                date_end_subscription = (($("[name=end_subscription]").val()).split("/"))[2] + "-"
                        + (($("[name=end_subscription]").val()).split("/"))[1] + "-"
                        + (($("[name=end_subscription]").val()).split("/"))[0]
            }
            var eventFormData = {
                'event_id': event_id,
                'name': $("[name=name]").val(),
                'event_type_id': $("[name=category]").val(),
                'start': date_start,
                'end': date_end,
                'price': $("[name=price]").val(),
                'status': "disable",
                'zipcode': $("[name=zipcode]").val(),
                'street': $("[name=street]").val(),
                'state': $("[name=state]").val(),
                'number': $("[name=number]").val(),
                'city': $("[name=city]").val(),
                'neighborhood': $("[name=neighborhood]").val(),
                'description': $("#description[name=description]").val(),
                'picture': picture,
                'end_subscription': date_end_subscription,
                'num_users': $("[name=num_users]").val(),
                'invite_limit': $("[name=invite_limit]").val(),
                'complement': $("[name=complement]").val(),
                'reference': $("[name=reference]").val(),
                'phone': $("[name=phone]").val(),
                'private': 1,
                'user_id': $("[name=user_id]").val(),
                'status': status,
                'free_invitation':$("[name=free_invitation]:checked").val()
            };

            var category_other = [];
            category_other.push({'value': $("[name=category_other]").val()});
            if ($("[name=category_other]").attr('data-id') != "")
                category_other.push({'event_type_other_id': $("[name=category_other]").attr('data-id')});
            eventFormData.category_other = category_other;

            var eventGuests = [];
            $("[name=guests]:checked").each(function () {
                eventGuests.push({'user_id': $(this).val(), 'status': 'waiting'});
            });

            var eventInfo = {};
            $(".event_info_type").each(function () {
                var id = $(this).attr("name");
                var val = $(this).val();
                eventInfo[id] = val;
            });

            fotos.filter(Array);
            eventFormData.fotos = fotos;
            eventFormData.fotos_save = fotos_save;
            eventFormData.guests = eventGuests;
            eventFormData.guests_save = guests_save;
            eventFormData.fields = eventInfo;

            jQuery.ajax({
                url: site + 'api/evento/novo/',
                type: 'POST',
                dataType: 'json',
                data: eventFormData,
                complete: function (xhr, textStatus) {},
                success: function (data, textStatus, xhr) {
                    if (status == "incomplete") {
                       
                          //window.location.href = site + "chef/evento/novo/" + data.event_id; 
                        $("[name=itemId1]").val(data.event_id);
                        $("[name=itemDescription1]").val($("[name=name]").val());
                        $("[name=itemAmount1]").val($("#free_invitation_label").text());
                        $("[name=reference]").val(data.event_id);
                        var dadosFormData = {
                            'itemDescription1': $("[name=itemDescription1]").val(),
                            'itemQuantity1': $("[name=itemQuantity1]").val(),
                            'itemId1': $("[name=itemId1]").val(),
                            'itemWeight1': $("[name=itemWeight1]").val(),
                            'itemAmount1':$("[name=itemAmount1]").val(),
                            'senderName': $("[name=senderName]").val(),
                            'senderEmail': $("[name=senderEmail]").val(),
                            'reference': $("[name=referencia]").val()
                        };
                        $.post(BASEURL + "chef/evento/pagamento",dadosFormData,function(code){
                            var isOpenLightbox = PagSeguroLightbox({
                                code: code
                            }, {
                                success : function(transactionCode) {
                                    location.href = site+'chef/evento/novo/'+data.event_id
                                },
                                abort : function() {
                                    location.href = site+'chef/evento/novo/'+data.event_id
                                }
                            });
                        })

                    } else {
                        sendEmailGuests(data.event_id);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(xhr);
                }
            });
        }

        function sendForm(status) {
            var picture;
            for (foto in fotos) {
                if (fotos[foto].principal == "sim")
                    picture = fotos[foto].imagem;
            }

        
            var date_start = "";
            var date_end = "";
            var date_end_subscription = "";
            if ($("[name=date]").val() != "") {
                date_start = (($("[name=date]").val()).split("/"))[2] + "-"
                        + (($("[name=date]").val()).split("/"))[1] + "-"
                        + (($("[name=date]").val()).split("/"))[0] + " "
                        + $("[name=timestart]").val();
                date_end = (($("[name=date]").val()).split("/"))[2] + "-"
                        + (($("[name=date]").val()).split("/"))[1] + "-"
                        + (($("[name=date]").val()).split("/"))[0] + " "
                        + $("[name=timeend]").val();
            }
            if ($("[name=end_subscription]").val() != "") {
                date_end_subscription = (($("[name=end_subscription]").val()).split("/"))[2] + "-"
                        + (($("[name=end_subscription]").val()).split("/"))[1] + "-"
                        + (($("[name=end_subscription]").val()).split("/"))[0]
            }
            var eventFormData = {
                'event_id': event_id,
                'name': $("[name=name]").val(),
                'event_type_id': $("[name=category]").val(),
                'start': date_start,
                'end': date_end,
                'price': $("[name=price]").val(),
                'status': "disable",
                'zipcode': $("[name=zipcode]").val(),
                'street': $("[name=street]").val(),
                'state': $("[name=state]").val(),
                'number': $("[name=number]").val(),
                'city': $("[name=city]").val(),
                'neighborhood': $("[name=neighborhood]").val(),
                'description': $("#description[name=description]").val(),
                'picture': picture,
                'end_subscription': date_end_subscription,
                'num_users': $("[name=num_users]").val(),
                'invite_limit': $("[name=invite_limit]").val(),
                'complement': $("[name=complement]").val(),
                'reference': $("[name=reference]").val(),
                'phone': $("[name=phone]").val(),
                'private': 1,
                'user_id': $("[name=user_id]").val(),
                'status': status,
                'free_invitation':$("[name=free_invitation]:checked").val()

            };

            var category_other = [];
            category_other.push({'value': $("[name=category_other]").val()});
            if ($("[name=category_other]").attr('data-id') != "")
                category_other.push({'event_type_other_id': $("[name=category_other]").attr('data-id')});
            eventFormData.category_other = category_other;

            var eventGuests = [];
            $("[name=guests]:checked").each(function () {
                eventGuests.push({'user_id': $(this).val(), 'status': 'waiting'});
            });

            var eventInfo = {};
            $(".event_info_type").each(function () {
                var id = $(this).attr("name");
                var val = $(this).val();
                eventInfo[id] = val;
            });

            fotos.filter(Array);
            eventFormData.fotos = fotos;
            eventFormData.fotos_save = fotos_save;
            eventFormData.guests = eventGuests;
            eventFormData.guests_save = guests_save;
            eventFormData.fields = eventInfo;

            jQuery.ajax({
                url: site + 'api/evento/novo/',
                type: 'POST',
                dataType: 'json',
                data: eventFormData,
                complete: function (xhr, textStatus) {},
                success: function (data, textStatus, xhr) {
                    if (status == "incomplete") {
                        window.location.href = site + "chef/evento/novo/" + data.event_id;  
                        
                    } else {
                        sendEmailGuests(data.event_id);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(xhr);
                }
            });
        }

        function sendEmailGuests(event_id) {
            var post_data = {};
            post_data.event_id = event_id;

            jQuery.ajax({
                url: site + 'api/evento/sendemailfromguests',
                type: 'POST',
                dataType: 'json',
                data: post_data,
                complete: function (xhr, textStatus) {},
                success: function (data, textStatus, xhr) {
                    window.location.href = site + "chef/evento/";
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(xhr);
                }
            });
        }

        function clearValidate() {
            $("div.form-group").removeClass('has-error');
            $("label").removeClass('text-danger');
        }

        function validateForm(list, photos = false) {
            clearValidate();
            var error = 0;
            var position = 0;

            for (l in list) {
                if ($('#' + list[l] + '[name=' + list[l] + ']').val() == "") {
                    $('label[for=' + list[l] + ']').addClass('text-danger');
                    $('label[for=' + list[l] + ']').parent().addClass('has-error');
                    if (position == 0) {
                        position = $('label[for=' + list[l] + ']').offset().top - $('.navbar').height() - 10;
                    }
                    error++;
                }
            }

            if (photos == true) {
                if (fotos.length == 0) {
                    $('label[for=photo]').addClass('text-danger');
                    $('label[for=photo]').parent().addClass('has-error');
                    if (position == 0) {
                        position = $('label[for=photo]').offset().top - $('.navbar').height() - 10;
                    }
                    error++;
                }
            }

            if (error > 0) {
                $("body").animate({scrollTop: position});
                return false;
            }
            return true;
        }
        var max_character = 1000;
        var count_character = 0;
        $("#description[name=description]").keypress(function (ev) {
            count_character = $(this).val().length;
            if (count_character == max_character)
                ev.preventDefault();
        });
        $("#description[name=description]").keyup(function (ev) {
            count_character = $(this).val().length;
            $(".contador-char").text((count_character) + " de " + max_character + " caracteres");
        });

        $('body').on('click','#pagseguro_pgto',function(e){
            
            e.preventDefault(); 
            if($("[name=referencia]").val()==""){
               
                var list = ['name', 'category'];
                if ($("[name=category]").val() == 6) {
                    list.push('category_other');
                }
                if (validateForm(list)) {
                    $(this).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> aguarde').attr("disabled", "disabled");
                    sendFormPgto("incomplete");
                } else {
                    $(".box-float-validate").show();
                    setTimeout(function () {
                        $(".box-float-validate").hide();
                    }, 5000);
                    $(this).text($(this).attr("data-label")).removeAttr("disabled");
                }
            }else{

                var dadosFormData = {
                    'itemDescription1': $("[name=itemDescription1]").val(),
                    'itemQuantity1': $("[name=itemQuantity1]").val(),
                    'itemId1': $("[name=itemId1]").val(),
                    'itemWeight1': $("[name=itemWeight1]").val(),
                    'itemAmount1':$("[name=itemAmount1]").val(),
                    'senderName': $("[name=senderName]").val(),
                    'senderEmail': $("[name=senderEmail]").val(),
                    'reference': $("[name=referencia]").val()
                    };
                $.post(BASEURL + "chef/evento/pagamento",dadosFormData,function(data){
                    $('#code').val(data);
                    $('#comprar').submit();
                })
            }

        })


    });
</script>
