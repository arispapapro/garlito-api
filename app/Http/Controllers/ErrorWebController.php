<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ErrorWebController extends Controller
{
    public function forbidden_page(): View
    {
        return view('garlito.general-pages.error.403');
    }
}
