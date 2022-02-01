import {$} from './imports/jquery';
import {maskPhone, maskCp, maskFecha} from './imports/maskForms';
import 'bootstrap/js/dist/tab';
import 'bootstrap/js/dist/dropdown';
import alertify from 'alertifyjs';

maskPhone();
maskCp();
maskFecha();

$('.dropdown-menu a').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
});

document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', () =>{
        document.querySelectorAll('.dropdown-item').forEach(item2 => {
            item2.classList.remove('active');
        });
        item.classList.add('active');
        document.querySelector('.btn-nav-m').innerHTML = item.innerHTML;
    });
});

document.querySelectorAll('.toggle-change').forEach(item=> {
    item.addEventListener("click", function () {
        let toggle = this.dataset.toggle;
        document.querySelectorAll(toggle).forEach(x =>{
            x.toggleAttribute("disabled");
        })
    });
});

if(document.querySelector('.btn-cancel-reservacion')){
    document.querySelectorAll('.btn-cancel-reservacion').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelector('#formCancelReservacion [name="id_reservacion"]').value = this.dataset.reservacion;
        })
    });
}

document.getElementById("formUpdate").addEventListener('submit', function (ev) {
    ev.preventDefault();

    if(document.getElementById('editar_pass').checked){
        let password = this.querySelector('[name="password"]');
        let password2 = this.querySelector('[name="password_confirmation"]');

        if(password.value.length < 6){
            alertify.error("Contraseña muy corta").dismissOthers();
        }
        else{
            if(password.value === password2.value){
                this.submit();
            }else{
                alertify.error("Las contraseñas no coinciden").dismissOthers();
            }
        }
    }else{
        this.submit();
    }
})