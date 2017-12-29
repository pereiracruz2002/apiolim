$(document).ready(function () {
    $('input[name=filter-month-cadastro]').MonthPicker({Button: false});
    $("select[name=filter-type-cadastro]").change(function () {
        var type = $(this).val();
        if (type == "Anual") {
            $("div.div-filter-month-cadastro").hide();
        }
        if (type == "Mensal") {
            $("div.div-filter-month-cadastro").removeClass("hide").show();
        }
    });
    $("button[name=btn-filter-month-cadastro]").click(function () {
        if ($(this).attr("data-label") == "filtrar") {
            $(this).attr("data-label", "loading");
            $(this).html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> Aguarde');
        }
        if ($("select[name=filter-type-cadastro]").val() == "Anual") {
            $.post(site + "administrativo/Painel/getAnnualUserRegisters", {token: $("#token").val()},
                    function (data) {
                        parseFilterRegisterUser(data);
                    });
        } else if ($("select[name=filter-type-cadastro]").val() == "Mensal") {
            $.post(site + "administrativo/Painel/getMonthlyUserRegisters", {month: $("input[name=filter-month-cadastro]").val(), token: $("#token").val()},
                    function (data) {
                        parseFilterRegisterUser(data);
                    });
        }
    });
});

function parseFilterRegisterUser(data)
{
    var parent = $("#cadastros_chart").parent();
    $("#cadastros_chart").remove();
    parent.append('<canvas id="cadastros_chart"></canvas>');
    var cadastros_chart = $("#cadastros_chart")[0].getContext('2d');
    var keys = Object.keys(data.users_register);
    var graph_colors = palette('tol', keys.length);
    var cadastros_datasets = [];
    var keys_label = [];
    for (key in keys) {
        var keyKeys = (Object.keys(data.users_register[keys[key]]));
        for (i in keyKeys) {
            keys_label[i] = keyKeys[i];
        }
        var keyValues = (Object.values(data.users_register[keys[key]]));
        cadastros_datasets.push({
            data: keyValues,
            borderColor: '#' + graph_colors[key],
            label: keys[key]
        });
    }
    var myLineChart = new Chart(cadastros_chart, {
        type: 'line',
        data: {
            labels: keys_label,
            datasets: cadastros_datasets,
        },
        options: {
            maintainAspectRatio: false,
            resposive: true, 
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
    if ($("button[name=btn-filter-month-cadastro]").attr("data-label") == "loading") {
        $("button[name=btn-filter-month-cadastro]").attr("data-label", "filtrar");
        $("button[name=btn-filter-month-cadastro]").html('<span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar');
    }
}