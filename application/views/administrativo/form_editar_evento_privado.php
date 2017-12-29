<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
<div id="main-container">
    <div class="col-md-12">
        <h3 class="headline m-top-md"><?php echo ucfirst("Editar"); ?></h3>
        <ul class="nav nav-tabs">
            <li role="presentation" class="tab calendario"><a href=".calendario">CALENDÁRIO</a></li>
            <li role="presentation" class="tab anuncio disabled"><a href=".anuncio">ANUNCIO</a></li>
            <li role="presentation" class="tab preco disabled "><a href=".preco">PREÇO</a></li>
            <li role="presentation" class="tab fotos disabled"><a href=".fotos">FOTOS</a></li>
            <li role="presentation" class="tab localizacao disabled"><a href=".localizacao">LOCALIZAÇÃO</a></li>
            <li role="presentation" class="tab sobre disabled"><a href=".sobre">MENU</a></li>
        </ul>
        <script type="text/javascript">
            var event_id = "<?php echo $info['event_id'] ?>";
            var ncupons = 0;
            var fotos = [];
            var fotos_saved = [];
            var cupons = [];
            var cupons_saved = [];
            var event_type_id = "<?php echo $info['event_type_id']; ?>";
            var event_private = "<?php echo ($info['private']); ?>";

<?php if (isset($info['picture']) && (explode('/', $info['picture'])[count(explode('/', $info['picture'])) - 1]) != ""): ?>
                newobjt = {};
                newobjt.id_imagem = "event";
                newobjt.imagem = "<?php echo explode("/", $info['picture'])[count(explode("/", $info['picture'])) - 1] ?>";
                newobjt.href = "<?php echo explode("/", $info['picture'])[count(explode("/", $info['picture'])) - 1] ?>";
                newobjt.principal = "sim";
                fotos.push(newobjt);
                fotos_saved.push(newobjt);
    <?php
endif;
if (isset($info['pictures'])):
    foreach ($info['pictures'] as $key => $picture):
        ?>
                    newobjt = {};
                    newobjt.id_imagem = "<?php echo $key ?>";
                    newobjt.imagem = "<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] ?>";
                    newobjt.href = "<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] ?>";
                    newobjt.principal = "não";

                    fotos.push(newobjt);
                    fotos_saved.push(newobjt);
        <?php
    endforeach;
endif;
?>
        </script>
        <div class="panel-body">
            <!--  <form action="" method="post" class="form-horizontal no-margin form-border" enctype="multipart/form-data">  -->               
            <div class="calendario tabcontent">
                <div class="form-group">
                    <label for="">Data início</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="datestart" id="datestart" class="form-control required" value="<?php echo ((isset($info['start']) && (strtotime($info['start']) >= 0)) ? date("d/m/Y", strtotime($info['start'])) : '') ?>" />
                </div>
                <div class="form-group">
                    <label for="">Hora início</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="time" name="timestart" id="timestart" class="form-control required" value="<?php echo ((isset($info['start']) && (strtotime($info['start']) >= 0)) ? date("H:i", strtotime($info['start'])) : '') ?>" />
                </div>
                <div class="form-group">
                    <label for="">Hora término</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="time" name="timeend" id="timeend" class="form-control required" value="<?php echo ((isset($info['end']) && (strtotime($info['end']) >= 0)) ? date("H:i", strtotime($info['end'])) : '') ?>" />
                </div>
                <!--<div class="form-group">
                    <label for="">Fim Participação</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="date" name="end_subscription" id="end_subscription" class="form-control" value="" />
                </div>-->
                <div class="form-group">
                    <div class="">
                        <button type="button" data-proxima=".anuncio" data-atual=".calendario" value="Salvar" class="btn btn-primary btn-next">Próxima</button>
                    </div>
                </div>
            </div>

            <div class="anuncio tabcontent">
                <div class="form-group">
                    <label for="">Título do evento</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="name" class="form-control" value="<?php echo $info['name']; ?>" />
                </div>
                <?php /* <div class="form-group">
                  <label for="">Evento Privado</label>
                  <div class="error">Campo Obrigatório</div>
                  <?php
                  $private = array(
                  array('value' => 0, 'label' => 'Não'),
                  array('value' => 1, 'label' => 'Sim')
                  );
                  ?>
                  <select class="form-control required" name="private">
                  <option value="">Escolha uma opção</option>
                  <?php foreach ($private as $priv): ?>
                  <?php if ($priv['value'] == $info['private']): ?>
                  <option value="<?php echo $priv['value']; ?>" selected><?php echo $priv['label']; ?></option>
                  <?php else: ?>
                  <option value="<?php echo $priv['value']; ?>"><?php echo $priv['label']; ?></option>
                  <?php endif; ?>
                  <?php endforeach; ?>
                  </select>
                  </div> */ ?>
                <div class="form-group">
                    <label for="">Tipo de evento</label>
                    <div class="error">Campo Obrigatório</div>
                    <select class="form-control required" name="event_type_id">
                        <option value="">Escolha uma opção</option>
                        <?php foreach ($event_type as $type): ?>
                            <?php if ($info['event_type_id'] == $type->event_type_id): ?>
                                <option value="<?php echo $type->event_type_id ?>" selected><?php echo $type->name ?></option>
                            <?php else: ?>
                                <option value="<?php echo $type->event_type_id ?>"><?php echo $type->name ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Descrição</label>
                    <div class="error">Campo Obrigatório</div>
                    <textarea name="description" id="description" class="form-control required" cols="30" rows="10"><?php echo $info['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <div class="error">Campo Obrigatório</div>
                    <?php
                    $status = array(
                        array('value' => 'enable', 'label' => 'Ativo'),
                        array('value' => 'disable', 'label' => 'Inativo')
                    );
                    ?>
                    <select name="status" class="form-control required">
                        <option value="">Escolha uma opção</option>
                        <?php foreach ($status as $stat): ?>
                            <?php if ($stat['value'] == $info['status']): ?>
                                <option value="<?php echo $stat['value']; ?>" selected><?php echo $stat['label']; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $stat['value']; ?>"><?php echo $stat['label']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="form-group">
                    <div class="">
                        <button type="button" data-proxima=".calendario" data-atual=".anuncio" value="Salvar" class="btn btn-danger btn-prev">Anterior</button>
                        <button type="button" data-proxima=".preco" data-atual=".anuncio" value="Salvar" class="btn btn-primary btn-next">Próxima</button>
                    </div>
                </div>
            </div>

            <div class="preco tabcontent">
                <div class="row-preco">
                    <div class="form-group">
                        <label for="">Preço</label>
                        <div class="error">Campo Obrigatório</div>
                        <input type="text" name="price" class="form-control currency" value="<?php echo $info['price']; ?>" placeholder="R$">
                    </div>
                    <div class="form-group">
                        <label for="">Taxa</label>
                        <input type="text" name="rate" id="rate" value="<?php echo $info['rate']; ?>" class="form-control currency">
                    </div>
                    <div class="form-group">
                        <label for="">Número de convidados</label>
                        <div class="error">Campo Obrigatório</div>
                        <input type="text" name="num_users" class="form-control" value="<?php echo $info['num_users']; ?>" placeholder="" />
                    </div>
                    <div class="form-group">
                        <label for="">Número de Acompanhantes por convidado</label>
                        <div class="error">Campo Obrigatório</div>
                        <input type="text" name="invite_limit" class="form-control" value="<?php echo $info['invite_limit']; ?>" placeholder="" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <button type="button" data-proxima=".anuncio" data-atual=".preco" value="Salvar" class="btn btn-danger btn-prev">Anterior</button>
                        <button type="button" data-proxima=".fotos" data-atual=".preco" value="Salvar" class="btn btn-primary btn-next">Próxima</button>
                    </div>
                </div>
            </div>

            <div class="fotos tabcontent">
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="clearfix" style="max-width:100%;">
                                <ul id="gallery_event" class="gallery list-unstyled">
                                    <?php if (isset($info['picture']) && (explode('/', $info['picture'])[count(explode('/', $info['picture'])) - 1]) != ""): ?>
                                        <li data-thumb="<?php echo $info['picture'] ?>">
                                            <div class="box-img-functions">
                                                <div class="img-functions"><input type="radio" checked="checked" class="photo-main btn-photo-main" value="<?php echo explode('/', $info['picture'])[count(explode('/', $info['picture'])) - 1] ?>" name="photo_main" id="<?php echo explode('/', $info['picture'])[count(explode('/', $info['picture'])) - 1] ?>" /><label class="photo-main" for="<?php echo explode('/', $info['picture'])[count(explode('/', $info['picture'])) - 1] ?>">Foto Principal</label></div>
                                                <div class='img-functions' style='float: right'><a href="#" class='btn btn-excluir-foto btn-block' style='color: #d43f3a' data-toggle='popover' title='Remover foto' data-img='<?php echo explode('/', $info['picture'])[count(explode('/', $info['picture'])) - 1] ?>'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
                                            </div>
                                            <img src="<?php echo $info['picture'] ?>" class="img-responsive img-align-center" style="margin-top: -36px" />
                                        </li>
                                        <?php
                                    endif;
                                    if (isset($info['pictures'])):
                                        foreach ($info['pictures'] as $key => $picture):
                                            ?>
                                            <li data-thumb="<?php echo $picture['href'] ?>">
                                                <div class="box-img-functions">
                                                    <div class="img-functions"><input type="radio" checked="checked" class="photo-main btn-photo-main" value="<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] ?>" name="photo_main" id="<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] ?>" /><label class="photo-main" for="<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] ?>">Foto Principal</label></div>
                                                    <div class='img-functions' style='float: right'><a href="#" class='btn btn-excluir-foto btn-block' style='color: #d43f3a' data-toggle='popover' title='Remover foto' data-img='<?php echo explode("/", $picture['href'])[count(explode("/", $picture['href'])) - 1] ?>'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
                                                </div>
                                                <img src="<?php echo $picture['href'] ?>" class="img-responsive img-align-center" style="margin-top: -36px" />
                                            </li>
                                            <?php
                                        endforeach;
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
                <div class="form-group">
                    <div class="bg-info" style="padding: 5px">
                        Se a galeria não estiver exibindo as imagens <button class="btn btn-primary btn-reconfigure-gallery">clique aqui</button> para reconfigurar.
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <button type="button" data-proxima=".preco" data-atual=".fotos" value="Salvar" class="btn btn-danger btn-prev">Anterior</button>
                        <button type="button" data-proxima=".localizacao" data-atual=".fotos" value="Salvar" class="btn btn-primary btn-next">Próxima</button>
                    </div>
                </div>
            </div>

            <div class="localizacao tabcontent">
                <div class="form-group">  
                    <label for="">CEP(Somente números)</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="zipcode" id="zipcode" class="form-control required" value="<?php echo $info['zipcode']; ?>" />  
                </div>
                <div class="form-group">  
                    <label for="">Endereço</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="street" id="street" class="form-control required" value="<?php echo $info['street']; ?>" />  
                </div>
                <div class="form-group">  
                    <label for="">Numero</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="number" id="number" class="form-control required" value="<?php echo $info['number']; ?>" />  
                </div>
                <div class="form-group">  
                    <label for="">Estado</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="state" id="state" class="form-control required" value="<?php echo $info['state']; ?>" />  
                </div>
                <div class="form-group">  
                    <label for="">Cidade</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="city" id="city" class="form-control required" value="<?php echo $info['city']; ?>" />  
                </div>
                <div class="form-group">  
                    <label for="">Bairro</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="neighborhood" id="neighborhood" class="form-control required" value="<?php echo $info['neighborhood']; ?>" />  
                </div>
                <div class="form-group">
                    <div class="">
                        <button type="button" data-proxima=".fotos" data-atual=".localizacao" value="Salvar" class="btn btn-danger btn-prev">Anterior</button>
                        <button type="button" data-proxima=".sobre" data-atual=".localizacao" value="Salvar" class="btn btn-primary btn-next">Próxima</button>
                        <!--<button type="button" value="Salvar" data-proxima=".salvar" data-atual=".localizacao" data-label="Salvar" id="finalizarCadastro" class="btn btn-primary btn-next ">Salvar</button>-->
                    </div>
                </div>
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
            </div>
            <div class="sobre tabcontent">
                <?php
                if (isset($info['menu'])) {
                    foreach ($info['menu'] as $menu):
                        ?>
                        <div class="form-group">
                            <div><label for="<?php echo $menu->event_value_id ?>"><?php echo $menu->name ?></label></div>
                            <span class='error'>Campo Obrigatório</span>
                            <input type="text" name="<?php echo $menu->event_value_id ?>" id="<?php echo $menu->event_value_id ?>" class="form-control" value="<?php echo $menu->info_value ?>" />
                        </div>
                        <?php
                    endforeach;
                }
                ?>
                <button type="button" data-proxima=".localizacao" data-atual=".sobre" value="Salvar" class="btn btn-danger btn-prev">Anterior</button>
                <!--<button type="button" data-label="Salvar" value="Salvar" id="finalizarCadastro" class="btn btn-primary btn-finalizar">Atualizar</button>-->
                <button type="button" value="Salvar" data-proxima=".salvar" data-atual=".sobre" data-label="Salvar" id="finalizarCadastro" class="btn btn-primary btn-next ">Salvar</button>
            </div>
            <div class="area-loading">
                <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Aguarde...
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
<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/footer.php'); ?>