<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\database\factories\MstUnitFactory;

class MstUnit extends Model
{
    use HasFactory, UuidTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    protected $table = "mst_units";

    protected static function newFactory(): MstUnitFactory
    {
        return MstUnitFactory::new();
    }
}
