$('form').submit(function (e) {
    e.preventDefault();
});
$('.busca input').on('focus blur', function () {
    var elm = $(this);
    var form = elm.parent();
    if (elm.val() == '') {
        form.addClass('empty');
        elm.val('Procurar');
    } else {
        form.removeClass('empty');
        if (elm.val() == 'Procurar') {
            elm.val('');
        }
    }
})
$('.novos_amigos input').on('keyup', function () {
    var val = $(this).val();
    var resultado = $('.busca-amigos');
    if (val.length > 3) {
        resultado.html('<p class="text-center"><i class="fa fa-refresh fa-spin"></i></p>')
        $.post($(this).parent().attr('action'), {q: val}, function (data) {
            resultado.html(data);
        });
    } else {
        resultado.html('');
    }
});

$('.meus_amigos input').on('keyup', function () {
    var val = $(this).val();
    var result = $('.meus-amigos');
    result.html('<p class="text-center"><i class="fa fa-refresh fa-spin"></i></p>');
    $.post($(this).parent().attr('action'), {q: val}, function (data) {
        result.html(data);
    });
});

$('.nav-requests li a').on('click', function (e) {
    e.preventDefault();
    var elm = $(this);
    $('.nav-requests li').removeClass('active');
    elm.parent().addClass('active');
    $("#nav-requests-content .resultado-busca").hide();
    $(elm.attr('href')).show();
});

$('body').on('click', '#nav-requests-content .btn', function (e) {
    e.preventDefault();
    var elm = $(this);
    elm.addClass('disabled').html('<i class="fa fa-refresh fa-spin"></i>')
    var friend = elm.parents('li').clone();
    friend.find("div.col-sm-6").each(function () {
        $(this).removeClass("col-sm-6").addClass("col-sm-12");
    });
    var action = $(this).attr("data-id");
    friend.find('.col-add-friend').parent().remove();

    $.getJSON(elm.attr('href'), function (data) {
        elm.parents('li').fadeOut();
        if (action == 'accept') {
            var badge = $("#solicitacoes_badge").text();
            var nbadge = badge - 1;
            if (badge > 0)
                $(".solicitacoes_badge").text(nbadge);
            if (nbadge == 0)
                $(".solicitacoes_badge").addClass('hide');
            else
                $(".solicitacoes_badge").removeClass('hide');
            $("ul.lista-users.meus-amigos").append(friend);
            var total_friends = $(".total-friends span.h1").text();
            $(".total-friends span.h1").text(parseInt(total_friends) + 1);
            var person_stalker = $("h4.text-success span.pull-right").text();
            person_stalker = person_stalker.replace("(", "");
            person_stalker = person_stalker.replace(")", "");
            person_stalker = person_stalker.replace("0", "");
            $("h4.text-success span.pull-right").text("(" + ZerosLeft(parseInt(person_stalker) + 1) + ")");
        }
    });
})

function ZerosLeft(str)
{
    str = str.toString();
    while (str.length < 4) {
        str = "0" + str;
    }
    return str.toString();
}

$("#form_sendmail").on('submit', function (e) {
    e.preventDefault();
    $(".button_send_mail").html("<i class=\"fa fa-refresh fa-spin fa-fw\"></i>");
    $(".button_send_mail").addClass("disabled");
    $.post(BASEURL + "api/usuario/convidaamigos", {email: $("#invite_email").val(), baseurl: BASEURL}, function (data) {
        if (data['status'] == "success")
        {
            $(".return_message").html("<p class=\"text-success\">" + data['msg'] + "</p>");
            $("#form_sendmail")[0].reset();
            $(".button_send_mail").removeClass("disabled");
            $(".button_send_mail").html("Enviar email");
        } else
        {
            $(".return_message").html("<p class=\"text-danger\">" + data['msg'] + "</p>");
            $(".button_send_mail").removeClass("disabled");
            $(".button_send_mail").html("Enviar email");
        }
    });
});

$(".messenger_function").on('click', function () {
//    $.post(BASEURL + "api/usuario/convidaamigosmessenger", function (data) {
//
//    });
    FB.ui({
        method: 'send',
        link: BASEURL + "download",
    });
});

$("body").on('click', '.btn-friendship', function (e) {
    e.preventDefault();
    var obj = $(this);
    var href = obj.attr('href');
    var friend = $(this).parents('li').clone();

    //obj.addClass('disabled').fadeOut();
    $.getJSON(href, function (data) {
        if (data.status == "success") {
            $("#friends_pendding p.alert").fadeOut();
            obj.parent().html("<span class=\"padding bg-warning pull-right\">Solicitação enviada</span>");
            friend.find(".col-add-friend").each(function () {
                $(this).html('<a href="/chef/amigos/cancelarSolicitacao/' + data.id + '" class="btn btn-danger btn-sm pull-right">Cancelar</a>');
            });
            $("#friends_pendding .lista-users").append(friend);
        } else {
            obj.parent().html("<span class=\"padding bg-danger pull-right\">Erro</span>");
        }
    });
});