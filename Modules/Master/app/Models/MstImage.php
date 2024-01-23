<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MstImage extends Model
{
    use HasFactory, UuidTrait;

    protected $table = "mst_images";


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'filename',
        'title',
        'description',
        'source',
        'is_main_image',
    ];

     /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'is_main_image' => 'boolean'
    ];


    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
