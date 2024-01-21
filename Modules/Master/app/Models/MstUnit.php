<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
