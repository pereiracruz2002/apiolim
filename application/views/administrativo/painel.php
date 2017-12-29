<?php include_once(dirname(__FILE__).'/header.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
<script src="<?php echo base_url() ?>administrativo-assets/js/palette.js"></script>
<input type="hidden" value="<?php echo $token ?>" id="token" />
<div class="panel panel-primary">
    <div class="panel-heading">Estatísticas de Eventos</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4 col-md-6 col-lg-3">
                <div class="well-sm bg-danger">
                    <span class="text-muted pull-right icon d4ficon-14 hidden-xs"></span>
                    <h1><?php echo ceil($avg_num_users) ?></h1>
                    <p>Média de limite de convidados</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-6 col-lg-3">
                <div class="well-sm bg-warning">
                    <span class="text-muted pull-right icon fa fa-share hidden-xs"></span>
                    <h1><?php echo round($avg_invites)?></h1>
                    <p>Média de convites enviados</p>
                </div>
            </div>

            <div class="col-sm-4 col-md-6 col-lg-3">
                <div class="well-sm bg-success">
                    <span class="text-muted pull-right icon fa fa-check hidden-xs"></span>
                    <h1><?php echo round($avg_events_users_confirmed)?></h1>
                    <p>Média de convidados confirmados</p>
                </div>
            </div>

            <div class="col-sm-4 col-md-6 col-lg-3">
                <div class="well-sm bg-success">
                    <span class="text-muted pull-right icon fa fa-usd hidden-xs"></span>
                    <h1><span class="h4">R$</span><?php echo number_format($avg_payments, 2, ',','.')?></h1>
                    <p>Valor médio dos eventos por convidado</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="panel panel-success">
        <div class="panel-heading">Cadastros</div>
        <div class="panel-body" style="position: relative; height:60vh; width:80vw">
            <div class="col-sm-12">
                <div class="col-sm-3">
                    <label>Tipo de filtro</label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-3">
                    <select name="filter-type-cadastro" class="form-control">
                        <option>Anual</option>
                        <option>Mensal</option>
                    </select>
                </div>
                <div class="col-sm-3 hide div-filter-month-cadastro">
                    <input type="text" name="filter-month-cadastro" class="form-control" value="<?php echo date("m/Y") ?>" />
                </div>
                <div class="col-sm-2">
                    <button name="btn-filter-month-cadastro" class="btn btn-primary" data-label="filtrar"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar</button>
                </div>
            </div>
            <canvas id="cadastros_chart"></canvas>
            <script>
                var cadastros_chart = document.getElementById("cadastros_chart");
                var graph_colors = palette('tol', <?php echo count($users_register) ?>);
                var cadastros_datasets = [];
                <?php $i=0; foreach ($users_register as $userType => $item): ?>
                    cadastros_datasets.push({
                        data: <?php echo json_encode(array_values($item), JSON_OBJECT_AS_ARRAY); ?>,
                        borderColor: '#'+graph_colors[<?php echo $i ?>],
                        label: '<?php echo $userType ?>'
                    });
                <?php $i++; endforeach;?>
                var myLineChart = new Chart(cadastros_chart, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode(array_keys(end($users_register)), JSON_OBJECT_AS_ARRAY) ?>,
                        datasets: cadastros_datasets
                    },
                    options:{
                        maintainAspectRatio: false
                    }
                });
            </script>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-success">
            <div class="panel-heading">Ranking</div>
            <div class="panel-body">
                <div class="col-sm-6" id="eventos-criados">
                    <table class="table table-stripped table-bordered">
                        <caption>Chefs</caption>
                        <thead>
                            <tr>
                                <th>Chef</th>
                                <th>Qtd. Eventos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ranking_chef_eventos as $item): ?>
                            <tr>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->total ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>  
                </div> <!--/eventos-criados-->
                <div class="col-sm-6" id="convidados">
                    <table class="table table-stripped table-bordered">
                        <caption>Participações</caption>
                        <thead>
                            <tr>
                                <th>Convidado</th>
                                <th>Qtd. Eventos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ranking_convidados_eventos as $item): ?>
                            <tr>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->total ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>  
                </div> <!--/convidado-->        
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Eventos Privados</div>
            <div class="panel-body">
                <div id="categorias">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo de Evento</th>
                                <th>Qtd. Eventos</th>
                                <th>Em Andamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ranking_privados as $item): ?>
                            <tr>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->total ?></td>
                                <td><?php echo $item->em_andamento ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>  
                </div> <!--/categorias-->

                <div id="cities">
                    <?php foreach ($ranking_privados_cidades as $tipo_evento): ?>
                        <table class="table table-stripped table-bordered">
                            <caption><?php echo $tipo_evento['tipo'] ?></caption>
                            <thead>
                                <tr>
                                    <th>Cidade</th>
                                    <th>Qtd. Eventos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tipo_evento['cidades'] as $cidade => $total): ?>
                                <tr>
                                    <td><?php echo $cidade ?></td>
                                    <td><?php echo $total ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>  
                    <?php endforeach; ?>
                </div> <!--/categorias-->
            </div>
        </div>

        <div class="panel panel-danger">
            <div class="panel-heading">Eventos Públicos</div>
            <div class="panel-body">
                <div id="categorias">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>Tipo de Evento</th>
                                <th>Qtd. Eventos</th>
                                <th>Em Andamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ranking_publicos as $item): ?>
                            <tr>
                                <td><?php echo $item->name ?></td>
                                <td><?php echo $item->total ?></td>
                                <td><?php echo $item->em_andamento ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>  
                </div> <!--/categorias-->

                <div id="cities">
                    <?php foreach ($ranking_publicos_cidades as $tipo_evento): ?>
                        <table class="table table-stripped table-bordered">
                            <caption><?php echo $tipo_evento['tipo'] ?></caption>
                            <thead>
                                <tr>
                                    <th>Cidade</th>
                                    <th>Qtd. Eventos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tipo_evento['cidades'] as $cidade => $total): ?>
                                <tr>
                                    <td><?php echo $cidade ?></td>
                                    <td><?php echo $total ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>  
                    <?php endforeach; ?>
                </div> <!--/categorias-->
            </div>
        </div>

    </div>
    <div class="col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading">Sexo - Chefs</div>
            <div class="panel-body">
                <div id="categorias">
                    <canvas id="sexo_chart_chefs"></canvas>
                    <script>
                        var sexo_chart = document.getElementById("sexo_chart_chefs");
                        var data_sexo = <?php echo json_encode(array_values($users_sexo['chef']), JSON_OBJECT_AS_ARRAY) ?>;
                        var myPieChart = new Chart(sexo_chart, {
                            type: 'doughnut',
                            data: {
                                labels: <?php echo json_encode(array_keys($users_sexo['chef']), JSON_OBJECT_AS_ARRAY) ?>,
                                datasets:[{
                                    data: data_sexo,
                                    backgroundColor: palette('tol', data_sexo.length).map(function(hex) {
                                        return '#' + hex;
                                    })
                                }],
                            },
                        });
                    </script>
                </div> <!--/categorias-->
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">Sexo - Convidados</div>
            <div class="panel-body">
                <div id="categorias">
                    <canvas id="sexo_chart_guests"></canvas>
                    <script>
                        var sexo_chart = document.getElementById("sexo_chart_guests");
                        var data_sexo = <?php echo json_encode(array_values($users_sexo['guest']), JSON_OBJECT_AS_ARRAY) ?>;
                        var myPieChart = new Chart(sexo_chart, {
                            type: 'doughnut',
                            data: {
                                labels: <?php echo json_encode(array_keys($users_sexo['guest']), JSON_OBJECT_AS_ARRAY) ?>,
                                datasets:[{
                                    data: data_sexo,
                                    backgroundColor: palette('tol', data_sexo.length).map(function(hex) {
                                        return '#' + hex;
                                    })
                                }],
                            },
                        });
                    </script>
                </div> <!--/categorias-->
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Categorias</div>
            <div class="panel-body">
                <div id="categorias">
                    <canvas id="categorias_chart"></canvas>

                    <script>
                        var categorias_chart = document.getElementById("categorias_chart");
                        var data_categorias = <?php echo json_encode(array_values($ranking_categorias), JSON_OBJECT_AS_ARRAY) ?>;
                        var myPieChart = new Chart(categorias_chart, {
                            type: 'pie',
                            data: {
                                labels: <?php echo json_encode(array_keys($ranking_categorias), JSON_OBJECT_AS_ARRAY) ?>,
                                datasets:[{
                                    data: data_categorias,
                                    backgroundColor: palette('tol', data_categorias.length).map(function(hex) {
                                        return '#' + hex;
                                    })
                                }],
                            },
                        });
                    </script>
                </div> <!--/categorias-->
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Cidades - Eventos privados</div>
            <div class="panel-body">
                <div id="categorias">
                    <canvas id="cidades_chart_privados"></canvas>

                    <script>
                        var cidades_chart = document.getElementById("cidades_chart_privados");
                        var data_cidades = <?php echo json_encode(array_values($ranking_cidades['privados']), JSON_OBJECT_AS_ARRAY) ?>;
                        var myPieChart = new Chart(cidades_chart, {
                            type: 'polarArea',
                            data: {
                                labels: <?php echo json_encode(array_keys($ranking_cidades['privados']), JSON_OBJECT_AS_ARRAY) ?>,
                                datasets:[{
                                    data: data_cidades,
                                    backgroundColor: palette('tol', data_cidades.length).map(function(hex) {
                                        return '#' + hex;
                                    })
                                }],
                            },
                        });
                    </script>
                </div> <!--/categorias-->
            </div>
        </div>
        
        <div class="panel panel-primary">
            <div class="panel-heading">Cidades - Eventos públicos</div>
            <div class="panel-body">
                <div id="categorias">
                    <canvas id="cidades_chart_publicos"></canvas>
                    <script>
                        var cidades_chart = document.getElementById("cidades_chart_publicos");
                        var data_cidades = <?php echo json_encode(array_values($ranking_cidades['publicos']), JSON_OBJECT_AS_ARRAY) ?>;
                        var myPieChart = new Chart(cidades_chart, {
                            type: 'polarArea',
                            data: {
                                labels: <?php echo json_encode(array_keys($ranking_cidades['publicos']), JSON_OBJECT_AS_ARRAY) ?>,
                                datasets:[{
                                    data: data_cidades,
                                    backgroundColor: palette('tol', data_cidades.length).map(function(hex) {
                                        return '#' + hex;
                                    })
                                }],
                            },
                        });
                    </script>
                </div> <!--/categorias-->
            </div>
        </div>
    </div>
</div>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
