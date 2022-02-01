import alertify from 'alertifyjs';

var waitMoment = () =>{ alertify.alert('Espere un momento porfavor...').set({'frameless': true, 'closable': false, 'movable': false}); }
var removeAlert = () =>{ alertify.closeAll(); }

export { waitMoment, removeAlert, alertify}