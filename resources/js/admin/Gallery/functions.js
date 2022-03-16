import * as custom_data_tables from '../custom_data_tables';

$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/galeria/array-data',
        columns: [
            {data: 'id', name: 'galerias.id', orderable: false, searchable: false},
            {data: 'cover', name: 'galerias.cover'},
            // {data: 'portada', name: 'portada', orderable: false, searchable: false},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},


        ]
    };
    custom_data_tables.initDataTable(options);
});


$("input#global_filter").on("keyup", function(e) {
    custom_data_tables.filterGlobal();
});

$(document).on('click', '.do-delete', function(){
    deleteByModal($(this).data('id'));
});

$(document).on('click', '.do-change', function(){
    changeStatusByModal($(this).data('id'), $(this).data('status'));
});

function changeStatusByModal(id, status){
    $('input[name=id]').val(id);
    $('input[name=status]').val(status);
    $('#modal-change-status').modal('open');
}

function deleteByModal(id){
    $('input[name=id]').val(id);
    $('#modal-delete').modal('open');
}
