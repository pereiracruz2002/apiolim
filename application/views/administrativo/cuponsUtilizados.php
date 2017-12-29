<?php include_once(dirname(__FILE__) . '/header.php'); ?>
<div id="main-container">
    <a href="<?php echo site_url('administrativo/eventosPublicos') ?>" class="btn btn-warning"><span class="fa fa-angle-left"></span> Voltar</a>
    <h3 class="headline m-top-md">Cupons Utilizados para o evento: <?php echo $evento->name ?></h3>

    <div class="row" style="margin: 10px 0px">
        <div class="col-sm-12">
            <div class="col-sm-2">Exibir cupons:</div>
            <div class="col-sm-10">
                <?php foreach ($cupons as $cupom): ?>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" name="filter_cupom" id="<?php echo $cupom->event_cupom_id ?>" value="<?php echo $cupom->event_cupom_id ?>" checked="checked" />
                            </span>
                            <label for="<?php echo $cupom->event_cupom_id ?>"><?php echo $cupom->cupom ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cupom</th>
                    <th>Utilizado em</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($descontos as $item): ?>
                    <tr class="cupom-<?php echo $item->event_cupom_id ?>">
                        <td><?php echo $item->nome ?></td>
                        <td><?php echo $item->email ?></td>
                        <td><?php echo $item->cupom ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($item->data)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>
<script>
    $(document).ready(function () {
        $("input[name=filter_cupom]").change(function (element) {
            $("input[name=filter_cupom").each(function () {
                if ($(this).is(":checked")) {
                    $("tr.cupom-" + $(this).val()).show();
                } else {
                    $("tr.cupom-" + $(this).val()).hide();
                }
            });
        });
    });
</script>