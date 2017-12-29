<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/../header.php'); ?>
<div class="row">
    <div class="panel-heading">
        <h2><?php echo ucfirst($titulo) ?> 
            <?php if (in_array('C', $crud)): ?>
                <a href="<?php echo $url ?>/novo" class="btn btn-primary"><span>Novo</span></a>
            <?php endif ?>
        </h2>

        <?php if (isset($crud)): ?>
            <?php if (isset($acoes_controller)): ?>
                <?php foreach ($acoes_controller as $acao_extra): ?>
                    <a href="<?= site_url($acao_extra['url']); ?>" title="<?= $acao_extra['title']; ?>" class="btn <?php echo $acao_extra['class']; ?> btn-sm">
                        <?php if(isset($acao_extra['icon'])):?>
                            <span class="<?=$acao_extra['icon']?>"> </span>
                        <?php endif;?>
                    <?php echo $acao_extra['title']; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="panel-body">
        <?php $c->_call_pre_table(); ?>
        <?php if ($this->campos_busca): ?>
            <div class="well">
                <form method="post" class="form-inline filtro" action="<?php echo $url; ?>/listar">
                    <fieldset>
                        <legend>Buscar</legend>
                        <div class="input-group">
                            <input type="search" class="form-control" name="q" placeholder="Procurar por..." value="<?php echo $q ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Procurar!</button>
                            </span>
                        </div><!-- /input-group -->
                    </fieldset>
                </form>
            </div>
        <?php endif; ?>

        <?php if (!$itens): ?>
            <div class="alert alert-danger">Nenhum registro encontrado</div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-striped small">
                <thead>
                    <tr>
                        <?php foreach ($campos as $campo): ?>
                            <th scope="col"><?php echo $model->fields[$campo]['label'] ?></th>
                        <?php endforeach ?>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $row): ?>
                        <tr>
                            <?php foreach ($campos as $campo): ?>
                                <td class="<?php echo url_title($campo); ?>"><?php echo $row->{$campo} ?></td>
                            <?php endforeach ?>
                            <td class="acoes">
                                <?php if (in_array('P', $crud)): ?>
                                    <a class="btn btn-xs btn-info btn btn-info" href="<?php echo $url ?>/visualizar/<?php echo $row->{$model->id_col} ?>" title="Visulizar este registro" class="btn btn-mini btn-warning"><i class="fa fa-eye"></i> Ver</a>
                                <?php endif; ?>
                                <?php if (in_array('U', $crud)): ?>
                                    <a class="btn btn-xs btn-info btn btn-warning" href="<?php echo $url ?>/editar/<?= $row->{$model->id_col} ?>" title="Editar este registro" class="btn btn-mini btn-info"><i class="fa fa-pencil"></i> Editar</a>
                                <?php endif; ?>
                                <?php if (in_array('D', $crud)): ?>
                                    <a class="btn btn-xs btn btn-danger delete" href="#" data-remove="<?php echo $url ?>/deletar/<?php echo $row->{$model->id_col} ?>" title="Deletar este registro"><i class="fa fa-times-circle"></i> Deletar</a>
                                <?php endif ?>

                                <?php foreach ($acoes_extras as $acao_extra):

                                 ?>
                                    <a href="<?php echo site_url($acao_extra['url'] . "/" . $row->{$model->id_col}); ?>" class="btn btn-xs <?php echo $acao_extra['class']; ?>" <?php echo(isset($acao_extra['attr']) ? $acao_extra['attr'] : '') ?>><?php echo $acao_extra['title']; ?></a>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php $paginacao ?>
    </div><!--/panel-body-->
</div><!--/row-->
<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/../footer.php'); ?>
