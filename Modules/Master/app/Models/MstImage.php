<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Builder;
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

    
    /**
     * Method imageable
     *
     * @return MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Method getImgUrlAttribute
     *
     * @return void
     */
    public function getImgUrlAttribute()
    {
        $imgPath = $this->attributes['filename']; 

        if ($imgPath && file_exists(public_path($imgPath))) {
            return asset($imgPath);
        }

        return asset('assets/images/placeholder-product-images.png');
    }
        
    /**
     * Method scopeByType
     *
     * @param $query $query [explicite description]
     * @param $type $type [explicite description]
     *
     * @return Builder
     */
    public function scopeByType($query, $type): Builder
    {
        return $query->where('imageable_type', $type);
    }
}
