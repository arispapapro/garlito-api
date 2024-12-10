<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class AuthenticationWebController extends Controller
{
    public function login_page(): View | RedirectResponse
    {
        if(Auth::check()){
            return redirect('dashboard');
        }else{
            return view('garlito.general-pages.auth.login');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request): RedirectResponse
    {
        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){
            return redirect()->back()->withErrors([
                'login_error' => __('auth.login.errors.credentials'),
            ]);
        }

        $user = User::where('email', $request['email'])->first();

        if(!$user){
            return redirect()->back()->withErrors([
                'login_error' => __('auth.login.errors.email_not_exist')
            ]);
        }

        if (Auth::attemptWhen(['email' => $request['email'], 'password' => $request['password'],], function (User $user) {
            return $user->is_activated();
        })) {
            // Generate a new Session
            $request->session()->regenerate();

            // Authentication passed...
            return redirect()->intended('dashboard');
        } else {
            $user = User::where('email', $request['email'])->first();

            if (!$user) {
                $error = __('auth.login.errors.email_not_exist');
            } elseif (!$user->is_activated()) {
                $error = __('auth.login.errors.not_activated');
            } else {
                $error = __('auth.login.errors.credentials');
            }

            return redirect()->back()->withErrors(['login_error' => $error]);
        }
    }
}
