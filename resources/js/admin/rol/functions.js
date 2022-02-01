import * as custom_data_tables from '../custom_data_tables';


$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/rol/array-data',
        columns: [
         {data: 'rol' , name: 'rol'},
         {data: 'actions' , name: 'actions', searchable:false, orderable: false}
        ]
    };
    custom_data_tables.initDataTable(options);

});


$("input#global_filter").on("keyup", function(e) {
    if (e.keyCode === 13) {
        custom_data_tables.filterGlobal();
    }
});


// $(document).on('click', '.do-cancel', function(){
//     console.log("hi")
//      changeStatusByModal($(this).data('id'));
//  });
 
//  function changeStatusByModal(id){
//      $('input[name=id]').val(id);
//      $('#modal-cancel').modal('open');
//  }
 

