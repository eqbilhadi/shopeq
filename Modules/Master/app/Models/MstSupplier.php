<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Builder\MstSupplierBuilder;
use Modules\Master\database\factories\MstSupplierFactory;

class MstSupplier extends Model
{
    use HasFactory, UuidTrait;

    protected $table = "mst_suppliers";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'address',
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): MstSupplierFactory
    {
        return MstSupplierFactory::new();
    }

    public function newEloquentBuilder($query): MstSupplierBuilder
    {
        return new MstSupplierBuilder($query);
    }
}
