import SlimSelect from 'slim-select';
import * as custom_data_tables from '../custom_data_tables';
import 'slim-select/dist/slimselect.min.css';

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let options = {
        serverSide: true,
        processing: true,
        pageLength: 50,
        ajax: _PATH+'admin/ventas/array-data',
        columns: [
            {data: 'reference_code', name: 'purchase.reference_code'},
            {data: 'fullname', name: 'fullname', searchable: false},
            {data: 'name', name: 'purchase_data.name', visible: false},
            {data: 'lastname', name: 'purchase_data.lastname', visible: false},
            {data: 'id_package', name: 'id_package', searchable: false},
            {data: 'price', name: 'price', searchable: false},
            {data: 'created_at', name: 'created_at', searchable: false},
            {data: 'method_pay', name: 'method_pay', searchable: false},
            {data: 'status', name: 'status', searchable: false},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    };
    custom_data_tables.initDataTable(options);

    $('select[name="method_pay"]').on('change', function(){
       let val = $(this).val();
       if(val == 'tarjeta'){
           $('#reference_code').parent().show();
       }else{
           $('#reference_code').parent().hide();
       }
    });

    if( $('select[name="method_pay"]').find('option:selected').val() == 'tarjeta' ){
        $('#reference_code').parent().show();
    }else{
        $('#reference_code').parent().hide();
    }
    if($('#id_package').length > 0){

        new SlimSelect({
            select: '#id_package'
        });
        new SlimSelect({
            select: '#id_customer'
        });
        new SlimSelect({
            select: '#method_pay'
        });
    }

    $('.apply-cupon').on('click', function(){
       applyCupon();
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

$('select[name="id_package"]').on('change', function(){
    let _option = $(this).find(':selected'), _precio = _option.data('precio');
    $('input[name="subtotal"]').val(_precio);
    reiniciarCupon();
    calcularTotal();
});

function calcularTotal(){
    let _subtotal = $('input[name="subtotal"]').val(), _discount = $('input[name="discount"]').val(), _total = parseFloat(_subtotal) - parseFloat(_discount);
    $('input[name="subtotal"]').val(_subtotal);
    $('input[name="discount"]').val(_discount);
    $('input[name="total"]').val(_total);
    $('#subtotal').text(_subtotal);
    $('#total').text(_total);
}

function reiniciarCupon(){
    $('input[name=cupon_discount]').val('0');
    $('input[name=cupon_type]').val('0');
    $('input[name=discount]').val('0');
    $('#cupon_text').text('');
    $('#cupon_value').text('$0.00');
    $('input[name="cupon"]').val('');
}

function applyCupon(){
    let _cupon = $('input[name="cupon"]').val(), _btn = $('.apply-cupon'), _cupon_dis = $('input[name=cupon_discount]'), _cupon_type = $('input[name=cupon_type]'), _discount = $('input[name="discount"]'), _subtotal = $('input[name="subtotal"]').val(), _id_package = $('select[name="id_package"]').val(), _id_customer = $('select[name="id_customer"]').val();
    if(_id_package != 0){

        if(_cupon != ''){
            _btn.prop('disabled', true);
            $.post(_PATH+'admin/cupon/aplicar', {cupon:_cupon, total:_subtotal, id_package:_id_package, id_customer:_id_customer}, function(response){
                _btn.prop('disabled', false);
                _cupon_dis.val(response.cupon_discount);
                _cupon_type.val(response.cupon_type);
                _discount.val(response.discount);
                $('#cupon_text').text(response.show_text);
                $('#cupon_value').text(response.discount_text);
                M.toast({html: response.msg});
                calcularTotal();
            });
        }else{
            M.toast({html: 'Complete el campo'});
            $('input[name="cupon"]').focus();
        }
    }else{
        M.toast({html: 'Selecciona un paquete para continuar'});
    }

}


