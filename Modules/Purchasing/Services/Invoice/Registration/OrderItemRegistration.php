<?php

namespace Modules\Purchasing\Services\Invoice\Registration;

use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\app\Models\TransactionItem;
use Illuminate\Support\Arr;

class OrderItemRegistration extends RegistrationService
{
    public ?Transaction $transaction;

    public ?TransactionItem $transactionItem;

    public array $data;

    public function __construct(Transaction $transacion = null, array $data)
    {
        $this->transaction = $transacion;
        $this->transactionItem = Arr::get($data, 'transaction_item');
        $this->data = $data;
    }

    public function save()
    {
        return (new OrderItemAction(
            $this->transaction,
            $this->transactionItem,
            $this->data
        ))->handle();
    }
}
