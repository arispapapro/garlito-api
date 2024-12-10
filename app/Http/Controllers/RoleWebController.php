<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleWebController extends Controller
{
    public function roles_page(): View
    {
        $roles = Role::all();

        foreach($roles as $role){
            $role->total_users = sizeof( $role->users);
            unset($role->users);
        }
        return view('garlito.role.garlito-super-admin.roles', [ 'roles' => $roles->toQuery()->paginate(5) ]);
    }
}
