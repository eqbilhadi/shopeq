<?php

namespace Modules\Master\app\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Builder\MstCustomerBuilder;
use Modules\Master\Database\factories\MstCustomerFactory;

class MstCustomer extends Model
{
    use HasFactory, UuidTrait;

    protected $table = "mst_customers";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function newEloquentBuilder($query): MstCustomerBuilder
    {
        return new MstCustomerBuilder($query);
    }
}
