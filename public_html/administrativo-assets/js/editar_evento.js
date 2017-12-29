$(document).ready(function () {
    var validate = 0;
    $(".btn-next").on("click", function () {
        $(".text-danger").removeClass('text-danger');
        $(".has-error").removeClass('has-error');

        $(tabs[i] + ".tabcontent input.required, " + tabs[i] + ".tabcontent select.required, " + tabs[i] + ".tabcontent textarea.required").each(function (index, element) {
            if ($(this).val() == "") {
                validate += 1;
                $(this).prev().addClass('text-danger').fadeIn();
                $(this).parent("div").addClass('has-error');
            } else
                validate = 0;
        });
    });

    $("#finalizarCadastro").on("click", function () {
        var eventFormData = {};

        var field_datestart = $("[name=datestart]");
        var field_dateend = $("[name=dateend]");
        if (field_datestart.val() != "") {
            date_start = ((field_datestart.val()).split("/"))[2] + "-"
                    + ((field_datestart.val()).split("/"))[1] + "-"
                    + ((field_datestart.val()).split("/"))[0] + " "
                    + $("[name=timestart]").val();
        }
        if (field_dateend.get(0)) {
            if (field_dateend.val() != "") {
                date_end = ((field_dateend.val()).split("/"))[2] + "-"
                        + ((field_dateend.val()).split("/"))[1] + "-"
                        + ((field_dateend.val()).split("/"))[0] + " "
                        + $("[name=timeend]").val();
            }
        } else {
            if (field_datestart.val() != "") {
                date_end = ((field_datestart.val()).split("/"))[2] + "-"
                        + ((field_datestart.val()).split("/"))[1] + "-"
                        + ((field_datestart.val()).split("/"))[0] + " "
                        + $("[name=timeend]").val();
            }
        }

        eventFormData.event_id = event_id;
        eventFormData.start = date_start;
        eventFormData.end = date_end;

        var inputs = ['name', 'event_type_id', 'description', 'status', 'zipcode', 'street', 'number', 'state', 'city', 'neighborhood'];
        for (i in inputs) {
            if ($("[name=" + inputs[i] + "]").val() == "")
                validate++;
            eventFormData[inputs[i]] = $("[name=" + inputs[i] + "]").val();
        }
        var send_cupons = [];
        for (i in cupons) {
            send_cupons.push(cupons[i].cupom);
        }
        for (i in fotos) {
            if (fotos[i].principal == "sim") {
                eventFormData.picture = fotos[i].imagem;
                break;
            }
        }
        fotos.filter(Array);
        eventFormData.fotos = fotos;
        eventFormData.private = event_private;
        eventFormData.fotos_save = fotos_saved;
        eventFormData.cupons = send_cupons;
        eventFormData.cupons_save = cupons_saved;
        eventFormData.user_id = $("#token").val();
        eventFormData.edit_admin = true;

        var eventInfo = {};
        $(".sobre input").each(function () {
            var id = $(this).attr("name");
            var val = $(this).val();
            eventInfo[id] = val;
        });
        eventFormData.fields = eventInfo;

        if (validate == 0) {
            $(".error").fadeOut();
            $(".area-loading").fadeIn();
            $.ajax({
                url: site + 'api/evento/novo/',
                type: 'POST',
                dataType: 'json',
                data: eventFormData,
                complete: function (xhr, textStatus) {},
                success: function (data, textStatus, xhr) {
                    if (eventFormData.private == 0)
                        location.href = "/administrativo/eventosPublicos";
                    else if (eventFormData.private == 1)
                        location.href = "/administrativo/eventosPrivados";
                },
                error: function () {
                    $(".area-loading").fadeOut();
                    alert(xhr);
                }
            });
        }
    });
});
