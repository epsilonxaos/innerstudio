import * as custom_data_tables from '../custom_data_tables';
import moment from 'moment';

$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/cupones/array-data',
        columns: [
            {data: 'title', name: 'title'},
            {data: 'price', name: 'price', searchable: false},
            {data: 'directed', name: 'directed', searchable: false},
            {data: 'duration', name: 'duration', searchable: false},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    };
    custom_data_tables.initDataTable(options);

});

$('input[name="directed"]').on('change', function(){
   let _val =  $('input[name="directed"]:checked').val();
   console.log(_val);
   if(_val == 'paquete')
       $('select[name=id_package]').prop('disabled', false);
   else
       $('select[name=id_package]').prop('disabled', true);
});


$.fn.datepicker
$('input[name="start_show"]').datepicker({
    format: 'dd-mm-yyyy',
    autoClose: true,
    onClose: function () {
        parseDayStart();
    }
});

$('input[name="end_show"]').datepicker({
    format: 'dd-mm-yyyy',
    autoClose: true,
    onClose: function () {
        parseDayEnd();
    }
});

function parseDayStart(){
    let init_day_value = $('input[name="start_show"]').val();
    document.querySelector('#start').value = moment(init_day_value, ["DD-MM-YYYY"]).format('YYYY-MM-DD');
}

function parseDayEnd(){
    let init_day_value = $('input[name="end_show"]').val();
    document.querySelector('#end').value = moment(init_day_value, ["DD-MM-YYYY"]).format('YYYY-MM-DD');
}

if($('input[name="directed"]:checked').val() == 'paquete'){
    $('select[name=id_package]').prop('disabled', false);
}else{
    $('select[name=id_package]').prop('disabled', true);
}

$('input[name="title"]').on('focusout', function(){
    $('input[name="title"]').val (function () {
        return this.value.toUpperCase();
    });
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


function deleteByModal(id){
    $('input[name=id]').val(id);
    $('#modal-delete').modal('open');
}

function changeStatusByModal(id, status){
    $('input[name=id]').val(id);
    $('input[name=status]').val(status);
    $('#modal-change-status').modal('open');
}
