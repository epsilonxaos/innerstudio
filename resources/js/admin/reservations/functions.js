import * as custom_data_tables from '../custom_data_tables';


$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/reservations/array-data',
        columns: [
         {data: 'id_reservation' , name: 'A.id_reservation', searchable:false, visible: false},
         {data: 'fullname' , name: 'fullname', searchable:false},
         {data: 'name' , name: 'B.name', visible: false},
         {data: 'lastname' , name: 'B.lastname', visible: false},
         {data: 'clase' , name: 'clase', searchable:false},
         {data: 'no_mat' , name: 'mat.no_mat', searchable:false},
         {data: 'instructor_name' , name: 'E.name'},
         {data: 'status' , name: 'status', searchable:false},
         {data: 'actions' , name: 'Cancelar', searchable:false, orderable: false}
        ]
    };
    custom_data_tables.initDataTable(options);

});


$("input#global_filter").on("keyup", function(e) {
    custom_data_tables.filterGlobal();
});


$(document).on('click', '.do-cancel', function(){
    console.log("hi")
     changeStatusByModal($(this).data('id'));
 });
 
 function changeStatusByModal(id){
     $('input[name=id]').val(id);
     $('#modal-cancel').modal('open');
 }
 

