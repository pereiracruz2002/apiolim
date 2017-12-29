$('.fbLogin').on('click', function(e){
    e.preventDefault();
    var elm = $(this);
    var elm_val = elm.val();
    elm.html('<span class="fa fa-refresh fa-spin"></span>')
    FB.login(function(response) {
        if (response.authResponse) {
            $.post(BASEURL+'api/usuario/fbLogin', {accessToken: response.authResponse.accessToken}, function(data){
                if(data.status == 'error'){
                    alert(data.msg);
                    elm.html(elm_val);
                } else {
                    location.href = BASEURL+'chef/painel';
                }
            }, 'json')
        } else {
            elm.html(elm_val);
        }
    }, {scope: 'email'});
});

$('#recuperar_senha form').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    form.find('.alert').remove();
    form.find('button').addClass('disabled').html('<span class="fa fa-refresh fa-spin"></span>');
    $.post(form.prop('action'), form.serialize(), function(data){
        form.find('button').removeClass('disabled').html('Recuperar Senha');
        if(data.status == 'success'){
            form.prepend('<div class="alert alert-success">'+data.msg+'</div>');
        } else {
            form.prepend('<div class="alert alert-danger">'+data.msg+'</div>');
        }
    }, 'json');
})
