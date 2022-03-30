function imprimirFormula(id) {
    var form = document.createElement('form');
    form.method = 'post';
    form.action = '/funciones/imprimir.formula.php';
    form.target = '_blank';

    var html_med = '';
    var meds = document.getElementById(id).getElementsByTagName('table')[0].rows;
    for (var m = 0, med; med = meds[m]; m++) {
        html_med += `
            <table class="medicamento">
            <tr style="font-weight: 600;">
            <th rowspan=2 style="vertical-align: top; width: 10%;">${med.getElementsByTagName('th')[0].textContent}</th>
            <td>${med.getElementsByClassName('medicamentoTitulo')[0].textContent}</td>
            <td style="width: 10%;">${med.getElementsByClassName('medicamentoCantidad')[0].textContent}</td>
            </tr><tr>
            <td colspan=2>${med.getElementsByClassName('medicamentoIndicaciones')[0].innerHTML}</td>
            </tr></table>`;
    }

    add_input(form, 'html_med', html_med);
    add_input(form, 'nombre', dat['nombre']);
    add_input(form, 'id', dat['id']);
    add_input(form, 'edad', dat['edad_genero_gs'].split(' / ')[0]);
    add_input(form, 'eps', dat['eps']);
    add_input(form, 'profesional', dat['profesional']);
    add_input(form, 'especialidad', dat['especialidad']);
    add_input(form, 'registro', dat['registro']);
    add_input(form, 'fechaatencion', dat['fechaatencion'].split(' ')[0]);

    document.body.appendChild(form);
    form.submit();

    document.body.removeChild(form);
}

function add_input(form, nombre, valor) {
    var inp = document.createElement('input');
    inp.type = 'hidden';
    inp.name = nombre;
    inp.value = valor;
    form.appendChild(inp);
}

function imprimirFormula_bk(id) {
    var html_med = '';
    var meds = document.getElementById(id).getElementsByTagName('table')[0].rows;
    for (var m = 0, med; med = meds[m]; m++) {
        html_med += `
            <table class="medicamento">
            <tr style="font-weight: 600;">
            <th rowspan=2 style="vertical-align: top; width: 10%;">${med.getElementsByTagName('th')[0].textContent}</th>
            <td>${med.getElementsByClassName('medicamentoTitulo')[0].textContent}</td>
            <td style="width: 10%;">${med.getElementsByClassName('medicamentoCantidad')[0].textContent}</td>
            </tr><tr>
            <td colspan=2>${med.getElementsByClassName('medicamentoIndicaciones')[0].innerHTML}</td>
            </tr></table>`;
    }

    var win = popupWindow("", "Imprimir F&oacute;rmula", window, 1, 1);
    win.document.write(`
        <html>
            <head>
                <title>Imprimir Atenci&oacute;n</title>
                <link rel="stylesheet" href="/css/formula.print.css">
            </head>
            <body onload="window.print();">
                <div class="header">
                    <table>
                        <tr>
                            <td rowspan=2><img src="" alt="IPS" id="imgIPS" /></td>
                            <td>${parent.dat['ips']}</td>
                            <td rowspan=2><table class="">
                                <tr>
                                    <th colspan=2>Paciente</th>
                                    <th>Fecha</th>
                                </tr>
                                <tr>
                                    <td colspan=2>${parent.dat['nombre']}</td>
                                    <td>${parent.dat['fechaatencion'].split(' ')[0]}</td>
                                </tr>
                                <tr>
                                    <th>Documento</th>
                                    <th>Edad</th>
                                    <th>Aseguradora</th>
                                </tr>
                                <tr>
                                    <td>${parent.dat['id']}</td>
                                    <td>${parent.dat['edad_genero_gs'].split(' / ')[0]}</td>
                                    <td>${parent.dat['eps']}</td>
                                </tr>
                            </table></td>
                        </tr>
                        <tr>
                            <td>Info de la IPS</td>
                        </tr>
                    </table>
                </div>
                <div class="footer">
                    <table>
                        <tr>
                            <td colspan=2>
                                Firmado electr&oacute;nicamente
                            </td>
                        </tr>
                        <tr>
                            <td><img src="" alt="Firma Electronica" id="imgFirma" /></td>
                            <td>
                                ${parent.dat['profesional']}<br />
                                ${parent.dat['especialidad']}<br />
                                ${parent.dat['registro']}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="formula">${html_med}</div>
            </body>
        </html>`);
    win.document.close();
    win.focus();
    setTimeout(function() { win.print(); win.close(); }, 750);
}

function popupWindow(url, windowName, win, w, h) {
    const y = win.top.outerHeight / 2 + win.top.screenY - ( h / 2);
    const x = win.top.outerWidth / 2 + win.top.screenX - ( w / 2);
    return win.open(url, windowName, `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`);
}

function agregarMedicamento(tipo_atencion, formulaId) {
    var medId = 'medicamento_' + Date.now();
    var tabla = document.getElementById(formulaId).getElementsByTagName('table')[0];

    var tbody;
    if (tabla.getElementsByTagName('tbody').length > 0 ) {
        tbody = tabla.getElementsByTagName('tbody')[0];
    }
    else {
        tbody = document.createElement('tbody');
        tabla.appendChild(tbody);
    }

    var html = `<th></th>
    <td class='medicamentoDesc'>
        <div class='medicamentoTitulo'>
            <label>Medicamento / Presentaci&oacute;n:</label>
            <input type='text' name='datos[${tipo_atencion}][${formulaId}][${medId}][titulo]' />
        </div>
        <div class='medicamentoCantidad'>
            <label>Cantidad:</label>
            <input type='text' name='datos[${tipo_atencion}][${formulaId}][${medId}][cantidad]' />
        </div>
        <div class='medicamentoIndicaciones'>
            <label><br />Indicaciones:</label>
            <textarea name='datos[${tipo_atencion}][${formulaId}][${medId}][indicaciones]' rows='2'></textarea>
        </div>
    </td>
    <th class='medicamentoQuitar'><img src='/img/trash.png' onclick="quitarMedicamento('${formulaId}', '${medId}');"/></th>`;

    var newRow = document.createElement("tr");
    newRow.id = medId;
    newRow.setAttribute('class', 'medicamento');
    newRow.innerHTML = html;
    tbody.appendChild(newRow);

    enumerarMedicamentos(formulaId);
}

function quitarMedicamento(formulaId, medId) {
    var indice = document.getElementById(medId).cells[0].textContent.replace(')', '');
    parent.mostrarModal(
        `¿Desea eliminar el medicamento #${indice} de la f&oacute;rmula?`,
        `var medicamento = document.getElementById('obj').contentDocument.getElementById('${medId}');
            medicamento.parentNode.removeChild(medicamento);
            document.getElementById('obj').contentWindow.enumerarMedicamentos('${formulaId}');`,
        'Quitar medicamento',
        'Si',
        'No'
    );
}

function enumerarMedicamentos(formulaId) {
    var tabla = document.getElementById(formulaId).getElementsByTagName('table')[0];
    for (var i = 0, row; row = tabla.rows[i]; i++) {
        row.cells[0].textContent = (i + 1) + ')';
    }
}