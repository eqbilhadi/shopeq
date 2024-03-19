<?php

namespace Modules\Purchasing\Services\Invoice\Registration;

use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\app\Models\TransactionItem;

class InvoiceRegistration extends RegistrationService
{
    /**
     * Data
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Transaction
     *
     * @var Transaction|null
     */
    public ?Transaction $transaction = null;

    /**
     * Transaction Items
     *
     * @var Transaction|null
     */
    public ?TransactionItem $itemOrder = null;

    /**
     * @param Transaction|null $transaction
     * @param array $data
     */
    public function __construct(?Transaction $transaction = null, ?TransactionItem $itemOrder, array $data = [])
    {
        $this->transaction = $transaction;

        $this->itemOrder = $itemOrder;

        $this->data = $data;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    public function save()
    {
        return (new ActionInvoice($this->transaction, $this->itemOrder, $this->data))->handle();
    }
}
