<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
<div id="main-container">
    <div class="col-md-12">	
        <h3 class="headline m-top-md"><?= ucfirst("Cadastro de Evento") ?><span class="line"></span></h3>
        <ul class="nav nav-tabs">
            <li role="presentation" class="tab calendario"><a href=".calendario">CALENDÁRIO</a></li>
            <li role="presentation" class="tab anuncio "><a href=".anuncio">ANUNCIO</a></li>
            <li role="presentation" class="tab preco "><a href=".preco">CUPONS</a></li>
            <li role="presentation" class="tab fotos"><a href=".fotos">FOTOS</a></li>
            <li role="presentation" class="tab localizacao "><a href=".localizacao">LOCALIZAÇÃO</a></li>
            <!--<li role="presentation" class="tab sobre disabled"><a href=".sobre">MENU</a></li>-->
        </ul>

        <div class="panel-body">
            <div class="calendario tabcontent">
                <div class="form-group">
                    <label for="">Data início</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="datestart" id="datestart" class="form-control required">
                </div>
                <div class="form-group">
                    <label for="">Data término</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="dateend" id="dateend" class="form-control required">
                </div>
                <div class="form-group">
                    <label for="">Hora início</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="time" name="timestart" id="timestart" class="form-control required">
                </div>
                <div class="form-group">
                    <label for="">Hora término</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="time" name="timeend" id="timeend" class="form-control required">
                </div>
                <!--<div class="form-group">
                    <label for="">Fim Participação</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="date" name="end_subscription" id="end_subscription" class="form-control">
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
                    <input type="text" name="name" class="form-control required" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Tipo de evento</label>
                    <div class="error">Campo Obrigatório</div>
                    <select class="form-control required" name="event_type_id">
                        <option value="">Escolha uma opção</option>
                        <?php foreach ($event_type as $type): ?>
                            <option value="<?php echo $type->event_type_id ?>"><?php echo $type->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Descrição</label>
                    <div class="error">Campo Obrigatório</div>
                    <textarea name="description" id="description" class="form-control required" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <div class="error">Campo Obrigatório</div>
                    <select name="status" class="form-control required">
                        <option value="">Escolha uma opção</option>
                        <option value="enable">Ativo</option>
                        <option value="disable">Inativo</option>
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
                <?php /* <div class="row-preco">
                  <div class="form-group">
                  <label for="">Preço</label>
                  <div class="error">Campo Obrigatório</div>
                  <input type="text" name="price" class="form-control currency" placeholder="R$">
                  </div>
                  <div class="form-group">
                  <label for="">Taxa</label>
                  <input type="text" name="rate" id="rate" class="form-control currency">
                  </div>
                  <!--<div class="form-group">
                  <label for="">Número de convidados</label>
                  <div class="error">Campo Obrigatório</div>
                  <input type="text" name="num_users" class="form-control" placeholder="">
                  </div>
                  <div class="form-group">
                  <label for="">Número de Acompanhantes por convidado</label>
                  <div class="error">Campo Obrigatório</div>
                  <input type="text" name="invite_limit" class="form-control" placeholder="">
                  </div>-->
                  </div> */ ?>
                <div class="row-cupom">
                    <div class="row">
                        <div class="form-group">
                            <label for="">Cupom</label>
                            <!--<div class="error">Campo Obrigatório</div>-->
                            <input type="text" name="cupom_description" id="cupom_description" class="form-control" placeholder="Descreva o detalhe do cupom" />
                        </div>
                        <div class="form-group">
                            <button type="button" name="add_cupom" id="add_cupom" class="btn btn-default btn-add-cupom" style="color: #4cae4c;">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add cupom
                            </button>
                        </div>
                    </div>
                    <div class="row lista-cupom"></div>
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
                            <div class="gallery" class="clearfix" style="max-width:100%;">
                                <ul id="gallery_event" class="gallery list-unstyled"></ul>
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
                    <input type="text" name="zipcode" id="zipcode" class="form-control required">  
                </div>
                <div class="form-group">  
                    <label for="">Endereço</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="street" id="street" class="form-control required">  
                </div>
                <div class="form-group">  
                    <label for="">Numero</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="number" id="number" class="form-control required">  
                </div>
                <div class="form-group">  
                    <label for="">Estado</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="state" id="state" class="form-control required">  
                </div>
                <div class="form-group">  
                    <label for="">Cidade</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="city" id="city" class="form-control required">  
                </div>
                <div class="form-group">  
                    <label for="">Bairro</label>
                    <div class="error">Campo Obrigatório</div>
                    <input type="text" name="neighborhood" id="neighborhood" class="form-control required">  
                </div>
                <div class="form-group">
                    <div class="">
                        <button type="button" data-proxima=".fotos" data-atual=".localizacao" value="Salvar" class="btn btn-danger btn-prev">Anterior</button>
                        <!--<button type="button" data-proxima=".sobre" data-atual=".localizacao" value="Salvar" class="btn btn-primary btn-next">Próxima</button>-->
                        <button type="button" value="Salvar" data-proxima=".salvar" data-atual=".localizacao" data-label="Salvar" id="finalizarCadastro" class="btn btn-primary btn-next ">Cadastrar</button>
                    </div>
                </div>
                <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
            </div>
            <?php
            /* <div class="sobre tabcontent">
              $url = SITE_URL . "api/evento/getInfoTipoEventos";
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HEADER, false);
              //curl_setopt( $ch, CURLOPT_POST, true );
              //curl_setopt( $ch, CURLOPT_POSTFIELDS, $postfields );
              $inforesult = json_decode(curl_exec($ch));
              $infoDados = $inforesult->html;
              curl_close($ch);

              foreach ($infoDados as $info) {
              if ($info->field_type == 'text') {
              echo "
              <div class='form-group'>
              <div><label>" . $info->name . "</label></div>
              <span class='error'>Campo Obrigatório</span>
              <input type='text' name='" . $info->namefields . "' id='" . $info->namefields . "' class='form-control'>
              </div>
              ";
              }
              if ($info->field_type == 'radio') {
              $values = explode(",", $info->field_values);
              echo "<div><label for='exampleInputName2'>" . $info->name . "</label>";
              echo "<div class='error'>Campo Obrigatório</div>";
              foreach ($values as $item) {
              echo "<div class='radio'>";
              echo "<label><input type='radio' value='" . $item . "' name='" . $info->namefields . "'>" . $item . "</label>";
              echo "</div>";
              }
              echo "</div>";
              }
              }
              <button type="button" data-proxima=".localizacao" data-atual=".sobre" value="Salvar" class="btn btn-danger btn-next">Anterior</button>
              <button type="button" value="Salvar" data-label="Salvar" id="finalizarCadastro" class="btn btn-primary btn-finalizar">Cadastrar</button>
              </div> */
            ?>
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

<script>
    var fotos = [];
    var cupons = [];

    /*var eventPrivate = [];
     var eventPublic = [];
     var newobjt = {};*/
<?php /* foreach ($categorias as $categoria): ?>
  <?php if ($categoria->private == 1): ?>
  newobjt.name = "<?php echo $categoria->name ?>";
  newobjt.event_type_id = "<?php echo $categoria->event_type_id ?>";
  eventPrivate.push(newobjt);
  newobjt = {};
  <?php elseif ($categoria->private == 0): ?>
  newobjt.name = "<?php echo $categoria->name ?>";
  newobjt.event_type_id = "<?php echo $categoria->event_type_id ?>";
  eventPublic.push(newobjt);
  newobjt = {};
  <?php endif; ?>
  <?php endforeach; */ ?>
</script>
<?php
if (!$this->input->is_ajax_request())
    include_once(dirname(__FILE__) . '/footer.php');
?>
