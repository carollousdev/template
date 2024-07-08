var studentSelect = $('.form-select');
$.ajax({
    url: "http://localhost:8080/template/user/get_data",
    type: "POST",
    dataType: "json",
    data: {
        id: $("#id").val()
    },
    success: function (response) {
        if (response.response == true) {
            var option = new Option(response.data.name, response.data.id, true, true);
            studentSelect.append(option).trigger('change');
        }
    },
});

function call_option(i) {
    i.forEach(myFunction);
}

function myFunction(item, index) {
    $("#" + item).select2({
        ajax: {
            url: 'http://localhost:8080/template/navigation/optionData',
            dataType: 'json',
            type: "GET",
            quietMillis: 100,
            data: function (term) {
                return {
                    term: term,
                    id: $("#id").val(),
                    tipe: item,
                    data: $('form').serializeArray(),
                };
            },
            processResults: function (data) {
                return { results: data };
            },
        }, minimumResultsForSearch: Infinity
    });
}

call_option(['root']);

$('#type').on('change', function () {
    callback_option('root');
});

var $newOption = $("<option selected='selected'></option>").val(result[item]).text("The text");
$("#" + item).append($newOption).trigger('change');