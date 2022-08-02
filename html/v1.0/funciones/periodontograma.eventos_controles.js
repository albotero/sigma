var firmados = document.getElementsByClassName('firma');
for (var e = 0; e < firmados.length; e++) {
    deshabilitarElementos(firmados[e], 'th');
    deshabilitarElementos(firmados[e], 'input');
    deshabilitarElementos(firmados[e], 'textarea');
    deshabilitarElementos(firmados[e], 'label');
}

function deshabilitarElementos(padre, tag) {
    var all=padre.getElementsByTagName(tag);
    var inp, i=0;
    while (inp=all[i++]) {
        if (tag == 'input' || tag == 'textarea')
            inp.disabled=true;
        else {
            inp.classList.add('deshab');
            inp.onclick = function() { return false; };
        }
    }
}

function btnTitulo_click(id) {
    var valor = document.getElementById(id);
    valor.value++;
    if (valor.value > 3)
        valor.value = 0;
    pintar_all();
}

function btnIVMP_click(btn, opciones) {
    opciones = opciones.split(',');
    var indice = opciones.indexOf(btn.value) + 1;
    if (indice == 0 || indice == opciones.length) {
        indice = 0;
    }
    btn.value = opciones[indice];
    pintar_all();
}

function btnFurca_click(filas, inputId) {
    var diente = inputId.substring(inputId.indexOf('_') + 1);
    var inicial = document.getElementById(inputId).value.split(" ");
    var html = `
    <style>
        div.filafurca {
            display: flex;
            justify-content: left;
            align-items: center;
            padding-left: 10px;
            width: 100%;
        }
        .btnfurca {
            flex: 1 1 25px;
            height: 25px;
        }
        input[type=text].inputfurca {
            text-align: center;
            flex: 1 1 50px;
            width: 50px;
        }
    </style>
    <table>`;
    for (var f in filas) {
        var valor = '-';
        for (var i in inicial) {
            if (inicial[i].includes(filas[f][1]))
                valor = inicial[i].replace(filas[f][1], '');
        }
        html += `
        <tr><td width='150px' align='right'>${filas[f][0]}</td>
        <td width='150px'>
            <div class='filafurca'>
                <button id='Furca_btn${filas[f][1]}_Menos' type='button' class='btnfurca' onclick=\"botonMenos_Click('Furca_txt${f}');\">-</button>
                <input type='text' id='Furca_txt${f}' class='inputfurca' value='${valor}' readonly />
                <button id='Furca_btn${filas[f][1]}_Mas' type='button' class='btnfurca' onclick=\"botonMas_Click('Furca_txt${f}');\">+</button>
            </div>
        </td></tr>`;
    }
    html += '</table>';
    parent.mostrarModal(html, `btnFurcaOk_Click(${diente}, '${inputId}')`, 'Editar Furca &rArr; Diente ' + diente, 'Aceptar', 'Cancelar');
}