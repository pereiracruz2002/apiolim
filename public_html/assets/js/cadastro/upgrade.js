$(document).ready(function () {
    var site = $("#site").val();
    $("a.btn-continue-comilao").click(function (e) {
        e.preventDefault();
        $.getJSON(site + "chef/conta/CancelUpgrade", function () {
            location.href = site;
        });
    });
    
    $("a.btn-upgrade").click(function (e) {
        e.preventDefault();
        location.href = site + "chef/conta/upgrade/sim"
    });
});