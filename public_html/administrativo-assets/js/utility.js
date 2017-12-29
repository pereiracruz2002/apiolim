$('.fancybox').fancybox({'type': 'iframe'});

$(document).ready(function () {
    $.ajax({
        url: site_url + "api/usuario/getRequestChef",
        type: 'POST',
        dataType: 'json',
        data: {'data': 'get'},
        success: function (data, textStatus, xhr) {
            $("#solicitacoes_badge").text(data.listagem.length);
        }
    });

    $('.currency').maskMoney();
    $('.delete').popover({
        trigger: 'manual',
        html: true,
        placement: 'left',
        title: 'Remover esse registro?',
        content: '<a class="btn btn-danger cancelar" href="#">Cancelar</a> <a class="btn btn-primary confirmar_remover" href="#">Deletar</a>'
    }).on('click', function (e) {
        e.preventDefault();
        $(this).popover('toggle');
    });

    $('body').on('click', '.cancelar', function (e) {
        e.preventDefault();
        $('.remover, .remover_field, .remover_imagem').popover('hide');
        $(this).parents('.popover').fadeOut(function () {
            $(this).remove();
        });
    });

    $('body').on('click', '.confirmar_remover', function (e) {
        e.preventDefault();
        var tr = $(this).parents('tr:first');
        var href = $(this).parents('td:first').find('.delete').attr('data-remove');
        $.get(href, function (data) {
            if (data == 'ok')
                tr.fadeOut(function () {
                    $(this).remove();
                });
            else
                alert(data);
        });
    });
});

