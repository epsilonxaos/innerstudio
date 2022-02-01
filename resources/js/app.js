require('./bootstrap');
import {$} from './imports/jquery';
import 'bootstrap/js/dist/modal';
import {alertify, waitMoment} from './imports/alerta';
window.axios = require('axios');

document.addEventListener("DOMContentLoaded", function(event) {
    document.querySelector('body').classList.remove('fade-in');
});

if(document.getElementById('open-menu')){
    document.getElementById('open-menu').addEventListener('click',  () => {
        document.getElementById('open-menu').classList.toggle('active');
        document.getElementById('overlay').classList.toggle('visible');
    });
}

document.getElementById("formLogin").addEventListener("submit", function (ev) {
    let username = this.querySelector('input[name="username"]');
    let password = this.querySelector('input[name="password"]');
    waitMoment();
    this.submit();
});

document.getElementById("formRegistro").addEventListener("submit", function (ev) {
    let password = this.querySelector('input[name="password"]');
    let password2 = this.querySelector('input[name="password_confirmation"]');
    ev.preventDefault();
    if(password.value.length < 6){
        alertify.error("Contraseña muy corta").dismissOthers();
    }
    else{
        if(password.value === password2.value){
            waitMoment();
            this.submit();
        }else{
            alertify.error("Las contraseñas no coinciden").dismissOthers();
        }
    }
});

$('#resetClick').click(function( event ) {
    event.preventDefault();
    axios.get(PATH +'/api/user/'+$('#emailReset').val())
       .then(function (response) {
        if(!response.data.res){
            $('#error_reset').toggleClass('invisible')
        }else{
            $('#formReset').submit()
        }
       })
       .catch(function (error) {
       })
});