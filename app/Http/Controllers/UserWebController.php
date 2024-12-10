<?php

namespace App\Http\Controllers;

// Helpers
use App\Helpers\GarlitoApiResponseHelper;

// Configuration
use App\Configuration\GarlitoApiConfiguration;

// Resources
use App\Http\Resources\AccountDetailsResource;

// Utilities
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

// Models
use App\Models\Role;
use App\Models\User;
use App\Models\UserSetting;


class UserWebController extends Controller
{
    public function add_user(Request $request)
    {
        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, [
            'first_name' => ['nullable', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'role_id' => ['required'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'email' => ['required', 'email', 'unique:users' ],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){ return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Get Default User Registration Role
        $role = Role::find($request['role_id'])->first();

        // If Default Role Does Not Exist Through Error
        if(!$role){return GarlitoApiResponseHelper::getNotFoundResponse('role'); }



        $user = User::create([
            'first_name'=> $request['first_name'] ?? '',
            'middle_name'=> $request['middle_name'] ?? '',
            'last_name'=> $request['last_name'] ?? '',
            'gender'=> $request['gender'] ?? 'other',
            'email'=> $request['email'] ?? '',
            'password'=>  Hash::make($request['password']),
            'role_id'=> $request['role_id'] ?? '',
            'email_activation_token'=> Str::uuid(),
        ]);

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse('registration_successful', AccountDetailsResource::make($user));
    }

    public function edit_user(Request $request, $id)
    {

        // Search for User
        $user = User::find($id);

        // If user not exist.
        if(!$user){ return GarlitoApiResponseHelper::getNotFoundResponse('user'); }

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, [
            'first_name' => ['nullable', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'role_id' => ['required','numeric', 'exists:roles,id'],
            'language_id' => ['nullable', 'numeric','exists:languages,id'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($user)]
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){
            return back()->with([ 'errors' => $validator->errors()]);
        }

        // User Information
        if(isset($request->first_name)) $user->first_name = $request->first_name;
        if(isset($request->middle_name)) $user->middle_name = $request->middle_name;
        if(isset($request->last_name)) $user->last_name = $request->last_name;
        if(isset($request->gender)) $user->gender = $request->gender;
        if(isset($request->email)) $user->email = $request->email;
        if(isset($request->role_id)) $user->role_id = $request->role_id;

        if(isset($request['language_id'])){
            $user_setting = UserSetting::where('user_id', $user->id)->first();
            $user_setting->language_id = $request['language_id'];
            $user_setting->save();
        }

        // Create User
        $user->save();

        // User Language
        $user->language = $user->user_setting->language;

        // Return Success Response
        return view('garlito.role.garlito-super-admin.single-user', [
            'user' => $user,
            'type' => 'successful_edit'
        ]);

    }

    public function delete_user($id)
    {

        $user = User::find($id);

        if(!$user){
            return back()->with([ 'errors' => 'This user does not exist']);
        }else{
            $user->delete();

            // Return Success Response
            return redirect('users');
        }
    }

    public function users_page(): View
    {
        // Fetch Users With Eager Loading for User Settings
        $usersQuery = User::with('user_setting');

        // Paginate the Users Query
        $users = $usersQuery->paginate(GarlitoApiConfiguration::DEFAULT_WEB_PAGINATION_NUMBER);

        // Modify the paginated collection
        foreach ($users as $user) {
            $user->language = $user->user_setting->language;
        }

        // Return View With Paginated Users
        return view('garlito.role.garlito-super-admin.users', [
            'users' => $users
        ]);
    }

    public function single_user_page($id): View{

        // Fetch Users With Eager Loading for User Settings
        $user = User::find($id);

        if(!$user){ return view('garlito.general-pages.error.404', [ 'type' => 'user'] ); }

        // User Language
        $user->language = $user->user_setting->language;

        // Return View With Paginated Users
        return view('garlito.role.garlito-super-admin.single-user', [
            'user' => $user
        ]);
    }

}
