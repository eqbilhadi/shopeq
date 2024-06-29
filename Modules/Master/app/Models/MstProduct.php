<?php

namespace Modules\Master\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Master\Builder\MstProductBuilder;
use Modules\Master\database\factories\MstProductFactory;

class MstProduct extends Model
{
    use HasFactory, UserStampsTrait, UuidTrait;

    protected $table = "mst_products";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'barcode',
        'selling_price',
        'purchase_price',
        'minimal_stok',
        'status',
        'visibility'
    ];

    protected static function newFactory(): MstProductFactory
    {
        return MstProductFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MstCategory::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(MstImage::class, 'imageable');
    }

    public function units(): MorphMany
    {
        return $this->morphMany(MstUnitProducts::class, 'unitable');
    }

    public function getMainImageUrlAttribute()
    {
        $mainImage = $this->images->where('is_main_image', 1)->first();
        
        $imgPath = $mainImage?->filename; 

        if ($imgPath && file_exists(public_path($imgPath))) {
            return asset($imgPath);
        }

        return asset('assets/images/placeholder-product-images.png');
    }

    public function newEloquentBuilder($query): MstProductBuilder
    {
        return new MstProductBuilder($query);
    }
}
