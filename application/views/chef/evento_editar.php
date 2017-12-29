<?php include_once(dirname(__FILE__).'/header.php'); ?>
    <ul class="breadcrumbs">
        <li class="col-sm-3 text-center">Eventos Gastrônomicos</li>
        <li class="col-sm-9 text-success text-center"><?php echo $evento['name'] ?> <?php echo formata_data(substr($evento['start'],0, 10)); ?></li>
    </ul>
    <?php if (isset($save)): ?>
        <div class="alert alert-success">Dados salvos com sucesso</div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error ?></div>
    <?php endif; ?>
    <div class="bg-white">
        <div class="panel panel-success">
            <div class="panel-heading"></div>
            <div class="panel-body text-center text-strong">
                <p><?php echo $evento['name'] ?> <?php echo formata_data(substr($evento['start'],0, 10));; ?></p>
            </div>
        </div>
        <div class="col-sm-6">
            <?php /*
            <form method="post" action="<?php echo site_url('chef/evento/addFoto/'.$evento['event_id']) ?>" enctype="multipart/form-data">
                <div class="form-group input-group">
                    <label class="input-group-addon" for="picture"><i class="fa fa-image"></i> Nova Imagem</label>
                    <input type="file" class="form-control" name="picture" id="picture">
                    <span class="input-group-btn">
                        <button class="btn btn-default">Enviar</button>
                    </span>
                </div>
            </form>
            <div id="galeria" class="clearfix" style="max-width:100%;"><!--galeria de imagens -->
                <?php if(count($evento['pictures']) > 1):?>
                    <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                        <?php foreach($evento['pictures'] as $picture_id => $foto):?>
                            <li data-thumb="<?php echo $foto['href'];?>">
                                <a href="<?php echo site_url('chef/evento/removerFoto/'.$picture_id) ?>" class="btn-trash"><i class="fa fa-trash fa-2x"></i></a>
                                <img src="<?php echo $foto['href'];?>" alt="<?php echo $evento['name'] ?>" class="img-responsive" />
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </div>
             * 
             */ ?>
            <input type="hidden" name='user_id' id='user_id' value="<?php echo $user_id ?>" />
            <div class="col-sm-12">
                <div class="row">
                    <div class="gallery" class="clearfix" style="max-width:100%;">
                        <ul id="gallery_event" class="gallery list-unstyled">
                        <?php if (isset($evento['picture']) && (explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1]) != ""): 
                            $li = "<li data-thumb='{$evento['picture']}'>";
                            $li .= "<div class='box-img-functions'>";
                            $li .= "<div class='img-functions'><input type='radio' checked='checked' class='photo-main btn-photo-main' value='".explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1]."' name='photo_main' id='".explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1]."'/><label class='photo-main' for='".explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1]."'>Foto principal</label></div>";
                            $li .= "<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='".explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1]."' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>";
                            $li .= "</div>";
                            $li .= "<img src='{$evento['picture']}' class='img-responsive img-align-center' style='margin-top: -36px' />";
                            $li .= "</li>";
                            echo $li;
                            endif;
                        if (isset($evento['pictures'])):
                         foreach ($evento['pictures'] as $picture) {
                            $li = "<li data-thumb='{$picture['href']}'>";
                            $li .= "<div class='box-img-functions'>";
                            $li .= "<div class='img-functions'><input type='radio' class='photo-main btn-photo-main' value='".explode("/", $picture['href'])[count(explode("/", $picture['href'])) -1]."' name='photo_main' id='".explode("/", $picture['href'])[count(explode("/", $picture['href'])) -1]."'/><label class='photo-main' for='".explode("/", $picture['href'])[count(explode("/", $picture['href'])) -1]."'>Foto principal</label></div>";
                            $li .= "<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='".explode("/", $picture['href'])[count(explode("/", $picture['href'])) -1]."' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>";
                            $li .= "</div>";
                            $li .= "<img src='{$picture['href']}' class='img-responsive img-align-center' style='margin-top: -36px' />";
                            $li .= "</li>";
                            echo $li;
                         }
                        endif; ?>
                        </ul>
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
            <ul class="evento-tabs" role="tablist">
                <li class="active">
                    <a href="#informacoes" data-toggle="tab"><i class="icon ion-ios-list-outline fa-2x"></i></a>
                </li>
                <li>
                    <a href="#profile" data-toggle="tab" class="cardapio"><i class="icon-cardapio"></i></a>
                </li>
                <li>
                    <a href="#messages" data-toggle="tab"><i class="icon ion-person-stalker fa-2x"></i> <span><?php echo $evento['total_confirmed'] ?></span></a>
                </li>
                <li>
                    <a href="#settings" data-toggle="tab"><i class="icon ion-quote fa-2x"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <form class="form-horizontal tab-content" method="post">
                <div role="tabpanel" class="tab-pane active padding-md" id="informacoes">
                    <h5 class="text-danger">Informações</h5>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <p class="form-control-static"><?php echo $evento['description'] ?></p>
                            <?php /*<textarea class="form-control"><?php echo $evento['description'] ?></textarea>*/ ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Data:</label> 
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo date('d/m/Y', strtotime($evento['start'])) ?></p>
                            <?php /*<input type="date" value="<?php echo substr($evento['start'], 0, 10) ?>" name="start" class="form-control" />*/ ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hora:</label> 
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo date('H:i', strtotime($evento['start'])) ?></p>
                            <?php /*<input type="text" value="<?php echo substr($evento['start'], 11, -3) ?>" name="start_hour" class="form-control" />*/ ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Valor:</label> 
                        <div class="col-sm-9">
                            <p class="form-control-static">R$ <?php echo number_format($evento['price'], 2, ',', '.') ?></p>
                            <?php /*<input type="text" class="form-control" name="price" value="<?php echo number_format($evento['price'], 2, ',', '.') ?>">*/ ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Categoria:</label> 
                        <div class="col-sm-9">
                            <p class="form-control-static">
                            <?php foreach ($tipos as $item):
                                    if ($item->event_type_id == 6) 
                                        echo (isset($event_type_other->value)) ? $event_type_other->value : " ";
                                    else if ($item->event_type_id == $evento['event_type_id']):
                                        echo (isset($item->name)) ? $item->name : " ";
                                    endif;
                                endforeach; ?>
                            </p>
                            <?php /*
                            <select name="event_type_id" class="form-control">
                                <?php foreach ($tipos as $item): ?>
                                <option value="<?php echo $item->event_type_id ?>" <?php echo ($item->event_type_id == $evento['event_type_id'] ? 'selected' : '') ?>><?php echo $item->name ?></option>
                                <?php endforeach; ?>
                            </select>
                             */ ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><i class="icon ion-ios-location"></i> Local:</label> 
                        <div class="col-sm-9">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p class="form-control-static"><?php echo $evento['street'] ?>, <?php echo $evento['number'] ?></p>
                                    <?php /*<input type="text" name="street" class="form-control" value="<?php echo $evento['street'] ?>" placeholder="Logradouro" /> */ ?>
                                </div>
                                <?php /*<div class="col-sm-4">
                                    <input type="number" name="number" class="form-control col-sm-6" value="<?php echo $evento['number'] ?>" placeholder="Número" />
                                </div>*/ ?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p class="form-control-static"><?php echo $evento['neighborhood'] ?>, <?php echo $evento['city'] ?>, <?php echo $evento['state'] ?> - <?php echo $evento['zipcode'] ?></p>
                                    <?php /*<input type="text" name="state" class="form-control" value="<?php echo $evento['state'] ?>" placeholder="Estado" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="city" class="form-control" value="<?php echo $evento['city'] ?>" placeholder="Cidade" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" name="neighborhood" class="form-control" value="<?php echo $evento['neighborhood'] ?>" placeholder="Bairro" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="zipcode" class="form-control" value="<?php echo $evento['zipcode'] ?>" placeholder="CEP" />
                                 */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label"><i class="icon-chair"></i> Limite de participantes:</label> 
                        <div class="col-sm-6">
                            <p class="form-control-static field-noedit" data-id="num_users"><?php echo $evento['num_users'] ?></p>
                            <?php /*<input type="number" name="num_users" value="<?php echo $evento['num_users'] ?>" class="form-control" /> */ ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label"><i class="icon ion-ios-clock-outline"></i> Limite para adesão:</label> 
                        <div class="col-sm-6">
                            <p class="form-control-static"><?php echo date('d/m/Y', strtotime($evento['end_subscription'])) ?></p>
                            <?php /*<input type="date" name="end_subscription" value="<?php echo date('Y-m-d', strtotime($evento['end_subscription'])) ?>" class="form-control" />*/ ?>
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn btn-sm btn-gray btn-block" id="edit_evento" data-toggle="modal" data-target="#form_evento">Editar evento</button>
                    </div>
                    <div class="modal fade" id="form_evento" tabindex="-1" role="dialog" aria-labelledby="Editar evento">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header edit-evento">
                                    <h4 class="modal-title edit-evento">
                                        <div class="title">
                                            Evento
                                        </div>
                                        <div class="desc-event">
                                            <?php echo "{$evento['name']} ".date("d/m/Y", strtotime($evento['start'])); ?>
                                        </div>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label"><i class="icon-chair"></i> Limite de participantes:</label> 
                                            <div class="col-sm-6">
                                                <input type="number" name="num_users" value="<?php echo $evento['num_users'] ?>" class="form-control" />
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                                <div class="modal-footer edit-menu">
                                    <div class="footer-buttons" style="float: left">
                                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
                                    </div>                                        
                                    <div class="footer-buttons">
                                        <button type="button" class="btn btn-success btn-block" data-dismiss="modal" id="change_evento">Ok</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane padding-md" id="profile">
                    <h5 class="text-danger">Menu</h5>
                    <div class="row noedit-menu">
                        <?php $extras = array_replace(array_flip(array(4, 0, 5, 1, 6, 2, 3, 7)), $evento['menu']); ?>
                        <?php foreach ($extras as $item): ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?php echo $item->name ?>:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static field-noedit" data-id="<?php echo $item->event_value_id ?>"><?php echo $item->info_value ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <button class="btn btn-sm btn-gray btn-block" id="edit_menu" data-toggle="modal" data-target="#form_menu">Editar menu</button>
                    </div>
                    <div class="modal fade" id="form_menu" tabindex="-1" role="dialog" aria-labelledby="Editar menu">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header edit-menu">
                                    <h4 class="modal-title edit-menu">
                                        <div class="title">
                                            Menu
                                        </div>
                                        <div class="desc-event">
                                            <?php echo "{$evento['name']} ".date("d/m/Y", strtotime($evento['start'])); ?>
                                        </div>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <?php $extras = array_replace(array_flip(array(4, 0, 5, 1, 6, 2, 3, 7)), $evento['menu']); ?>
                                        <?php foreach ($extras as $item): ?>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"><?php echo $item->name; ?>:</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="<?php echo $item->event_value_id ?>" value="<?php echo $item->info_value ?>" />
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="modal-footer edit-menu">
                                    <div class="footer-buttons" style="float: left">
                                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancelar</button>
                                    </div>                                        
                                    <div class="footer-buttons">
                                        <button type="button" class="btn btn-success btn-block" data-dismiss="modal" id="change_menu">Ok</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div role="tabpanel" class="tab-pane padding-md" id="messages">
                    <h5 class="text-success text-center">Convites Confirmados</h5>
                    <p class="text-center">Convidados que já efetuaram o pagamento</p>
                    <ul class="lista-users">
                        <?php foreach ($evento['guests'] as $item): ?>
                            <?php if ($item['status'] == 'confirmed' && $item['payment'] == "Pago"): ?>
                                <li class="row media">
                                    <div class="col-sm-10 row-friend">
                                        <div class="col-sm-3 col-photo">
                                            <img src="<?php echo $item['picture'] ?>" alt="<?php echo $item['name'] ?> <?php echo $item['lastname'] ?>" class="photo-friends">
                                            <span class="indicator-guests <?php echo ($item['convidados'] == "")? 'hide' : '' ?>">+<?php echo $item['convidados'] ?></span>
                                        </div>
                                        <div class="col-sm-2 col-type-user">
                                            <img src="<?php echo base_url() ?>assets/img/<?php echo ($item['type'] == 3 ? 'pacman.jpg' : 'chef.jpg') ?>" class="picture-type-user">
                                        </div>
                                        <div class="col-sm-7 col-friend">
                                            <div class="row-desc-friends">
                                                <div class="friend-name"><?php echo $item['name'] ?> <?php echo $item['lastname'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <span class="text-success pull-right"><i class="fa fa-check-circle fa-2x"></i></span>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane padding-md" id="settings">
                    <h5 class="text-danger">Comentários</h5>
                    <ul class="media-list">
                        <?php foreach ($evento['comments'] as $item): ?>
                        <li class="row media">
                            <div class="col-xs-2">
                                <img class="photo-friends" src="<?php echo $item['picture'] ?>" alt="<?php echo $item['name'] ?>">
                            </div>
                            <div class="col-xs-10">
                                <h4 class="media-heading"><?php echo $item['name'] ?> <?php echo $item['lastname'] ?></h4>
                                <p><small><?php echo $item['date'] ?></small></p>
                                <p><?php echo $item['comment'] ?></p>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="row">
                    <button class="btn btn-sm btn-success btn-block" id="update_event">Salvar alterações e publicar</button>
                    <button class="btn btn-sm btn-gray btn-block" id="cancel_event" data-toggle="modal" data-target="#modal_cancel_event">Cancelar evento</button>
                    <div class="modal fade" id="modal_cancel_event" tabindex="-1" role="dialog" aria-labelledby="Cancelar evento">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header remove-event">
                                    <h4 class="modal-title remove-event">
                                        <div class="title">
                                            Evento
                                        </div>
                                        <div class="desc-event">
                                            <?php echo "{$evento['name']} ".date("d/m/Y", strtotime($evento['start'])); ?>
                                        </div>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <h3 class="text-danger">Tem certeza que deseja cancelar este evento?</h3>
                                </div>
                                <div class="modal-footer remove-event">
                                    <div class="footer-buttons" style="float: left">
                                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Não</button>
                                    </div>                                        
                                    <div class="footer-buttons">
                                        <button type="button" class="btn btn-success btn-block" id="remove-event" data-dismiss="modal">Sim, tenho certeza!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
            <div class="col-sm-6">
                <div class="well bg-white procurar_amigos">
                    <h2 class="h3 text-success text-center"><i class="icon ion-person-add"></i> Convidar amigos</h2>
                    <p class="text-center">Convidar seus amigos para o encontro.</p>
                    <form class="inline-form busca empty filter_list">
                        <input type="search" name="search" class="form-control filterinput" value="Procurar">
                    </form>
                    <div class="resultado-busca">
                        <ul class="lista-users">
                            <?php foreach ($amigos as $item): ?>
                            <li>
                                <div class="col-sm-12 row-friend">
                                    <div class="col-sm-3 col-photo">
                                        <img src="<?php echo $item->picture ?>" alt="<?php echo $item->name ?>" class="photo-friends" />
                                    </div>
                                    <div class="col-sm-2 col-type-user">
                                        <img src="<?php echo base_url() ?>assets/img/<?php echo ($item->user_type_id == 2)? 'chef.jpg' : 'pacman.jpg' ?>" class="picture-type-user" />
                                    </div>
                                    <div class="col-sm-7 col-friend">
                                        <div class="row-desc-friends">
                                            <div class="friend-name"><?php echo $item->name; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 row-friend">
                                    <div class="col-add-friend">
                                        <?php if (in_array($item->user_id, $users_convidados)): ?>
                                            <span class="pull-right btn btn-xs btn-warning disabled">Convite enviado</span>
                                        <?php else: ?>
                                            <a href="<?php echo site_url('chef/evento/convidar/'.$evento['event_id'].'/'.$item->user_id) ?>" class="btn btn-success btn-xs pull-right convidar">Convidar</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>    
            </div>
        <div class="clearfix"></div>
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
<?php include_once(dirname(__FILE__).'/footer.php'); ?>
<script>
    $(document).ready(function(){
        var event_id = "<?php echo $evento['event_id']; ?>";
        var fotos = [];
        var fotos_save = [];
        
        setTimeout(function(){
            $('[name=photo_main]:checked').next().trigger('click');
            checkQuantImage();
        }, 500);
        
        var newObjt = {};
        <?php if (isset($evento['picture']) && (explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1]) != "") { ?>
            newObjt.id_imagem = "event";
            newObjt.imagem = "<?php echo explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1] ?>";
            newObjt.href = "<?php echo explode("/", $evento['picture'])[count(explode("/", $evento['picture'])) -1] ?>";
            newObjt.principal = "sim";
            fotos_save.push(newObjt);
            fotos.push(newObjt);
            newObjt = {};
        <?php } 
        foreach ($evento['pictures'] as $key => $picture) { ?>
            newObjt.id_imagem = "<?php echo $key?>";
            newObjt.imagem = "<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) -1]; ?>";
            newObjt.href = "<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) -1]; ?>";
            newObjt.principal = "não";
            fotos_save.push(newObjt);
            fotos.push(newObjt);
            newObjt = {};
        <?php } ?>
        
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
        
        $("button.btn-cancel-upload").click(function () {
            if (ajaxUploadFoto)
                ajaxUploadFoto.abort();
        });
        
        function toggleSpinner() {
            $(".file-upload").toggleClass('hide');
            $(".upload-spinner").toggleClass('hide');
            $("button.btn-cancel-upload").toggleClass("hide");
        }
        
        var slide = $("#gallery_event").lightSlider({
            gallery:true,
            formUpload: $(".form-upload").html(),
            item:1,
            loop:true,
            thumbItem:9,
            slideMargin:0,
            enableDrag: true,
            currentPagerPosition:'left',
            onSliderLoad: function(el) {
                /*el.lightGallery({
                    selector: '#gallery_event .lslide'
                });*/
            }
        });
       
        function rebuildSlider() {
            slide.destroy();
            slide = $("#gallery_event").lightSlider({
                gallery:true,
                formUpload: $(".form-upload").html(),
                item:1,
                loop:true,
                thumbItem:9,
                slideMargin:0,
                enableDrag: true,
                currentPagerPosition:'left',
                onSliderLoad: function(el) {
                    /*el.lightGallery({
                        selector: '#gallery_event .lslide'
                    });*/
                }
            });
        }
        
        function checkImageMain() {
            for (foto in fotos) {
                if (fotos[foto].principal == "sim") {
                    $('body').find("input[name=photo_main]").each(function(){
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
        
        $("body").on('change', '#photo', function(e){
            //toggleSpinner();
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
                    //toggleSpinner();
                }
            });
        });
        
        function cropImage(img) {
            var area_image = "<img id='image_crop' src='"+site+"uploads/"+img+"' class='img-responsive img-align-center' />";
            $("#adjustPhoto .modal-dialog").width($(document).width() * 0.80);
            $(".area-img").parent().height($(window).height() * 0.70);
            $(".area-img").html(area_image).removeClass('hide').fadeIn();
            $(".area-img").append("<input type='hidden' value='"+img+"' name='formPhoto' />");
            $(".area-spinner").fadeOut();
            
            var mc = $("#image_crop");
            mc.croppie({
                viewport: {
                    width: 800,
                    height: 400,
                }, boundary: {
                    width: ($(".area-img").parent().width() > 800)? $(".area-img").parent().width() : 800,
                    height: ($(".area-img").parent().height() > 400)? $(".area-img").parent().height() * 0.93 : 400
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
        
        function cleanAdjustPhoto () {
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
        
        $("body").on('click', '.btn-photo-main', function(e){
            var img = $(this).val();
            for (foto in fotos) {
                if (fotos[foto].imagem == img) {
                    fotos[foto].principal = "sim";
                } else {
                    fotos[foto].principal = "não";
                }
            }
        });
        
        $("button#change_menu").on("click", function(ev){
            ev.preventDefault();
            $("#form_menu").find('input').each(function(){
                $(".field-noedit[data-id="+$(this).attr('name')+"]").text($(this).val());
            });
        });
        
        $("button#edit_menu").on("click", function(ev){
            ev.preventDefault();
        });

        $("button#change_evento").on("click", function(ev){
            ev.preventDefault();
            $("#form_evento").find('input').each(function(){
                $(".field-noedit[data-id="+$(this).attr('name')+"]").text($(this).val());
            });
        });

        $("button#edit_evento").on("click", function(ev){
            ev.preventDefault();
        });
        
        $("button#update_event").on("click", function(ev){
            ev.preventDefault();
            var eventInfo = {};
            $(".noedit-menu").find('.field-noedit').each(function(){
                var id = $(this).attr('data-id')
                var val = $(this).text();
                eventInfo[id] = val;
            });

            
            
            var eventFormData = {};
            fotos.filter(Array);
            eventFormData.fotos = fotos;
            eventFormData.fotos_save = fotos_save;
            eventFormData.fields = eventInfo;
            eventFormData.event_id = event_id;
            eventFormData.status = "update_publish";
            eventFormData.user_id = $("[name=user_id]").val();

            $('#informacoes').find('.field-noedit').each(function(){
                var id = $(this).attr('data-id')
                var val = $(this).text();
                eventFormData.num_users = val;

            });
            
            jQuery.ajax({
                url: site + "api/evento/novo",
                type: 'POST',
                dataType: 'json',
                data: eventFormData,
                complete: function (xhr, textStatus) {},
                success: function (data, textStatus, xhr){
                    if (data.status == "ok") {
                        window.location.href = site + 'chef/evento/editar/' + data.event_id + "/" + data.status;
                    } else {
                        window.location.href = site + 'chef/evento/editar/' + data.event_id;
                    }
                }, error: function (xhr, textStatus, errorThrown) {
                    window.location.href = site + 'chef/evento/editar/' + data.event_id;
                }
            });
        });
        
        $("button#cancel_event").on("click", function(ev){
            ev.preventDefault();
        });
        $("button#remove-event").on("click", function(){
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
                        window.location.href = site + 'chef/evento/editar/' +
                                data.event_id;
                    }
            });
        });
        
        edit_disable();
        function edit_disable() {
            var start_event = "<?php echo strtotime($evento["start"]); ?>";
            var time = "<?php echo strtotime(date("Y-m-d H:i:s")); ?>";
            if (time >= start_event) {
                $(".btn.convidar").remove();
                $(".lSFile").remove();
                $(".box-img-functions").remove();
                $("#edit_menu").remove();
                $("#edit_evento").remove();
                $("#update_event").remove();
                $("#cancel_event").remove();
            }
        }
    });
</script>
