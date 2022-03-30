<?php
const ANTECEDENTES = [
    'procedimiento' => [
        'dx' => 'diagn&oacute;stico',
        'proc' => 'procedimiento'
    ],
    'ap' => [
        'patol' => 'patol&oacute;gicos',
        'farm' => 'farmacol&oacute;gicos',
        'qx' => 'quir&uacute;rgicos',
        'anest' => 'anest&eacute;sicos',
        'transf' => 'transfusionales',
        'go' => 'ginecobst&eacute;tricos',
        'tox' => 'toxicol&oacute;gicos',
        'otro' => 'otros'
    ],
    'af' => [
        'patol' => 'patol&oacute;gicos',
        'anest' => 'anest&eacute;sicos',
        'otro' => 'otros'
    ]
];

const EF = [
    'cv' => 'cardiovascular',
    'resp' => 'respiratorio',
    'gi' => 'gastrointestinal',
    'neuro' => 'neurol&oacute;gico',
    'musc' => 'musculoesquel&eacute;tico',
    'gu' => 'genitourinario',
    'otro' => 'otro'
];

const SIGNOS = [
    'signosvitales' => [
        'fc' => [
            'titulo' => 'fc',
            'patron' => '\d+',
            'unidades' => 'lat/min'
        ],
        'spo2' => [
            'titulo' => 'spo<sub style="font-size: xx-small;">2</sub>',
            'patron' => '([1-9]?\d|100)',
            'unidades' => '%'
        ],
        'pa' => [
            'titulo' => 'pa',
            'patron' => '\d{2,3}/\d{2,3}',
            'unidades' => 'mmHg',
            'opciones' => "placeholder='PAS/PAD' id='pa' onchange='calcular_pam();' onkeypress='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'"
        ],
        'pam' => [
            'titulo' => 'pam',
            'id' => 'tdPAM',
            'unidades' => 'mmHg'
        ],
        'fr' => [
            'titulo' => 'fr',
            'patron' => '\d+',
            'unidades' => 'resp/min'
        ],
        'peso' => [
            'titulo' => 'peso',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'kg',
            'opciones' => "id='peso' onchange='calcular_imc();' onkeypress='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'"
        ],
        'talla' => [
            'titulo' => 'talla',
            'patron' => '[0-2]([\.,]\d+)?',
            'unidades' => 'm',
            'opciones' => "id='talla' onchange='calcular_imc();' onkeypress='this.onchange();' onpaste='this.onchange();' oninput='this.onchange();'"
        ],
        'imc' => [
            'titulo' => 'imc',
            'id' => 'tdIMC',
            'unidades' => 'kg/m<sup style="font-size: xx-small;">2</sup>'
        ]
    ],
    'viaaerea' => [
        'mallamp' => [
            'titulo' => 'mallampati',
            'tipo' => 'select',
            'opciones' => ['Clase 1', 'Clase 2', 'Clase 3', 'Clase 4', 'No valorable']
        ],
        'protrusion' => [
            'titulo' => 'incisivos',
            'tipo' => 'select',
            'opciones' => ['Normal', 'Protrusi&oacute;n disminuida', 'No valorable']
        ],
        'cervical' => [
            'titulo' => 'mov. cervical',
            'tipo' => 'select',
            'opciones' => ['Normal', 'Alterada', 'No valorable']
        ],
        'apertura' => [
            'titulo' => 'ao',
            'patron' => '*',
            'unidades' => 'cm'
        ],
        'dtm' => [
            'titulo' => 'dtm',
            'patron' => '*',
            'unidades' => 'cm'
        ],
        'dem' => [
            'titulo' => 'dem',
            'patron' => '*',
            'unidades' => 'cm'
        ]
    ],
    'lab' => [
        'hb' => [
            'titulo' => 'hb',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'g/dl'
        ],
        'hto' => [
            'titulo' => 'hto',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => '%'
        ],
        'leu' => [
            'titulo' => 'leu',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => '/mm<sup style="font-size: xx-small;">3</sup>'
        ],
        'plaq' => [
            'titulo' => 'plaq',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => '/mm<sup style="font-size: xx-small;">3</sup>'
        ],
        'bun' => [
            'titulo' => 'bun',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'mg/dl'
        ],
        'cr' => [
            'titulo' => 'cr',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'mg/dl'
        ],
        'na' => [
            'titulo' => 'na<sup style="font-size: xx-small;">+</sup>',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'mEq/L'
        ],
        'k' => [
            'titulo' => 'k<sup style="font-size: xx-small;">+</sup>',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'mEq/L'
        ],
        'cl' => [
            'titulo' => 'cl<sup style="font-size: xx-small;">-</sup>',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'mEq/L'
        ],
        'tp' => [
            'titulo' => 'tp',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'seg'
        ],
        'inr' => [
            'titulo' => 'inr',
            'patron' => '\d+([\.,]\d+)?'
        ],
        'tpt' => [
            'titulo' => 'tpt',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'seg'
        ],
        'glu' => [
            'titulo' => 'glu',
            'patron' => '\d+([\.,]\d+)?',
            'unidades' => 'mg/dl'
        ],
        'ekg' => [
            'titulo' => 'ekg',
            'nl' => 'si'
        ]
    ],
    'plan' => [
        'asa' => [
            'titulo' => 'asa',
            'tipo' => 'select',
            'opciones' => [
                'I' => 'I - Sano',
                'II' => 'II - Enfermedad sist&eacute;mica leve',
                'III' => 'III - Enfermedad sist&eacute;mica grave',
                'IV' => 'IV - Enfermedad sist&eacute;mica incapacitante',
                'V' => 'V - Enfermedad terminal',
                'VI' => 'VI - Muerte cerebral / Donante de &oacute;rganos'
            ]
        ],
        'nyha' => [
            'titulo' => 'nyha',
            'tipo' => 'select',
            'opciones' => [
                'I' => 'I - Sin disnea',
                'II' => 'II - Disnea con actividades ordinarias',
                'III' => 'III - Disnea con actividades menores a ordinarias',
                'IV' => 'IV - Disnea en reposo',
                '0' => 'No valorable'
            ]
        ],
        'mets' => [
            'titulo' => 'mets',
            'patron' => '*'
        ],
        'ayuno' => [
            'titulo' => 'ayuno',
            'patron' => '*',
            'opciones' => 'style="text-align: left;"'
        ]
    ]
];

const ANESTESIA = [
    'general' => 'general',
    'neuraxial' => 'neuraxial',
    'bloqueo' => 'bloqueo',
    'sedacion' => 'sedaci&oacute;n',
    'local' => 'local'
];
?>