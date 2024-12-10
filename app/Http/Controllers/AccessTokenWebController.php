<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AccessTokenWebController extends Controller
{
    public function access_tokens_page(): View
    {

        $access_tokens = DB::table('oauth_access_tokens')->paginate(5);
        return view('garlito.role.garlito-super-admin.access-tokens', ['access_tokens' => $access_tokens]);
    }
}
