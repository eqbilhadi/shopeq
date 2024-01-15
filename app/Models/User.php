<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Traits\UuidTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Modules\Rbac\app\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticationLoggable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'birthplace',
        'birthdate',
        'gender',
        'avatar',
        'phone',
        'address',
        'is_active',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];
    
    /**
     * Method roles
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Method getAgeAttribute
     *
     * @return void
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthdate'])->age;
    }
    
    /**
     * Method getFullNameAttribute
     *
     * @return void
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }
    
    /**
     * Method getPhotoUrlAttribute
     *
     * @return void
     */
    public function getPhotoUrlAttribute()
    {
        $photoPath = $this->attributes['avatar']; 

        if ($photoPath && file_exists(public_path($photoPath))) {
            return asset($photoPath);
        }

        return asset('assets/images/users/user-dummy-img.jpg');
    }
    
    /**
     * Method authentications
     *
     * @return void
     */
    public function authlog()
    {
        return $this->morphMany(AuthenticationLog::class, 'authenticatable')->latest('login_at');
    }
}
