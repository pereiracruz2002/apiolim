<?php include_once(dirname(__FILE__).'/header.php'); ?>
<h2 >Solitação à chefes</h2>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped small">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody id="containerListagem">
                <?php if($listagem->num_rows() == 0): ?>
                    <tr>
                        <td cols="3">Nenhuma solicitação no momento</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($listagem->result() as $item): ?>
                        <tr>
                            <td class="name"><?php echo $item->name; ?> <?php echo $item->lastname ?></td>
                            <td class="email"><?php echo $item->email; ?></td>
                            <td class="acoes">
                                <a href="<?php echo SITE_URL."administrativo/solicitacoes/perfil/".$item->user_id; ?>" class="btn btn-xs btn-primary" ><i class="fa fa-pencil"></i> Ver perfil</a>
                                <?php /*<button value="aceitar" data-user="<?php echo $item->user_id; ?>" class="btn btn-xs btn-success btn-solicitacao" ><i class="fa fa-pencil"></i> Aceitar</button>
                                <button value="recusar" data-user="<?php echo $item->user_id; ?>" class="btn btn-xs btn-warning btn-solicitacao" ><i class="fa fa-pencil"></i> Recusar</button> */ ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /*
<script>
    $(document).ready(function($) {
        $("body").on("click",".btn-solicitacao",function(e){
            $(this).attr("disabled", "disabled");
            $(this).text("aguarde");
            var resposta = $(this).val();
            var user = $(this).attr('data-user');
            var url = $("#site").val()+"api/usuario/confirmaChefe";

            jQuery.ajax({
                'url': url,
                type: 'POST',
                dataType: 'json',
                data: {"resposta": resposta,"user_id":user},
                complete: function(xhr, textStatus) {
                  //called when complete
                },
                success: function(data, textStatus, xhr) {
                    $("#solicitacoes_badge").text(data.listagem.length);
                    if(data.listagem.length == 0){
                        var tr = "<tr>";
                        tr+="<td cols='3'>Nenhuma solicitação no momento</td>";
                        tr+="</tr>";
                        $("#containerListagem").html(tr);
                    }else{
                        $("#containerListagem").html('');
                        for(user in data.listagem){
                            var tr = "<tr>";
                            tr+="<td class='name'>"+data.listagem[user].name+"</td>";
                            tr+="<td class='email'>"+data.listagem[user].email+"</td>";
                            tr+="<td class='acoes'>";
                            tr+="<button value='aceitar' data-user='"+data.listagem[user].user_id+"' class='btn btn-xs btn-info btn btn-success btn-solicitacao' ><i class='fa fa-pencil'></i> Aceitar</button>";
                            tr+="<button value='recusar' data-user='"+data.listagem[user].user_id+"' class='btn btn-xs btn-info btn btn-warning btn-solicitacao' ><i class='fa fa-pencil'></i> Recusar</button>";
                            tr+="</td>";
                            tr+="</tr>";
                            $("#containerListagem").append(tr);
                        }
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  //called when there is an error
                }
            });
        });
    });
</script>
*/ ?>

<?php include_once(dirname(__FILE__).'/footer.php'); ?>
