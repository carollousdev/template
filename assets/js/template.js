var parts = window.location.pathname.split("/");
var link = parts[parts.length - 1];
var columnDefsVal = [
	{
		targets: -1,
		visible: true,
		width: '100px'
	}
];
var onChangeOption = [];

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
					onChange: onChangeOption,
				};
			},
			processResults: function (data) {
				return { results: data };
			},
		},
	});
}

function callback_option(name) {
	$.ajax({
		type: "POST",
		url: 'http://localhost:8080/template/navigation/get_data',
		dataType: 'json',
		data: {
			type: $("#type").val()
		},
		success: function (result) {
			if (result.length == 0) {
				$('#' + name).val("").trigger("change");
			} else $('#' + name).val('NANt9eH41719583069').trigger("change");
		}
	});
}

$(".form-select").select2();
