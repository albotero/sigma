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

var load_history = (filter) => socket_event({ 'action': 'load_history', 'filter': filter || getFormData('patient') });
var new_patient = () => socket_event({ 'action': 'new_patient', 'patient': { 'id': $('#patient input[name=id]').val(), 'surname': $('#patient input[name=surname]').val(), 'lastname': $('#patient input[name=lastname]').val() } });
var new_record = (patient_id, record_type) => socket_event({'action': 'new_record', 'patient_id': patient_id, 'record_type': record_type});
var load_record = (record_id) => socket_event({'action': 'load_record', 'record_id': record_id});
var save_record = (record_id) => socket_event({'action': 'save_record', 'record_id': record_id, 'data': getFormData('record') });
var sign_record = (record_id) => socket_event({'action': 'sign_record', 'record_id': record_id, 'data': getFormData('record') });

var _current_ = {};
var _info_ = null;

socket.on('response_event', (data) => {
    switch (data['action']) {
        
        case 'load_history':
        case 'new_patient':
            _current_ = {};
            let html = '';
            if (data['patients']) {
                for (p of data['patients']) {
                    html += `
                    <div class="--history-patient">
                        <div class="title" onclick="load_history(${ build_filter(p, ['id', 'surname', 'lastname']) })">
                            <div class="name">${ p['surname'] } ${ p['lastname'] }</div>
                            <div class="id">${ p['id'] }</div>
                            <div class="new-event" onclick="new_record('${p['id']}', 'Evolución Periodoncia')"></div>
                        </div>`;
                    if (p['events']) {
                        _current_['patient'] = p;
                        for (e of p['events']) {
                            html += `
                            <div class="event" onclick="load_record('${e['id']}')">
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
        case 'load_record':
            // Get form html
            $('.--workarea-content').html(data['html']);
            // Update info
            if (_info_) {
                clearInterval(_info_);
            }
            $('.--clev-info .--info-id').html(data['record_id'].replace('clev-',''));
            $('.--clev-info .--info-time').html(data['time']);
            $('.--clev-info .--info-user').html(data['user']);
            if (data['sign']) {
                $('.--clev-info .--info-save').prop('class', '--info-save --save-signed');
            } else if (data['user'] == _user_) {
                _info_ = setInterval(() => save_record(data['record_id']), 5000);
            }
            break;

        case 'save_record':
            if (data['error']) {
                console.log('error', data['error']);
                $('.--clev-info .--info-save').prop('class', '--info-save --save-error');
            } else {
                $('.--clev-info .--info-save').prop('class', '--info-save --save-saved');
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