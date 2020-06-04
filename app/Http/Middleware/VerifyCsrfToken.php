<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

        '/adm/fence/add',
        '/adm/fence',
        '/adm/alert/*',
        '/adm/alert/batch',
        '/adm/device',
        '/adm/meet',
        '/adm/track',
        '/logout',


    ];
}
