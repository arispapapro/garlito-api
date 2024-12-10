<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsWebController extends Controller
{
    public function settings_page(): View
    {
        return view('garlito.general-pages.settings');

    }


}
