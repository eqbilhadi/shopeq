<?php

namespace Modules\Rbac\app\Models;

use App\Models\User;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
        'create',
        'read',
        'update',
        'delete',
        'print',
        'import',
        'export'
    ];
        
    /**
     * Method users
     *
     * @return BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    
    /**
     * Method menus
     *
     * @return BelongsToMany
     */
    public function menus() :BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }
}
