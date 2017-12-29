<?php include_once(dirname(__FILE__) . '/header.php'); ?>

<div class="well well-sm bg-white well-title">
    <h5><strong>Eventos gastronômicos</strong></h5>
</div>
<div class="row">
    <div class="col-sm-4 text-strong">
        <div class="well well-sm bg-white">
            <div class="col-sm-4 h1 text-center text-purple"><?php echo (isset($eventos['publicados']))? count($eventos['publicados']) : "0" ?></div>
            <div class="col-sm-8">
                <h4 class="text-purple">Eventos gastronômicos</h4>
                <p class="text-success">publicados</p>
            </div> 
            <div class="clearfix"></div>
        </div>

        <div class="well well-sm bg-white">
            <div class="col-sm-4 text-center h3"><?php echo (isset($eventos['anteriores']))? count($eventos['anteriores']) : "0" ?></div>
            <div class="col-sm-8">
                <p>Eventos gastronômicos anteriores</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="well well-fixed bg-white text-strong">
            <p>Aqui você tem a relação dos eventos <span class="text-success">publicados</span> e anteriores.</p>
            <p>Você pode adicionar fotos e convidar mais amigos para os eventos em andamento e acessar as avalições dos convidados dos eventos que já aconteceram.</p>
        </div>
    </div>
</div>

<div class="well bg-white">
    <ul  class="nav nav-tabs nav-justified">
        <li class="salvos"><a  href="#salvos" data-toggle="tab">Salvos</a><div class="indicator-tab"></div></li>
        <li class="publicados active"><a href="#publicados" data-toggle="tab">Publicados (Ativos)</a><div class="indicator-tab"></div></li>
        <li class="anteriores"><a href="#anteriores" data-toggle="tab">Anteriores</a><div class="indicator-tab"></div></li>
    </ul>

    <div class="tab-content clearfix" style="margin: 20px 0px;">
        <div class="tab-pane" id="salvos">
        <?php if (isset($eventos['salvos']) && count($eventos['salvos'])): ?>
            <?php foreach ($eventos['salvos'] as $item): ?>
                <div class="col-sm-4 text-center">
                    <div class="thumbnail">
                        <a href="<?php echo site_url('chef/evento/editar/' . $item->event_id) ?>">
                            <div class="area-image-thumb" <?php if ($item->picture != "") echo "style=\"background: url('" . base_url() . "uploads/{$item->picture}') no-repeat center\""; ?>></div>
                        </a>
                        <div class="caption salvos">
                            <a href="<?php echo site_url('chef/evento/editar/' . $item->event_id) ?>"><?php echo $item->name ?> <?php echo formata_time($item->start); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <div class="tab-pane active" id="publicados">
        <?php if (isset($eventos['publicados']) && count($eventos['publicados'])): ?>
            <?php foreach ($eventos['publicados'] as $item): ?>
                <div class="col-sm-4 text-center">
                    <div class="thumbnail">
                        <a href="<?php echo site_url('chef/evento/editar/' . $item->event_id) ?>">
                            <div class="area-image-thumb" <?php if ($item->picture != "") echo "style=\"background: url('" . base_url() . "uploads/{$item->picture}') no-repeat center\""; ?>></div>
                        </a>
                        <div class="caption publicados">
                            <a href="<?php echo site_url('chef/evento/editar/' . $item->event_id) ?>"><?php echo $item->name ?> <?php echo formata_time($item->start); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <div class="tab-pane" id="anteriores">
        <?php if (isset($eventos['anteriores']) && count($eventos['anteriores'])): ?>
            <?php foreach ($eventos['anteriores'] as $item): ?>
                <div class="col-sm-4 text-center">
                    <div class="thumbnail">
                        <a href="<?php echo site_url('chef/evento/editar/' . $item->event_id) ?>">
                            <div class="area-image-thumb" <?php if ($item->picture != "") echo "style=\"background: url('" . base_url() . "uploads/{$item->picture}') no-repeat center\""; ?>></div>
                        </a>
                        <div class="caption anteriores">
                            <a href="<?php echo site_url('chef/evento/editar/' . $item->event_id) ?>"><?php echo $item->name ?> <?php echo formata_time($item->start); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <?php if (count($eventos) == 0): ?>
            <p class="text-center text-strong">Você não tem nenhum evento próximo até o momento.</p>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
<script>

</script>