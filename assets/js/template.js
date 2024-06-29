var parts = window.location.pathname.split("/");
var link = parts[parts.length - 1];
var columnDefsVal = [
	{
		targets: -1,
		visible: true,
		width: '100px'
	}
];

showDataTables();
function showDataTables() {
	$("#myTable").DataTable({
		scrollCollapse: true,
		scrollY: '50vh',
		scrollX: '100%',
		processing: true,
		serverSide: true,
		autoWidth: true,
		responsive: false,
		info: false,
		paging: true,
		lengthChange: true,
		ajax: {
			url: link + "/server_side",
			type: "POST",
		}, initComplete: function (settings, json) {

		},
		fixedColumns: {
			start: 1,
			end: 1
		},
		columnDefs: columnDefsVal,
	});
}

function call_option(name) {
	console.log(name);
}

var studentSelect = $('.form-select');
$(".form-select").select2({
	ajax: {
		url: "http://localhost:8080/template/user/optionData",
		dataType: 'json',
		data: function (term) {
			return {
				term: term,
				id: $("#id").val()
			};
		},
		processResults: function (data) {
			return {
				results: data.result
			};
		},
	}
});

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