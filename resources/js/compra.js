import { getDataForms } from './imports/AxiosUtilities';
import { maskPhone, maskCp, maskCvv, maskTarjeta } from './imports/maskForms';
import { alertify, waitMoment, removeAlert } from './imports/alerta';

maskPhone();
maskCp();
maskCvv();
maskTarjeta();

document.getElementById("do-pay").addEventListener("click", function (ev) {
    let valid = true;
    waitMoment();

    document.querySelectorAll('#compraForm [required]').forEach(item => {
        item.classList.remove('campo-requerido');
        if(item.value == ''){
            item.classList.add('campo-requerido');
            valid = false;
        }
    });

    if(valid){
        if(document.getElementById("terminos").checked){
            let dataAxios = getDataForms("compraForm");
            console.log(dataAxios);
            axios.post(PATH+"/compra/save", dataAxios)
            .then(function (response) {
                if(response.data.response == true){
                    if(response.data.redirect){
                        alertify.success("Registro hecho!").dismissOthers();
                        $('#param1').val(response.data.id_purchase)
                        $('#httpUserAgent').val(navigator.userAgent);
                        $("#3ds-form").submit();
                    }else{
                        if(response.data.complete_payment){
                            window.location.href = PATH+'/complete/free';
                        }else{
                            removeAlert();
                            alertify.error("La compra minima debe ser mayor a $10.00").dismissOthers();
                        }
                    }
                }else{
                    removeAlert();
                    alertify.error("Este paquete ya no aplica para ti!").dismissOthers();
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }
        else{
            removeAlert();
            alertify.error("Acepta términos y condiciones").dismissOthers();
        }
    }else{
        removeAlert();
        alertify.error("Faltan campos por llenar").dismissOthers();
    }
});

document.querySelector('.apply-cupon').addEventListener('click', function () {
    applyCupon();
});

function calcularTotal(){
    let _subtotal = document.querySelector('input[name="subtotal"]').value;
    let _discount = document.querySelector('input[name="discount"]').value;
    let _total = parseFloat(_subtotal) - parseFloat(_discount)

    if(parseFloat(_discount) > 0){
        document.getElementById("content-descuento").style.display = "block";
    }else{
        document.getElementById("content-descuento").style.display = "none";
    }

    document.querySelector('input[name="subtotal"]').value = _subtotal;
    document.querySelector('input[name="discount"]').value = _discount;
    document.querySelector('input[name="total"]').value = _total;
    document.querySelector('input[name="monto"]').value = _total;
    document.getElementById('total_value_new').innerText = _total;

    // document.getElementById('subtotal').innerText = _subtotal;
    // document.getElementById('total').innerText = _total;

}

function applyCupon(){
    console.log('entre');
    let _cupon = document.querySelector('input[name="cupon"]').value;
    let _btn = document.querySelector('.apply-cupon');
    let _cupon_dis = document.querySelector('input[name="cupon_discount"]');
    let _cupon_type = document.querySelector('input[name="cupon_type"]');
    let _discount = document.querySelector('input[name="discount"]');
    let _subtotal = document.querySelector('input[name="subtotal"]').value;
    let _id_package = document.querySelector('input[name="id_package"]').value;
    let _id_customer = document.querySelector('input[name="id_customer"]').value;

    if(_id_package != 0){

        if(_cupon != ''){
            _btn.setAttribute('disabled', true);
            axios.post(PATH + '/admin/cupon/aplicar', {
                cupon: _cupon,
                total: _subtotal,
                id_package: _id_package,
                id_customer: _id_customer
            })
            .then(function (response) {
                response = response.data;
                _btn.removeAttribute('disabled');
                _cupon_dis.value = response.cupon_discount;
                _cupon_type.value = response.cupon_type;
                _discount.value = response.discount;

                document.getElementById('cupon_text').innerText = response.show_text;
                document.getElementById('cupon_value').innerText = response.discount_text;

                alertify.success(response.msg).dismissOthers();
                calcularTotal();
            })
            .catch(function (error) {
                console.log(error);
            });
        }else{
            alertify.error('Ingrese el cupon').dismissOthers();
            document.getElementById("content-descuento").style.display = "none";
            document.querySelector('input[name="cupon"]').focus();
        }
    }else{
        document.getElementById("content-descuento").style.display = "none";
        alertify.error('Problemas con el paquete seleccionado').dismissOthers();
    }

}

