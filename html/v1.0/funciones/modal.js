
function toggleModal() {
    modal.classList.toggle("show-modal");
}

function mostrarModal(contenido = '', accion = '', titulo = 'SIGMA', aceptar = 'Aceptar', cancelar = '') {
    var modal = document.getElementById('modal');
    var clase = titulo === 'Alertas' ? ' class="alerta"' : '';
    if (accion) accion += '; ';
    modal.innerHTML = `
    <div${clase}>
        <div class="titulo noseleccion">
            ${titulo}
            <span id="btnModalCerrar" class="cerrar" onclick="toggleModal();">X</span>
        </div>
        <div class="cuerpo">${contenido}</div>
        <div class="pie">
            ${cancelar == '' ? '' : `<input type="reset" class="boton" onclick="toggleModal();" value="${cancelar}" />`}
            <input type="submit" class="boton${cancelar == '' ? '' : ' ok'}" onclick="${accion}toggleModal();" value="${aceptar}" />
        </div>
    </div>`;
    toggleModal();
}

function firma_confirmar() {
    document.getElementById('roller').style.display = 'block';
    var titulo = 'Firmar Atenci&oacute;n';
    var mensaje = `<p>Luego de firmar la historia, ya no podr&aacute; modificarla nuevamente.</p>
                    <p>Si desea guardar cambios sin firmar, haga clic en <i>Volver</i> y luego seleccione la opci&oacute;n <i>Guardar Cambios</i>.</p>`;
    
    mostrarModal(mensaje, `document.getElementById('obj').contentDocument.getElementById('btnFirmar').click()`, titulo, "Firmar", "Volver");
    document.getElementById('roller').style.display = 'none';
}

function url_alerta(tipoid, id, nombre) {
    var alerta = document.getElementById('textareaAlertas').value;
    location.href = `/paciente/actualizar.alertas.php?tipo=${tipoid}&id=${id}`
    + `&nombre=${encodeURIComponent(nombre)}&alerta=${encode_variable(alerta)}`;
}

function encode_variable(str) {
    return encodeURIComponent(escapeHtml(str));
}

function escapeHtml(text) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;',
      "\n": '&#10;',
      "\\": '\\\\\\\\'
    };    
    return text.replace(/[&<>"'\n\\]/g, function(m) { return map[m]; });
  }