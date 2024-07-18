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

function call_option(i) {
	i.forEach(myFunction);
}

function myFunction(item, index) {
	$("#" + item).select2({
		ajax: {
			url: 'http://localhost:8080/template/navigation/getOption',
			dataType: 'json',
			type: "GET",
			quietMillis: 100,
			data: function (term) {
				return {
					term: term,
					tipe: item,
					FormData: $('form').serializeArray(),
				};
			},
			processResults: function (data) {
				return { results: data };
			},
			cache: false,
		},
		theme: "bootstrap4",
	});
}

$('.form-select').select2();

//Date picker
$('#reservationdate').datetimepicker({
	format: 'L'
});
