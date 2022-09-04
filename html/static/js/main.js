$.extend({
  confirm: (titulo, mensaje, texto_si, funcion_si, texto_no, cerrar=true) => {
    $('<div></div>').dialog({
      // Remove the closing 'X' from the dialog
      open: function(event, ui) { $('.ui-dialog-titlebar-close').hide(); },
      width: 400,
      buttons: [{
        text: texto_si,
        click: function() {
          funcion_si();
          if (cerrar) $(this).dialog('close');
        }
      },
      {
        text: texto_no,
        click: function() {
          $(this).dialog('close');
        }
      }],
      close: (event, ui) => $(this).remove(),
      resizable: false,
      title: titulo,
      modal: true
    }).html(mensaje);
  }
});

$.extend({
  alert: (titulo, mensaje, texto_ok) => {
    $('<div></div>').dialog({
      // Remove the closing 'X' from the dialog
      open: function(event, ui) { $('.ui-dialog-titlebar-close').hide(); },
      width: 400,
      buttons: [{
        text: texto_ok,
        click: function() {
          $(this).dialog('close');
        }
      }],
      close: (event, ui) => $(this).remove(),
      resizable: false,
      title: titulo,
      modal: true
    }).html(mensaje);
  }
});

$.extend({
  message: (message, title = null) => {
    title = title ? `<div class="--message-title">${title}</div>` : '';
    $('body').append($(`
      <div id="message">
        ${title}
        <div class="--message-body">${message}</div>
      </div>`));
    setTimeout(() => {
      $('#message').remove()
    }, 5000);
  }
});