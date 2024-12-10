<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ClientWebController extends Controller
{
    public function clients_page(): View
    {

        $clients = DB::table('oauth_clients')->paginate(5);
        return view('garlito.role.garlito-super-admin.clients', ['clients' => $clients]);
    }
}
