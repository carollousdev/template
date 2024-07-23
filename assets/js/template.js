var parts = window.location.pathname.split("/");
var link = parts[parts.length - 1];
var columnDefsVal = [
	{
		targets: -1,
		visible: true,
		width: '40px'
	}
];

showDataTables();
function showDataTables() {
	var orientations = '';
	var numCols = $('#myTable thead th').length;
	if (numCols > 4) {
		orientations = 'landscape';
	} else {
		orientations = 'portrait';
	}

	$("#myTable").DataTable({
		title: "test",
		layout: {
			topStart: {
				buttons: [
					{
						extend: 'copyHtml5',
						title: 'DATA ' + link.toUpperCase(),
						exportOptions: {
							columns: ':visible'
						}
					}, {
						extend: 'csvHtml5',
						title: 'DATA ' + link.toUpperCase(),
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'excelHtml5',
						title: 'DATA ' + link.toUpperCase(),
						exportOptions: {
							columns: ':visible'
						}
					}, {
						extend: 'pdfHtml5',
						title: 'DATA ' + link.toUpperCase(),
						orientation: orientations,
						download: 'open',
						exportOptions: {
							columns: ':visible',
						},
						customize: function (doc) {
							var logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAjVBMVEUstpz///8stpvq+PUds5wRsZPd8+9nyLMgtZhMv6d9z73S6+cMtJbD6ODZ8e5nyLdVxK3N7efz+/ksuZsUsZfm9PSY2My04tvs+fRxy7cetZT7/f+O08Ww4tf0+/w3uJ+n39Gu4Np5zb2D0cI8vKA8u6Wb18nL6uhhxbBPwKuF0cap4tM9vp7B5uLp9vjDJI4KAAAExklEQVR4nO2dCXPiOBBGhczREEEwCBjC4QyQGbO78P9/3hJCKgxjyW1ASEp9L0dVDlx6pbaOVgNCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAChHFv5yWPjruJAHiLQmTQfev+nDD/RhRvUiDv/judFVIGrI/no86T41kzPSo6JOfyRFpFMVR99K/dJeT0az2t80jwq6WfCnI/MIelEq0VqMTAYfhg2j4TLz3f4ySPcXian5DMNaHnaYatXpWfQ4hi3fDjaUmA/sfnEbkpjbwjN6Q6laJfEZuaHOuhy/eA11p/QGjNlQCpow/SI11Btze7+FIU25ERqpoZ5X8IvQUKpxJcHYDKVQr9UEozOkqoKxGVLFEI3OkDq1ok3u9zGkaVW92AzbVebBGA2pwkomSsPK80RshlfdhDEZDjPGfr7Y8P3hERjSz+sEa6NI+pC2TKFZOplP8/YZx2Rh+IaalZMZLfJ6Q5Ek+X4oIT4+jwRvWF8x/NJnpU3Z3eANGVNhmmsyZ69DN6R1md++82JNzgdvWNaF3UzbrxC4YelkP34pu0Tghrok+bsu6UARvOHG6jebqvJLhG2o7Rt7Rg8Gb2gdZ8YcwbAN7Qu2lBGiInBD/csiONjwzqjDNnyyGHIrKZSxkiGAc/w3S3amaVmonSPJbNj3bmib7lvMLpTDfbiGtiRwkzWOHpAbcyC0nTafAf02G6659Uyyb7zGzHfFkBTm/Mwg4waYNO8v+Rdxxcacx+8aN7yXWLI8zeJqzQdijq9ah902y/Yr9V25V7cMpVt2kLbNgTDhjlausJxpJ3V2kFqWRfO60/YzGrcwtu03O74sa7bas8vWc1Dm3e8r27BlFhxsXLaeA5kNf3ENlSXZ2vN9G9oMuatusnRhbeF7KBUqNTauw2zc0LaDnno3bNxs2LAlQQb+n4Zxs6HMbdUNacO1QCnKvP9lGcrMevjPjXSH3GpovQlrS++L0lsNpW3vdWDivwtvMpRSlhw75pEbUrvkRKcnhg+RsHK9oWysl3bB2pqZyHLK1YZKlBbzj0IQvM5QSpWNy2v82Gkep1Q1PIwuQuvtK6MErslOgriA5AnLunSl5QWCiBp6Ozc/5o/H+xTM8v4nk56B5j/9S1qr+b8pt3bKb4Lm+ash/YaJHVOlmFnbq+HZju6ZLmPxhGXnyIF37vgQQ9Pdcpthj53GcoN7wzfPM4VzQ+9ToWvDBfnOkjo2fDK8tMQDcWs4kr5j1LFh4j0JLNwa7rf+e9Cp4cDvWuYTd4aJ74nwhDPD3n9hCDoz7HqfJT5xZDi2l0o/EieGydT7SdoXLgx3WRCJpxP3N1yueGWaj+LehrNXomAGmSP3NZzttmF1oLiz4S4P8FXZ7mc4WGxUeH53M1ymHSIZ1P33yT0Ml915O9wX1Ds3rJ+eS3j+JQ4ftmfS7NNxnlFo4+cZMk9GJ/bTtonJ6JJmL91Nxp2+1C++8zBlyK/MtvlkZvV3Glyp4ytfhtpzhdxaqRA+MIwfGMYPDOMHhvEDw/iBYfzAMH5gGD8wjB8Yxg8M48dmGFVa1Ah1B4Vv8pMkA6+V6HeEdOE7Nb2fX3wTQwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD34n/9EVLZkQ9HRwAAAABJRU5ErkJggg==';
							if (orientations == 'portrait') {
								doc.content.splice(0, 1);
								doc.content[0].table.widths = '*';

								doc['header'] = (function () {
									return {
										columns: [{
											image: logo,
											width: 20,
											margin: [1, 0]
										},
										{
											alignment: 'left',
											text: 'SAP SURVEYOR',
											fontSize: 8,
											margin: [5, 5]
										},
										{
											alignment: 'right',
											fontSize: 8,
											text: 'DATA ' + link.toUpperCase(),
											margin: [20, 0]
										}
										],
										margin: 20
									}
								});
							}
						},
					}, {
						extend: 'print',
						title: 'DATA ' + link.toUpperCase(),
						exportOptions: {
							columns: ':visible'
						}
					}, 'colvis']
			}
		},
		scrollCollapse: true,
		scrollY: '50vh',
		scrollX: '100%',
		processing: true,
		serverSide: true,
		autoWidth: true,
		responsive: true,
		info: false,
		paging: true,
		lengthChange: true,
		ajax: {
			url: link + "/server_side",
			type: "POST",
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
