call_option(['root']);
$('#type').on('change', function () {
    if ($(this).val() == 0) {
        call_option(['root']);
        $("#root").val("").trigger('change');
    } else {
        call_option(['root']);
        $("#root").val("").trigger('change');
    }
});