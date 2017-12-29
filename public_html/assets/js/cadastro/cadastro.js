var geocoder = new google.maps.Geocoder();

$("#field_address").on('keyup', function () {
    var field = $(this);
    var type = field.val();
    var listaddress = []

    field.autocomplete({
        source: listaddress
    });

    geocoder.geocode({
        address: type,
        componentRestrictions: {
            country: 'BR'
        }
    }, function (results, status) {
        var rows = (results['length'] !== null) ? results.length : 0
        if (rows > 0)
        {
            for (i = 0; i < rows; i++)
            {
                console.log(results.length, i, results[i]['formatted_address']);
                listaddress.push(results[i]['formatted_address']);
            }
        }
    });
});

$("#field_cep").on('keyup', function () {
    var field = $(this);
    var type = field.val();
    if (type.length < 9) {
        $("#field_address").val("")
        $("#field_city").val("")
        $("#field_state").val("")
        return false;
    }
    $.post(BASEURL + "api/cep", {cep: type}, function (data) {
        if (data !== null) {
            $("#field_address").val(data['logradouro'])
            $("#field_city").val(data['localidade'])
            $("#field_state").val(data['uf'])
        } else {
            $("#field_address").val("")
            $("#field_city").val("")
            $("#field_state").val("")
        }
    });
});

$("div.panel-heading").click(function () {
    var heading = $(this);
    var caret = heading.children();
    
    heading.next().fadeToggle();
    
    if (caret.hasClass('caret-down'))
        caret.removeClass('caret-down').removeClass('fa-caret-down').addClass('fa-caret-up').addClass('caret-up');
    else
        caret.removeClass('caret-up').removeClass('fa-caret-up').addClass('fa-caret-down').addClass('caret-down');
});