<?php

namespace Modules\Purchasing\app\Models;

use App\Traits\UuidTrait;
use App\Traits\UserStampsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Master\app\Models\MstProduct;

class TransactionItem extends Model
{
    use HasFactory, UserStampsTrait, UuidTrait;

    protected $table = "transaction_items";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'transaction_id',
        'status',
        'reff_id',
        'product_id',
        'unit_product_id',
        'qty',
        'final_qty',
        'price',
        'total_price',
        'expired',
        'note',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function mstProduct(): BelongsTo
    {
        return $this->belongsTo(MstProduct::class, 'product_id');
    }
}
