<?php

namespace App\Http\Controllers;

// Utilities
use App\Configuration\GarlitoApiConfiguration;
use App\Helpers\GarlitoAuthenticationHelper;
use App\Http\Resources\AccountDetailsResource;
use App\Mail\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

// Support Utilities
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

//Helpers
use App\Helpers\GarlitoApiResponseHelper;

// Models
use App\Models\User;
use App\Models\Role;

class AuthenticationController extends BaseApiController
{

    /**
     *
     * @OA\Post(
     *     path="/register",
     *     tags={"Authentication"},
     *     operationId="Register",
     *     summary="Register a new User.",
     *     @OA\RequestBody(
     *         description="Login.",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"email", "password", "password_confirmation"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                    property="password",
     *                    type="string",
     *                 ),
     *                 @OA\Property(
     *                    property="password_confirmation",
     *                    type="string",
     *                 ),
     *                @OA\Property(
     *                   property="first_name",
     *                   type="string",
     *                ),
     *                @OA\Property(
     *                     property="middle_name",
     *                     type="string",
     *                  ),
     *                @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                  ),
     *                @OA\Property(
     *                     property="gender",
     *                     type="string",
     *                  ),
     *                example={"username": "arispapapro@gmail.com", "password" : "123456", "password_confirmation" : "123456", "first_name" : "Aris" , "last_name" : "Papaprodromou", "middle_name": "Giorgos" , "gender" : "male"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Response Successful",
     *          @OA\JsonContent(
     *               example={"message":"registration_successful","data":{"first_name":"","middle_name":"","last_name":"","full_name":" ","gender":"","email":"arispapapro@gmail.com","role":"garlito_user"},"status":200,"status_message":"success"}
     *          )
     *       ),
     *      @OA\Response(
     *           response=400,
     *           description="Bad Request",
     *           @OA\JsonContent(
     *                example={"message":{"validation_errors":{{"input":"email","error":{"The email field is required."}},{"input":"password","error":{"The password field is required."}},{"input":"password_confirmation","error":{"The password confirmation field is required."}}}},"data":{},"status":400,"status_message":"invalid_inputs"}
     *           )
     *        )
     *  )
     * )
     */
    public function register(Request $request): JsonResponse{

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, [
            'first_name' => ['nullable', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'email' => ['required', 'email', 'unique:users' ],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){ return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Get Default User Registration Role
        $role = Role::where('slug', GarlitoApiConfiguration::DEFAULT_USER_ROLE_SLUG)->first();

        // If Default Role Does Not Exist Through Error
        if(!$role){return GarlitoApiResponseHelper::getNotFoundResponse('role'); }

        // Begin Database Transaction
        DB::beginTransaction();

        try {

           // Create User
           $is_user_created =  User::create([
               'first_name' => $request->first_name,
               'middle_name' => $request->middle_name,
               'last_name' => $request->last_name,
               'gender' => $request->gender,
               'email' => $request->email,
               'password' => Hash::make($request->password),
               'role_id' => $role->id,
               'email_activation_token' => Str::uuid(),
               'created_at' => Carbon::now()->toDateTimeString(),
               'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

           // Fetch User
           $user = User::where('email', $request->email)->first();

            // If User Created
            if($is_user_created && $user){

                if(GarlitoApiConfiguration::use_email_verification()){
                    // Send Success Registration Email.
                    $email_sent = Mail::to($request->email)->send(new Registered($user));

                }else{
                    // Activate User
                    $user->email_verified_at = Carbon::now()->toDateTimeString();

                    // Update User Instance
                    $user->save();
                }

                // Commit the transaction
                DB::commit();

                // Return Success Response
                return GarlitoApiResponseHelper::getSuccessResponse('registration_successful', AccountDetailsResource::make($user));

                // If User is not created through a registration failure error.
            }else {return GarlitoApiResponseHelper::getErrorResponse('registration_failed'); }

        } catch (\Exception $e) {

            // Rollback the transaction
            DB::rollBack();

            // If User is not created through a registration failure error.
            return GarlitoApiResponseHelper::getErrorResponse($e->getMessage());
        }

    }
    /**
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     operationId="Login",
     *     summary="Login.",
     *     @OA\RequestBody(
     *         description="Login.",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"username": "arispapapro@gmail.com", "password" : "123456"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Response Successful",
     *          @OA\JsonContent(
     *               example={"message":"logged_in","data":{"user":{"id":2,"full_name":"Anissa Collier","email":"user_2@iti.gr","username":"user_2","created_at":"2024-03-01T12:40:45.000000Z","updated_at":"2024-03-01T12:40:45.000000Z"},"role":"operator","access_token":"1|3MgJLqlbYIT87TrqyAvB6FzaaCAJsPqtPdU4yQMz4a932f83"},"status":200,"status_message":"success"}
     *          )
     *       ),
     *  @OA\Response(
     *            response=401,
     *            description="Unauthorized Response",
     *            @OA\JsonContent(
     *                 example={"message":"You are not authorized to access this endpoint.","status":401,"status_message":"unauthorized"}
     *            )
     *         )
     *    )
     *  )
     * )
     */
    public function login(Request $request): JsonResponse{

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, [
            'email' => ['required' , 'email'],
            'password' => ['required' , 'string']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Make an attempt to login.
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){

            // Fetch Current User
            $user = User::find(Auth::id());

            if($user->is_activated()){

                // Revoke All Tokens Before
                GarlitoAuthenticationHelper::revokeAllTokensOfUser($user->id);

                // Create New Token
                $token = $user->createToken('logged_in_' . Carbon::now()->toDateTimeString());

                // Make Response
                $response = [
                    'access_token' => $token->accessToken,
                    'expires_at' => $token->token->expires_at,
                    'role' => $user->role->slug,
                    'account_details' => AccountDetailsResource::make($user)
                ];

                return GarlitoApiResponseHelper::getSuccessResponse('logged_in', $response);

            }else{
                return GarlitoApiResponseHelper::getErrorResponse('user_not_activated');
            }
        }

        // Return Unauthorized Response
        else{ return GarlitoApiResponseHelper::getUnauthorizedResponse(); }
    }

    /**
     *
     * @OA\Put(
     *     path="/change-password",
     *     tags={"Account"},
     *     operationId="ChangePassword",
     *     summary="Change User Password when you are authenticated.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Change Password Payload.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"password", "password_confirmation"},
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string"
     *                 ),
     *                 example={"password": "123456", "password_confirmation": "123456"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Response Successful",
     *          @OA\JsonContent(
     *               example={"message":"password_changed","data":{},"status":200,"status_message":"success"}
     *          )
     *       ),
     *       @OA\Response(
     *            response=400,
     *            description="Bad Request",
     *            @OA\JsonContent(
     *                 example={"message":{"validation_errors":{{"input":"password","error":"The password field is required."},{"input":"password_confirmation","error":"The password confirmation field is required."}}},"data":{},"status":400,"status_message":"invalid_inputs"}
     *            )
     *         ),
     *      @OA\Response(
     *            response=401,
     *            description="Unauthorized Response",
     *            @OA\JsonContent(
     *                 example={"message":"You are not authorized to access this endpoint.","status":401,"status_message":"unauthorized"}
     *            )
     *         )
     *    )
     * )
     */
    public function change_password(Request $request): JsonResponse{

        // Get all input values from request
        $input = $request->all();

        // Validation Rules
        $validator = Validator::make($input, [
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'string', 'same:password']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Get Auth User
        $user = User::find(Auth::id());

        // Set Updated Password
        $user->password = Hash::make($request['password']);

        // Update User Instance
        $user->save();

        // Return Success Response
        return GarlitoApiResponseHelper::getSuccessResponse('password_changed', []);
    }


    /**
     *
     * @OA\Post(
     *     path="/forgot-password",
     *     tags={"Authentication"},
     *     operationId="ForgotPassword",
     *     summary="In Case User Forgot Password.",
     *     @OA\RequestBody(
     *         description="Change Password Payload.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 example={"email": "arispapapro@gmail.com"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Response Successful",
     *          @OA\JsonContent(
     *               example={"message":"reset_link_sent","data":{ "status" : true },"status":200,"status_message":"success"}
     *          )
     *       ),
     *       @OA\Response(
     *            response=400,
     *            description="Bad Request",
     *            @OA\JsonContent(
     *                 example={"message":{"validation_errors":{{"input":"email","error":{"The email field is required."}}}},"data":{},"status":400,"status_message":"invalid_inputs"}
     *            )
     *         ),
     *            @OA\Response(
     *             response=429,
     *             description="Reset Password Throttle",
     *             @OA\JsonContent(
     *                  example={"message":"reset_password_throttle","status_message":"error","status":429}
     *             )
     *          ),
     *      @OA\Response(
     *            response=401,
     *            description="Unauthorized Response",
     *            @OA\JsonContent(
     *                 example={"message":"You are not authorized to access this endpoint.","status":401,"status_message":"unauthorized"}
     *            )
     *         )
     *    )
     * )
     */
    public function forgot_password(Request $request): JsonResponse
    {
        // Validation Rules.
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email' , 'exists:users']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        // Send Reset Link
        $status = Password::sendResetLink($request->only('email'));

        // Check Status of Reset Link Operation
        switch($status){
            case(Password::RESET_THROTTLED):{
                return GarlitoApiResponseHelper::getManyRequestsError('reset_password_throttle');
            }

            case(Password::RESET_LINK_SENT):{
                return GarlitoApiResponseHelper::getSuccessResponse('reset_link_sent', [ 'status' => $status]);
            }

        }

        // Return Error Response
        return GarlitoApiResponseHelper::getErrorResponse('forget_password_failed');
    }

    /**
     *
     * @OA\Post(
     *     path="/reset-password",
     *     tags={"Authentication"},
     *     operationId="ResetPassword",
     *     summary="When you want to reset your password.",
     *     @OA\RequestBody(
     *         description="Reset Password Payload.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                @OA\Property(
     *                      property="token",
     *                      type="string"
     *                  ),
     *                 example={"email": "arispapapro@gmail.com" , "password" : "123456", "token": "4LTQ3ZmEtYTkwNS1iN2VmOGE5NjllZmYiLCJqdGkiOiIzMTVlMWU4YzUwZjk3Zjc0NDMwMTcxM2J"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Response Successful",
     *          @OA\JsonContent(
     *               example={"message":"password_reset_success","data":{ },"status":200,"status_message":"success"}
     *          )
     *       ),
     *       @OA\Response(
     *              response=429,
     *              description="Reset Password Throttle",
     *              @OA\JsonContent(
     *                   example={"message":"reset_throttle","status_message":"error","status":429}
     *              )
 *           ),
     *       @OA\Response(
     *            response=400,
     *            description="Bad Request",
     *            @OA\JsonContent(
     *                 example={"message":{"validation_errors":{{"input":"email","error":{"The email field is required."}}}},"data":{},"status":400,"status_message":"invalid_inputs"}
     *            )
     *       ),
     *       @OA\Response(
     *            response=401,
     *            description="Unauthorized Response",
     *            @OA\JsonContent(
     *                 example={"message":"You are not authorized to access this endpoint.","status":401,"status_message":"unauthorized"}
     *            )
 *          )
     *    )
     * )
     */
    public function reset_password(Request $request)
    {

        // Validation Rules.
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        // If its not validated return response with error messages.
        if($validator->fails()){return GarlitoApiResponseHelper::getInvalidInputsResponse($validator->errors());}

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        switch($status){
            case(Password::PASSWORD_RESET):{
                // Return Success Response
                return GarlitoApiResponseHelper::getSuccessResponse('password_reset_success', []);
            }
            case(Password::INVALID_USER):{
                // Return Error Response
                return GarlitoApiResponseHelper::getErrorResponse('invalid_user', []);
            }
            case(Password::INVALID_TOKEN):{
                // Return Error Response
                return GarlitoApiResponseHelper::getErrorResponse('invalid_token', []);
            }
            case(Password::RESET_THROTTLED):{
                // Return Error Response
                return GarlitoApiResponseHelper::getManyRequestsError('reset_throttle', []);
            }

        }
        // Return Error Response
        return GarlitoApiResponseHelper::getErrorResponse('password_reset_failed');
    }


    public function activate_account($token): RedirectResponse | JsonResponse | View
    {

        // Search User
        $user = User::where('email_activation_token', $token)->first();

        if($user){

            // IF user has already been activated or set password.
            if($user->is_activated()){ return GarlitoApiResponseHelper::getErrorResponse('user_already_activated'); }

            // Activate User
            $user->email_verified_at = Carbon::now()->toDateTimeString();

            // Update User Changes
            $user->save();


            $garlito_activate_account_redirect_uri = env('GARLITO_ACTIVATE_ACCOUNT_REDIRECT_URI');

            if(isset($garlito_activate_account_redirect_uri)){

                // Return Success Response of Activation
                return redirect($garlito_activate_account_redirect_uri);
            }else{
                return view('auth.account-activated');
            }

        }else{
            return GarlitoApiResponseHelper::getNotFoundResponse('user');
        }

    }


}
