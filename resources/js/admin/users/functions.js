import * as custom_data_tables from '../custom_data_tables';
import SlimSelect from 'slim-select';
import 'slim-select/dist/slimselect.min.css';

$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/accounts/array-data',
        columns: [
         {data: 'email' , name: 'email'},
         {data: 'name' , name: 'name'},
         {data: 'rol' , name: 'rol'},
         {data: 'actions' , name: 'actions'}
        ]
    };
    custom_data_tables.initDataTable(options);

});


$("input#global_filter").on("keyup", function(e) {
    if (e.keyCode === 13) {
        custom_data_tables.filterGlobal();
    }
});



 
 function changeStatusByModal(id){
     $('input[name=id]').val(id);
     $('#modal-cancel').modal('open');
 }
 


 new SlimSelect({
    select: '#rol'
   });


document.getElementById('edit_email').addEventListener( 'change', function() {
    if(this.checked) {
        document.getElementById('email').disabled = false;
    } else {
        document.getElementById('email').disabled = true;
    }
});

document.getElementById('edit_pass').addEventListener( 'change', function() {
    if(this.checked) {
        document.getElementById('password').disabled = false;
    } else {
        document.getElementById('password').disabled = true;
    }
});