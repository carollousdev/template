var url = window.location.pathname;
var parts = url.split("/");
var link = parts[parts.length - 1];
var columnDefsVal = [
	{
		orderable: false,
		targets: [-1],
		width: "100px",
	},
	{
		orderable: false,
		targets: [0],
		width: "70px",
	},
];

$(function () {
	$("#btn_add").on("click", function () {
		$.ajax({
			url: link + "/addModal",
			type: "POST",
			dataType: "json",
			success: function (response) {
				$("#addModal").modal("show");
				$("#form-field-add").html(response.data);
			},
		});
	});
});

submitData();
function submitData() {
	$("#btn_submit").on("click", function () {
		var data = $("#form-add").serialize();
		$.ajax({
			url: link + "/add",
			type: "POST",
			dataType: "json",
			data: data,
			success: function (output) {
				if (output.response == 'success') {
					$("#addModal").modal("hide");
					$("#myTable").DataTable().ajax.reload(null, false);
				} else {
					$.each(output.error, function (index, value) {
						if (value !== 'false') {
							$('.' + index).text(value);
							$('#' + index).addClass('is-invalid');
						} else {
							$('#' + index).removeClass('is-invalid');
							$('.' + index).empty();
						}
					});
				}
			},
		});
	});
}

$("#myTable").on("click", ".btn_edit", function () {
	var id = $(this).attr("data-id");
	$.ajax({
		url: link + "/editModal",
		type: "POST",
		data: {
			id: id,
		},
		dataType: "json",
		success: function (response) {
			$("#editModal").modal("show");
			$("#form-field-edit").html(response.data);
		},
	});
});

$("#btn_edit_submit").on("click", function () {
	$.ajax({
		url: link + "/edit",
		type: "POST",
		dataType: "json",
		data: $("#form-edit").serializeArray(),
		success: function (response) {
			$("#editModal").modal("hide");
			$("#myTable").DataTable().ajax.reload(null, false);
		},
	});
});

$("#myTable").on("click", ".btn_delete", function () {
	var id = $(this).attr("data-id");
	$.ajax({
		url: link + "/delete",
		type: "POST",
		dataType: "json",
		data: {
			id: id,
		},
		success: function (response) {
			$("#myTable").DataTable().ajax.reload(null, false);
		},
	});
});

showDataTables();
function showDataTables() {
	$("#myTable").DataTable({
		processing: true,
		serverSide: true,
		autoWidth: false,
		responsive: true,
		scrollCollapse: true,
		info: true,
		orderable: true,
		lengthChange: true,
		ajax: {
			url: link + "/server_side",
			type: "POST",
		},
		columnDefs: columnDefsVal,
	});
}
