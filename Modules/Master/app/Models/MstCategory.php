<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\database\factories\MstCategoryFactory;

class MstCategory extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'is_active'
    ];

    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    
    protected $table = "mst_category";

    protected static function newFactory(): MstCategoryFactory
    {
        return MstCategoryFactory::new();
    }
}
