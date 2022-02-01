





if($('#demo-component').length > 0){
 let _color = $('input[name=color]').val();
 $('#demo-component').colorpicker({
     component: '.btn-color-picker',
     format: 'hex'
 });
 $('#demo-component').colorpicker('setValue', _color);

}