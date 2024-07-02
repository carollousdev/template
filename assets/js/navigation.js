call_option(['root']);

$('#type').on('change', function () {
    onChangeOption = { name: $(this).attr('id'), value: $(this).val() };
    callback_option('root');
});