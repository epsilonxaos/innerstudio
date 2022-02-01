import {$} from './jquery';
import 'jquery-mask-plugin/dist/jquery.mask';

var maskPhone = () => {
    $('[mask-phone]').each(function (){
        console.log('Ejecutado');
        $(this).mask('(000) 000 0000');
    });
}

var maskCp = () => {
    $('[mask-cp]').each(function(){
        $(this).mask('00000');
    });
}

var maskCvv = () => {
    $('[mask-cvv]').each(function(){
        $(this).mask('0000');
    });
}

var maskTarjeta = () => {
    $('[mask-tarjeta]').each(function(){
        $(this).mask('0000000000000000');
    });
}

var maskFecha = () => {
    $('[mask-fecha]').each(function(){
        $(this).mask('0000-00-00');
    });
}

export {maskPhone, maskCp, maskFecha, maskCvv, maskTarjeta}