<?php

namespace Modules\Purchasing\Livewire\Validations;

use Illuminate\Validation\Validator;

trait CreatePurchasingInvoiceValidations
{
    protected function validationsItemOrder($key)
    {
        $this->validate(
            [
                'form.item_orders.' . $key . '.product_id' => 'required',
                'form.item_orders.' . $key . '.unit_product_id' => 'required',
                'form.item_orders.' . $key . '.qty' => 'required',
                'form.item_orders.' . $key . '.price' => 'required',
                'form.item_orders.' . $key . '.total_price' => 'required',
            ],
            [
                'required' => ':attribute required'
            ],
            [
                'form.item_orders.' . $key . '.product_id' => 'product',
                'form.item_orders.' . $key . '.unit_product_id' => 'unit product',
                'form.item_orders.' . $key . '.qty' => 'qty',
                'form.item_orders.' . $key . '.price' => 'price',
                'form.item_orders.' . $key . '.total_price' => 'total price',
            ]
        );
    }

    protected function validationsInvoice()
    {
        $this->withValidator([$this, 'withValidation'])->validate(
            [
                'form.transaction.supplier_id' => 'required',
                'form.transaction.invoice_no' => 'required|unique:transactions,invoice_no,' . $this->form['transaction']['invoice_no'] . ',invoice_no',
                'form.transaction.transaction_date' => 'required'
            ],
            [],
            [
                'form.transaction.supplier_id' => 'supplier',
                'form.transaction.invoice_no' => 'invoice number',
                'form.transaction.transaction_date' => 'transaction date'
            ]
        );
    }

    protected function withValidation(Validator $validation): void
    {
        $validation->after(function (Validator $validation) {
            $this->checkIfTransactionNotNull($validation);
        });
    }

    protected function checkIfTransactionNotNull(Validator $validation): void
    {
        if (is_null($this->transaction) || count($this->transaction?->orderItems) <= 0) {
            $validation->errors()->add('form.transaction', 'Item orders still empty, you cannot save this transaction');
        }
    }
}
