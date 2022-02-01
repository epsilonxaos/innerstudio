import SlimSelect from 'slim-select';
import moment from 'moment';
window.axios = require('axios');
import flatpickr from "flatpickr";
import mexico from "flatpickr/dist/l10n/es.js";

import * as custom_data_tables from '../custom_data_tables';

import 'slim-select/dist/slimselect.min.css';



$(function () {
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/clases/array-data',
        columns: [
            {data: 'name', name: 'B.name'},
            {data: 'schedule', name: 'schedule', searchable: false},
            {data: 'tipo', name: 'A.tipo',},
            {data: 'disponibilidad', name: 'disponibilidad', searchable: false},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    };
    custom_data_tables.initDataTable(options);
    new SlimSelect({
        select: '#id_instructor'
    });
    new SlimSelect({
        select: '#tipo'
    });

    /*new SlimSelect({
        select: '#start_hour'
    });*/

    /*new SlimSelect({
        select: '#duration'
    });*/

    $('#fecha').flatpickr({
        locale: 'es',
        altInput: true,
        dateFormat: "Y-m-d",
        /*onClose: function () {
            parseDay();
        }*/
    });

    $('#start_hour_select').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
       /* onClose: function () {

        }*/
    });
    $('#end_hour_select').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        /*onClose: function () {

        }*/
    });
});

function parseDay(){
    let init_day_value = $('#fecha').val();
    document.querySelector('#start').value = moment(init_day_value, ["DD-MM-YYYY"]).format('YYYY-MM-DD');
}

function parseStartHour(){
    let init_day_value = $('#start_hour_select').val();
    document.querySelector('#start_hour').value = moment(init_day_value, ["H:i"]).format('YYYY-MM-DD');
}

$("input#global_filter").on("keyup", function(e) {
    custom_data_tables.filterGlobal();
});



$(document).on('click', '.do-delete', function(){
    const id = $(this).data('id');
    axios.get(_PATH +'admin/clase/mats/'+id)
    .then(function (response) {
        if(response.data.res === 0){
            console.log(id)
            deleteByModal(id,"¿Estás seguro que deseas eliminar este registro?");
        }else{
            console.log(id)
            deleteByModal(id,"¿Esta clase contiene "+response.data.res+" reservaciones, seguro que deseas eliminar este registro?");
        }

    })
    .catch(function (error) {
    console.log(error);
    })
});

$(document).on('click', '.do-change', function(){
    changeStatusByModal($(this).data('id'), $(this).data('status'));
});


function deleteByModal(id,msg){
    $('input[name=id]').val(id);
    $('#modalmsg').text(msg);
    $('#modal-delete').modal('open');
}

function changeStatusByModal(id, status){
    $('input[name=id]').val(id);
    $('input[name=status]').val(status);
    $('#modal-change-status').modal('open');
}
