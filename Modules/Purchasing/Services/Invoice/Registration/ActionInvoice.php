<?php

namespace Modules\Purchasing\Services\Invoice\Registration;

use Illuminate\Support\Arr;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstUnitProducts;
use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\app\Models\TransactionItem;

class ActionInvoice
{

    protected array $data = [];

    public ?Transaction $transaction = null;

    public ?TransactionItem $itemOrder = null;

    /**
     * Method __construct
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function __construct(?Transaction $transaction = null, ?TransactionItem $itemOrder, array $data = [])
    {
        $this->data = $data;

        $this->transaction = $transaction;

        $this->itemOrder = $itemOrder;
    }

    /**
     * Method handle
     *
     * @return void
     */
    public function handle(): static
    {
        if (is_null($this->transaction) && is_null($this->itemOrder)) {
            $this->createInvoice()
                ->createOrderItem();
        } else if (!is_null($this->transaction) && is_null($this->itemOrder)) {
            $this->createOrderItem();
        } else if (!is_null($this->transaction) && !is_null($this->itemOrder)) {
            $this->updateOrderItem();
        }

        return $this;
    }

    protected function createInvoice(): static
    {
        $this->transaction = Transaction::create($this->getRegistrationDataInvoice());

        return $this;
    }

    protected function createOrderItem(): static
    {
        $this->itemOrder = TransactionItem::create($this->getRegistrationDataOrderItem());

        return $this;
    }

    protected function updateOrderItem(): static
    {
        $this->itemOrder->update($this->getRegistrationDataOrderItem());

        return $this;
    }

    protected function getRegistrationDataInvoice(): array
    {
        // set data
        $data = [
            'invoice_no' => Arr::get($this->data['transaction'], 'invoice_no'),
            'transaction_date' => Arr::get($this->data['transaction'], 'transaction_date'),
            'status' => Arr::get($this->data['transaction'], 'status'),
            'type' => Arr::get($this->data['transaction'], 'type'),
            'supplier_id' => Arr::get($this->data['transaction'], 'supplier_id'),
            'description' => Arr::get($this->data['transaction'], 'description'),
        ];

        return $data;
    }

    protected function getRegistrationDataOrderItem(): array
    {
        // set data
        $data = [
            'transaction_id' => $this->transaction->id,
            'status' => Arr::get($this->data['item_orders'], 'status'),
            'reff_id' => Arr::get($this->data['item_orders'], 'reff_id'),
            'product_id' => Arr::get($this->data['item_orders'], 'product_id'),
            'unit_product_id' => Arr::get($this->data['item_orders'], 'unit_product_id'),
            'qty' => Arr::get($this->data['item_orders'], 'qty'),
            'final_qty' => $this->getFinalQty(),
            'price' => Arr::get($this->data['item_orders'], 'price'),
            'total_price' => Arr::get($this->data['item_orders'], 'total_price'),
            'expired' => Arr::get($this->data['item_orders'], 'expired'),
            'note' => Arr::get($this->data['item_orders'], 'note'),
        ];

        return $data;
    }

    protected function getFinalQty()
    {
        $idUnitProduct = Arr::get($this->data['item_orders'], 'unit_product_id');
        $productUnit = MstUnitProducts::find($idUnitProduct);

        if (!$productUnit->is_main_unit) {
            $finalQty = $productUnit->convert_main / $productUnit->convert_other * Arr::get($this->data['item_orders'], 'qty');

            return $finalQty;
        }

        $finalQty = Arr::get($this->data['item_orders'], 'qty');
        return $finalQty;
    }
}
