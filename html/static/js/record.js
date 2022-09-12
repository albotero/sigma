function updateDisabled() {
    $('.--event-del').prev().removeClass('--disabled');
    $('.--event-add').prev().addClass('--disabled');
}

function handler(element, func) {
    func();
    $(element).change(func);
}

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

var record_id;
var socket = io();
var socket_event = (data) => socket.emit('socket_event', data);

var load_history = (filter) => socket_event({ 'action': 'load_history', 'filter': filter || getFormData('patient') });

var new_patient = () => socket_event({ 'action': 'patient_data_form' });

var cancelPatientData = () => $.confirm(
    'Cancelar',
    `<p>Si cancela el formulario perderá todos los datos que no se hayan guardado.</p>
    <p>¿Desea continuar?</p>`,
    'Salir del formulario',
    () => $('.--workarea-content').html(''),
    'Continuar editando'
);

var savePatientData = () => {
    if ($('#patient-data')[0].reportValidity()) {
        $.confirm(
            'Guardar',
            `<p>Se van a guardar los cambios en la información del paciente.</p>
            <p>¿Desea continuar?</p>`,
            'Guardar',
            () => socket_event({ 'action': 'save_patient', 'data': getFormData('patient-data') }),
            'Cancelar'
        );
    }
}

var new_record = (patient_id, record_type) => $.confirm(
    'Nueva Historia',
    `<p>Se va a crear un nuevo registro. Esta acción no se puede revertir.</p>
    <p>¿Desea continuar?</p>`,
    'Crear',
    () => socket_event({'action': 'new_record', 'patient_id': patient_id, 'record_type': record_type}),
    'Cancelar'
);

var load_record = (element, record_id) => {
    $('.event').removeClass('--event-selected');
    $(element).addClass('--event-selected');
    socket_event({'action': 'load_record', 'record_id': record_id});
};

var save_record = () => socket_event({'action': 'save_record', 'record_id': record_id, 'data': getFormData('record') });

var sign_record = () => $.confirm(
    'Firmar historia',
    `<p>Esta acción no se puede revertir y la historia ya no podrá modificarse más.</p>
    <p>¿Desea continuar?</p>`,
    'Firmar',
    () => socket_event({'action': 'sign_record', 'record_id': record_id, 'data': getFormData('record') }),
    'Cancelar'
);

var add_del_section = (section_id) =>  socket_event({'action': 'add_del_section', 'record_id': record_id, 'section_id': section_id, 'data': getFormData('record')});

var _current_ = {};
var _info_ = null;

socket.on('response_event', (data) => {
    switch (data['action']) {

        case 'patient_data_form':
            // Get form html
            $('.--workarea-content').html(data['html']);
            break;

        case 'save_patient': //No break
            if (data['error']) {
                $.message(data['error'], 'Error al guardar los cambios');
                break;
            }
            $('.--workarea-content').html('');
            $.message('Datos guardados con éxito.');
        
        case 'load_history':
            _current_ = {};
            let html = '';
            if (data['patients']) {
                for (p of data['patients']) {
                    html += `
                    <div class="--history-patient">
                        <div class="title" onclick="load_history(${ build_filter(p, ['id', 'surname', 'lastname']) })">
                            <div class="name">${ p['surname'] } ${ p['lastname'] }</div>
                            <div class="id">${ p['id'] }</div>
                            <div class="new-event tooltip" onclick="new_record('${p['id']}', '${data['user_specialty']}')">
                                <div class="tooltiptext">Agregar nuevo Evento Clínico</div>
                            </div>
                        </div>`;
                    if (p['events']) {
                        _current_['patient'] = p;
                        for (e of p['events']) {
                            html += `
                            <div class="event" onclick="load_record(this, '${e['id']}')">
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

        case 'new_record': //No break
            load_history( { 'id': data['patient_id'] } );

        case 'load_record':
        case 'add_del_section':
            // Get form html
            $('.--workarea-content').html(data['html']);
            // Update info
            record_id = data['record_id'];
            if (_info_) {
                clearInterval(_info_);
            }
            if (!data['sign'] && data['user'] == _user_) {
                _info_ = setInterval(() => save_record(), 5000);
            }
            updateDisabled()
            updateInfoSave(data);
            break;

        case 'save_record':
            if (data['error']) {
                $.message(data['error'], 'Error al guardar los cambios');
            }
            updateInfoSave(data);
            break;

        case 'sign_record':
            if(data['error']) {
                $.message(data['error'], 'Ocurrió un error al firmar la historia');
            } else {
                if (_info_) {
                    clearInterval(_info_);
                }
                $('.--workarea-content').html(data['html']); // get readonly html
                $.message('Se firmó la historia con éxito');
            }
            updateInfoSave(data);
            break;

        default:
            console.log(data);
    }
});

function updateInfoSave(data) {
    var clev_status = 'saved';
    if (data['error']) {
        clev_status = 'error';
    } else if (data['sign']) {
        clev_status = 'signed';
    }
    
    $('.--clev-info .--info-save').prop('class', `--info-save --save-${clev_status}`);
}