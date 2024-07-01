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