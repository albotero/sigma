function getFormData(form) {
    const json = {};
    $.each($(`#${form}`).serializeArray(), function() {
        json[this.name] = this.value || null;
    });
    return json;
}

var build_filter = (patient, items) => {
    args = [];
    for (i of items) {
        args.push(`'${i}':'${patient[i] || ''}'`);
    }
    return `{${args.join(', ')}}`;
};

var socket = io();
var socket_event = (data) => socket.emit('socket_event', data);

var load_history = (filter) => {console.log(filter); socket_event({ 'action': 'load_history', 'filter': filter || getFormData('patient') });}
var new_record = (patient_id, record_type) => socket_event({'action': 'new_record', 'patient_id': patient_id, 'record_type': record_type});
var load_record = (record_id) => socket_event({'action': 'load_record', 'record_id': record_id});
var save_record = (record_id) => socket_event({'action': 'save_record', 'record_id': record_id, 'data': getFormData('record') });
var sign_record = (record_id) => socket_event({'action': 'sign_record', 'record_id': record_id, 'data': getFormData('record') });

var current = {};

socket.on('response_event', (data) => {
switch (data['action']) {
    
    case 'load_history':        
        let html = '';
        if (data['patients']) {
            for (p of data['patients']) {
                html += `
                <div class="--history-patient">
                    <div class="title" onclick="load_history(${ build_filter(p, ['surname', 'lastname', 'id']) })">
                        <div class="name">${ p['surname'] } ${ p['lastname'] }</div>
                        <div class="id">${ p['id'] }</div>
                    </div>`;
                if (p['events']) {
                    for (e of p['events']) {
                        html += `
                        <div class="event">
                            <div class="name">${ e['name'] }</div>
                            <div class="id">${ e['id'] }</div>
                            <div class="time">${ e['time'] }</div>
                            <div class="user">${ e['user'] }</div>
                        </div>`;
                    }
                }
                html += '</div>';
            }
        }
        $('.--history').html(html);
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