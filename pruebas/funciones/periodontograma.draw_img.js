let lista_canvas = [
    'canvas_vestibular', 'canvas_palatino_',
    'canvas_lingual', 'canvas_vestibular_'
];
let dientes_sup = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
let dientes_inf = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
var _ancho;
create_all_canvas();

function area_sup(canvas_ID) {
    return !canvas_ID.includes('lingual') && !canvas_ID.includes('vestibular_');
}

function num_diente(superior, indice) {
    if (superior) {
        if (indice < 8)
            return 18 - indice;
        else
            return 21 - 8 + indice;
    }
    else {
        if (indice < 8)
            return 48 - indice;
        else
            return 31 - 8 + indice;
    }
}

function auto_grow(element) {
    element.style.height = "1px";
    element.style.height = element.scrollHeight + "px";
}

function create_all_canvas() {
    for (var c in lista_canvas) {
        if (!_ancho)
            _ancho = document.getElementById(lista_canvas[c].replace('canvas', 'pnlimg')).clientWidth;
    
        if (!document.contains(document.getElementById(lista_canvas[c])))
            create_canvas(lista_canvas[c]);
    }
    pintar_all();
}

function create_canvas(canvas_ID) {
    //Crear canvas con el ID
    var canvas = document.createElement('canvas');
    var panel_img = document.getElementById(canvas_ID.replace('canvas', 'pnlimg'));

    canvas.id = canvas_ID;
    canvas.className = 'cover_canvas';
    canvas.width = _ancho;
    canvas.height = panel_img.clientHeight;
    canvas.getContext('2d');

    // Agregarlo al panel
    panel_img.appendChild(canvas);
}

function reset_all_canvas() {
    for (var c in lista_canvas) {
        reset_canvas(lista_canvas[c]);
    }
}

function reset_canvas(canvas_ID) {
    var canvas = document.getElementById(canvas_ID);
    var context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height);
}

function pintar_all() {
    reset_all_canvas();
    pintar_all_lineas();

    for (var c in lista_canvas) {
        for (var i = 0; i < 16; i++) {
            var es_sup = lista_canvas[c].replace('canvas_', '').includes('_');
            var panel = es_sup ? 'b' : '';
            var area = area_sup(lista_canvas[c]) ? 'Sup' : 'Inf';
            var diente = num_diente(area == 'Sup', i);

            var pic = document.getElementById(lista_canvas[c].replace('canvas', 'img') + '_' + diente);
            var txtimplante = document.getElementById(`implante_${diente}`);
            var txtmargen = document.getElementById(`margen${es_sup ? '' : '_'}_${diente}`);
            var txtsondaje = document.getElementById(`sondaje${es_sup ? '' : '_'}_${diente}`);
            var txtni = document.getElementById(`ni${es_sup ? '' : '_'}_${diente}`);
            var txtlmg = document.getElementById(`lmg${es_sup ? '' : '_'}_${diente}`);
            var txtfurca = document.getElementById(`furca_${diente}`);
            var btntitulo = document.getElementById(`titulo_${diente}`);

            var x1m, x2m, x3m, ym_ancho, ym, x1s, x2s, x3s, ys_ancho, ys, x1l, x2l, x3l, yl;
            var patt = new RegExp('^-?\\d{1,2} -?\\d{1,2} -?\\d{1,2}$');

            // Cambia la imagen del diente
            var table = document.getElementById('tblPerio' + area);
            for (var r = 1; r < table.rows.length; r++) {
                var cel = (area == 'Sup' ? dientes_sup : dientes_inf).indexOf(diente) + 1;
                if (cel < table.rows[r].cells.length) {
                    var celda = table.rows[r].cells[cel];
                    celda.setAttribute('class', (celda.getAttribute('tag') == `${diente}` && btntitulo.value == 1)? 'mueco' : '');
                }
            }
            if (btntitulo.value == 1) {
                    pic.src = `/img/perio/negro/${area}/${diente}${panel}.png`;
            }
            else {
                if (txtimplante.value == 'Si')
                    pic.src = `/img/perio/implantes/${area}/${diente}${panel}.png`;
                else
                    pic.src = `/img/perio/dientes/${area}/${diente}${panel}.png`;

                if (patt.test(txtmargen.value)) {
                    var margen = txtmargen.value.split(' ');
                    var ym_ancho = margen;

                    x1m = dienteBordeIzq(pic, ym_ancho[0]);
                    x3m = dienteBordeDer(pic, ym_ancho[2]);
                    x2m = (x1m + x3m) / 2;
                    ym = puntos_y(txtmargen.value, lista_canvas[c]);

                    if (patt.test(txtsondaje.value)) {
                        // Nivel de inserción
                        var sondaje = txtsondaje.value.split(" ");
                        var ni_texto = '';
                        for (var n = 0; n <= 2; n++) {
                            ni_texto += Number(margen[n]) - Number(sondaje[n]);
                            ni_texto += (n < 2) ? ' ' : '';
                        }
                        txtni.value = ni_texto;

                        ys_ancho = ni_texto.split(" ");
                        x1s = dienteBordeIzq(pic, ys_ancho[0]);
                        x3s = dienteBordeDer(pic, ys_ancho[2]);
                        x2s = (x1s + x3s) / 2;
                        ys = puntos_y(ni_texto, lista_canvas[c]);

                        // Pintar bolsas
                        for (var v = 0; v <= 2; v++) {
                            if (Number(sondaje[v]) >= 4) {
                                var puntos_bolsas = [];
                                var puntos_ls = getCurvePoints([x1s, ys[0], x2s, ys[1], x3s, ys[2]]);
                                var puntos_lm = getCurvePoints([x1m, ym[0], x2m, ym[1], x3m, ym[2]]);

                                // PUNTOS DE LA LINEA DE SONDAJE
                                for (var w = 0; w < puntos_ls.length - 1; w += 2) {
                                    if ((w > (v * puntos_ls.length) / 3 - 2) && (w < ((v + 1) * puntos_ls.length) / 3 + 2)) {
                                        puntos_bolsas[puntos_bolsas.length] = puntos_ls[w]; // X
                                        puntos_bolsas[puntos_bolsas.length] = puntos_ls[w + 1]; // Y
                                    }
                                }

                                // PUNTOS DE LA DERECHA
                                if (v == 2) {
                                    for (var w = Number(ni_texto.split(' ')[2]) + 1; w < Number(margen[2]); w++) {
                                        puntos_bolsas[puntos_bolsas.length] = dienteBordeDer(pic, w); // X
                                        puntos_bolsas[puntos_bolsas.length] = puntos_y(w + ' ', lista_canvas[c])[0]; // Y
                                    }
                                }

                                // PUNTOS DE LA LINEA DE MARGEN
                                for (var w = puntos_lm.length - 2; w >= 0; w -= 2) {
                                    if ((w > (v * puntos_lm.length) / 3 - 2) && (w < ((v + 1) * puntos_lm.length) / 3 + 2)) {
                                        puntos_bolsas[puntos_bolsas.length] = puntos_lm[w]; // X
                                        puntos_bolsas[puntos_bolsas.length] = puntos_lm[w + 1]; // Y
                                    }
                                }

                                // PUNTOS DE LA IZQUIERDA
                                if (v == 0) {
                                    for (var w = Number(margen[0]) + 1; w > Number(ni_texto.split(' ')[0]); w--) {
                                        puntos_bolsas[puntos_bolsas.length] = dienteBordeIzq(pic, w); // X
                                        puntos_bolsas[puntos_bolsas.length] = puntos_y(w + ' ', lista_canvas[c])[0]; // Y
                                    }
                                }

                                var color_bolsa = (Number(margen[v]) >= 4 && Number(margen[v]) >= Number(sondaje[v])) ? 'red' : 'black';
                                pintar_curva(lista_canvas[c], puntos_bolsas, color_bolsa, color_bolsa);
                            }
                        }

                        // Pintar curva de sondaje
                        pintar_curva(lista_canvas[c],
                            [x1s, ys[0], x2s, ys[1], x3s, ys[2]],
                            'black');
                    }

                    // Pintar curva de margen
                    pintar_curva(lista_canvas[c],
                        [x1m, ym[0], x2m, ym[1], x3m, ym[2]],
                        'red');

                    // L.M.G.
                    if (!isNaN(txtlmg.value) && txtlmg.value != '') {
                        var lmg = Number(txtlmg.value);
                        x1l = dienteBordeIzq(pic, Number(ym_ancho[0]) - lmg);
                        x3l = dienteBordeDer(pic, Number(ym_ancho[2]) - lmg);
                        x2l = (x1l + x3l) / 2;

                        // ***** Si no quiere que siga el recorrido del margen sino tomar solo en cuenta el centro:
                        // ***** Cambia Number(margen[0]) y Number(margen[2]) por Number(margen[1])
                        var margen0 = Number(margen[1]);
                        var margen1 = Number(margen[1]);
                        var margen2 = Number(margen[1]);

                        yl = puntos_y(
                            (margen0 - lmg) + ' ' + (margen1 - lmg) + ' ' + (margen2 - lmg),
                            lista_canvas[c]);

                        // Usar el diente de la izquierda y la derecha, si tienen LMG
                        var x0l = x1l, y0l = yl[0], x4l = x3l, y4l = yl[2];

                        // Obtiene el diente izquierdo si no es columna 1 o si el izquierdo no está oculto o si el izquierdo tiene lmg
                        /*if (c > 1) {
                            var mueco_izq = document.getElementById('btn_' + (c - 1) + '_' + area + '_'
                                + (area == 'Sup' ? dientes_Sup[c - 2] : dientes_Inf[c - 2])).getAttribute('tag') == '1';
                            if (!mueco_izq) {
                                var lmg_izq = document.getElementById('txt_' + (c - 1) + '_' + area + '_' + (area == 'Sup' ? dientes_Sup[c - 2] : dientes_Inf[c - 2])
                                    + '_fila' + ((f == 0) ? 8 : ((area == 'Inf') ? 17 : 0))).value;
                                var margen_izq = document.getElementById('txt_' + (c - 1) + '_' + area + '_' + (area == 'Sup' ? dientes_Sup[c - 2] : dientes_Inf[c - 2])
                                    + '_fila' + ((f == 0) ? 11 : 14));

                                if (!isNaN(lmg_izq) && lmg_izq != '' && patt.test(margen_izq.value)) {
                                    // ***** Si no quiere que siga el recorrido del margen sino tomar solo en cuenta el centro:
                                    // ***** Cambia margen_izq.value.split(' ')[2] por margen_izq.value.split(' ')[1]
                                    var mrg3_izq = margen_izq.value.split(' ')[1];

                                    x0l = get_left_diente(diente, ((f == 0) ? 12 : 13));
                                    y0l = puntos_y(((margen0 - lmg) + (Number(mrg3_izq) - Number(lmg_izq))) / 2 + ' ', area, (f == 0) ? 12 : 13)[0];
                                }
                            }
                        }*/

                        // Obtiene el diente derecho si no es columna 16 o si el derecho no está oculto o si el derecho tiene lmg
                        /*if (c < 16) {
                            var mueco_der = document.getElementById('btn_' + (c + 1) + '_' + area + '_'
                                + (area == 'Sup' ? dientes_Sup[c] : dientes_Inf[c])).getAttribute('tag') == '1';
                            if (!mueco_der) {
                                var lmg_der = document.getElementById('txt_' + (c + 1) + '_' + area + '_' + (area == 'Sup' ? dientes_Sup[c] : dientes_Inf[c])
                                    + '_fila' + ((f == 0) ? 8 : ((area == 'Inf') ? 17 : 0))).value;
                                var margen_der = document.getElementById('txt_' + (c + 1) + '_' + area + '_' + (area == 'Sup' ? dientes_Sup[c] : dientes_Inf[c])
                                    + '_fila' + ((f == 0) ? 11 : 14));

                                if (!isNaN(lmg_der) && lmg_der != '' && patt.test(margen_der.value)) {
                                    // ***** Si no quiere que siga el recorrido del margen sino tomar solo en cuenta el centro:
                                    // ***** Cambia margen_der.value.split(' ')[0] por margen_der.value.split(' ')[1]
                                    var mrg1_der = margen_der.value.split(' ')[1];

                                    x4l = get_right_diente(diente, ((f == 0) ? 12 : 13));
                                    y4l = puntos_y(((margen2 - lmg) + (Number(mrg1_der) - Number(lmg_der))) / 2 + ' ', area, (f == 0) ? 12 : 13)[0];
                                }
                            }
                        }*/

                        // Pintar curva de LMG
                        pintar_curva(lista_canvas[c],
                            [x0l, y0l, x1l, yl[0], x2l, yl[1], x3l, yl[2], x4l, y4l],
                            'green');
                    }
                }

                // Pinta círculos en las furcas
                auto_grow(txtfurca);
                /*if (txtfurca.value.length > 1) {
                    var furca = txtfurca.value.replace(/I/g, '').split(' ');
                    for (var i = 0; i < furca.length; i++) {
                        var coord = coord_furca(furca[i], diente);
                        var circ_canvas_id = coord[0];
                        var circ_x = coord[1];
                        var circ_y = coord[2];
                        pintarCirculo(circ_canvas_id, circ_x, circ_y, 5, 'white', 0.5, 'black');
                    }
                }*/

                // Incluido - Extruido'
                var centro_diente = dienteCentro(pic);
                var y1 = pic.style.bottom;
                var y2 = y1 - 4;
                switch (btntitulo.value) {
                    case '2':
                        // Flecha hacia arriba
                        drawArrow(lista_canvas[c], centro_diente, y2, centro_diente, y1, 'red');
                        break;
                    case '3':
                        // Flecha hacia abajo
                        drawArrow(lista_canvas[c], centro_diente, y1 + 2, centro_diente, y2 + 2, 'red');
                        break;
                }
            }
        }
    }
}

function pintar_all_lineas() {
    for (var c in lista_canvas) {
        pintar_lineas(lista_canvas[c]);
    }
}

function pintar_lineas(canvas_ID) {
    var canvas = document.getElementById(canvas_ID);
    if (canvas) {
        var context = canvas.getContext('2d');

        // Agrega las líneas
        for (var i = 0; i < 17; i++) {
            var x2 = canvas.clientWidth;
            var y = i * canvas.clientHeight / 22;
            if (!area_sup(canvas_ID)) {
                y = canvas.clientHeight - y;
            }

            context.beginPath();
            context.moveTo(0, y);
            context.lineTo(x2, y);
            context.lineWidth = 1;
            context.strokeStyle = '#838383';
            context.stroke();
            context.closePath();
        }
    }
}

function puntos_y(valor, canvas_ID) {
    var canvas = document.getElementById(canvas_ID);
    var y_s = valor.split(' ');
    var y = y_s;
    for (var i = 0; i < y_s.length; i++) {
        y[i] = Number(y_s[i]) * canvas.clientHeight / 22;
        if (!area_sup(canvas_ID))
            y[i] = canvas.clientHeight - y[i];
    }
    return y;
}

function dienteBordeIzq(pic, val_y = null) {
    if (val_y == null)
        return pic.style.left;
    else
        return pic.style.left + val_y;
}

function dienteBordeDer(pic, val_y = null) {
    if (val_y == null)
        return pic.style.right;
    else
        return pic.style.right - val_y;
}

function dienteCentro(pic) {
    return (pic.style.left + pic.style.right) / 2;
}

function pintar_curva(canvas_ID, puntos, color, color_relleno) {
    // puntos ==> [ x1, y1, x2, y2, x3, y3 ]

    var canvas = document.getElementById(canvas_ID);
    if (canvas == null) return;
    var context = canvas.getContext('2d');

    context.beginPath();
    
    drawCurve(context, puntos);

    if (color_relleno != null) {
        context.fillStyle = color_relleno;
        context.fill();
    } else {
        context.lineWidth = 1;
        context.strokeStyle = color;
        context.stroke();
    }

    context.closePath();
}

function drawCurve(ctx, ptsa, tension, isClosed, numOfSegments, showPoints) {

    drawLines(ctx, getCurvePoints(ptsa, tension, isClosed, numOfSegments));

    if (showPoints) {
        for (var i = 0; i < ptsa.length - 1; i += 2)
            ctx.rect(ptsa[i] - 2, ptsa[i + 1] - 2, 4, 4);
    }
}

function drawLines(ctx, pts) {
    ctx.moveTo(pts[0], pts[1]);
    for (var i = 2; i < pts.length - 1; i += 2) ctx.lineTo(pts[i], pts[i + 1]);
}

function pintarCirculo(canvas_ID, x, y, diametro, color_borde, grosor_borde, color_relleno) {
    var canvas = document.getElementById(canvas_ID);
    if (canvas == null) return;
    var context = canvas.getContext('2d');
    
    context.beginPath();
    context.arc(x, y, diametro / 2, 0, 2 * Math.PI);

    context.fillStyle = color_relleno;
    context.fill();
    context.lineWidth = grosor_borde;
    context.strokeStyle = color_borde;
    context.stroke();
}

function drawArrow(canvas_ID, fromx, fromy, tox, toy, color) {
    //variables to be used when creating the arrow
    var c = document.getElementById(canvas_ID);
    var ctx = c.getContext('2d');
    var headlen = 0.75;

    var angle = Math.atan2(toy - fromy, tox - fromx);

    //starting path of the arrow from the start square to the end square and drawing the stroke
    ctx.beginPath();
    ctx.moveTo(fromx, fromy);
    ctx.lineTo(tox, toy);
    ctx.strokeStyle = color;
    ctx.lineWidth = 1.5;
    ctx.stroke();

    //starting a new path from the head of the arrow to one of the sides of the point
    ctx.beginPath();
    ctx.moveTo(tox, toy);
    ctx.lineTo(tox - headlen * Math.cos(angle - Math.PI / 7), toy - headlen * Math.sin(angle - Math.PI / 7));

    //path from the side point of the arrow, to the other side point
    ctx.lineTo(tox - headlen * Math.cos(angle + Math.PI / 7), toy - headlen * Math.sin(angle + Math.PI / 7));

    //path from the side point back to the tip of the arrow, and then again to the opposite side point
    ctx.lineTo(tox, toy);
    ctx.lineTo(tox - headlen * Math.cos(angle - Math.PI / 7), toy - headlen * Math.sin(angle - Math.PI / 7));

    //draws the paths created above
    ctx.strokeStyle = color;
    ctx.lineWidth = 2;
    ctx.stroke();
    ctx.fillStyle = color;
    ctx.fill();
}

function getCurvePoints(pts, tension, isClosed, numOfSegments) {

    // use input value if provided, or use a default value   
    tension = (typeof tension != 'undefined') ? tension : 0.5;
    isClosed = isClosed ? isClosed : false;
    numOfSegments = numOfSegments ? numOfSegments : 16;

    var _pts = [], res = [],    // clone array
        x, y,           // our x,y coords
        t1x, t2x, t1y, t2y, // tension vectors
        c1, c2, c3, c4,     // cardinal points
        st, t, i;       // steps based on num. of segments

    // clone array so we don't change the original
    //
    _pts = pts.slice(0);

    // The algorithm require a previous and next point to the actual point array.
    // Check if we will draw closed or open curve.
    // If closed, copy end points to beginning and first points to end
    // If open, duplicate first points to befinning, end points to end
    if (isClosed) {
        _pts.unshift(pts[pts.length - 1]);
        _pts.unshift(pts[pts.length - 2]);
        _pts.unshift(pts[pts.length - 1]);
        _pts.unshift(pts[pts.length - 2]);
        _pts.push(pts[0]);
        _pts.push(pts[1]);
    }
    else {
        _pts.unshift(pts[1]);   //copy 1. point and insert at beginning
        _pts.unshift(pts[0]);
        _pts.push(pts[pts.length - 2]); //copy last point and append
        _pts.push(pts[pts.length - 1]);
    }

    // ok, lets start..

    // 1. loop goes through point array
    // 2. loop goes through each segment between the 2 pts + 1e point before and after
    for (var i = 2; i < (_pts.length - 4); i += 2) {
        for (var t = 0; t <= numOfSegments; t++) {

            // calc tension vectors
            t1x = (_pts[i + 2] - _pts[i - 2]) * tension;
            t2x = (_pts[i + 4] - _pts[i]) * tension;

            t1y = (_pts[i + 3] - _pts[i - 1]) * tension;
            t2y = (_pts[i + 5] - _pts[i + 1]) * tension;

            // calc step
            st = t / numOfSegments;

            // calc cardinals
            c1 = 2 * Math.pow(st, 3) - 3 * Math.pow(st, 2) + 1;
            c2 = -(2 * Math.pow(st, 3)) + 3 * Math.pow(st, 2);
            c3 = Math.pow(st, 3) - 2 * Math.pow(st, 2) + st;
            c4 = Math.pow(st, 3) - Math.pow(st, 2);

            // calc x and y cords with common control vectors
            x = c1 * _pts[i] + c2 * _pts[i + 2] + c3 * t1x + c4 * t2x;
            y = c1 * _pts[i + 1] + c2 * _pts[i + 3] + c3 * t1y + c4 * t2y;

            //store points in array
            res.push(x);
            res.push(y);

        }
    }

    return res;
}