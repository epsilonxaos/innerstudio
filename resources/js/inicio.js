import {$} from './imports/jquery';
import Swiper from 'swiper';

var swiper = new Swiper ('.swiper-container', {
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    autoplay: true,
    lop: true,
});