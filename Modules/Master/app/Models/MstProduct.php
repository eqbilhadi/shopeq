<?php

namespace Modules\Master\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    public function getSellingPriceFormatAttribute()
    {
        return 'Rp ' . number_format($this->attributes['selling_price'], 0, ',', '.');
    }

    public function getPurchasePriceFormatAttribute()
    {
        return 'Rp ' . number_format($this->attributes['purchase_price'], 0, ',', '.');
    }
}
