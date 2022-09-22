var _GRUPOS = {
    "cfle93lrgi": "odontologia",
    "sddke03kr9": "odontologia",
    "e83oe84o3d": "odontologia",
    "ddk895jd74": "anestesia",
    "go84kd94kt": "anestesia",
    "hiw830dk48": "anestesia"
};

function leadZero(numero, size = 0) {
    var s = String(numero);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}

const _difHoras = _horaInicial.getTime() - new Date().getTime();
const _horaOptions = { weekday: 'long', year: 'numeric', month: 'short',
    day: 'numeric', hour: 'numeric', minute: '2-digit', second: '2-digit',
    hour12: true };
function mostrarHora() {
    var _date = new Date();
    _date.setMilliseconds(_date.getMilliseconds() - _difHoras);
    document.getElementById("reloj").textContent = _date.toLocaleString('es-CO', _horaOptions);
    setTimeout(mostrarHora, 1000);
}
mostrarHora();

function timerLogout() {
    var expira;

    var eventos = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
    eventos.forEach(function(nombre) {
        document.addEventListener(nombre, resetTimer, true); 
    });

    function resetTimer() {
        expira = new Date();
        expira.setMilliseconds(expira.getMilliseconds() + 60*60*1000);
    }

    function logout() {
        var ahora = new Date();
        if (expira.getTime() < ahora.getTime()) {
            _hcAbierta = false;
            location.href = '/logout?r=exp';
        }
        setTimeout(logout, 500);
    }

    resetTimer();
    logout();
}
timerLogout();

function nueva_atencion(tipoid, id, nombre, carpeta) {
    document.getElementById('roller').style.display = 'block';
    var form = document.createElement('FORM');
    form.method = 'post';
    form.action = '/hc/atencion/nueva.atencion.php';

    form.appendChild(crearInput('tipoid', tipoid));
    form.appendChild(crearInput('id', id));
    form.appendChild(crearInput('nombre', nombre));
    form.appendChild(crearInput('carpeta', carpeta));

    document.body.appendChild(form);
    form.submit();

    document.body.removeChild(form);
}

function menu_anexos(carpeta = '') {
    var ul = document.getElementById('menuAnexos').getElementsByTagName('ul')[0];
    ul.innerHTML = '';

    if (carpeta) {
        for (var i = 0; i < _ANEXOS.length; i++) {
            (function(i) {
                var obj = document.getElementById('obj').contentDocument;
                var anexo = _ANEXOS[i];
                if (anexo['carpetas'] == '*' || anexo['carpetas'].includes(_GRUPOS[carpeta])) {
                    var li = document.createElement('li');
                    li.appendChild(document.createTextNode(anexo['nombre']));
                    li.addEventListener("click", function() {
                        if (obj.getElementById(anexo['id'])
                            && !anexo['id'].includes('+')) {
                            mostrarModal(
                                `<p>La Atenci&oacute;n actual ya contiene el Anexo <i>${anexo['nombre']}</i></p>`,
                                '', 'Error', 'Aceptar');
                        }
                        else {
                            document.getElementById('roller').style.display = 'block';
                            var id = anexo['id'].replace(/[+%]/g, '');
                            id = indiceAnexo(id, 'formula');
                            // Agrega inputs al formulario
                            var p = document.createElement('input');
                            p.type = 'hidden';
                            p.name = `datos[${_TIPOSATENCION[carpeta]}][${id}]`;
                            p.id = id;
                            obj.forms[0].appendChild(p);
                            // Guarda cambios del formulario en el servidor
                            obj.getElementById('btnRecargar').value = id;
                            obj.getElementById('btnRecargar').click();
                        }
                    });
                    ul.appendChild(li);
                }
            })(i);
        }
    }
}

function indiceAnexo(id, tipo) {
    if (id == tipo) {
        id += '_' + Date.now();
    }
    return id
}

function imprimirAtencion() {
    /*var page = document.getElementById("obj").contentWindow.document.body.innerHTML;
    var win = window.open("", "Imprimir Atenci&oacute;n", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=670,height=450,top=100,left=100");
    win.document.head.innerHTML += '<link rel="stylesheet" href="/css/periodontograma.css">';
    win.document.body.innerHTML = page;
    win.print();*/
}