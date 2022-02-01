var table;
function initDataTable(options){
    if($('#data-table-contact').length > 0){
        table = $('#data-table-contact').DataTable(options);
        table.on('xhr', function() {
            var ajaxJson = table.ajax.json();
            $('#total-entries').text(ajaxJson.recordsTotal);
        });
    }
}

// Custom search
function filterGlobal() {
    table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
}

export {filterGlobal, initDataTable};