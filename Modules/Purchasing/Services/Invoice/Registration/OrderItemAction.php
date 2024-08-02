<?php

namespace Modules\Purchasing\Services\Invoice\Registration;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstUnitProducts;
use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\app\Models\TransactionItem;
use Modules\Purchasing\Services\Invoice\GenerateInvoiceNumber;

class OrderItemAction
{

    protected array $data = [];

    public ?Transaction $transaction = null;

    public ?TransactionItem $transactionItem = null;

    public MstProduct $mstProduct;

    public function __construct(?Transaction $transaction = null, ?TransactionItem $transactionItem, array $data = [])
    {
        $this->data = $data;
        $this->transaction = $transaction;
        $this->transactionItem = $transactionItem;
        $this->mstProduct = Arr::get($data, 'mst_product');
    }

    public function handle()
    {
        if (is_null($this->transaction)) {
            $this->createDraftTransaction();
        }
        if (is_null($this->transactionItem)) {
            $this->createOrderItem();
        } else {
            $this->updateOrderItem();
        }

        return $this;
    }

    protected function createDraftTransaction()
    {
        $params = [
            'invoice_no' => (new GenerateInvoiceNumber("IN"))->create(),
            'transaction_date' => Carbon::now(),
            'status' => 'IN',
            'type' => 'TRANSACTION',
        ];

        $this->transaction = Transaction::create($params);
    }

    protected function createOrderItem()
    {
        $this->transactionItem = TransactionItem::create($this->getRegistrationDataOrderItem());
    }

    protected function updateOrderItem()
    {
        $this->transactionItem->update($this->getRegistrationDataOrderItem());
    }

    protected function getRegistrationDataOrderItem(): array
    {
        // set data
        $data = [
            'transaction_id' => $this->transaction->id,
            'status' => Arr::get($this->data, 'status'),
            'reff_id' => Arr::get($this->data, 'reff_id'),
            'product_id' => Arr::get($this->data, 'product_id'),
            'unit_product_id' => Arr::get($this->data, 'unit_product_id'),
            'qty' => Arr::get($this->data, 'qty'),
            'final_qty' => $this->getFinalQty(),
            'price' => preg_replace("/[^0-9]/", "", Arr::get($this->data, 'price')),
            'total_price' => preg_replace("/[^0-9]/", "", Arr::get($this->data, 'total_price')),
            'expired' => Arr::get($this->data, 'expired'),
            'note' => Arr::get($this->data, 'note'),
        ];

        return $data;
    }

    protected function getFinalQty()
    {
        $idUnitProduct = Arr::get($this->data, 'unit_product_id');
        $productUnit = MstUnitProducts::find($idUnitProduct);

        if (!$productUnit->is_main_unit) {
            $finalQty = $productUnit->convert_main / $productUnit->convert_other * Arr::get($this->data, 'qty');

            return $finalQty;
        }

        $finalQty = Arr::get($this->data, 'qty');
        return $finalQty;
    }
}
