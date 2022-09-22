
var _hcAbierta = false;
var _atencionActual = 0;
var _tempAtenciones = new Map();

function cargar_hc(consecutivo, carpeta, estado) {
    document.getElementById('roller').style.display = 'block';

    if (estado != 'Firmado') _hcAbierta = true;
    preguntar();

    // Antes de cargar un nuevo elemento, guarda en la variable temp el consecutivo
    if (_atencionActual > 0) {
        _tempAtenciones.set(_atencionActual, document.getElementById('obj').contentDocument.body);
    }

    // Cuando va a cargar la historia, se fija si existe temp en el consecutivo y lo carga
    _atencionActual = parseInt(consecutivo);
    document.getElementById('historia').innerHTML = "<iframe src='/hc/atencion/cargar.hc.php?d=" + carpeta + "&c="
    + _atencionActual + "' width='100%' height='100%' style='overflow:auto;' id='obj'></iframe>";
    var obj = document.getElementById('obj');
    obj.onload = function() {
        if (_tempAtenciones.has(_atencionActual)) {
            obj.contentDocument.body = _tempAtenciones.get(_atencionActual);
        }
        // Actualiza los items del menú de Anexos
        if (obj.contentDocument.forms[0]) {
            var d = obj.contentDocument.getElementsByName('d')[0].value;
            menu_anexos(d);
        }
        parent.document.getElementById('roller').style.display = 'none';
    };
}

function preguntar() {
    // onbeforeunload: Si se va a salir de la página y hay una atención cargada pregunta
    if (_hcAbierta) return '';
}

function info_atencion(datos) {
    var encabezado = document.getElementById('encabezado');

    // Caja: Datos del paciente
    encabezado.innerHTML = `
    <div class='cajaenc'>
        <span class='titulo'>${datos['nombre']}</span><br />
        <span class='subtitulo'>Identificaci&oacute;n: ${datos['id']}<br />${datos['edad_genero_gs']}</span>
    </div>`;
    
    if (datos['consecutivo']) {
        // Caja: Atención seleccionada
        encabezado.innerHTML += `
        <div class='cajaenc'>
            <span class='titulo'>${datos['tipoatencion']}</span><br />
            <span class='subtitulo'>
                Consecutivo: ${datos['consecutivo']}<br />
                ${datos['fechaatencion']}<br />
                Estado: ${datos['estadoatencion']}
            </span>
        </div>`;
    }

    if (datos['eps']) {
        // Caja: EPS
        var afiliacion = datos['afiliacion'] ? `Afiliaci&oacute;n: ${datos['afiliacion']}` : '';
        encabezado.innerHTML += `
        <div class='cajaenc'>
            <span class='titulo'>${datos['eps']}</span><br />
            <span class='subtitulo'>${afiliacion}</span>
        </div>`;
    }

    if (datos['alerta']) {
        // Caja: Alerta
        encabezado.innerHTML += `
        <div class='cajaenc' id='cajaAlerta'>
            <span class='titulo'>Alertas:</span><br />
            <span class='subtitulo'>
                ${datos['alerta'].replace(/&#10;/g, "<br />")}
            </span>
        </div>`;
    }

    // Caja: Profesional
    encabezado.innerHTML += `
    <div class='cajaenc'>
        <span class='titulo'>${datos['profesional']}</span><br />
        <span class='subtitulo'>
            ${datos['especialidad']}<br />
            Reg. ${datos['registro']}
        </span>
    </div>`;

    // Si no hay atenciones cargadas, borra el desplegable de Anexos
    if (!datos['consecutivo'] || datos['estadoatencion'] == 'Firmado') {
        menu_anexos();
    }
}

// Funciones de Periodontograma en el Parent
// Son llamadas desde el popup Furca
function botonMenos_Click(txtId) {
    var txt = document.getElementById(txtId);
    switch (txt.value) {
        case 'III': txt.value = 'II';   break;
        case 'II':  txt.value = 'I';    break;
        default:    txt.value = '-';    break;
    }
}

function botonMas_Click(txtId) {
    var txt = document.getElementById(txtId);
    switch (txt.value) {
        case '-':   txt.value = 'I';    break;
        case 'I':   txt.value = 'II';   break;
        case 'II':  txt.value = 'III';  break;
        case 'III': break;
        default:    txt.value = '-';    break;
    }
}

function btnFurcaOk_Click(diente, inputId) {
    var inputFurca = document.getElementById('obj').contentDocument.getElementById(inputId);
    var dato1, dato2, dato3;
    var res = '-';
    switch (diente) {
        case 18: case 17: case 16: case 26: case 27: case 28:
            // Molares superiores            
            dato1 = document.getElementById('Furca_txt0').value;
            if (dato1 != null && dato1 != '-')
                res = 'V' + dato1;
            dato2 = document.getElementById('Furca_txt1').value;
            if (dato2 != null && dato2 != '-')
                res += ' MP' + dato2;
            dato3 = document.getElementById('Furca_txt2').value;
            if (dato3 != null && dato3 != '-')
                res += ' DP' + dato3;
            break;
        case 14: case 24:
            // Primer premolar superior
            dato1 = document.getElementById('Furca_txt0').value;
            if (dato1 != null && dato1 != '-')
                res = 'M' + dato1;
            dato2 = document.getElementById('Furca_txt1').value;
            if (dato2 != null && dato2 != '-')
                res += ' D' + dato2;
            break;
        case 48: case 47: case 46: case 36: case 37: case 38:
            // Molares inferiores
            dato1 = document.getElementById('Furca_txt0').value;
            if (dato1 != null && dato1 != '-')
                res = 'L' + dato1;
            dato2 = document.getElementById('Furca_txt1').value;
            if (dato2 != null && dato2 != '-')
                res += ' V' + dato2;
            break;
    }
    if (res != '-') res = res.replace('-', '');
    inputFurca.value = res;
    document.getElementById('obj').contentWindow.pintar_all();
}