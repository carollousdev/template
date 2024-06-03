var url = window.location.pathname;
var parts = url.split("/");
var link = parts[parts.length - 1];

showDataTables();
function showDataTables() {
$('#myTable').DataTable({
    "scrollY": 300,
    "scrollX": true,
    "fixedColumns": true,
    "fixedHeaders": true,
    "processing": true,
    "serverSide": true,
    "autoWidth": false,
    "responsive": false,
    "scrollCollapse": true,
    "info": true,
    "orderable": true,
    "lengthChange": true,
    "ajax": {
        "url": link + "/server_side",
        "type": "POST"
    },
});
}