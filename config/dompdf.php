<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DomPDF Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls the configuration for the DomPDF library.
    |
    */

    'public_path' => public_path(),

    'public_url' => env('APP_URL'),

    'convert_entities' => true,

    'pdf' => [
        'enabled' => true,
        'binary' => false,
        'timeout' => 360,
        'options' => [
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ],
        'env' => [
            'DOMPDF_TEMP_DIR' => storage_path('logs'),
            'DOMPDF_CHROOT' => public_path(),
            'DOMPDF_DEFAULT_MEDIA_TYPE' => 'screen',
        ],
    ],

    'font_dir' => storage_path('fonts/'),

    'font_cache' => storage_path('fonts/'),

    'temp_dir' => sys_get_temp_dir(),

    'chroot' => public_path(),

    'include_html5_parser' => false,

    'show_warnings' => false,

    'orientation' => 'portrait',

    'defines' => [
        'fontDir' => storage_path('fonts/'),
        'fontCache' => storage_path('fonts/'),
        'tempDir' => sys_get_temp_dir(),
        'chroot' => public_path(),
        'logOutputFile' => storage_path('logs/dompdf.log'),
        'allowedProtocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],
        'defaultMediaType' => 'screen',
        'defaultPaperSize' => 'a4',
        'defaultFont' => 'serif',
        'dpi' => 96,
        'enablePhp' => false,
        'enableJavascript' => true,
        'debugPng' => true,
        'debugKeepTemp' => false,
        'debugCss' => false,
        'debugLayout' => false,
        'debugLayoutLines' => true,
        'debugLayoutBlocks' => true,
        'debugLayoutInline' => true,
        'debugLayoutPaddingBox' => true,
        'pdfBackend' => 'CPDF',
        'pdflibLicense' => '',
        'adminUsername' => 'user',
        'adminPassword' => 'password',
        'tableCellMargin' => 0,
    ],

];
