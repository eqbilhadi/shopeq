<?php

namespace Modules\Master\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MstUnitProducts extends Model
{
    use HasFactory;

    protected $table = "mst_unit_products";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'unit_id',
        'convert_main',
        'convert_other',
        'selling_price',
        'purchase_price',
        'is_main_unit',
        'stok'
    ];

    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'is_main_unit' => 'boolean'
    ];

    /**
     * Method unitable
     *
     * @return MorphTo
     */
    public function unitable(): MorphTo
    {
        return $this->morphTo();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MstUnit::class);
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
