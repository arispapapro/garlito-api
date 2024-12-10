<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [];

    //------------------------------------------------------------------------------------------------------------------
    // Eloquent Relationships
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Get the user settings for the language.
     */
    public function user_settings(): HasMany
    {
        return $this->hasMany(UserSetting::class);
    }
}
