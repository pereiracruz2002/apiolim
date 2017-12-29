(function ($) {
    var $slider = $('#image-gallery').lightSlider({
        gallery:true,
        item:1,
        thumbItem:9,
        slideMargin: 0,
        speed:500,
        auto:false,
        loop:true,
        pause:5000,
        onSliderLoad: function() {
            $('#image-gallery').removeClass('cS-hidden');
        }  
    });
    
    var state = $('[name=state]');
    var city = $('[name=city]');
    if (state.val() && city.val()) {
        new dgCidadesEstados({
            estado: $('[name=state]').get(0), 
            cidade: $('[name=city]').get(0),
            change: true
        });
    }

    $('.busca input').on('focus blur', function(){
        var elm = $(this);
        var form = elm.parent();
        if(elm.val() == ''){
            form.addClass('empty');
            elm.val('Procurar');
        } else {
            form.removeClass('empty');
            if(elm.val() == 'Procurar'){
                elm.val('');
            }
        }
    })

    $('.btn-trash').on('click', function(e){
        e.preventDefault();
        var elm = $(this);
        if(confirm('Você tem certeza que deseja remover essa foto?')){
            $.get(elm.attr('href'));
            elm.parent().fadeOut(function(){
                $(this).remove();
                $slider.refresh();
            });
        }
    })

    $('.convidar').on('click', function(e){
        e.preventDefault();
        var elm = $(this);
        elm.addClass('disabled').html('<i class="fa fa-refresh fa-spin"></i>');
        $.getJSON(elm.attr('href'), function(data){
            if(data.status == 'success'){
                elm.removeClass('btn-success').addClass('btn-warning').html('Convite enviado');
            } else {
                alert(data.msg);
                elm.removeClass('disabled').html('Convidar');
            }
        });
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

}(jQuery));
