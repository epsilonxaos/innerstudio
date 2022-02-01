import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import resourceTimeGridPlugin from '@fullcalendar/resource-timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import esLocale from '@fullcalendar/core/locales/es';

import flatpickr from "flatpickr";
import mexico from "flatpickr/dist/l10n/es.js";

import tippy from 'tippy.js'
import '@fullcalendar/core/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/timegrid/main.css';
import 'tippy.js/themes/light.css'

var moment = require('moment');
var calendar;

moment.locale('es');

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var btn_next = document.querySelector('#c-next');
    var btn_prev = document.querySelector('#c-prev');
    var change_view = document.querySelector('#switcher-1');
    var change_view_week = document.querySelector('#c-change-view-week');
    var change_view_doctor = document.querySelector('#c-change-view-doctor');
    var c_current_date = document.querySelector('#c-current-date');

    calendar = new Calendar(calendarEl, {
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        plugins: [ timeGridPlugin, resourceTimeGridPlugin, interactionPlugin ],
        aspectRatio: 1,
        height: 900,
        contentHeight: 'auto',
        locale: esLocale,
        defaultView: 'timeGridDay',
        slotEventOverlap: true,
        eventLimit: true,
        minTime: '06:00',
        maxTime: '24:00',
        slotDuration: '00:15:00',
        allDaySlot: false,
        nowIndicator: true,
        header: {
          left: '',
          center: '',
          right: ''
        },
        columnHeaderFormat:{
            weekday: 'long',
            day: '2-digit'
        },
        slotLabelFormat: [
            {   hour: 'numeric',
                minute: '2-digit',
                hour12: true,
                omitZeroMinute: false,
            }, // top level of text
        ],
        refetchResourcesOnNavigate: true,

        resources: function(fetchInfo, successCallback, failureCallback) {
            //listCitasSemana(moment(fetchInfo.startStr).format('YYYY-MM-DD'), moment(fetchInfo.endStr).subtract(1, 'days').format('YYYY-MM-DD'), successCallback)
            listDoctorDia(moment(fetchInfo.startStr).format('YYYY-MM-DD'), successCallback);
           /*$.get(_PATH+'calendario/doctor/dia/'+moment(fetchInfo.startStr).format('YYYY-MM-DD'), function(response){
               successCallback(response.citas);
               if(calendar.view.type == 'resourceTimeGridDay' || calendar.view.type == 'timeGridDay')
                   listDoctors(response.doctores);
           });*/
        },
        events: function(fetchInfo, successCallback, failureCallback) {

            listCitasSemana(moment(fetchInfo.startStr).format('YYYY-MM-DD'), moment(fetchInfo.endStr).subtract(1, 'days').format('YYYY-MM-DD'), successCallback)
           /* $.get(_PATH+'calendario/citas/semana/'+moment(fetchInfo.startStr).format('YYYY-MM-DD')+'/'+moment(fetchInfo.endStr).format('YYYY-MM-DD'), function(response){
                successCallback(response.citas);
                listDoctors(response.doctores);
            });*/
        },
        eventClick(info) {


        },
        eventRender: function(info) {
            $(info.el).find('.fc-time').remove();
            //let url_edit = info.event._def.extendedProps.cita_from == 'Paciente' ? _PATH+'admin/clase/editar/'+info.event.id : _PATH+'cita/estudio/modificar/'+info.event.id;
            let url_edit = _PATH+'admin/clase/editar/'+info.event.id;
            let dia = moment(info.event.start).format('dddd DD [de] MMMM');
            let dia_inicio = moment(info.event.start).format('DD-MM-YYYY hh:mm A');
            let dia_termino = moment(info.event.end).format('DD-MM-YYYY hh:mm A');
            let hora_inicio = moment(info.event.start).format('hh:mm A');
            let hora_termino = moment(info.event.end).format('hh:mm A');
            $(info.el).find('.fc-title').append('<br> <span>'+hora_inicio+'-'+hora_termino+'</span>');
            $(info.el).find('.fc-title').prepend('<span>'+info.event._def.extendedProps.tipo+' ('+info.event._def.extendedProps.disp+')</span> <br>')
            tippy(info.el, {
                animation: 'perspective',
                interactive: true,
                trigger: 'click',
                appendTo: document.body,
                content: '<div class="content-detail-cita">\n' +
                    '       <h6>Instructor: '+info.event.title+'</h6>\n' +
                    '       <div class="divider"></div>\n' +
                    '       <strong class="left">DATOS DE LA CLASE</strong>\n' +
                    '       <button class="right btn-floating waves-effect red do-delete" data-id="'+info.event.id+'"><i class="fas fa-trash"></i></button>\n'+
                    '       <a href="'+url_edit+'" class="right btn-floating waves-effect btn-cafe"><i class="fas fa-pen"></i></a><br>\n'+
                    '       <p><strong>Tipo de clase:</strong> '+info.event._def.extendedProps.tipo+'</p>\n' +
                    '       <p><strong>Día:</strong> '+dia+'</p>\n' +
                    '       <p><strong>Horario:</strong> '+hora_inicio+' - '+hora_termino+'</p>\n' +
                    '       <p><strong>Disponibilidad:</strong> '+info.event._def.extendedProps.disp+' </p>\n' +
                    '       <p><center><a href="'+_PATH+'admin/calendario/asistencia/'+info.event.id+'" class="waves-effect btn-small btn-main">Ver Lista de Asistentes</a></center></p>\n'+
                    '     </div>',
                placement: 'right',
                theme: 'light',
                arrow: true
            });

            info.el.ondblclick = function(){
                window.location.href=url_edit;
            }
        },
        dateClick(arg) {
            console.log(moment(arg.date).format('DD-MM-YYYY hh:mm A'));


            arg.jsEvent.target.ondblclick = function(){
                //alert(moment(arg.date).format('DD-MM-YYYY hh:mm A'));
                moment.locale('es');
                let _d = moment(arg.date).format('YYYY-MM-DD'), _h = moment(arg.date).format('HH:mm');

                $('#select_date').text(moment(arg.date).format('DD MMM YYYY'))
                $('#select_hour').text(moment(arg.date).format('hh:mm A'))

                $('#link-cita-paciente').attr('href', _PATH+'admin/clase/create?p_fecha='+_d+'&p_hora='+_h);
                //$('#link-cita-estudio').attr('href', _PATH+'cita/estudio/nuevo?p_fecha='+_d+'&p_hora='+_h);

                $('#modal-add-cita').modal();
                $('#modal-add-cita').modal('open');

                //var inst_modal = M.Modal.init(document.querySelectorAll('#modal-add-cita')).open();
            }
        }
    });
    calendar.render();
    c_current_date.innerHTML = calendar.view.title;

    btn_next.addEventListener('click', function(){

       calendar.next();
       c_current_date.innerHTML = calendar.view.title;
    });

    btn_prev.addEventListener('click', function(){
        calendar.prev();
        c_current_date.innerHTML = calendar.view.title;
    });

    change_view.addEventListener('click', function(x){
        if(x.target.checked)
            calendar.changeView('timeGridWeek');
        else
            calendar.changeView('timeGridDay');
        c_current_date.innerHTML = calendar.view.title;
    });
    change_view_week.addEventListener('click', function(x){
        calendar.changeView('timeGridWeek');
        c_current_date.innerHTML = calendar.view.title;
        change_view.checked = true;
        change_view.disabled = false;
        change_view_week.classList.add('hide');
        change_view_doctor.classList.remove('hide');
    });
    change_view_doctor.addEventListener('click', function(x){
        calendar.changeView('resourceTimeGridDay');
        c_current_date.innerHTML = calendar.view.title;
        change_view.disabled = true;
        change_view_doctor.classList.add('hide')
        change_view_week.classList.remove('hide');
    });

    $('#day').flatpickr({
        locale: 'es',
        altInput: true,
        dateFormat: "Y-m-d",
        /*onClose: function () {
            parseDay();
        }*/
    });

});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var loading = ' <div class="progress">\n' +
    '               <div class="indeterminate"></div>\n' +
    '           </div>';

function listDoctorDia(day, cb){
    $('.load-events').html(loading);
    $.get(_PATH+'admin/calendario/instructor/dia/'+day, function(response){
        /*if(calendar.view.type == 'resourceTimeGridDay' || calendar.view.type == 'timeGridDay')
            listDoctors(response.doctores);*/
        $('.load-events').html('');
        cb(response.citas);

    });
}

function listCitasSemana(start, end, cb){
    let _input_doctors = $('input[name="id_doctor"]:checked'),
        _id_doctors = [];

    _input_doctors.each(function(e, i){
       _id_doctors.push($(i).val());
    });

    $('.load-events').html(loading);
    $.post(_PATH+'admin/calendario/lessons/semana/'+start+'/'+end, {'id_doctors' : _id_doctors},  function(response){
        $('.load-events').html('');
        cb(response.citas);
    });
}



$('#filter-doctors').on('click', function(){
    calendar.removeAllEvents()
    calendar.refetchEvents();
});


$( function() {
    if($( "#datepicker" ).length > 0){
        $( "#datepicker" ).datepicker({
            dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ],
            dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
            onSelect: function(a,b){
                console.log(calendar.view.title);
                $('#switcher-1').prop('checked', false);
                var grid_view = calendar.view.type == 'resourceTimeGridDay' ? 'resourceTimeGridDay' : 'timeGridDay';
                calendar.changeView(grid_view, moment(a).format('YYYY-MM-DD'));
                $('#c-current-date').html(calendar.view.title);
            }
        })
    }

    /*var init_day_picker = document.querySelectorAll('#day');
    var ins_idp = M.Datepicker.init(init_day_picker, {
        format: 'dd-mm-yyyy',
        container: 'body',
        autoClose: true,
        onClose: function () {
            //parseInitDay();
        }
    });*/
    $('.modal').modal();

    $('select[name="tipo"]').on('change', function(){
        if($(this).val() == 'doctor'){
            $('#content-select-doctors').removeClass('hide')
            $('#content-select-tecnico').addClass('hide')
        }else{
            $('#content-select-doctors').addClass('hide')
            $('#content-select-tecnico').removeClass('hide')
        }
    });
});

$(document).on('click', '.do-delete', function(){
    deleteByModal($(this).data('id'));
});

function deleteByModal(id){
    $('input[name=id]').val(id);
    $('#modal-delete').modal('open');
}

