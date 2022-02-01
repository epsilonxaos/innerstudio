window.axios = require('axios');
import { alertify, waitMoment, removeAlert } from './imports/alerta';


$('[data-btn="mat"]').on('click', (x) => {
    $('#mat_place').text(x.target.dataset.place)
    $('#reserve').val(x.target.dataset.place)
    $('#mdSeleccion').modal('show')
})
$('[data-btn="guest"]').on('click', () => $('#mdLogin').modal('show'))





$('#reservebtn').on('click', (x) => {
    $(this).attr("disabled", "disabled");
	waitMoment();
	axios.post(PATH + '/reserve', {
        id: id,
        place: $('#reserve').val(),
        class: class_num
    })
    .then(function (response) {
        removeAlert();
        $(this).removeAttr("disabled");
        if (response.data.res == 2) {
            $('#mdSeleccion').modal('hide')
            $('#mdCompra').modal('show')
        } else if (response.data.res == 3) {
            $('#mdSeleccion').modal('hide')
            $('#mdEnd').modal('show')
        } else if (response.data.res == 4) {
            $('#mdRegistrada').modal('hide')
            $('#mdEnd').modal('show')
        } else {
            $('#hrs').text(response.data.fecha)
            $('#matSel').text(response.data.tapete)
            $('#mdSeleccion').modal('hide')
            $('#mdThx').modal('show')
        }
    })
    .catch(function (error) {
        console.log(error);
	});
});