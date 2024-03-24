<?php

namespace Modules\Purchasing\app\Models;

use App\Traits\UserStampsTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Master\app\Models\MstSupplier;
use Modules\Purchasing\Builder\TransactionBuilder;

class Transaction extends Model
{
    use HasFactory, UserStampsTrait, UuidTrait;

    protected $table = "transactions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'invoice_no',
        'transaction_date',
        'status',
        'type',
        'supplier_id',
        'customer_id',
        'paid',
        'change',
        'description',
        'is_draft',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'transaction_date' => 'datetime'
    ];
    
    public function newEloquentBuilder($query): TransactionBuilder
    {
        return new TransactionBuilder($query);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(MstSupplier::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}
