var socket = io();

var socket_event = (data) => socket.emit('socket_event', data);
var current = {};

socket.on('response_event', (data) => {
switch (data['action']) {
    case 'load_patient':
        $('.--history').html(data['html']);
        break;

    case 'new_record':
        alert('creado: ok');
        // Does not break, so continues with load_record

    case 'load_record':
        $('.--workarea-content').html(data['html']); // get form html
        current['patient'] = data['patient'];
        break;

    case 'save_record':
        if (data['error']) {
            alert('error: ' + data['error']);
        }
        break;

    case 'sign_record':
        alert('firmado: ok');
        $('.--workarea-content').html(data['html']); // get readonly html
        break;

    default:
        console.log(data);
}
});

var load_patient = (patient_id) => socket_event({'action': 'load_patient', 'patient': patient_id});
var new_record = (patient_id, record_type) => socket_event({'action': 'new_record', 'patient_id': patient_id, 'record_type': record_type});
var load_record = (record_id) => socket_event({'action': 'load_record', 'record_id': record_id});
var save_record = (record_id) => socket_event({'action': 'save_record', 'record_id': record_id, 'data': $('#record').serializeArray()});
var sign_record = (record_id) => socket_event({'action': 'sign_record', 'record_id': record_id, 'data': $('#record').serializeArray()});