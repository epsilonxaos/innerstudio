import SlimSelect from 'slim-select';
window.axios = require('axios');
import 'slim-select/dist/slimselect.min.css';

new SlimSelect({
 select: '#id_cliente'
});
var mats =new SlimSelect({
    select: '#id_mat'
   });


var clase = new SlimSelect({
 select: '#id_clase',
 onChange: (info) => {
    axios.get(_PATH +'/admin/reservations/mats/'+info.value, )
       .then(function (response) {
        mats.setData(response.data.map((x)=>({"text":x.no_mat,"value":x.id_mat})));
       })
       .catch(function (error) {
        console.log(error);
       })
  }
});
