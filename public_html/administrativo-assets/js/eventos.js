var tabs = ['.calendario', '.anuncio', '.preco', '.fotos', '.localizacao', '.sobre'];
$(document).ready(function () {
    $('.error').hide();
    $('.tabcontent').fadeOut();
    $('.calendario.tabcontent').fadeIn();

    $(".tab a").click(function (e) {
        e.preventDefault();
    });

    $("button.btn-cancel-upload").click(function () {
        if (ajaxUploadFoto)
            ajaxUploadFoto.abort();
    });

    $("body").on('change', '#photo', function (e) {
        $(".message-upload").html("");
        var form_picture = new FormData();
        form_picture.append('image', e.target.files[0]);

        ajaxUploadFoto = $.ajax({
            url: site + "api/upload/image",
            type: "POST",
            data: form_picture,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                data = JSON.parse(data);
                if (data.error) {
                    $(".message-upload").html(data.error);
                    cleanAdjustPhoto();
                } else {
                    cropImage(data.upload_data.file_name);
                }
            }
        });
    });

    $("body").on('click', '.btn-excluir-foto', function (e) {
        e.preventDefault();

        var img = $(this).attr('data-img');
        $(this).parent("div").parent("div").parent("div").parent("div").parent("li").remove();

        for (foto in fotos) {
            if (fotos[foto].imagem == img) {
                delete fotos[foto];
                fotos.filter(Object);
            }
        }
        rebuildSlider();
        checkImageMain();
    });

    $("body").on('click', '.btn-photo-main', function (e) {
        var img = $(this).val();
        for (foto in fotos) {
            if (fotos[foto].imagem == img) {
                fotos[foto].principal = "sim";
            } else {
                fotos[foto].principal = "não";
            }
        }
    });

    $("#enviarCrop").on('click', function () {
        $("#enviarCrop").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw upload-spinner"></i>');
        var mc = $("#image_crop");
        mc.croppie('result', {
            type: 'base64',
            format: 'png'
        }).then(function (resp) {
            var img = $("input[name=formPhoto]").val();
            var dados = {img: resp, output: img};
            $.ajax({
                url: site + 'api/upload/base64_to_image',
                dataType: 'json',
                type: 'POST',
                data: dados,
                async: false,
                success: function (data) {
                    if (data.status == "ok") {
                        var newObj = {};
                        newObj.imagem = data.file_name;
                        newObj.href = data.file_name;

                        if (fotos.length == 0) {
                            newObj.principal = "sim";
                        } else {
                            newObj.principal = "não";
                        }
                        fotos.push(newObj);
                        gallery(newObj.imagem);
                        $("#photo").val("");

                        cleanAdjustPhoto();
                        $("#enviarCrop").html('Salvar');
                    }
                }, error: function (error) {
                    alert(error);
                }
            });
        });
    });

    $("button#cleanCrop").click(function () {
        cleanAdjustPhoto();
    });

    var ncupons = 0;
    $("button#add_cupom").on('click', function () {
        var cupom = $("#cupom_description").val();
        if (cupom == "") {
            $("#cupom_description").focus();
            return false;
        }

        ncupons += 1;
        var div_cupom = "<div class='box-cupom' data-id='" + ncupons + "'>";
        div_cupom += "<span class='desc_cupom'>" + cupom + "</span>";
        div_cupom += "<button class='btn btn-remove-cupom' data-id='" + ncupons + "'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>";
        div_cupom += "</div>";

        $("div.lista-cupom").append(div_cupom);
        $("#cupom_description").val("").focus();

        var obj = {};
        obj.id = ncupons;
        obj.cupom = cupom;
        cupons.push(obj);
    });

    $("body").on("click", ".btn-remove-cupom", function () {
        var cupom_id = $(this).attr("data-id");
        var element = $(this).parent();
        for (i in cupons) {
            if (cupons[i].id == cupom_id) {
                cupons.splice(i, 1);
                element.remove();
            }
        }
    });

    $(".btn-prev").on("click", function (e) {
        e.preventDefault();
        var proxima = $(this).attr('data-proxima');
        var atual = $(this).attr('data-atual');

        $(atual + ".tabcontent").hide();
        $(proxima + ".tabcontent").fadeIn();
    });

    $(".btn-next").on("click", function () {
        var proxima = $(this).attr('data-proxima');
        var atual = $(this).attr('data-atual');

        var validate = 0;

        for (i in tabs) {
            if (atual == tabs[i]) {
                $(tabs[i] + ".tabcontent input.required, " + tabs[i] + ".tabcontent select.required, " + tabs[i] + ".tabcontent textarea.required").each(function (index, element) {
                    if ($(this).val() == "") {
                        $(this).prev().show();
                        validate += 1;
                    } else {
                        $(this).prev().fadeOut();
                    }
                });
                if (validate == 0) {
                    $(".tab").addClass('disabled');
                    $(".tab" + proxima).removeClass('disabled');
                    $(".tabcontent").hide();
                    $(proxima + ".tabcontent").fadeIn();
                }
                break;
            }
        }
    });

    $(".btn-reconfigure-gallery").click(function () {
        rebuildSlider();
    });

    $("#zipcode").on('keyup', function () {
        var field = $(this);
        var type = field.val();
        $.post(site + "/api/cep", {cep: type}, function (data) {
            if (data !== null) {
                $("#street").val(data['logradouro'])
                $("#neighborhood").val(data['bairro'])
                $("#city").val(data['localidade'])
                $("#state").val(data['uf'])
            } else {
                $("#street").val("")
                $("#neighborhood").val("")
                $("#city").val("")
                $("#state").val("")
            }
        });
    });
    var date = new Date();
    $('input[name=datestart]').datepicker({
        format: "dd/mm/yyyy",
        startDate: "now",
        endDate: new Date(date.getFullYear() + 5, 12, 31),
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom right",
        monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekHeader: 'Sm'
                //days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"], daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"], daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"], months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"], monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], today: "Hoje", monthsTitle: "Meses", clear: "Limpar"
    });
    $('input[name=dateend]').datepicker({
        format: "dd/mm/yyyy",
        startDate: "now",
        endDate: new Date(date.getFullYear() + 5, 12, 31),
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom right",
        monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekHeader: 'Sm'
                //days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"], daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"], daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"], months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"], monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"], today: "Hoje", monthsTitle: "Meses", clear: "Limpar"
    });

    $("body").on('click', '[data-toggle=popover]', function (e) {
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
    
    $("ul#gallery_event li .box-img-functions .img-functions a").each(function (e) {
        console.log($(this));
        var img = $(this).attr("data-img");
        $(this).popover({
            trigger: 'manual',
            html: true,
            placement: 'bottom',
            title: 'Remover esta foto?',
            content: '<a class="btn btn-danger cancelar" href="#">Cancelar</a> <a class="btn btn-primary btn-excluir-foto" href="#" data-img="' + img + '">Remover</a>'
        });
    });
});

var slide = $("#gallery_event").lightSlider({
    gallery: true,
    formUpload: $(".form-upload").html(),
    item: 1,
    loop: true,
    thumbItem: 9,
    slideMargin: 0,
    enableDrag: true,
    currentPagerPosition: 'left',
    onSliderLoad: function () {}
});

function toogleSpinner() {
    $(".file-upload").toggleClass('hide');
    $(".upload-spinner").toggleClass('hide');
}

function gallery(img) {
    var li = "<li data-thumb='" + site + "uploads/" + img + "'>";
    li += "<div class='box-img-functions'>";
    li += "<div class='img-functions'><input type='radio' class='photo-main btn-photo-main' value='" + img + "' name='photo_main' id='" + img + "'/><label class='photo-main' for='" + img + "'>Foto principal</label></div>";
    li += "<div class='img-functions' style='float: right'><a href='#' class='btn btn-rm-photo' data-toggle='popover' title='Remover foto' style='color: #d43f3a' data-img='" + img + "' btn-block'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></div>"
    li += "</div>"
    li += "<img src='" + site + "uploads/" + img + "' class='img-responsive img-align-center' style='margin-top: -36px' />";
    li += "</li>";
    $("#gallery_event").append(li);
    $("[data-img='" + img + "']").popover({
        trigger: 'manual',
        html: true,
        placement: 'bottom',
        title: 'Remover esta foto?',
        content: '<a class="btn btn-danger cancelar" href="#">Cancelar</a> <a class="btn btn-primary btn-excluir-foto" href="#" data-img="' + img + '">Remover</a>'
    });
    rebuildSlider();
    checkImageMain();
}

function rebuildSlider() {
    slide.destroy();
    slide = $("#gallery_event").lightSlider({
        gallery: true,
        formUpload: $(".form-upload").html(),
        item: 1,
        loop: true,
        thumbItem: 9,
        slideMargin: 0,
        enableDrag: true,
        currentPagerPosition: 'left',
        onSliderLoad: function () {}
    });
}

function checkImageMain() {
    for (foto in fotos) {
        if (fotos[foto].principal == "sim") {
            $('body').find("input[name=photo_main]").each(function () {
                if (fotos[foto].imagem == $(this).val()) {
                    $(this).attr("checked", "checked");
                }
            });
        }
    }
}

function cleanAdjustPhoto() {
    $("#adjustPhoto").modal('toggle');
    $("#adjustPhoto .modal-dialog").width("600px");
    $(".area-img").parent().height("auto");
    $(".area-img").fadeOut().html("");
    $(".area-spinner").fadeIn();
}

function cropImage(img) {
    var area_image = "<img id='image_crop' src='" + site + "uploads/" + img + "' class='img-responsive img-align-center' />";
    $("#adjustPhoto .modal-dialog").width($(document).width() * 0.80);
    $(".area-img").parent().height($(window).height() * 0.70);
    $(".area-img").html(area_image).removeClass('hide').fadeIn();
    $(".area-img").append("<input type='hidden' value='" + img + "' name='formPhoto' />");
    $(".area-spinner").fadeOut();

    var mc = $("#image_crop");
    mc.croppie({
        viewport: {
            width: 800,
            height: 400,
        }, boundary: {
            width: ($(".area-img").parent().width() > 800) ? $(".area-img").parent().width() : 800,
            height: ($(".area-img").parent().height() > 400) ? $(".area-img").parent().height() * 0.93 : 400
        }, enforceBoundary: false
    });

    return false;
}