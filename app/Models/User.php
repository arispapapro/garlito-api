<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Configuration\GarlitoApiConfiguration;
use App\Helpers\GarlitoLanguageHelper;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'email_activation_token',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }




    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {

        // After User Creation
        static::created(function ($user) {

            // Search if default language exists.
            $default_language = GarlitoLanguageHelper::get_default_language();

            // If Default Lang Exists set the language id else leave it null.
            if($default_language){ $language_id = $default_language->id; }else{ $language_id = null; }

            // Init User Settings
            $user->user_setting()->create([
                'language_id' => $language_id,
            ]);
        });
    }

    /**
     * Return either the account is activated or not
     *
     * @return bool
     */
    public function is_activated():bool
    {
        return isset($this->email_verified_at);
    }


    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {

        // Init Url Value
        $url = '';

        // Get Garlito Forget Password Type [ It can be either 'internal_url' either 'external_url'
        $garlito_forget_password_type = env('GARLITO_FORGET_PASSWORD_TYPE', 'internal_url');

        // In case it's 'external_url' developer has also to add the external url
        if($garlito_forget_password_type == 'external_url'){
            $url = env('GARLITO_FORGET_PASSWORD_EXTERNAL_URL', url());
        }

        // In case it's 'internal_url' the url is fixed.
        if($garlito_forget_password_type == 'internal_url'){
            $url =  url('/');
        }

        $reset_password_url = $url .'/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($reset_password_url));
    }


    //------------------------------------------------------------------------------------------------------------------
    // Eloquent Relationships
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Get the user setting associated with the user.
     */
    public function user_setting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    //------------------------------------------------------------------------------------------------------------------
    // Authorization Functions
    //------------------------------------------------------------------------------------------------------------------

    public function is_super_admin(): bool{
        return $this->role->slug === GarlitoApiConfiguration::DEFAULT_GARLITO_SUPER_ADMIN_ROLE_SLUG;
    }

    public function is_user(): bool{
        return $this->role->slug === GarlitoApiConfiguration::DEFAULT_GARLITO_USER_ROLE_SLUG;
    }


}
