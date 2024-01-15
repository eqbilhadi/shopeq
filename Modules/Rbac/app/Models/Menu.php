<?php

namespace Modules\Rbac\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_id',
        'sort_num',
        'icon',
        'label_name',
        'controller_name',
        'route_name',
        'url',
        'is_active',
    ];

    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
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
     * Method parent
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id')->with('parent', 'roles')->orderBy('sort_num', 'asc');
    }

    /**
     * Method children
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->with('children')->orderBy('sort_num', 'asc');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Menu $menu) {
            $parentCondition = $menu->parent_id === null ? ['parent_id' => null] : ['parent_id' => $menu->parent_id];

            $sortNum = Menu::where($parentCondition)->max('sort_num');

            $menu->update([
                'sort_num' => $sortNum !== null ? $sortNum + 1 : 1
            ]);
        });
    }
}
