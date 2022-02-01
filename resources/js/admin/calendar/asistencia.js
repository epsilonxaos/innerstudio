import * as custom_data_tables from '../custom_data_tables';
var moment = require('moment');

$(function () {
    let options;
    options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Imprimir',
                customize: function ( win ) {
                    console.log( $(win.document.body));
                    var now = moment();
                    var current_date = moment(now).format('DD-MM-YYYY hh:mm A')
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<div style="width: 100%; height: 50px; padding: 10px; background-color: #0d47a1; margin-bottom: 20px"><p style="margin: 0px;"><span style="font-size: 18px; color: #000; font-weight: bold; float: left;">Instructor: '+_instructor+'</span> <span style="font-size: 18px; color: #000; font-weight: bold; float: right;">'+_string_date+'</span></p><p style="margin-top: 30px;"><span style="font-size: 12px; color: #000; float:left;">Fecha de impresión: '+current_date+'</span></p></div>'
                        );
                    $(win.document.body).find( 'h1' ).remove();
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            }
        ],
        ajax: {
            url: _PATH + 'admin/calendario/asistencia/clases/array-data',
            data: {
                id_lesson: _id_lesson,
            }
        },
        columns: [
            {data: 'name', name: 'customer.name'},
            {data: 'email', name: 'customer.email'},
            {data: 'phone', name: 'customer.phone'},
            {data: 'no_mat', name: 'mat.no_mat'},
            {data: 'firma', name: 'firma', visible: false, orderable: false, searchable: false},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ],
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