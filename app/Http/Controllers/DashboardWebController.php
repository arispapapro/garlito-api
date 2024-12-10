<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class DashboardWebController extends Controller
{
    public function dashboard_page(): View
    {

        // Dashboard Counters
        $counters = [
            'users' => User::all()->count()
        ];

        return view('garlito.general-pages.dashboard');
    }
}
