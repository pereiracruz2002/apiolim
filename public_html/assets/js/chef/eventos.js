

$(document).ready(function () {

    var list_all_friends = $(".resultado-busca").html();

    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show');
    })

    $(".busca input").on('focus blur', function () {
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
    });

    $(".filter_list input").on('keyup', function () {
        var val = $(this).val();
        $(".row-desc-friends").find(".friend-name").each(function () {
            var friend = $(this).text();
            if (friend.toLowerCase().indexOf(val.toLowerCase()) < 0) {
                console.log($(this).parent().parent().parent().parent().hide());
            } else {
                console.log($(this).parent().parent().parent().parent().show());
            }
        });
    });

    var date = new Date();
    $('input[name=date]').datepicker({
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
    $('input[name=end_subscription]').datepicker({
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

    // $('body').on('click','#pagseguro_pgto',function(e){
    //     e.preventDefault(); 
    //     var dadosFormData = {
    //         'itemDescription1': $("[name=itemDescription1]").val(),
    //         'itemQuantity1': $("[name=itemQuantity1]").val(),
    //         'itemId1': $("[name=itemId1]").val(),
    //         'itemWeight1': $("[name=itemWeight1]").val(),
    //         'itemAmount1':$("[name=itemAmount1]").val(),
    //         'senderName': $("[name=senderName]").val(),
    //         'senderEmail': $("[name=senderEmail]").val(),
    //         'reference': $("[name=referencia]").val()
    //         };
    //     $.post(BASEURL + "chef/evento/pagamento",dadosFormData,function(data){
    //         $('#code').val(data);
    //         $('#comprar').submit();
    //     })
    // })

    $('body').on('change', '#free_invitation', function (e) {
        if($('input[name=free_invitation]:checked').val() == "sim"){
            $('#price').attr('disabled','disabled');
            $(".row_warnig_free").show();
            $(".row_resume").hide();
            $("#btn_save_publish_event").attr("disabled","disabled");
        }else{
             $('#price').removeAttr('disabled','disabled');
             $(".row_warnig_free").hide();
             $(".row_resume").show();
             $('#btn_save_publish_event').removeAttr('disabled','disabled');
        }
    });

    $("input[name=price]").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $("input[name=price]").change(function () {
        calc_rate();
        calc_total();
        $(".row_resume").show();
    });
    
    $("input[name=num_users]").change(function () {
        calc_total();
    });
    
    setTimeout(function () {
        if ($("input[name=price]").val() == "" || $("input[name=num_users]").val() == "")
            return;
        calc_rate();
        calc_total();
        $(".row_resume").show();
        if ($("input[name=free_invitation]:checked").val() == "sim"){
          $(".row_resume").hide(); 
          if($("#status_payment").text() == "Pago")
            $('#btn_save_publish_event').removeAttr('disabled');
          else
          $('#btn_save_publish_event').attr('disabled','disabled');
        }
    }, 1000);
    
    function calc_rate() {
        var value = parseFloat(($("input[name=price]").val()).replace('.','').replace(",", "."));
        var calc_service = (value * rate_service);
        var rate = parseFloat($('.rate_dinner').data('value'));
        var calc_dinner;

        if(rate > 0){
            if (value > 33.5) {
                calc_dinner = (value * rate_dinner);
            } else {
                calc_dinner = 5;
            }
        } else {
            calc_dinner = 0;
        }
        $(".resume-calc.value_person").text("R$ "+number_format(value, 2, ',', '.'));
        $(".resume-calc.rate_dinner").text("R$ "+number_format(calc_dinner, 2, ',','.'));
        $(".resume-calc.return_chef").text("R$ " + number_format((value - calc_dinner), 2, ',', '.'));
        $(".resume-calc.rate_service").text("R$ "+ number_format((value + calc_service), 2, ',', '.'));
    }
    
    function calc_total() {
        var value = parseFloat(($("input[name=price]").val()).replace(",", "."));
        var quant = parseInt($("input[name=num_users]").val());
        var calc_dinner;
        if (value > 33.5) {
            calc_dinner = (value * rate_dinner);
        } else {
            calc_dinner = 5;
        }
        
        $(".resume-calc.quant_invites").text(quant);

        console.log(value)
        if(value <= 0 ){
            $(".resume-calc.return_total_chef").text("R$ 0,00 ");
        }else{
             $(".resume-calc.return_total_chef").text("R$ " + (quant * (value - calc_dinner)).toFixed(2).replace(".", ","));  
        }
    }
});
