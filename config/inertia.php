<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SSR (Server-Side Rendering)
    |--------------------------------------------------------------------------
    |
    | Aquí puedes habilitar el SSR y definir el path del bundle de JS que se usará
    | para renderizar del lado del servidor.
    |
    */

    'ssr' => [
        'enabled' => env('INERTIA_SSR', false),
        'url' => 'http://localhost:13714',
        'bundle' => base_path('bootstrap/ssr.js'),
    ],

];
