import * as custom_data_tables from '../custom_data_tables';

$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/tapetes/array-data',
        columns: [
            {data: 'no_mat', no_mat: 'name'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    };
    custom_data_tables.initDataTable(options);

});


$("input#global_filter").on("keyup", function(e) {
    custom_data_tables.filterGlobal();
});



$(document).on('click', '.do-change', function(){
    changeStatusByModal($(this).data('id'), $(this).data('status'));
});


function changeStatusByModal(id, status){
    $('input[name=id]').val(id);
    $('input[name=status]').val(status);
    $('#modal-change-status').modal('open');
}
