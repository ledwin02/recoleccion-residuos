<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Constructor para aplicar middleware de autenticación.
     */
    public function __construct()
    {
        // Aplicar el middleware de autenticación a todos los controladores que hereden de Controller
        $this->middleware('auth');
    }
}
