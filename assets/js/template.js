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

$(".form-select").select2();