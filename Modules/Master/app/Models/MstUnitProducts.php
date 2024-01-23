<?php

namespace Modules\Master\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'is_main_unit',
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
}
