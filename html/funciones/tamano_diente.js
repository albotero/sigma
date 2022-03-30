const dientes_Sup = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
const dientes_Inf = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];

const ancho_sup = [55, 56, 57, 43, 47, 41, 42, 50, 50, 42, 41, 47, 43, 57, 56, 55];
const ancho_inf = [65, 60, 64, 45, 41, 37, 37, 35, 35, 37, 37, 41, 45, 64, 60, 65];

const centro_sup = [10, 31, 53, 73, 90, 107, 123, 141, 160, 177, 194, 211, 228, 248.5, 270.5, 291.5];
const centro_inf = [12, 36, 60, 81, 98, 113, 127, 141, 154, 168.5, 182, 197.5, 214.5, 236, 259.5, 283.5];

const bottom_sup = [52, 52, 53, 56, 55, 55, 55, 59, 58, 56, 55, 54, 56, 53.5, 52, 51];
const bottom_inf = [15, 15, 12, 8.5, 8.5, 7, 9, 9, 9, 9, 7, 8.5, 9, 12, 15, 15];

// Ancho total = 782 / 768


const rows_Sup = ["", "IMPLANTE", "VITALIDAD", "FURCA", "MOVILIDAD", "PLACA", "SUPURACIÓN",
    "SANGRADO", "L.M.G", "N.I.", "SONDAJE", "MARGEN", "VESTIBULAR", "PALATINO", "MARGEN",
    "SONDAJE", "N.I.", "SUPURACIÓN", "SANGRADO", "PLACA"];
const rows_Inf = ["", "IMPLANTE", "VITALIDAD", "FURCA", "MOVILIDAD", "PLACA", "SUPURACIÓN",
    "SANGRADO", "L.M.G", "N.I.", "SONDAJE", "MARGEN", "LINGUAL", "VESTIBULAR", "MARGEN",
    "SONDAJE", "N.I.", "L.M.G", "SUPURACIÓN", "SANGRADO", "PLACA"];

// Diente / borde-izq front / borde-der tras / borde-izq front / borde-der tras
// -17 a +5
const margen_dientes = [
    [
        // 18
        [12, 12, 12, 12, 12, 12, 12, 11, 11, 10, 10, 9, 9, 9, 9, 8, 8, 8, 7, 4, 1, 1, 2],
        [33, 33, 33, 33, 33, 33, 35, 38, 41, 42, 43, 44, 45, 45, 45, 46, 46, 47, 50, 52, 54, 54, 55],
        [10, 10, 10, 10, 10, 10, 10, 7, 6, 6, 6, 6, 6, 5, 6, 6, 6, 5, 3, 1, 1, 2, 9],
        [28, 28, 28, 28, 28, 28, 31, 34, 37, 40, 42, 43, 44, 45, 45, 45, 45, 46, 49, 53, 53, 56, 51]
    ],
    [
        // 17
        [12, 12, 12, 12, 12, 12, 12, 11, 11, 10, 10, 9, 9, 9, 9, 8, 8, 8, 5, 3, 1, 1, 1],
        [33, 33, 33, 33, 33, 33, 35, 38, 41, 43, 44, 45, 46, 47, 46, 47, 46, 47, 50, 52, 54, 56, 55],
        [10, 10, 10, 10, 10, 10, 9, 8, 7, 7, 7, 7, 7, 6, 7, 7, 7, 6, 6, 4, 1, 1, 3],
        [28, 28, 28, 28, 28, 30, 32, 34, 37, 39, 41, 43, 44, 43, 45, 45, 45, 46, 48, 52, 55, 56, 56]
    ],
    [
        // 16
        [8, 8, 8, 8, 8, 8, 7, 6, 5, 5, 5, 5, 5, 5, 5, 5, 5, 4, 3, 2, 1, 1, 1],
        [42, 42, 42, 42, 42, 43, 45, 47, 48, 49, 50, 52, 52, 52, 52, 52, 52, 52, 54, 54, 55, 56, 55],
        [10, 10, 10, 10, 10, 10, 8, 7, 6, 8, 8, 8, 8, 8, 7, 7, 5, 4, 4, 2, 1, 1, 1],
        [37, 37, 37, 37, 37, 40, 43, 43, 45, 46, 48, 48, 48, 48, 47, 47, 47, 48, 49, 52, 55, 56, 58]
    ],
    [
        // 15
        [16, 16, 16, 16, 16, 16, 16, 16, 15, 14, 13, 12, 12, 12, 11, 11, 10, 9, 7, 4, 3, 1, 1],
        [28, 28, 28, 28, 28, 28, 28, 29, 30, 30, 31, 32, 32, 32, 33, 34, 35, 36, 37, 40, 40, 42, 43],
        [11, 11, 11, 11, 11, 11, 11, 10, 9, 9, 8, 8, 8, 8, 7, 7, 7, 7, 6, 4, 2, 0, 1],
        [24, 24, 24, 24, 24, 24, 24, 24, 26, 26, 28, 28, 30, 30, 32, 32, 33, 34, 36, 38, 40, 43, 43]
    ],
    [
        // 14
        [13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 12, 12, 12, 11, 11, 10, 9, 7, 5, 3, 0, 2],
        [31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 32, 32, 32, 33, 34, 35, 36, 39, 41, 45, 48, 44],
        [13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 12, 13, 13, 13, 13, 12, 10, 8, 7, 4, 2, 2],
        [31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 31, 32, 33, 33, 34, 35, 36, 37, 39, 40, 43, 46, 45]
    ],
    [
        // 13
        [14, 14, 14, 13, 11, 9, 8, 8, 7, 7, 7, 6, 6, 6, 6, 6, 5, 5, 5, 5, 3, 0, 1],
        [25, 25, 25, 24, 24, 23, 23, 23, 23, 23, 23, 23, 25, 25, 27, 29, 31, 33, 35, 37, 39, 41, 41],
        [13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 12, 11, 11, 11, 10, 10, 10, 8, 7, 5, 3, 0, 2],
        [23, 23, 23, 23, 24, 24, 25, 26, 27, 28, 29, 31, 31, 32, 32, 33, 34, 34, 36, 38, 40, 41, 40]
    ],
    [
        // 12
        [17, 17, 17, 17, 17, 17, 18, 19, 17, 17, 15, 14, 13, 13, 12, 12, 11, 10, 9, 7, 5, 3, 1],
        [29, 29, 29, 29, 29, 29, 31, 32, 33, 34, 34, 35, 35, 35, 35, 34, 35, 36, 38, 38, 39, 41, 41],
        [9, 9, 9, 9, 9, 9, 9, 10, 10, 10, 10, 10, 10, 10, 10, 9, 9, 7, 5, 3, 1, 0, 0],
        [23, 23, 23, 23, 24, 24, 25, 25, 26, 27, 28, 30, 30, 30, 30, 30, 31, 33, 34, 36, 38, 40, 41]
    ],
    [
        // 11
        [21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 20, 18, 17, 15, 14, 14, 14, 13, 11, 8, 6, 4, 3],
        [32, 32, 32, 32, 32, 32, 34, 36, 37, 38, 40, 40, 41, 40, 41, 41, 41, 41, 41, 42, 43, 45, 47],
        [10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 8, 6, 6, 6, 6, 6, 6, 6, 5, 3, 1, 1, 2],
        [26, 26, 26, 26, 26, 26, 26, 26, 27, 29, 31, 34, 35, 36, 37, 38, 38, 39, 39, 41, 43, 45, 47]
    ],
    [
        // 48
        [6, 6, 6, 6, 6, 6, 4, 2, 2, 3, 4, 6, 8, 9, 11, 11, 8, 4, 3, 1, 0, 2, 9],
        [32, 32, 32, 32, 32, 32, 34, 36, 37, 41, 44, 48, 51, 53, 54, 53, 54, 57, 59, 63, 65, 64, 57],
        [6, 6, 6, 6, 6, 6, 4, 2, 2, 3, 3, 5, 7, 9, 11, 11, 8, 4, 3, 1, 0, 1, 6],
        [32, 32, 32, 32, 32, 32, 34, 36, 37, 41, 45, 49, 52, 53, 54, 53, 54, 57, 59, 63, 65, 65, 60]
    ],
    [
        // 47
        [7, 7, 7, 7, 7, 7, 6, 6, 6, 7, 7, 8, 9, 8, 9, 9, 8, 5, 3, 1, 0, 2, 9],
        [35, 35, 35, 35, 35, 35, 40, 44, 47, 49, 48, 49, 48, 49, 50, 50, 52, 53, 56, 58, 60, 58, 52],
        [6, 6, 6, 6, 6, 6, 6, 6, 6, 7, 8, 8, 10, 11, 11, 11, 9, 7, 5, 2, 0, 1, 8],
        [34, 34, 34, 34, 34, 34, 39, 43, 46, 48, 48, 49, 49, 48, 49, 49, 51, 53, 56, 58, 60, 59, 55]
    ],
    [
        // 46
        [6, 6, 6, 6, 6, 6, 4, 2, 2, 3, 6, 8, 10, 11, 12, 12, 11, 10, 8, 5, 2, 0, 2],
        [42, 42, 42, 42, 42, 42, 42, 46, 48, 49, 50, 51, 53, 52, 53, 52, 52, 55, 59, 63, 63, 64, 64],
        [18, 18, 18, 18, 18, 15, 12, 12, 12, 12, 12, 12, 12, 12, 12, 13, 12, 10, 7, 4, 2, 0, 2],
        [52, 52, 52, 52, 52, 54, 56, 58, 59, 60, 60, 59, 59, 58, 57, 56, 55, 56, 59, 63, 65, 65, 61]
    ],
    [
        // 45
        [16, 16, 16, 16, 16, 15, 15, 15, 15, 15, 14, 14, 14, 13, 13, 12, 12, 11, 9, 5, 2, 0, 1],
        [27, 27, 27, 27, 27, 27, 28, 29, 29, 30, 30, 31, 31, 32, 33, 33, 33, 34, 36, 40, 43, 46, 42],
        [16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 14, 10, 5, 1, 0, 6],
        [28, 28, 28, 28, 28, 28, 29, 28, 30, 29, 30, 31, 31, 32, 32, 33, 34, 35, 38, 41, 43, 45, 42]
    ],
    [
        // 44
        [14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 12, 12, 12, 11, 11, 10, 10, 8, 6, 4, 2, 0, 1],
        [24, 24, 24, 24, 24, 24, 25, 26, 26, 27, 27, 28, 29, 29, 30, 30, 30, 32, 34, 38, 40, 42, 39],
        [13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 12, 13, 11, 10, 6, 3, 1, 1],
        [28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 29, 29, 30, 30, 31, 31, 30, 31, 34, 38, 40, 40]
    ],
    [
        // 43
        [13, 13, 13, 13, 13, 13, 13, 13, 13, 14, 14, 13, 13, 12, 11, 11, 10, 9, 8, 6, 4, 3, 1],
        [24, 24, 24, 24, 24, 24, 25, 26, 26, 27, 27, 26, 26, 26, 26, 26, 26, 27, 28, 30, 32, 34, 36],
        [13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 12, 11, 11, 10, 10, 9, 9, 6, 3, 1, 1, 1],
        [26, 26, 26, 26, 26, 26, 27, 28, 28, 28, 28, 28, 28, 28, 29, 29, 29, 29, 29, 31, 33, 35, 36]
    ],
    [
        // 42
        [9, 9, 9, 9, 9, 9, 10, 11, 12, 12, 12, 11, 11, 10, 9, 9, 8, 7, 6, 5, 4, 3, 1],
        [21, 21, 21, 21, 21, 21, 21, 21, 21, 22, 22, 23, 23, 24, 24, 25, 25, 26, 28, 30, 32, 34, 36],
        [17, 17, 17, 17, 17, 17, 18, 18, 18, 17, 16, 15, 14, 13, 12, 11, 10, 9, 6, 3, 1, 1, 1],
        [28, 28, 28, 28, 28, 28, 28, 28, 29, 30, 30, 30, 30, 30, 30, 29, 29, 29, 29, 31, 33, 35, 36]
    ],
    [
        // 41
        [9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 8, 8, 7, 6, 5, 4, 3, 1],
        [21, 21, 21, 21, 21, 21, 21, 21, 21, 22, 22, 23, 23, 24, 24, 25, 25, 26, 28, 30, 32, 34, 36],
        [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 11, 12, 10, 9, 8, 7, 5, 3, 2, 1, 1],
        [22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 23, 23, 23, 24, 25, 27, 29, 31, 33, 35, 36]
    ]
];

function coord_furca(propiedad, diente) {
    var res = [null, null, null];

    switch (diente) {
        case 18:
            if (propiedad == 'V') res = ['canvas_Sup_12', 10, 28];
            if (propiedad == 'DP') res = ['canvas_Sup_13', 6, 13];
            if (propiedad == 'MP') res = ['canvas_Sup_13', 12, 13];
            break;
        case 17:
            if (propiedad == 'V') res = ['canvas_Sup_12', 32, 29];
            if (propiedad == 'DP') res = ['canvas_Sup_13', 27, 12];
            if (propiedad == 'MP') res = ['canvas_Sup_13', 33, 12];
            break;
        case 16:
            if (propiedad == 'V') res = ['canvas_Sup_12', 54, 28];
            if (propiedad == 'DP') res = ['canvas_Sup_13', 50, 10];
            if (propiedad == 'MP') res = ['canvas_Sup_13', 54, 10];
            break;
        case 14:
            if (propiedad == 'M') res = ['canvas_Sup_12', 87, 14];
            if (propiedad == 'D') res = ['canvas_Sup_13', 92, 16];
            break;
        case 24:
            if (propiedad == 'M') res = ['canvas_Sup_12', 214, 14];
            if (propiedad == 'D') res = ['canvas_Sup_13', 209, 16];
            break;
        case 26:
            if (propiedad == 'V') res = ['canvas_Sup_12', 248, 28];
            if (propiedad == 'DP') res = ['canvas_Sup_13', 251, 10];
            if (propiedad == 'MP') res = ['canvas_Sup_13', 247, 10];
            break;
        case 27:
            if (propiedad == 'V') res = ['canvas_Sup_12', 269, 29];
            if (propiedad == 'DP') res = ['canvas_Sup_13', 274, 12];
            if (propiedad == 'MP') res = ['canvas_Sup_13', 269, 12];
            break;
        case 28:
            if (propiedad == 'V') res = ['canvas_Sup_12', 291, 28];
            if (propiedad == 'DP') res = ['canvas_Sup_13', 296, 13];
            if (propiedad == 'MP') res = ['canvas_Sup_13', 291, 13];
            break;
        case 48:
            if (propiedad == 'L') res = ['canvas_Inf_12', 11, 35];
            if (propiedad == 'V') res = ['canvas_Inf_13', 11, 35];
            break;
        case 47:
            if (propiedad == 'L') res = ['canvas_Inf_12', 37, 35];
            if (propiedad == 'V') res = ['canvas_Inf_13', 37, 35];
            break;
        case 46:
            if (propiedad == 'L') res = ['canvas_Inf_12', 59, 30];
            if (propiedad == 'V') res = ['canvas_Inf_13', 62, 33];
            break;
        case 36:
            if (propiedad == 'L') res = ['canvas_Inf_12', 237, 30];
            if (propiedad == 'V') res = ['canvas_Inf_13', 234, 33];
            break;
        case 37:
            if (propiedad == 'L') res = ['canvas_Inf_12', 259, 35];
            if (propiedad == 'V') res = ['canvas_Inf_13', 259, 35];
            break;
        case 38:
            if (propiedad == 'L') res = ['canvas_Inf_12', 285, 35];
            if (propiedad == 'V') res = ['canvas_Inf_13', 285, 35];
            break;
    }

    return res;
}

function get_margen_diente(diente, tipo, val_y, funcion) {
    // var area = (diente < 30) ? 'Sup' : 'Inf';
    // var lblImplante = document.getElementById('lbl_' & area & '_' & diente & '_tipo1');
    var indice, c;

    if (diente >= 11 && diente <= 18) {
        indice = 18 - diente;
        c = 19 - diente;
    } else if (diente >= 21 && diente <= 28) {
        indice = 28 - diente;
        c = diente - 12;
    } else if (diente >= 31 && diente <= 38) {
        indice = 46 - diente;
        c = diente - 22;
    } else if (diente >= 41 && diente <= 48) {
        indice = 56 - diente;
        c = 49 - diente;
    }

    var aa = (funcion == 'l') ? 0 : 1;
    var bb = (funcion == 'l') ? 1 : 0;
    var ancho = (diente < 30) ? ancho_sup[c - 1] : ancho_inf[c - 1];
    if (c <= 8) {
        return margen_dientes[indice][aa + (tipo - 12) * 2][17 + Number(val_y)];
    } else {
        return ancho - margen_dientes[indice][bb + (tipo - 12) * 2][17 + Number(val_y)];
    }
}

function get_left_diente(diente, tipo, val_y) {
    var anchos = (diente < 30) ? ancho_sup : ancho_inf;
    var dientes = (diente < 30) ? dientes_Sup : dientes_Inf;
    var cont = 0;

    for (var i = 0; i < dientes.length; i++) {
        if (diente == dientes[i]) {
            // izq de la imagen si valor_y no está declarado
            // izq del diente en el valor_y si está declarado
            if (val_y == undefined) {
                return cont / 2.6;
            } else {
                return (cont + get_margen_diente(diente, tipo, val_y, 'l')) / 2.6;
            }
        } else {
            cont += anchos[i];
        }
    }

    return -1;
}

function get_right_diente(diente, tipo, val_y) {
    var anchos = (diente < 30) ? ancho_sup : ancho_inf;
    var dientes = (diente < 30) ? dientes_Sup : dientes_Inf;
    var cont = 0;

    for (var i = 0; i < dientes.length; i++) {
        if (diente == dientes[i]) {
            // ancho de la imagen si valor_y no está declarado
            // ancho del diente en el valor_y si está declarado
            if (val_y == undefined) {
                return (cont + anchos[i]) / 2.6;
            } else {
                return (cont + get_margen_diente(diente, tipo, val_y, 'r')) / 2.6;
            }
        } else {
            cont += anchos[i];
        }
    }

    return -1;
}

function get_centro_diente(diente) {
    var centros = (diente < 30) ? centro_sup : centro_inf;
    var dientes = (diente < 30) ? dientes_Sup : dientes_Inf;

    for (var i = 0; i < dientes.length; i++) {
        if (diente == dientes[i]) {
            return centros[i];
        }
    }

    return -1;
}

function get_bottom_diente(diente) {
    var bottoms = (diente < 30) ? bottom_sup : bottom_inf;
    var dientes = (diente < 30) ? dientes_Sup : dientes_Inf;

    for (var i = 0; i < dientes.length; i++) {
        if (diente == dientes[i]) {
            return bottoms[i];
        }
    }

    return -1;
}