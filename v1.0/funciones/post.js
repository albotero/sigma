function postPage(tipoid, id, nombre, consecutivo = '') {
    var objForm = document.createElement('FORM');
    objForm.method = 'post';
    objForm.action = '/hc/atencion/';

    objForm.appendChild(crearInput('tipoid', tipoid));
    objForm.appendChild(crearInput('id', id));
    objForm.appendChild(crearInput('nombre', nombre));
    objForm.appendChild(crearInput('consecutivo', consecutivo));

    document.body.appendChild(objForm);
    objForm.submit();

    document.body.removeChild(objForm);
}

function crearInput(nombre, valor) {
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = nombre;
    hiddenField.value = valor;

    return hiddenField;
}